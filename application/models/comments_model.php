<?php

class Comments_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function set_comment($data){
        $entry_id = (int)$data['entry_id'];
        $this->db->insert('comments', $data);
        
        $this->db->set('comment_count', 'comment_count+1',FALSE);
        $this->db->where_in('entry_id', $entry_id); // '1' test value here ?
        $this->db->update('entries'); 
        
        return $this->db->insert_id();
    }
    
}