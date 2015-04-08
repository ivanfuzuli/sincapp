<?php

class Domains_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function set_domain($site_id, $domain, $package, $external_registerer = 0) {
    	$data['site_id'] = $site_id;
    	$data['domain'] = $domain;
    	$data['package'] = $package;
        $data['external_registerer'] = $external_registerer;
        $data['yandex_logo_status'] = 0;
    	$data['years'] = 1;
    	$data['created_at'] = date("Y-m-d H:i:s");
    	if(!$this->is_existing($domain)) {
    		$this->db->insert('domains', $data);
    	}
    }


    public function set_do_id($domain, $domain_id) {
    	$data = array(
    		'digital_ocean_domain_id' => $domain_id
    		);
        $this->db->where('domain', $domain);
        $this->db->update('domains', $data);
        return true;
    }

    public function get_domain_id($domain) {
    	$query = $this->db->get_where('domains', array('domain' => $domain));
    	$row = $query->row();

    	if($row) {
    		return $row->id;
    	} else {
    		return false;
    	}
    }

    public function get_digital_ocean_domain_id($domain) {
    	$query = $this->db->get_where('domains', array('domain' => $domain));
    	$row = $query->row();

    	if($row) {
    		return $row->digital_ocean_domain_id;
    	} else {
    		return false;
    	}
    }
    /**
     * Is user exits?
     * @param int $user_id
     * @return bool
     */
    public function is_existing($domain){
            $query = $this->db->get_where('domains', array('domain' => $domain));
            $check = $query->num_rows();
            if($check >= 1){
                return true;
            }
            return false;
    }
}
