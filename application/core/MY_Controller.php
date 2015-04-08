<?php if (!defined('BASEPATH')) exit('No direct access allowed.');
/*****
  * This class provides a set of base Controller classes to be utilized with ErkanaAuth
  * @author     Michael Wales
  * @email      webmaster@michaelwales.com
  * @filename   MY_Controller.php
  * @title      ErkanaAuth Controller Library
  * @url        http://www.michaelwales.com/
  * @version    1.0
  *****/

// Controllers accessible by everyone, regardless of login status
class Public_Controller extends CI_Controller {

    function Public_Controller() {
        parent::__construct();
	
      // Get the user data, in case they are logged in
        $this->data = new stdClass();
        $this->data->user = $this->auth->get_user($this->session->userdata('user_id'));
        
        //eger hesap askiya alinmissa
        if($this->data->user == 'suspended'){
            redirect('error/suspended_user');
        }
     //beni hatirla varsa
     $remember = $this->input->cookie('token', TRUE);
     if($remember and $this->data->user === FALSE){
            $this->auth->remember_login($remember);
     }
    }
    
    // This function is used to prevent a user from accessing a method if they are logged in
    function no_user_access() {
        if ($this->data->user !== FALSE) {		
            redirect('error/user');
        }
    }
	
}

// Controllers only accessible by logged in users
class Auth_Controller extends Public_Controller {
    function Auth_Controller() {
        parent::Public_Controller();
        if ($this->data->user === FALSE) {
            // The user is not logged in, send them to the homepage
            redirect('');
        }
    }
    //güvenlik için sitenin sahibiyle istek yapılan id ayni mi
    public function get_site_auth($site_id){
       $this->db->select('site_id');
       $query = $this->db->get_where('sites', array('site_id' => (int) $site_id, 'user_id' => $this->auth->get_user_id()));
       $count = $query->num_rows();
        $statu = $this->auth->get_statu();
       
        //giris yapmamissa ve admin degilse
       if($count != 1 and $statu != 2){
           echo "Opps. Yetki hatasi";
           die;
       }
    }    
} 


// Controllers only accessible to logged in users that are admins
class Editor_Controller extends Public_Controller {
    protected $site_id;
    
    function __construct() {

        parent::Public_Controller();

        if ($this->data->user === FALSE) {
            $seg  = $this->uri->segment(3, 0);
            if($seg == "wellcome"){
                redirect('');                
            }else{//ajax isteklerini buna yönlme
                redirect('error/no_auth');
            }
        }else{
            
        }
    }
    //güvenlik için sitenin sahibiyle istek yapılan id ayni mi
    public function get_site_auth($site_id){
       $this->db->select('site_id');
       $query = $this->db->get_where('sites', array('site_id' => (int) $site_id, 'user_id' => $this->auth->get_user_id()));
       $count = $query->num_rows();
       $statu = $this->auth->get_statu();
      //sitenin sahibi ya da admin degilse
       if($count != 1 and $statu != 2){
            $this->output->set_status_header('401');           
           echo "Opps. Yetki hatasi";
           die;
       }
    }
    
        //site numarasini ayarla 
        protected function __set_site_id(){
                $site_id = (int)$this->input->post('site_id');
                $this->get_site_auth($site_id);  
                
                $this->site_id = $site_id;
        } 
        
        protected function __get_site_id(){
            return (int)$this->site_id;
        }        
} 

//tüm sistem yöneticisi
class Admin_Controller extends Public_Controller{
    public function __construct() {
        parent::__construct();
        
        $statu = $this->auth->get_statu();
        
        //eger admin degilse erisemesin
        if($statu != 2){
            $this->output->set_status_header('401');
            echo "Opps. Erişim engellendi..";
            die;
        }        
    }
}

?>