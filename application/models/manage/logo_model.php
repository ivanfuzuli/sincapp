<?php

class Logo_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    
    }

    public function update_footer($site_id, $data, $prefix){
        $this->db->where(array('site_id'=>$site_id, 'prefix' => $prefix));
        $this->db->update('settings', $data); 
        
        return true;
    }
    
    public function update($site_id, $logo, $prefix){
        $this->db->where(array('site_id'=>$site_id, 'prefix' => $prefix));
        $this->db->update('settings', array('logo_str' => $logo, 'logo_type' => false)); 
        
        return true;
    }
    
    public function mode_text($site_id, $prefix){
        $this->db->where(array('site_id'=>$site_id, 'prefix' => $prefix));
        $this->db->update('settings', array('logo_type' => false));   
        $data = $this->_get_logo($site_id, $prefix);
        
        return $data;
    }
    
    public function update_position($site_id, $data, $prefix){
        $this->db->where(array('site_id'=>$site_id, 'prefix' => $prefix));
        $this->db->update('settings', $data);         
    }
    
    public function update_image($site_id, $pic_id, $prefix){
        $this->load->library('resize');
        $this->db->where(array('site_id'=>$site_id, 'prefix' => $prefix));
        $this->db->update('settings', array('logo_img_id' => $pic_id, 'logo_type' => true));   

        $config = array(
            'site_id' => $site_id,
            'pic_id' => $pic_id,
            'path' => '_logo',
            'width' => 150
        );
        $this->resize->resize_pic($config);
        
        $data = $this->_get_logo($site_id, $prefix);        
        return $data;        
    }

    
    
    public function resize_logo($site_id, $width, $height, $prefix){
        $this->load->library('resize');
        $query = $this->db->get_where('settings', array('site_id' => $site_id));
        $pic_id = $query->row()->logo_img_id;
        
        $config = array(
            'site_id' => $site_id,
            'pic_id' => $pic_id,
            'path' => '_logo',
            'width' => $width,
            'height' => $height
        );
        $this->resize->resize_pic($config);      
    }

    
    private function _get_logo($site_id, $prefix){
        $this->load->model('site_model');      

        $this->site_model->set_settings($site_id, $prefix);
        $data = $this->site_model->get_logo('ajax');
        
        return $data;
    }
}