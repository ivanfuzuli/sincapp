<?php

class Signup_model extends CI_Model {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        
    }
    
    public function save_user($sitename, $email, $password){ 
        if ($this->session->userdata('ref')) {
            $ref = $this->session->userdata('ref');            
        } else {
            $ref = null;
        }
        //passwordu sifreleme
        $password = md5($password);
        $data = array(
               'email' => $email ,
               'password' => $password,
               'statu' => 0,
               'ref' => $ref
         );

            $this->db->insert('users', $data); 
            //üyeyi olusturduk hadi simdi de siteyi kayit edelim
            $user_id = $this->db->insert_id();    
            
            if ($sitename != null) {
                $this->save_site($user_id, $sitename);
                return $user_id;
            }
            return true;
    }

    public function save_facebook($user_id, $fb_id, $first_name, $last_name){
        //passwordu sifreleme
        $data = array(
               'user_id' => $user_id,
               'fb_id'   => $fb_id,
               'first_name' => $first_name,
               'last_name'  => $last_name
         );

            $this->db->insert('facebook', $data); 
            //üyeyi olusturduk hadi simdi de siteyi kayit edelim
            $insert_id = $this->db->insert_id();    
            return true;
    }    
    //email adresi dogrulama
    public function check_email($email){
        $query = $this->db->get_where('users', array('email' => $email));
        $check = $query->num_rows();
        if($check >= 1){
            return true;
        }
        return false;
    }
    //site adı kayıt etme
    
    public function save_site($user_id, $sitename){
            $this->db->insert('sites', array('user_id' => $user_id, 'sitename' => $sitename)); 
            $site_id = $this->db->insert_id();    
            
            //foto klasörünü yarat
            $pathPic = './files/photos/'.$site_id.'/';
                mkdir($pathPic);
                chmod($pathPic, 0777);  
                
            $pathDoc = './files/documents/'.$site_id.'/';
                mkdir($pathDoc);
                chmod($pathDoc, 0777); 
                
            return true;
    }
   
    //site adı alınmmış mı
    public function check_sitename($sitename){
        $query = $this->db->get_where('sites', array('sitename' => $sitename));
        $check = $query->num_rows();
        if($check >= 1){
            return true;
        }
        return false;        
    }

    public function check_fb_id($fb_id){
        $query = $this->db->get_where('facebook', array('fb_id' => $fb_id));
        $check = $query->num_rows();
        if($check >= 1){
            return true;
        }
        return false;        
    }    
}