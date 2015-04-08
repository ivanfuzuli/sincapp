<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Resize {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();          
        $this->CI->load->library('image_lib'); 

    }
    
    public function resize_pic($data){
        $site_id = (int)$data['site_id'];
        $pic_id = (int)$data['pic_id'];
        $thumb = $data['path'];
        $width = (int)$data['width'];
        $height = isset($data['height']) ? $data['height'] : false;
        $r_data = $this->_get_upload_file($site_id, $pic_id);//dosyanin yolunu al
        
        $file = './files/photos/';       
        $folder = $r_data['path'];
        $ext= $r_data['ext'];
        $file = $file.$site_id.'/'.$folder.'/photo'.$ext;

        $this->_resize_do($file, $width, $height, $thumb); //yeniden boyutlandir
        
        return $r_data;
    }
    
    private function _resize_do($file, $width, $height, $path){
        //boyutu degistir
        $config['image_library'] = 'gd2';
        $config['source_image']	= $file;
        $config['create_thumb'] = TRUE;
        $config['width']	 = $width;
        if (!$height) {
            $config['height'] = '1';
            $config['maintain_ratio'] = TRUE;            
        } else {
            $config['height'] = $height;
            $config['maintain_ratio'] = FALSE;            
        }
        $config['master_dim'] = 'width';        
        $config['thumb_marker'] = $path;
        
        $this->CI->image_lib->initialize($config);       
        if ( ! $this->CI->image_lib->resize()){
            echo $this->CI->image_lib->display_errors();
        }         
    } 
    
    //yeniden boyutlandirma islemleri
    private function _get_upload_file($site_id, $pic_id){
        $this->CI->db->select('path, ext, height, width');
        $query = $this->CI->db->get_where('pictures', array('site_id' => $site_id, 'pic_id' => $pic_id));
        $row = $query->row();
        
        $ext = $row->ext;
        $path = $row->path;
        $ratio = $row->height/$row->width;
        $data = array('path' => $path, 'ext' => $ext, 'ratio' => $ratio);
        return $data;
    }        
}