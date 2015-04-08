<?php

class Users_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_user_count(){
         return $this->db->count_all('users');
    }   
    
    public function get_users($limit, $where){
        $this->db->limit($limit, $where);
        $this->db->order_by('user_id', 'desc');
        $query = $this->db->get('users');
        $result = $query->result();
        return $result;
    }
    
    public function passive_user($user_id, $statu){
        //kullanıcıyı pasifleştirme
        $this->db->where('user_id', $user_id);
        $this->db->update('users', array('statu' => $statu));
        //sitelerini pasifleştirme
       $this->db->where('user_id', $user_id);
       $this->db->update('sites', array('statu' => $statu));
        return $statu;
    }
    
}