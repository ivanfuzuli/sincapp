<?php

class Maps_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function save_do($site_id, $map_id, $data){
        $this->db->where(array('site_id'=>$site_id, 'map_id' => $map_id));
        $this->db->update('maps', $data);

    }

}