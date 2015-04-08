<?php

class Theme_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_themes(){
        $query = $this->db->get('themes');

        return $query->result();
    }

    public function set_theme($site_id, $theme_id){
        $statu = $this->_check_exits($theme_id);
        if($statu == false){
            return false;
        }

        $this->db->where('site_id', $site_id);
        $this->db->update('settings', array('theme_id' => $theme_id, 'logo_left' => -1, 'logo_top' => -1));

        return true;
    }

    public function get_theme_id($site_id){
        $this->db->select('theme_id');
        $query = $this->db->get_where('settings', array('site_id' => $site_id));
        $row = $query->row();
        return $row->theme_id;
    }

    //tema gercekte var mi yok mu kontrol et
    private function _check_exits($theme_id){
        $query = $this->db->get_where('themes', array('theme_id' => $theme_id));
        $row = $query->row();

        if($row){
            return true;
        }else{
            return false;
        }

    }
}
