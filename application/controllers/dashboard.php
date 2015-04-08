<?php
class Dashboard extends Auth_Controller {

        public function __construct() {
              parent:: __construct();
              $this->load->model('dashboard_model');

              $this->lang->load('dashboard', 'turkish');
              $this->lang->load('footer', 'turkish');

              $this->load->helper('language');//lang kısaltması icin gerekli

        }
	public function index()
	{
                $this->load->model('pay/orders_model');
                $this->load->helper('format_size_units');
                $data = array();
                $user_id = $this->auth->get_user_id();
                $p_data['sites'] = $this->dashboard_model->get_sites();

                $data['sites_view'] = $this->load->view('dashboard/sites_view', $p_data, true);

                $data['email'] = $this->auth->get_email();
                $data['unread'] = $this->dashboard_model->get_unread_message($user_id);
                $data['unread_order'] = $this->orders_model->get_unread_orders($user_id);
                $data['header'] = $this->load->view('dashboard/header_view',$data, true);
                $data['footer']     = $this->load->view('dashboard/footer_view', '', true);

                //bfcache bug fix
                $this->output->set_header("Cache-Control: no-store, no-cache");
                $this->load->view('dashboard_view', $data);
	}

  public function orders() {
      $user_id = $this->auth->get_user_id();

      $this->load->model('pay/orders_model');
      $this->orders_model->update_unread($user_id);
      $data = array();
      $data['orders'] = $this->orders_model->get_user_orders($user_id);
      $this->load->view('dashboard/orders_view', $data);
  }
  public function mails($site_id) {
      $this->load->model('site_model');
      $this->load->model('mails_model');
      $this->load->model('auth_model');

      $this->auth_model->check_auth($site_id);
      $data = array();
      $data['domain'] = $this->site_model->get_domain_by_site_id($site_id);
      $data['mails'] = $this->mails_model->get_mails($site_id);
      $data['site_id'] = $site_id;
      $this->load->view('dashboard/mails_view', $data);
  }

  public function add_mail() {
    $this->load->model('site_model');
    $this->load->model('mails_model');
    $this->load->model('packages_model');
    /**
    * @var string $email
    * @var string $password
    * @var int $site_id
    */
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $site_id = $this->input->post('site_id');

      // Check auth
      $this->load->model('auth_model');
      $this->auth_model->check_auth($site_id);
      //End Check auth

    /**
    * @var string $domain
    * @var object $limit of package
    * @var int $cnt total mail address count
    * @var string $login, login and domain ex. can@sincapp.com
    * @var bool|string $error, if it isn't false javascript will parse an error message
    * @var bool|string $success, if it isn't false javascript will parse an success message
    * @var int $email_id email user id
    */
    $domain = $this->site_model->get_domain_by_site_id($site_id);
    $package = $this->packages_model->get_package_by_domain($domain);
    $limit = $this->packages_model->get_package($package)->mail;
    $cnt = $this->mails_model->get_mails_count($site_id);
    $login = $email . "@" . $domain;
    $error = false;
    $success = false;
    $email_id = 0;

    if($email == "" || $password == "") {
        $error = "Lütfen tüm alanları doldurunuz.";
    }

    if ($cnt >= $limit) {
        $error = "Bu alanadına en fazla ".$limit." adet e-posta adresi ekleyebilirsiniz.";
    }

    if($error == false) {
      $this->load->library('yandex');
      /**
      * @var string $err , yandex error messages, if it is null it should be success
      */
      $err = $this->yandex->reg_user($domain, $email, $password);
      //echo $err;
      if(!$err) {
        $success = "E-Posta başarılı bir şekilde oluşturuldu.";
        $email_id = $this->mails_model->add_user($site_id, $email);
        // if domain logo isn't uploaded to yandex, upload it
        $yandex_mail_status = $this->mails_model->get_yandex_logo_status($site_id);
        if(!$yandex_mail_status) {
          $this->mails_model->update_yandex_logo_status($site_id);
          $this->yandex->add_logo($domain);
        }
      } else {
        switch ($err) {
          case 'not_allowed':
            $error = "Alan adı dnsleri henüz tamamlanmamış. Lütfen birkaç saat sonra tekrar deneyin.";
            break;
          case 'badlogin':
            # code...
            $error = "E-Posta adresi için seçilen isim hatalı. Lütfen özel karakter ve ü,ğ,i,ş,ç,ö kullanmayın.";
            break;

          case 'passwd-tooshort':
            $error = "Şifre çok kısa. En az 6 karakterden oluşmalı.";
            break;
          case 'occupied':
            $error = "Bu adres zaten kullanımda.";
            break;
          default:
            $error = "Opps. Bir hata oluştu.";
            break;
        }
      }
    }
    echo json_encode(array('error' => $error, 'success' => $success, 'login' => $login, 'email_id' => $email_id));
  }

