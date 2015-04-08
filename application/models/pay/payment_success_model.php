<?php

class Payment_success_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }

    public function insert($data) {
    	$this->db->insert('payment_successes', $data);
    	return true;
    }    

    public function is_completed($order_id) {
            $query = $this->db->get_where('payment_successes', array('order_id' => $order_id));
            if ($query->num_rows() > 0){
                return true;
            }
            else{
                return false;
            }
    }
}