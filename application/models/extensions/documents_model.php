<?php

class Documents_model extends CI_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Remove Document
     * @param int $site_id
     * @param int $document_id
     * @return bool 
     */
    public function remove($site_id, $document_id) {
    	$this->db->delete('documents', array('site_id' => $site_id, 'id' => $document_id));
    	return true;
    }

    /**
     * Get Single Document
     * @param int $site_id
     * @param int $document_id
     * @return object|bool
     */
    public function get_document($site_id, $document_id) {
    	$query = $this->db->get_where('documents', array('site_id' => $site_id, 'id' => $document_id), 1, 0);
    	$row = $query->row();
    	if($row) {
    		return $row;
    	} else {
    		return false;
    	}
    }

    /**
     * Update document file id
     * @param int $site_id
     * @param int $document_id
     * @param int $file_id
     * @return bool
     *
     */
    public function update($site_id, $document_id, $file_id) {
        $this->db->where(array('site_id' => $site_id, 'id' => $document_id));
        $this->db->update('documents', array('file_id' => $file_id));

        return true;
    }
}