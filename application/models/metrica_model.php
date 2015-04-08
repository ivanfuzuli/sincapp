<?php

class Metrica_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    

    /**
     * Checker for metrica existing
     * @param int $site_id
     * @return bool
     */

    public function is_metrica_exist($site_id){
        $this->db->select('id');
        $query = $this->db->get_where('metrica', array('site_id' => $site_id) ,1 ,0);
        if($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function get_metrica_id($site_id) {
        $this->db->select('counter_id');
        $query = $this->db->get_where('metrica', array('site_id' => $site_id), 1, 0);
        $row = $query->row();

        if($row) {
            return $row->counter_id;
        } else {
            return false;
        }        
    }

    /**
     * Insert data to metrica table
     * @param array $data
     * @return bool  
     */
    public function insert($data) {
        $status = $this->db->insert('metrica', $data);
        return $status;
    }

    /**
     * Update a metrica counter
     * @param int $site_id
     * @param array $data
     * @return bool
     */
    public function update($site_id, $data) {
        $this->db->where(array('site_id' => $site_id));
        $status = $this->db->update('metrica', $data);

        return $status;
    }
    
    /**
     * Getter for metrica code
     * @param int $site_id
     * @return string|bool
     *
     */    
    public function get_code($site_id) {
        $this->db->select('code');
        $query = $this->db->get_where('metrica', array('site_id' => $site_id), 1, 0);
        $row = $query->row();

        if($row) {
            return $row->code;
        } else {
            return false;
        }
    }

    /**
     * Getter for all row data
     * @param int $site_id
     * @return object|bool
     */
    public function get_metrica($site_id) {
        $query = $this->db->get_where('metrica', array('site_id' => $site_id), 1, 0);
        $row = $query->row();

        if($row) {
            return $row;
        } else {
            return false;
        }        
    }
}