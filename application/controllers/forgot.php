<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot extends CI_Controller {

    
        public function __construct() {
              parent:: __construct();  
              $this->load->model('forgot_model');
              
              $this->lang->load('forgot', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli              
        }
        
        public function index(){
            $this->load->view('dashboard/forgot_view');
        }
        
        //yenileme epostası gönderildi
        public function rec(){
            $email = $this->input->post('email');
            $valid = $this->_isValidEmail($email);
            $data = array();
            $data['msg_class'] = "alert-danger";
            $data['title'] = "Opps!";
            
            if($email == "" or $valid==false){
                $data['str'] = lang('err_invalid_email');
            }else{
                       //benzersiz anahtar olusturmaca
                        $salt = "duzzz";
                        $token = $email.$salt.microtime();
                        $token = md5($token);
                        
                //anahtari ve emaili vtye kaydet
                $response = $this->forgot_model->add_to_db($email, $token);
                
                if($response == "noemail"){//eposta adresi yoksa
                    $data['str'] = lang('err_invalid_email_db');
                    
                }elseif($response == "timeerror"){//24 saate 3 taneden fazla ise
                    $data['str'] = lang('err_mail_timeerror');
       
                }elseif($response == "success"){//islem basarili
                    $this->_send_email($email, $token);
                    $data['msg_class'] = "alert-success";
                    $data['title'] = lang('succ_success_title');
                    $data['str'] = sprintf(lang('succ_success_send'), $email);                                 
                }
            }
            $this->load->view('dashboard/alert_template_view', $data);
        }
        
        public function validate($token = null){
            $data['token'] = $token;
            $data['alert'] = false;
            $this->load->view('dashboard/forgot_validate_view', $data);
        }
        
        //yeni sifreyi isle
        public function send(){
            $token = $this->input->post('token');
            $password = $this->input->post('password');
            $repassword = $this->input->post('repassword');
            
            $data['token'] = $token;
            $len = strlen($password);
            if($password != $repassword or $len < 4){
                $data['alert'] = $this->_error_parse(lang('err_pass_match'));
              
                if($len < 4){
                    $data['alert'] = $this->_error_parse(lang('err_pass_least'));                    
                }
               
                $this->load->view('dashboard/forgot_validate_view', $data);
                return false;
            }
            
            $response = $this->forgot_model->check_token($token);
            $statu = $response['statu'];
            
            if($statu == "denied"){//eger token yoksa uyar
                $data['alert'] = $this->_error_parse(lang('err_token_denied'));
            }elseif($statu == "timeout"){
                $data['alert'] = $this->_error_parse(lang('err_token_timeout'));

            }elseif($statu == "success"){
                //basarili giris
                $password = md5($password);
                $email = $response['email'];
                $this->forgot_model->change_password($email, $password);
                $data['alert'] = $this->_success_parse(lang('succ_pass_changed'));                
            }else{
                $data['alert'] = $this->_error_parse(lang('err_token_fatal'));
                
            }
            $this->load->view('dashboard/forgot_validate_view', $data);            
        }

            
        private function _send_email($email, $token){
            $this->load->library('email');

            $url = base_url()."forgot/validate/".$token;
            $message = sprintf(lang('str_email_message'), $url);        

                $this->email->set_newline("\r\n"); 
                $this->email->from('noreply@sincapp.com', 'Sincapp');
                $this->email->to($email); 


            $this->email->subject(lang('str_email_subject'));
            $this->email->message($message);	

            $this->email->send();

        }
    
       
        private function _error_parse($msg){
           $data = array('msg_class' => 'alert-error' ,'title' => lang('err_error_title'), 'str' => $msg);
           $temp = $this->load->view('dashboard/alert_template_view', $data, true);
           return $temp;
       }
       
        private function _success_parse($msg){
           $data = array('msg_class' => 'alert-success' ,'title' => lang('succ_success_title'), 'str' => $msg);
           $temp = $this->load->view('dashboard/alert_template_view', $data, true);
           return $temp;
       }
       
        private function _isValidEmail($email){
            if (preg_match('|^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$|i', $email)) {
                return true;
            }else{
                return false;
            }  
        }
}