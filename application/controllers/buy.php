<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buy extends Auth_Controller {
		private $_order_id = null;
        private $_order = null;

        public function __construct() {
            parent::__construct();
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('pay/orders_model');
            $this->load->model('exception_model');
            $this->load->model('kokpit/domains_model');
            $this->load->model('yandex_model');

              $this->lang->load('dashboard', 'turkish');
              $this->lang->load('footer', 'turkish');

              $this->load->helper('language');//lang kısaltması icin gerekli
        }


        public function pos() {
            $this->load->model('packages_model');

            $this->load->library('pos');

            $name = $this->input->post('name', TRUE);
            $ccno = $this->input->post('number', TRUE);
            $expdate = $this->input->post('expiry', TRUE);
            $cvc = $this->input->post('cvc', TRUE);
            $pos_orderid = $this->input->post('pos_orderid', TRUE);
            $order_id = (int)$this->input->post('order_id');

            $agreement = $this->input->post('agreement');

            if(!$agreement) {
                $error = "Lütfen sözleşmeyi kabul edin.";
                $this->session->set_flashdata('pos_error', $error);
                redirect('buy/index/'. $order_id);
                return flase;                
            }

            $order = $this->orders_model->get_order_by_id($order_id);
            $package = $this->packages_model->get_package($order->package);
            $amount = $package->price;

            if($order->external_registerer) {
                $amount -= 20;
            } 

            $ccno = str_replace(' ', '', $ccno); //replace blank string

            $expdate_arr = explode('/', $expdate);
            if(strpos($expdate,'/')) {
                $month = trim($expdate_arr[0]);
                $year = trim($expdate_arr[1]);                
            } else {
                $month = "00";
                $year = "00";
            }

            $expdate = (strlen($year) == 4) ? substr($year, -2) : $year;
            $expdate .= $month;

            $this->pos->set_ccno($ccno); // kart numarasını ayarla
            $this->pos->set_expdate($expdate); // son kullanım tarihi
            $this->pos->set_cvc($cvc);  // cvc numarası
            $this->pos->set_amount($amount); // tutar
            $this->pos->set_orderid($pos_orderid);
   
            $error = false;
            try{
                // for don't output, commented //flush() in postnet_http.php
                $this->pos->sale();
            } 
            catch (TransactionException $ex) {
                $error = $ex->getMessage();
                //save exception to db
                $this->load->model('pay/payment_error_model');
                $data = array(
                    'order_id' => $order_id,
                    'response_code' => $this->pos->get_response_code(),
                    'response_text' => $this->pos->get_response_text(),
                    'ip' => $this->pos->get_ip(),
                    'read' => 0,
                    'created_at' => date("Y-m-d H:i:s")
                );
                $this->payment_error_model->insert($data);
            }
            catch(ValidationException $ex) {
                $error = $ex->getMessage();
            };
            
            if($error) {
                $this->session->set_flashdata('pos_error', $error);
                redirect('buy/index/'. $order_id);
            } else {
                //basarili 

                $this->load->model('pay/payment_success_model');
                $data = array(
                    'order_id' => $order_id,
                    'auth_code' => $this->pos->get_auth_code(),
                    'reference' => $this->pos->get_reference(),
                    'amount' => $amount,
                    'ip' => $this->pos->get_ip(),
                    'read' => 0,
                    'created_at' => date("Y-m-d H:i:s")
                );
                $this->payment_success_model->insert($data);

                if($order->external_registerer) { // dont register domain
                    $this->_do_proccess_without_register($order_id);
                } else {
                    $this->_do_process($order_id);
                }
                redirect('buy/success/'. $order_id);                
            }  
        }

        public function success($order_id) {
            $this->load->model('dashboard_model');
            $this->load->model('packages_model');
            $this->load->model('pay/contact_details_model');
            $this->load->model('pay/payment_success_model');
            $this->load->library('pos');

              $user_id = $this->auth->get_user_id();
              $order = $this->orders_model->get_order_by_id($order_id);

              if(!$order) {
                    die("Siparis bulunamadi...");
              }

              if($user_id != $order->user_id) {
                    die('Opps. Kullanici bilgileri ile siparis bilgileri ayni degil.');
              }

              if(!$this->payment_success_model->is_completed($order_id)) {
                    die('Opps. Odeme tamamlanmamis..');
              }
              $data = array();
              $package = $this->packages_model->get_package($order->package);
              $amount = $package->price;
              if($order->external_registerer == TRUE) $amount -= 20;
              $data['site_id'] = $order->site_id;
              $data['domain'] = $order->domain;
              $data['contact'] = $this->contact_details_model->get_contact($user_id);
              $data['package'] = $package;
              $data['pos_orderid'] = $this->pos->generate_orderid();
              $data['order_id'] = $order_id;
              $data['existing'] = $order->external_registerer;
              $data['amount'] = $amount;
              $data['email'] = $this->auth->get_email();
              $data['unread'] = $this->dashboard_model->get_unread_message($user_id);
              $data['unread_order'] = $this->orders_model->get_unread_orders($user_id);

              $data['header'] = $this->load->view('dashboard/header_view', $data, true);
              $data['footer'] = $this->load->view('dashboard/footer_view', '', true);
              $this->load->view('dashboard/pay_success_view', $data);
        }

        public function index($order_id) {
            $this->load->model('dashboard_model');
            $this->load->model('packages_model');
            $this->load->model('pay/contact_details_model');
            $this->load->model('pay/payment_success_model');

            $this->load->library('pos');

              $user_id = $this->auth->get_user_id();
              $order = $this->orders_model->get_order_by_id($order_id);

              if($this->payment_success_model->is_completed($order_id)) {
                    die("Bu siparis tamamlanmis...");
              }
              if(!$order) {
                    die("Siparis bulunamadi...");
              }

              if($user_id != $order->user_id) {
                    die('Opps. Kullanici bilgileri ile siparis bilgileri ayni degil.');
              }

              $data = array();
              $data['site_id'] = $order->site_id;
              $data['domain'] = $order->domain;
              $data['existing'] = $order->external_registerer;
              $data['contact'] = $this->contact_details_model->get_contact($user_id);
              $data['package'] = $this->packages_model->get_package($order->package);
              $data['pos_orderid'] = $this->pos->generate_orderid();
              $data['order_id'] = $order_id;

              $data['email'] = $this->auth->get_email();
              $data['unread'] = $this->dashboard_model->get_unread_message($user_id);
              $data['unread_order'] = 0;

              $data['header'] = $this->load->view('dashboard/header_view', $data, true);
              $data['footer'] = $this->load->view('dashboard/footer_view', '', true);
              $this->load->view('dashboard/pay_view', $data);
        }


        public function domain_agreement() {
            $this->load->model('pay/contact_details_model');

            $user_id = $this->auth->get_user_id();
            $data['contact'] = $this->contact_details_model->get_contact($user_id);
            $this->load->view('pages/domain_agreement_view', $data);
        }

        public function hosting_agreement() {
            $this->load->model('pay/contact_details_model');

            $user_id = $this->auth->get_user_id();
            $data['contact'] = $this->contact_details_model->get_contact($user_id);
            $this->load->view('pages/hosting_agreement_view', $data);
        }

        private function _do_proccess_without_register($order_id) {
             $this->_set_order($order_id);
                if($this->_set_domain()) {//add to database
                    if($this->_set_dns()) {//update dns
                        if($this->_set_yandex()) { // add yandex records
                            $this->_close_order(); // close the order
                        };
                    };
                };           
        }
        private function _do_process($order_id) {
            $this->_set_order($order_id);
            if($this->_buy()) {//register domain
                $this->_do_proccess_without_register($order_id);
            };
        }
        private function _set_order($order_id) {
            $order = $this->orders_model->get_order_by_id($order_id);
            if(!$order) {
                echo 'Sipariş bulunamadı..';
                die();
            }

            $this->_order = $order;            
        }

        private function _get_order() {
            return $this->_order;
        }

      	private function _buy() {
            $this->load->model('pay/orders_model');
            $this->load->model('pay/contact_details_model');
            $this->load->library('domain');

            $order = $this->_get_order();
            $order_id = $order->id;
            
            $contact = $this->contact_details_model->get_contact_array($order->user_id);
			if ($contact['customer_id'] == null) {
	            // Save Customer
	            $contact = $this->contact_details_model->get_contact_array($order->user_id);
                $exception = null;
	            try {
					$customer_id = $this->domain->add_customer($contact);
	            } catch (CustomerExistsException $e) {
                    $exception = "CustomerExistsException"; 
	            } catch(AccessDeniedException $e) {
                    $exception = "AccessDeniedException";
	            } catch(UnexpectedException $e) {
                    $exception = "UnexpectedException";
	            } catch(ConnectionException $e) {
                    $exception = "ConnectionException";
                }
                if($exception) {
                    $data = array(
                            'order_id' => $order_id,
                            'library' => 'domain',
                            'method' => 'add_customer',
                            'exception' => $exception
                        );
                    $this->exception_model->create($data);
                    return false;
                }
	            $this->contact_details_model->update_customer_id($order->user_id, $customer_id);
            	// \ Save Customer
            } else {
                $customer_id = $contact['customer_id'];
            }

           	// Save Contact
            if ($contact['contact_id'] == null) {
            	try {
	                $contact_id = $this->domain->add_contact($customer_id, $contact);
            	} catch (UnexpectedException $ex) {
            		  $data = array(
                            'order_id' => $order_id,
                            'library' => 'domain',
                            'method' => 'add_contact',
                            'exception' => 'UnexpectedException'
                        );
                    $this->exception_model->create($data);
                    return false;
            	}
                $this->contact_details_model->update_contact_id($order->user_id, $contact_id);                  

            } else {
                $contact_id = $contact['contact_id'];
            }
            // \ Save Contact

            $exception = null;
            // Save Domain
            try {
	            $this->domain->register_domain($customer_id, $contact_id, $order);
            } catch(UnexpectedException $ex) {
                $exception = "UnexpectedException";
            } catch(DomainExistsException $ex) {
                $exception = "DomainExistsException";
            } catch(ConnectionException $ex) {
                $exception = "ConnectionException";
            }

            if($exception) {
                $data = array(
                        'order_id' => $order->id,
                        'library' => 'domain',
                        'method' => 'register_domain',
                        'exception' => $exception
                    );
                $this->exception_model->create($data);
                return false;              
            }

            return true;
            // \ Save Domain
        }

        private function _set_domain() {
            $order = $this->_get_order();
            $this->domains_model->set_domain($order->site_id, $order->domain, $order->package, $order->external_registerer);

            return true;
        }
        
        private function _set_dns() {
            $this->load->library('dns');
            $order = $this->_get_order();

            try {
                $domain_id = $this->dns->add_domain($order->domain);
            } catch(UnexpectedDnsException $ex) {
                $data = array(
                        'order_id' => $order->id,
                        'library' => 'dns',
                        'method' => 'add_domain',
                        'exception' => "UnexpectedDnsException"
                    );
                $this->exception_model->create($data);                
                return false;
            }

            if(is_numeric($domain_id)) {
                $this->domains_model->set_do_id($order->domain, $domain_id);
                /**
                * @param int domain_id Required, Integer or Domain Name (e.g. domain.com), specifies the domain for which to create a record.
                * @param string record_type Required, the type of record you would like to create. 'A', 'CNAME', 'NS', 'TXT', 'MX' or 'SRV'
                * @param string data Required, this is the value of the record
                * @param string name Optional, String, required for 'A', 'CNAME', 'TXT' and 'SRV' records
                * @param priority integer priority Optional, required for 'SRV' and 'MX' records
                */
                $data = array(
                    'domain_id' => $domain_id,
                    'record_type' => 'CNAME',
                    'data' => '@',
                    'name' => 'www'
                );
                try {
                    $this->dns->add_record($data);
                } catch(UnexpectedDnsException $ex) {
                    $data = array(
                            'order_id' => $order->id,
                            'library' => 'dns',
                            'method' => 'add_record',
                            'exception' => "UnexpectedDnsException"
                        );
                    $this->exception_model->create($data);                     
                }
            }   

            return true;         
        }


        private function _set_yandex() {

            $this->load->library('yandex');
            $this->load->library('dns');
            $order = $this->_get_order();

            $do_domain_id = $this->domains_model->get_digital_ocean_domain_id($order->domain);
            $domain_id = $this->domains_model->get_domain_id($order->domain);

            $exception = null;
            try {
                $yandex_data = $this->yandex->reg_domain($order->domain);
                $this->yandex_model->save_site($domain_id, $yandex_data);

            } catch(UnexpectedYandexException $ex) {
                $exception = "UnexpectedYandexException";
            } catch(DomainLimitYandexException $ex) {
                $exception = "DomainLimitYandexException";
            }
            
            if($exception) {
                    $data = array(
                            'order_id' => $order->id,
                            'library' => 'yandex',
                            'method' => 'save_site',
                            'exception' => $exception
                        );
                    $this->exception_model->create($data); 

                    return false; 
            }

                /**
                * @param int domain_id Required, Integer or Domain Name (e.g. domain.com), specifies the domain for which to create a record.
                * @param string record_type Required, the type of record you would like to create. 'A', 'CNAME', 'NS', 'TXT', 'MX' or 'SRV'
                * @param string data Required, this is the value of the record
                * @param string name Optional, String, required for 'A', 'CNAME', 'TXT' and 'SRV' records
                * @param priority integer priority Optional, required for 'SRV' and 'MX' records
                */
                $data = array(
                    'domain_id' => $do_domain_id,
                    'record_type' => 'MX',
                    'data' => 'mx.yandex.net.',
                    'priority' => '10'
                );
                $this->dns->add_record($data);

                $data = array(
                    'domain_id' => $do_domain_id,
                    'record_type' => 'TXT',
                    'data' => 'v=spf1 redirect=_spf.yandex.net',
                );
                $this->dns->add_record($data);

                // Yandex mail doğrulama
                $data = array(
                    'domain_id' => $do_domain_id,
                    'record_type' => 'CNAME',
                    'name' => 'yamail-' . $yandex_data['secret_name'],
                    'data' => 'mail.yandex.com.tr.'
                );
                $this->dns->add_record($data);

                // Yandex mail yönlendirme
                $data = array(
                    'domain_id' => $do_domain_id,
                    'record_type' => 'CNAME',
                    'name' => 'mail',
                    'data' => 'domain.mail.yandex.net.'
                );
                $this->dns->add_record($data);

                return true;
        }

        private function _close_order() {
            $this->load->model('pay/orders_model');
            $order = $this->_get_order();
            $this->orders_model->close($order->id);

            return true;
        }              
}