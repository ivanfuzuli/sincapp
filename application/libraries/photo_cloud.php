<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photo_cloud {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
       
              $this->CI->lang->load('photo_cloud', 'turkish');             
              $this->CI->load->helper('language');//lang kısaltması icin gerekli          
    }
    
    function index($site_id, $extra_id, $mode){      
         $str = array();
         $str['mode'] = $mode;
         $str['photos_view'] = $this->_get_photos($site_id, $extra_id);
         $str['photo_cloud_id'] = $extra_id;
         
         $data = array();
         $data['icon'] = array("photo_upload icon_position_2 photoSelectBut", "edit_icon photoEditBut");
         $data['html'] = $this->CI->load->view('extensions/photo_cloud_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id, $prefix = null){
       $result =  $this->CI->db->insert('photo_cloud', array('site_id' => $site_id,'page_id'=> $page_id));
       
       if($result == TRUE){
            $id = $this->CI->db->insert_id();
       }else{
           $id = FALSE;
       }
      
       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        
        $data['callback'] = "photo_cloud.firstRun($id)";
 
       return $data;           
    }
    
    public function delete($site_id, $cloud_id){
        $this->CI->db->delete('photo_cloud', array('photo_cloud_id' => $cloud_id));
        $this->CI->db->delete('photos', array('photo_cloud_id' => $cloud_id));
        
        return true;
    }
    
    
    private function _get_photos($site_id, $cloud_id){
        $this->CI->load->model('extensions/photo_cloud_model');

        $data['photos'] = $this->CI->photo_cloud_model->get_photos($site_id, $cloud_id);
        return $this->CI->load->view('extensions/photos_view', $data, true);
    }
}