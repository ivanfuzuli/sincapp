<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends Admin_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('pay/orders_model');

        }

        public function index($page = 0){
            $this->load->helper('time_converter');
            //sayfalama basla
            $limit = 10;
            $this->load->library('pagination');
                $config['uri_segment'] = 4;
                $config['base_url'] = base_url().'kokpit/orders/index/';
                $config['total_rows'] = $this->orders_model->get_order_count();
                $config['per_page'] = $limit;

                $config['cur_tag_open'] = '<li class="active"><a href="#">';
                $config['cur_tag_close'] = '</a></li>';

                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';

                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '<li>';

                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';


                $this->pagination->initialize($config);
            $data['pages'] = $this->pagination->create_links();
            //sayfalama bitti
            $data['orders']  = $this->orders_model->get_orders($limit, $page);

            $p_data['middle']  = $this->load->view('kokpit/order_view', $data, true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();

            $this->load->view('kokpit/index_view', $p_data);
        }

        public function buy($order_id) {
            $this->load->model('pay/orders_model');
            $this->load->model('pay/contact_details_model');
            $this->load->library('domain');
            $order = $this->orders_model->get_order_by_id($order_id);
            if(!$order) {
                echo 'Sipariş bulunamadı..';
                die();
            }

            $contact = $this->contact_details_model->get_contact_array($order->user_id);

            /// Customer kaydet
            if ($contact['customer_id'] == null) {
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
                    echo $exception;
                    return false;
                }

                $this->contact_details_model->update_customer_id($order->user_id, $customer_id);
            } else {
                $customer_id = $contact['customer_id'];
            }

            /// Contact Kaydet
            if ($contact['contact_id'] == null) {
                try {
                    $contact_id = $this->domain->add_contact($customer_id, $contact);
                } catch (UnexpectedException $ex) {
                    echo "UnexpectedException";
                    return false;
                }
                $this->contact_details_model->update_contact_id($order->user_id, $contact_id);
            } else {
                $contact_id = $contact['contact_id'];
            }

            // Domain Kaydet
            $exception = null;
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
                echo $exception;
            } else {
                echo "Başarılı bir şekilde domain oluşturuldu.";
            }
        }

        public function set_domain($order_id) {
            $this->load->model('pay/orders_model');
            $this->load->model('kokpit/domains_model');
            $order = $this->orders_model->get_order_by_id($order_id);
            $this->domains_model->set_domain($order->site_id, $order->domain, $order->package, $order->external_registerer);
        }

        public function set_dns($order_id) {
            $this->load->library('dns');
            $this->load->model('pay/orders_model');
            $this->load->model('kokpit/domains_model');
            $order = $this->orders_model->get_order_by_id($order_id);
            try {
                $domain_id = $this->dns->add_domain($order->domain);

            } catch (Exception $ex) {
                echo "DNS kayıt edilirken bir hata oluştur. - add_domain";
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
                } catch(Exception $ex) {
                    echo "DNS kayıt edilirken alt alan oluşturulamadı";
                    return false;
                }
            }
        }

        public function set_yandex($order_id) {
            $this->load->model('pay/orders_model');
            $this->load->model('kokpit/domains_model');
            $this->load->model('yandex_model');

            $this->load->library('yandex');
            $this->load->library('dns');
            $order = $this->orders_model->get_order_by_id($order_id);
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
                echo $exception;
                return false;
            } else {
                echo "Yandex'e bağlandı";
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
        }

        public function reject_order($order_id) {
            $this->load->model('pay/orders_model');
            $this->orders_model->reject($order_id);
        }

        public function close_order($order_id) {
            $this->load->model('pay/orders_model');
            $this->orders_model->close($order_id);
        }
}
