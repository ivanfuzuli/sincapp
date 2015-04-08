<?php

class Migrate_mails_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }

    public function save($email, $name, $domain, $password) {
        $site_id = $this->get_site_id_by_domain($domain);
        if($site_id) {
        $data = array(
            'email' => $email,
            'name' => $name,
            'domain' => $domain,
            'site_id' => $site_id,
            'password' => $password,
        );

        $this->db->insert('migrate_email', $data);
        return true;            
        } else {
            return false;
        }

    }

    public function get_site_id_by_domain($domain) {
    	$query = $this->db->get_where('domains', array('domain' => $domain));
    	$row = $query->row();

        if($row) {
          return $row->site_id;
        } else {
            return false;
        }
    }

    public function is_mail_exists($email) {
		$this->db->where(array('email' => $email));
		$query = $this->db->get('migrate_email');
		if( $query->num_rows() > 0 ){
		 	return TRUE; 
		} else { 
			return FALSE; 
		}
    }

    public function get_mails() {
    	$this->db->order_by('id', 'desc');
    	$query = $this->db->get('migrate_email');
    	return $query->result();
    }

    public function get_mail($id) {
    	$query = $this->db->get_where('migrate_email', array('id' => $id), 1, 0);
    	return $query->row();
    }

    public function update_mail_status($id) {
    	$this->db->where('id', $id);
    	$this->db->update('migrate_email', array('mailed_status' => TRUE, 'mailed_date' => date("Y-m-d H:i:s")));
    }

    public function update_added_status($id) {
    	$this->db->where('id', $id);
    	$this->db->update('migrate_email', array('added_status' => TRUE));
    }    
}