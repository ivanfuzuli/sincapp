<?php

class Login_details_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_logins($limit, $where, $removed = false){
        $this->db->limit($limit, $where);
 
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('logins');
        $result = $query->result();
        return $result;
    }
}