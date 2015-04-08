<?php

class Mails_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
    * Getter for all email addres by site id
    * @param int $site_id
    * @return object
    */
    public function get_mails($site_id) {
    	$query = $this->db->get_where('domain_mails', array('site_id' => $site_id));

    	return $query->result();
    }

    /**
    * Getter for count of all mail address by site id
    * @param int $site_id
    * @return int
    */
    public function get_mails_count($site_id) {
      $query = $this->db->get_where('domain_mails', array('site_id' => $site_id));

      return $query->num_rows();
    }
    
    /**
    * Getter for yandex logo status
    * @param int $site_id
    * @return bool
    *
    */
    public function get_yandex_logo_status($site_id) {
        $query = $this->db->get_where('domains', array('site_id' => $site_id));
        $row = $query->row();
        return $row->yandex_logo_status;
    }

    public function update_yandex_logo_status($site_id) {
        $this->db->where('site_id', $site_id);
        $this->db->update('domains', array('yandex_logo_status' => true));
    }
    /**
    * Getter for mail login by mail id
    * @param int $mail_id
    * @return string
    */
    public function get_login_by_mail_id($mail_id) {
    	$this->db->select('name');
    	$query = $this->db->get_where('domain_mails', array('id' => $mail_id));
    	$row = $query->row();
    	return $row->name;
    }

    /**
    * Adder for mail login to db
    * @param int $site_id
    * @param int $email
    * @return bool
    */
    public function add_user($site_id, $email) {
    	$data = array(
    		'site_id' => $site_id,
    		'name' => $email
     		);
    	$this->db->insert('domain_mails', $data);
    	return $this->db->insert_id();
    }

    /**
    * Remover for mail login
    * @param int $id
    * @return bool
    */
    public function delete_user($id) {
		$this->db->where('id', $id);
		$this->db->delete('domain_mails');
		return true;
    }
}
