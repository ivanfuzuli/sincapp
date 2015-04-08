<?php

class Kokpit_model extends CI_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_site_count($removed = false){
        if($removed == true){
            $this->db->where('statu', 2);
        }
        return $this->db->count_all_results('sites');
    }
    
    public function get_user_count(){
        return $this->db->count_all('users');
    }
    
     public function get_theme_count(){
        return $this->db->count_all('themes');
    }

    public function get_unread_feedback(){
         $this->db->where('to_id= 0 and to_read = 0 or sender_id = 0 and sender_read = 0', null, false);
         return $this->db->count_all_results('threads');       
    }
    
    public function get_unread_contact(){
         $query = $this->db->where('statu', 0);
         return $this->db->count_all_results('contacts');
    }
    
    public function get_unread_orders(){
         $query = $this->db->where('status', 0);
         return $this->db->count_all_results('domain_orders');
    }    
    public function get_delete_request(){
         $query = $this->db->where('statu', 2);
         return $this->db->count_all_results('sites');        
    }
    

}