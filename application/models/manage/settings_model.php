<?php

class Settings_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function get_settings($site_id, $prefix){
        $this->db->select('title, site_desc, header_code, footer_code');
        
        $query = $this->db->get_where('settings', array('site_id' => $site_id, 'prefix' => $prefix));
        $row = $query->row();
        
        $title = $row->title;
        $site_desc = $row->site_desc;
        
        $header_code = $row->header_code;
        $footer_code = $row->footer_code;
        
        $data = array('site_id' => $site_id, 'title' => $title, 'site_desc' => $site_desc, 'header_code' => $header_code, 'footer_code' => $footer_code);
        
        return $data;
    }
    
    public function set_settings($site_id, $prefix, $data){
        $this->db->where(array('site_id' => $site_id, 'prefix' => $prefix));
        $this->db->update('settings', $data);   
        
        return true;
    }
    
    public function set_tour_complete($site_id){
        $this->db->where(array('site_id' => $site_id));
        $this->db->update('settings', array('tour' => 1));
        return true;
    }
}