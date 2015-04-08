<?php

class Auth_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }

    /**
    * Check user auth
	*/

	public function check_auth($site_id) {
       $this->db->select('site_id');
       $query = $this->db->get_where('sites', array('site_id' => (int) $site_id, 'user_id' => $this->user_id));
       $count = $query->num_rows();
       $statu = $this->auth->get_statu();
      //sitenin sahibi ya da admin degilse
       if($count != 1 ){
            $this->output->set_status_header('401');           
           echo "Opps. Yetki hatasi";
           die;
       }
	}    
}

