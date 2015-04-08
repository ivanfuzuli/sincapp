<?php

class Stats_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }

    public function get_status($site_id) {
    	
    }
}