  public function delete_mail($site_id) {

      // Check auth
      $this->load->model('auth_model');
      $this->auth_model->check_auth($site_id);
      //End Check auth

      $this->load->model('site_model');
      $this->load->model('mails_model');
      $this->load->library('yandex');
      $mail_id = $this->input->post('id');
      $domain = $this->site_model->get_domain_by_site_id($site_id);
      $login = $this->mails_model->get_login_by_mail_id($mail_id);
      $this->yandex->delete_user($domain, $login);
      $this->mails_model->delete_user($mail_id);
  }

  public function domain($site_id) {
      $this->lang->load('dashboard', 'turkish');

      $data = array();
      $data['site_id'] = $site_id;
      $this->load->view('dashboard/domain_view', $data);
  }

  public function whois($site_id) {
      $this->load->library('domain');
      $this->load->helper('bolder_tdl');
      $domain = $this->input->post('domain');
      $tdls = $this->input->post('tdl');
      $json = $this->domain->whois($domain, $tdls);
      $data = array();
      $data['site_id'] = $site_id;
      $data['json'] = $json;
      $this->load->view('dashboard/domain_whois_view', $data);
  }

  public function buy($site_id, $domain, $existing = false) {
      $this->lang->load('buy', 'turkish');
      $this->load->model('pay/orders_model');
      $user_id = $this->auth->get_user_id();
      $data = array();
      $data['site_id'] = $site_id;
      $data['domain'] = $domain;
      $data['email'] = $this->auth->get_email();
      $data['existing'] = $existing;
      $data['unread_order'] = $this->orders_model->get_unread_orders($user_id);
      $data['unread'] = $this->dashboard_model->get_unread_message($user_id);
      $data['header'] = $this->load->view('dashboard/header_view', $data, true);
      $data['priceTable'] = $this->load->view('dashboard/price_table_view', array('no_buy_link' => false, 'existing' => ($existing == "existing" ? TRUE : FALSE)), true);
      $data['footer'] = $this->load->view('dashboard/footer_view', '', true);
      $this->load->view('dashboard/buy_view', $data);
  }

  public function details($site_id, $domain, $package, $existing, $error = false) {
      $this->load->model('pay/contact_details_model');
      $this->load->model('pay/orders_model');

      $user_id = $this->auth->get_user_id();
      $data = array();
      $data['site_id'] = $site_id;
      $data['domain'] = $domain;
      $data['package'] = $package;
      $data['error'] = $error;
      $data['existing'] = $existing;
      $data['details'] = $this->contact_details_model->get_contact($user_id);
      $data['email'] = $this->auth->get_email();
      $data['unread'] = $this->dashboard_model->get_unread_message($user_id);
      $data['unread_order'] = $this->orders_model->get_unread_orders($user_id);
      $data['header'] = $this->load->view('dashboard/header_view', $data, true);
      $data['footer'] = $this->load->view('dashboard/footer_view', '', true);
      $this->load->view('dashboard/details_view', $data);
  }

  public function details_do($site_id, $domain, $package) {

      $user_id = $this->auth->get_user_id();
      $existing = $this->input->post('existing');
      if($existing == "existing") {
          $external_registerer = TRUE;
      } else {
          $external_registerer = FALSE;
      }

      $data = array();
      $data['name'] = $this->input->post('name');
      $data['email'] = $this->input->post('email');
      $data['phone'] = $this->input->post('phone');
      $data['city'] = $this->input->post('city');
      $data['zipcode'] = $this->input->post('zipcode');
      $data['address'] = $this->input->post('address');

      // form validation
      if($data['name'] == "" || $data['email'] == "" || $data['phone'] == "" || $data['city'] == "" || $data['zipcode'] == "" || $data['address'] == ""){
          redirect(base_url() ."dashboard/details/" . $site_id ."/" . $domain ."/". $package ."/". $existing ."/error");
          return false;
      }
      $this->load->model('pay/contact_details_model');
      $this->load->model('pay/orders_model');
      // Kullanıcının kontakt bilgileri var mı?
      $status = $this->contact_details_model->is_existing($user_id);
      if ($status) {// varsa güncelle
          $this->contact_details_model->update($user_id, $data);
      } else { //yoksa yeni ekle
          $this->contact_details_model->save($user_id, $data);
      }

      //order'ı yaratmadan önce sitenin sahibimi diye bak
      // Sahibi değilse die olur
      $this->orders_model->check_auth($site_id);
      //siparisi gir
      $order_data = array(
        'site_id' => $site_id,
        'domain' => $domain,
        'package' => $package,
        'user_read' => 0,
        'external_registerer' => $external_registerer,
        'created_at' => date("Y-m-d H:i:s"),
        'status' => 0
      );
      $order_id = $this->orders_model->save($order_data);

      redirect(base_url() . "buy/index/". $order_id);
  }


