<?php

class Payment_error_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }

    public function insert($data) {
    	$this->db->insert('payment_errors', $data);
    	return true;
    }
}