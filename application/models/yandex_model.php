<?php

class Yandex_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function save_site($domain_id, $data) {
    	if(!$this->is_existing($domain_id)) {
            $data['domain_id'] = $domain_id;
    		$this->db->insert('domain_yandexs', $data);
    	} else {
            $this->db->where('domain_id', $domain_id);
            $this->db->update('domain_yandexs', $data);            
        }
    }
    /**
     * Is user exits? 
     * @param int $user_id
     * @return bool
     */
    public function is_existing($domain_id){
            $query = $this->db->get_where('domain_yandexs', array('domain_id' => $domain_id));
            $check = $query->num_rows();
            if($check >= 1){
                return true;
            }
            return false;
    }
}