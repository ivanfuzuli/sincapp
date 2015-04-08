<?php

class Router_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function _get_id_by_sub($subdomain){
        $query = $this->db->get_where('sites', array('sitename' => $subdomain, 'statu' => 0));
        
        $row = $query->row();
        if(!$row){
            return false;
        }
        
        $domain = $this->_get_domain_by_site_id($row->site_id);
        if($domain): redirect('http://www.'.$domain.$_SERVER['REQUEST_URI'], 'location', 301); endif;//eski adresi redirekt et
        
        $site_id = $row->site_id;
        
        return $site_id;
    }
    
    private function _get_domain_by_site_id($site_id) {
        $query = $this->db->get_where('domains', array('site_id' => $site_id, 'status' => 0));
        
        $row = $query->row();
        if($row) {
            return $row->domain;
        } else {
            return false;
        }
    }

    public function _get_id_by_main($domain){
        $query = $this->db->get_where('domains', array('domain' => $domain, 'status' => 0));
        
        $row = $query->row();
        if(!$row){
            return false;
        }
        $site_id = $row->site_id;
        
        return $site_id;        
    }
    
}