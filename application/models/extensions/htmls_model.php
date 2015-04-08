<?php

class Htmls_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_html($html_id){
        $query = $this->db->get_where('htmls', array('html_id' => $html_id));
        $row = $query->row();
        
        return $row;
    }
    
    function set_html($site_id, $html_id, $content){
                    $this->db->where(array('site_id'=>$site_id, 'html_id' => $html_id));
                    $this->db->update('htmls', array('content' => $content));   
    }
}