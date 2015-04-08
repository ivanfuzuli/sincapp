<?php
class Error extends CI_Controller {

        public function __construct() {
              parent:: __construct();                
              $this->lang->load('error', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli

        }
        
        public function no_auth(){
             $this->output->set_status_header('401');
             $this->load->view('error/re_login_warn_view');           
        }
        
        public function suspended_user(){
            $this->load->view('error/suspended_user_view');
            $this->auth->logout();
        }

        public function csrf() {
             $this->output->set_status_header('401');
             $this->load->view('error/csrf_error_view');            
        }
}