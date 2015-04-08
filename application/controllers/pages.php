<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Public_Controller {

	public function index()
	{

	}
        
        public function about(){
            $this->load->view('pages/about_view');
        }
        
        public function privacy(){
            $this->load->view('pages/privacy_view');
        }   
        
        public function sozlesme(){
            $this->load->view('pages/sozlesme_view');
        }   
        public function yer_saglayici(){
            $this->load->view('pages/yer_saglayici_view');
        }   
        public function contact(){
            $this->load->view('pages/contact_view');
        }      
        
        /**
        * Ajax contact form submission for popup window
        */
        public function form_do(){
            $this->load->model('dashboard_model');
            
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');
            //hata ayıkla
            if(!$name or !$email or !$message): 
                $this->_alert_parse(array('msg_class' => 'alert-error' ,'title' => 'Oppss!', 'str' => 'Lütfen tüm alanları doldurunuz.')); 
            return false; 
            endif;
            
            //hata yoksa isle
            $this->dashboard_model->set_contact($name, $email, $message);
            $this->_alert_parse(array('msg_class' => 'alert-success' ,'title' => 'Teşekkürler!', 'str' => 'Mesajınız başarılı bir şekilde iletildi. En kısa zamanda size geri dönülecektir.'));    
        }


        /**
        * Ajax form submission for landing page
        */
       public function do_contact() {
          $this->load->model('dashboard_model');
            
            $name = $this->input->post('full_name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');
            //hata ayıkla
            if (!$name) {
                $this->_contact_error_parse('empty_name');
                return false;
            }
            
            if(!$email) {
                $this->_contact_error_parse('empty_email');
                return false;
            }

            if(!$message) {
                $this->_contact_error_parse('empty_message');
                return false;
            }            
            //hata yoksa isle
            $this->dashboard_model->set_contact($name, $email, $message);
            $data['str'] = json_encode(['success' => true]);
            $this->load->view('print_view', $data);  

       }

       private function _contact_error_parse($error) {
           $p_data['str'] = json_encode(['success' => false, 'errors' => [ 0 => ['error' => $error]]]);

           $this->load->view('print_view', $p_data);        
       }
        
       private function _alert_parse($data){
           $p_data['str'] = $this->load->view('dashboard/alert_template_view', $data, true);

           $this->load->view('print_view', $p_data);
       }        
}