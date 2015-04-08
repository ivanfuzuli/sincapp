<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Public_Controller {
    
        public function __construct() {
            parent::__construct();
              $this->lang->load('footer', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli            
              $this->load->model('signup_model');
        }

	public function index()
	{
                $user_id = $this->auth->get_user_id();
                if($user_id){
                    redirect('dashboard/');
                }else{
                    //save ref
                    if ($this->input->get('ref')) {
                        $this->session->set_userdata('ref', $this->input->get('ref'));
                    }
                    $this->landing();
                }
	}
        
        public function landing() {
            $this->load->model('kokpit/kokpit_model');            
            $this->load->model('kokpit/blog_model');
            $this->load->model('signup_date_model');
            $attempts = $this->signup_date_model->get_ip_and_date_count();
            if($attempts > 4) {
                $this->session->set_userdata('captcha_signup', true);
            } else {
                $this->session->set_userdata('captcha_signup', false);
            }

            $user_id = $this->auth->get_user_id();
            $data = array();
            // Facebook like sayısı
            $ch = curl_init("http://graph.facebook.com/sincappmedia");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $raw = curl_exec($ch);
            curl_close($ch);
            $fb = json_decode($raw);
            $data['like_count'] = $fb->likes;
            $data['site_count'] = $this->kokpit_model->get_site_count();
            $data['user_count'] = $this->kokpit_model->get_user_count();
            $data['theme_count'] = $this->kokpit_model->get_theme_count();

            if ($user_id) {
                $data['logged'] = true;
            } else {
                $data['logged'] = false;
            }
            // setter for start point for counter
            foreach($data as $key => $value) {
              if ($data[$key] > 150) {
                $data[$key . '_start'] = $data[$key] - 150;
              } else {
                $data[$key . '_start'] = 0;
              }
            }
            $data['posts'] = $this->blog_model->get_posts(4, 0);
            $this->load->view('home/landing_view', $data);
        }

        public function fb_login($info) {
          $id = $info['id'];
          $email = $info['email'];

          // user doesn't exist
          if (!$this->signup_model->check_email($email)) {
              $this->signup_model->save_user(null, $email, $this->_randomPassword());
              $this->_save_mailchimp($email);

          };

          if ($this->auth->try_login(['email' => $email, 'password' => false, 'remember' => false])) {
              //facebook profile doesn't exist
              if(!$this->signup_model->check_fb_id($id)) {
                  $user_id = $this->auth->get_user_id();
                  $this->signup_model->save_facebook($user_id, $id, $info['first_name'], $info['last_name']);
              }

                redirect('dashboard/');
            } else {
                redirect('/');
            };
        }

        private function _randomPassword() {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }

        public function signup(){
            $this->load->model('signup_date_model');
            $this->load->model('signup_date_model');
            //captcha
            $attempts = $this->signup_date_model->get_ip_and_date_count();
            if($attempts > 4) {
                if(!$this->session->userdata('phrase') || $this->session->userdata('phrase') != $this->input->post('phrase')) {
                    $this->_error_parse("captcha_error");
                    return false;
                }
            }
            //captcha end

            $sitename = strtolower($this->input->post('sitename'));            
            $email = trim($this->input->post('email'));
            $password = $this->input->post('password');
            //boşsa eğer gönderilenler uyarı ver
            if(!$sitename or !$email or !$password): $this->_error_parse("empty_sitename"); return false; endif;
                //karakter sadece ingilizce olabilir
            if(!preg_match('/^[a-zA-Z0-9-_]+$/', $sitename)): $this->_error_parse("invalid_sitename_error"); return false; endif;
            //karakter sayısı sitename icin
            $len_sitename = strlen($sitename);
            if($len_sitename < 3 or $len_sitename > 25): $this->_error_parse("min_max_sitename_error"); return false; endif;
           //site adi daha once alinmis mi
            if($this->signup_model->check_sitename($sitename)): $this->_error_parse("sitename_exist"); return false; endif;
            //email geçerliliği
            if($this->isValidEmail($email)): $this->_error_parse("invalid_email_error"); return false; endif;
            //once alinmis mi
            if($this->signup_model->check_email($email)): $this->_error_parse("email_exist"); return false; endif;
            
            //şifre en az 4 
            if(strlen($password) < 4): $this->_error_parse("min_password_error"); return false; endif;
           
            //eğer tüm adımları geçmişse veri tabanına bilgileri işle
            $this->signup_model->save_user($sitename, $email, $password);
            $this->signup_date_model->save_ip_and_date();
            $login = $this->auth->try_login(array('email'=>$email, 'password' => md5($password), 'remember' => false));
            
            //kayıt basarili ona yönlendir
            if($login == true){
              // mailchimp'e adresi ekle
              $this->_save_mailchimp($email);

            $data['str'] = json_encode(['success' => true]);
            $this->load->view('print_view', $data);              
            }
        }
        private function _save_mailchimp($email){
              $MailChimp = new \Drewm\MailChimp('9be48668baed837835cbddf9d406b624-us8');
              $result = $MailChimp->call('lists/subscribe', array(
                'id'                => 'a6d3fae244',
                'email'             => array('email'=> $email),
                //'merge_vars'        => array('FNAME'=>'Davy', 'LNAME'=>'Jones'),
                'double_optin'      => false,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => false,
              ));          
        }

        public function login() {
            $this->load->library('fb');
                    // eğer fb linkiyse redirect etsin
            $this->fb->redirect_to_fb();
                    // fb bilgilerini alsın
            $fb_info = $this->fb->get_fb_info();
            if ($fb_info) {
              $this->fb_login($fb_info);
              return false;
            }
            $data['fb_link'] = $this->fb->get_url();
            $this->load->view('login_view', $data);
        }

        public function post_login(){

            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $remember = $this->input->post('remember');
            $attempt = $this->auth->get_attempt_count($email);

            // Captcha
            if ($attempt > 4) {
                if ($this->session->userdata('phrase') == "" || $this->session->userdata('phrase') != $this->input->post('phrase')) {
                    $this->session->set_userdata('login_captcha', true);
                    $this->session->set_flashdata('captcha_error', true);
                    redirect('home/login');
                    die();
                }
            }
            // End captcha
            if($remember != ""){
                $remember = true;
            }
            $password = md5($password);
            $login =  $this->auth->try_login(array('email'=>$email, 'password' => $password, 'remember' => $remember));
            if($login == true){
                  $this->session->set_userdata('login_captcha', false); // reset captcha statu
                  redirect('dashboard');
            }else{
                    $this->session->set_flashdata('login_error', true);
                    redirect('/home/login');
                }
        }
        public function isValidEmail($email){
            $this->load->helper('email');

              if((valid_email($email))){
              return false;
             }
             return true;
       }
       
       private function _error_parse($error){
           $p_data['str'] = json_encode(['success' => false, 'errors' => [ 0 => ['error' => $error]]]);

           $this->load->view('print_view', $p_data);    
       }
}
