<?php

class Exception_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
    * Getter for all exceptions
    * @param int $site_id
    * @return object
    */
    public function all() {
    	$query = $this->db->get('exceptions');

    	return $query->result();
    }

    /**
    * Adder for mail login to db
    * @param int $site_id
    * @param int $email
    * @return bool
    */
    public function create($data) {
        $data['status'] = 0;
        $data['created_at'] = date("Y-m-d H:i:s");
    	$this->db->insert('exceptions', $data);
    	return $this->db->insert_id();
    }

    /**
    * Remover for exception
    * @param int $id
    * @return bool
    */
    public function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete('exceptions');
		return true;
    }
}
