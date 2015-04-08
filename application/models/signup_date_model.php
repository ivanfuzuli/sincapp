<?php

class Signup_date_model extends CI_Model {


    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        
    }

    /**
    * Save users ip and date
    */
    public function save_ip_and_date() {
    	$data = array(
    		'ip' => $_SERVER['REMOTE_ADDR'],
    		'created_at' => date("Y-m-d H:i:s")
    	);
    	$this->db->insert('signups', $data);
    	return true;
    }

    public function get_ip_and_date_count() {
    	$ip = $_SERVER['REMOTE_ADDR'];
    	$query = $this->db->query("SELECT count(id) as count FROM signups WHERE ip ='$ip' AND created_at > CURDATE() - INTERVAL 1 DAY");
    	$row = $query->row();
    	if($row) {
    		return $row->count;
    	} else {
     		return 0;		
    	}

    }
}