<?php

class Language_model extends CI_Model {
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
    * Check existing of english settings
    * @param int $site_id
    * @return bool
    */
    public function is_english_exist($site_id) {
        $query = $this->db->get_where('settings', array('site_id' => $site_id, 'prefix' => 'en'), 1, 0);   
            $row = $query->row();
            if(!$row){
                return false;
            } else {
            	return true;
            }
    }

    /**
    * Check existing of active english
    * @param int $site_id
    * @return bool
    */
    public function is_active_english_exist($site_id) {
    		$this->db->where("site_id = $site_id AND prefix = 'en' AND status = 0 OR site_id = $site_id AND prefix = 'en' AND status = 1");
      		$query = $this->db->get('settings');   
            $row = $query->row();
            if(!$row){
                return false;
            } else {
            	return true;
            }    	
    }

    /**
     * Getter for english status
     * @param int $site_id
     * @return int
     */ 
    public function get_english_status($site_id) {
            $this->db->where("site_id = $site_id AND prefix = 'en' AND status = 0 OR site_id = $site_id AND prefix = 'en' AND status = 1");
            $query = $this->db->get('settings');   
            $row = $query->row();
            if(!$row){
                return 0;
            } else {
                return $row->status;
            }        
    }

    /**
     * Getter for site settings
     * @param int $site_id
     * @param string $prefix
     * @return objecy
     *
     */ 

    public function get_settings($site_id, $prefix) {
        $query = $this->db->get_where('settings', array('site_id' => $site_id, 'prefix' => $prefix));
        return $query->row();
    }
    /**
    * Create english settings
    * @param int $site_id
    * @return bool
    */
    public function create_english_settings($site_id) {
    	$query = $this->db->get_where('settings', array('site_id' => $site_id));
    	$row = $query->row();

    	$data = array(
    		'prefix' => 'en',
    		'site_id' => $site_id,
    		'logo_top' => $row->logo_top,
    		'logo_left' => $row->logo_left,
    		'logo_type' => $row->logo_type,
    		'logo_img_id' => $row->logo_img_id,
    		'logo_str' => $row->logo_str,
    		'footer_str' => $row->footer_str,
    		'header_code' => $row->header_code,
    		'footer_code' => $row->footer_code,
            'title' => $row->title,
            'site_desc' => $row->site_desc,
    		'theme_id' => $row->theme_id,
    		'tour' => $row->tour,
    		'cover_photo' => $row->cover_photo,
    		'status' => 1
    		);

    	$this->db->insert('settings', $data);
    	return true;
    }

    public function create_social($site_id) {
        $query = $this->db->get_where('social', array('site_id' => $site_id, 'prefix' => null));
        $row = $query->row();

        if($row) {
        $data = array(
            'site_id' => $site_id,
            'prefix' => 'en',
            'facebook' => $row->facebook,
            'twitter' => $row->twitter,
            'google' => $row->google
            ); 
        $this->db->insert('social', $data);            
        }
        
        return true;                   
    }
    /**
    * Passive english settings
    * @param int $site_id
    * @return bool
    */
    public function passive_settings($site_id) {
    	if($this->is_english_exist($site_id)) {
    		$this->db->where(array('site_id' => $site_id, 'prefix' => 'en'));
    		$this->db->update('settings', array('status' => 2));
    	}

    	return true;
    }

    /**
    * Active english settings
    * @param int $site_id
    * @return bool
    */
    public function active_settings($site_id) {
    	if($this->is_english_exist($site_id)) {
    		$this->db->where(array('site_id' => $site_id, 'prefix' => 'en'));
    		$this->db->update('settings', array('status' => 1));
    	}

    	return true;
    }    
}