  public function pay($site_id, $domain, $package, $order_id) {
      $user_id = $this->auth->get_user_id();
      $data = array();
      $data['site_id'] = $site_id;
      $data['domain'] = $domain;
      $data['package'] = $package;
      $data['order_id'] = $order_id;

      $data['email'] = $this->auth->get_email();
      $data['unread'] = $this->dashboard_model->get_unread_message($user_id);
      $data['unread_order'] = $this->orders_model->get_unread_orders($user_id);      
      $data['header'] = $this->load->view('dashboard/header_view', $data, true);
      $data['footer'] = $this->load->view('dashboard/footer_view', '', true);
      $this->load->view('dashboard/paypal_view', $data);
  }

        public function get_sites(){

        }
        public function setting(){

            $value['email'] = $this->auth->get_email();
            $this->load->view('dashboard/settings_view', $value);
        }

        public function email_change(){
           $email = $this->input->post('email');
           $password = $this->input->post('password');

           $data = $this->dashboard_model->change_email($email, $password);
           $success = false;//hata yoksa errora fırlat varsa successe fırlat

           switch($data):
               case 0:
                   $success = true;
                   $message = lang('succ_change_email');
                   break;
               case 1:
                   $message = lang('err_change_email');
                   break;
               case 2:
                   $message = lang('err_pass_match');

                   break;
           endswitch;

           //hata yoksa errora fırlat varsa successe fırlat
           $value['str'] = $this->_alert_hand_str($success, $message);

           $this->load->view('print_view', $value);

        }

        public function pass_change(){
           $old_password = $this->input->post('old_password');
           $new_password = $this->input->post('new_password');
           $re_new_password = $this->input->post('re_new_password');
           $success = false;
           //en az 4 karakterli sifre olsun
           if(strlen($new_password) < 4 or strlen($re_new_password) < 4){

               $message = lang('error_sort_pass');
           }else{
                   //şifreler aynı mı
               if($new_password != $re_new_password){

                    $message = lang('error_dont_match_pass');
               }else{
                   //şifrele bakiim
                   $new_password = md5($new_password);
                    $data = $this->dashboard_model->change_password($old_password, $new_password);
                    if($data == true){
                        $success = true;
                        $message = lang('succ_change_pass');
                    }else{
                        $message = lang('err_pass_match');
                    }
               }
           };

           $value['str'] = $this->_alert_hand_str($success, $message);
           $this->load->view('print_view', $value);
        }

        public function add_site(){
           $this->load->view('dashboard/add_site_view');
        }

        public function add_site_do(){
            $this->load->helper('format_size_units');
            $sitename = trim($this->input->post('sitename', true));
            //eger daha once alinmis ya da bossa hata ver
            //karakter sayısı sitename icin
            $len_sitename = strlen($sitename);

            if($len_sitename < 3 or $len_sitename > 25): $this->_err_hand_arr(lang('err_sitename_count')); return false; endif;
            //karakter sadece ingilizce olabilir
            if(!preg_match('/^[a-zA-Z0-9-_]+$/', $sitename)): $this->_err_hand_arr(lang('err_only_english')); return false; endif;

            $str = $this->dashboard_model->add_site($sitename);
            if($str == false): $this->_err_hand_arr(lang('err_site_exits')); return false; endif;

            //başarılıysa
            $p_data['sites'] = $this->dashboard_model->get_sites();
                $data['statu'] = "success";
                $data['orders'] = array();
                $data['html'] = $this->load->view('dashboard/sites_view', $p_data, true);

                echo json_encode($data);

        }


        public function setup($site_id){
            $this->load->model('manage/theme_model');
            $data['site_id'] = (int)$site_id;
            $data['themes'] = $this->theme_model->get_themes();
            $data['errors'] = null;

            $this->load->view('dashboard/setup_view', $data);
        }

        public function setup_do(){
            $this->load->model('manage/theme_model');
            $site_id = (int)$this->input->post('site_id');
            $this->get_site_auth($site_id);//yetki kontrol

            $title = $this->input->post('title', true);
            $description = $this->input->post('description', true);
            $theme_id = (int)$this->input->post('theme_id');
            $theme_exits = $this->dashboard_model->theme_exits($theme_id);
            $error = null;

            $data['site_id'] = $site_id;

            //hata ayıklama
            if($title == ""):$error = lang('err_no_title'); endif;
            if($description == ""):$error = lang('err_no_desc');endif;
            if($theme_id == 0){
                $error = lang('err_no_theme');
            }else{
                if(!$theme_exits): $error = lang('err_no_theme_fatal'); endif;
            }

            if($error == null){

                $this->dashboard_model->setup($site_id, $title, $description, $theme_id);
                $p_data['sites'] = $this->dashboard_model->get_sites();

                $data['statu'] = "success";
                $data['url'] = base_url()."manage/editor/wellcome/".$site_id;
            }else{

                $data['statu'] = 'error';
                $data['message'] = $this->_alert_hand_str(false, $error);
            }
            echo json_encode($data);

        }

