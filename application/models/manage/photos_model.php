<?php

class Photos_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }
    
    public function get_pictures($site_id){
        $this->db->order_by('pic_id', 'desc');
        $query = $this->db->get_where('pictures', array('site_id' => $site_id));
        $result = $query->result();
        
        $data = array();
        foreach($result as $row){
            $pic_id = $row->pic_id;
            $path = CDN.'photos/'.$row->site_id.'/'.$row->path;
            
            $ext = $row->ext;
            $data[] = array('pic_id' => $pic_id,'path' => $path, 'ext' => $ext);
        }
        
        return $data;
    }
    
    public function del_picture($site_id, $pic_id){
        $site_id = (int)$site_id;
        
        $query = $this->db->get_where('pictures', array('site_id' => $site_id, 'pic_id' => $pic_id));
        $row = $query->row();
        $path = $row->path;
        $ext = $row->ext;
        
        $this->db->delete('pictures', array('site_id' => $site_id, 'pic_id' => $pic_id));
        $this->db->delete('photos', array('site_id' => $site_id, 'pic_id' => $pic_id));
        
        $dirPath = './files/photos/'.$site_id.'/'.$path.'/';
        
        $files = glob($dirPath . '*', GLOB_MARK);
        
        foreach ($files as $file) {
            unlink($file);
        }        
        rmdir($dirPath);
        
        return true;
    }
}