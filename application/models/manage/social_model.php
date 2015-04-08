<?php

class Social_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Getter for social table
     * @param int  $site_id
     * @return array
     */
    public function get_social($site_id, $prefix){
        
        $query = $this->db->get_where('social', array('site_id' => $site_id, 'prefix' => $prefix));
        $row = $query->row();
 
        if (!$row) {
        	$data = array(
        		'site_id' => $site_id,
        		'facebook' => false,
        		'twitter' => false,
        		'google' => false,
        		'social_statu' => false
        		);
        } else {
        	if(!$row->facebook && !$row->twitter && !$row->google) {
        		$statu = false;
        	} else {
        		$statu = true;
        	}
	        $data = array(
	        			'site_id' => $row->site_id, 
	        			'facebook' => $row->facebook, 
	        			'twitter' => $row->twitter, 
	        			'google' => $row->google,
	        			'statu' => $statu
					);        	
        }

        
        return $data;
    }    
    /**
    * Insert new social information if exists, update.
    * @param int $site_id
    * @param array $data
    * @return true
    */
    public function insert_or_update($site_id, $prefix, $data) {
        $data['prefix'] = $prefix;
    	if($this->is_exist($site_id, $prefix)) {
    		$this->db->where('site_id', $site_id);
    		$this->db->update('social', $data);
    	} else {
    		$this->db->insert('social', $data);
    	}
    }

    public function is_exist($site_id, $prefix){
        $query = $this->db->get_where('social', array('site_id' => $site_id, 'prefix' => $prefix));
        $check = $query->num_rows();
        if($check >= 1){
            return true;
        }
        return false;        
    }
}