        public function feedback(){

            $sender_id = $this->auth->get_user_id();
            $thread_id = 0;//ilk mesaj oldugu icin thread olustursun diye
            $to_id = 0; //sadece admin sifir
            $message = trim($this->input->post('feed'));
            //feed yoksa hata ver
            if($message == ""){
                echo $this->_alert_hand_str(false, lang('err_no_feed'));
                return false;
            }else{
                $this->load->model('kokpit/feedback_model');
                //0 admin
                $this->feedback_model->set_message($sender_id, $to_id, $thread_id, $message);
                echo $this->_alert_hand_str(true, lang('succ_update_feed'));
            }
        }


        public function last_feeds(){
            $this->load->model('kokpit/feedback_model');

            $user_id = $this->auth->get_user_id();
            $data['feedbacks'] = $this->feedback_model->get_messages($user_id, 5, 0);
            $this->load->view('dashboard/home_feeds_view', $data);
        }

        public function thread($thread_id){
            $this->load->model('kokpit/feedback_model');
            $this->load->helper('time_converter');
            $thread_id = (int)$thread_id;
            $user_id = $this->auth->get_user_id();
            $p_data['thread_id'] = $thread_id;
            $p_data['feeds'] = "";
            $messages = $this->feedback_model->get_thread($user_id, $thread_id);
            foreach($messages as $message){
                $p_data['feeds'] .= $this->load->view('dashboard/thread_single_view', array('message' => $message), true);
            }
            $this->load->view('dashboard/thread_view', $p_data);
        }

        public function reply(){
            $this->load->model('kokpit/feedback_model');
            $this->load->helper('time_converter');

            $thread_id = (int)$this->input->post('thread_id');
            $user_id = $this->auth->get_user_id();
            $message = $this->input->post('message');
            $response = $this->feedback_model->reply($user_id, $thread_id, $message);

            if($response == true){
                $data = array('message' => array('email' => 'Ben', 'message' => $message, 'send_date' => time()));
                $this->load->view('dashboard/thread_single_view', $data);
            }else{
                echo "bir hata olustu.";
            }
        }

        /*Site silme bölümü*/
        public function delete($site_id){
            $user_id = $this->auth->get_user_id();
            $site_id = (int)$site_id;
            $data['site_id'] = $site_id;
            $this->load->view('dashboard/delete_site_view', $data);
        }

        public function delete_confirm(){
            $this->load->model('kokpit/sites_model');
            $user_id = $this->auth->get_user_id();

            $site_id = (int)$this->input->post('site_id');
            $password = $this->input->post('password');

            $response = $this->sites_model->delete_standart($user_id, $site_id, $password);
            $error = false;
            $success = false;
            switch ($response):
                case 'nomatch':
                    $error = "Girdiniz şifre hatalı. Lütfen tekrar deneyin.";
                    break;
                case 'noaccess':
                    $error = "Opps. Yetki hatası. Oturumunuz düşmüz olabilir. Lütfen tekrar giriş yapıp deneyin";
                    break;
                case 'success':
                    $success = true;
                    break;
            endswitch;

            if($success == true){
                //islem basarili
                $p_data['sites'] = $this->dashboard_model->get_sites();
                $data = array(
                    'statu' => 'success',
                    'sites' => $this->load->view('dashboard/sites_view', $p_data, true)
                );

            }else{
                //hatalar varsa isle
               $data = array(
                   'statu' => 'error',
                   'message' => $this->_alert_hand_str(false, $error)
               );
            }
            //isle
            echo json_encode($data);
        }

        public function logout(){
            $this->auth->logout();
            redirect(base_url());
        }

        /**
         *
         * @param type $message
         * return array
         */
        private function _err_hand_arr($message){
                $data['statu'] = "error";
                $data['message'] = $this->_alert_hand_str(false, $message);
                echo json_encode($data);
        }

        /**
         *
         * @param type $message
         * @return strıng
         */
        private function _alert_hand_str($success, $message){
            if($success == false){
                $str = "<div class=\"alert alert-error\"><a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>".$message."</div>";
            }else{
                $str = "<div class=\"alert alert-success\"><a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>".$message."</div>";

            }
            return $str;
        }
}
