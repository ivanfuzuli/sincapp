<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate_mail extends Admin_Controller {
    
        public function __construct() {
            parent::__construct();
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('kokpit/contact_model');
            $this->load->model('kokpit/migrate_mails_model');
 
        }
        
        public function index($page = 0){

            $data = array();
            $data['mails'] = $this->migrate_mails_model->get_mails();      
            $p_data['middle']  = $this->load->view('kokpit/migrate_mail_view', $data, true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();            
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();

            $this->load->view('kokpit/index_view', $p_data);            
        }

        public function add() {
            $mails = $this->input->post('mails');
            if(!$mails) {
                redirect(base_url().'kokpit/migrate_mail');
            }
            $mails = trim($mails);
            $mails = explode ("\n", $mails);

            foreach($mails as $mail) {
                $mail = trim($mail);
                $mail_arr = explode("@", $mail);
                $name = $mail_arr[0];
                $domain = $mail_arr[1];
                if($domain) {
                 $password = $this->generate_password();

                if(!$this->migrate_mails_model->is_mail_exists($mail)) {
                    $this->migrate_mails_model->save($mail, $name, $domain, $password);
                };                   
                }

            }

            redirect(base_url().'kokpit/migrate_mail');
        }

        private function generate_password($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    public function send($id) {
        $mail = $this->migrate_mails_model->get_mail($id);

        $email = $mail->email;
        $password = $mail->password;
        $domain = $mail->domain;
        $this->load->library('email');
        
         $config['charset'] = 'utf-8';
         $config['mailtype'] = 'html';
         $config['newline'] = '\r\n';
        $this->email->initialize($config);

        $this->email->from('noreply@sincapp.com', 'NB Ajans');
        $this->email->to($email); 

        $this->email->subject('ÖNEMLİ!! Yeni E-Posta Şifreniz');
        $this->email->message('E-Posta sunucusundaki değişiklik nedeniyle size yeni bir geçici şifre tanımlanmıştır.<br><br>
            Bu geçici şifreyi bir gün sonra kullanmaya başlayacaksınız. E-Posta hesabınıza girmek için http://mail.' . $domain .' adresini kullanacaksınız.<br><br>
            Yeni E-Postanız tanımlandıktan sonra şuanki e-posta adresinizi kullanayamayacağınızdan dolayı lütfen bu e-postayı <b>farklı bir yere kaydedin.</b><br>
            E-Posta istemciniz için gerekli olan bilgilere buradan ulaşabilirsiniz. https://yardim.yandex.com.tr/mail/mail-clients.xml <br><br>
            Güvenliğiniz için giriş yaptıktan sonra geçici şifrenizi değiştiriniz. <b>Geçici şifreniz</b>: '.$password.'
        ');    

        $status = $this->email->send(); 
        if($status == TRUE) {
            $this->migrate_mails_model->update_mail_status($id);
        }
    }

    public function connect($id) {
        $mail = $this->migrate_mails_model->get_mail($id);

        $email = $mail->email;
        $password = $mail->password;
        $domain = $mail->domain;
        $site_id = $mail->site_id;

    $this->load->model('site_model');
    $this->load->model('mails_model');
    $this->load->model('packages_model');

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
        $this->migrate_mails_model->update_added_status($id);
        $success = "E-Posta başarılı bir şekilde oluşturuldu.";
        $email_id = $this->mails_model->add_user($site_id, $email);
        // if domain logo isn't uploaded to yandex, upload it
        $yandex_mail_status = $this->mails_model->get_yandex_logo_status($site_id);
        if(!$yandex_mail_status) {
          $this->mails_model->update_yandex_logo_status($site_id);
          $this->yandex->add_logo($domain);
        }

        echo $success;
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

        echo $error;
      }
    } else {
        echo $error;
    }

    }
}