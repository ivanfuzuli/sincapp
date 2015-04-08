<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Slider_cloud {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
       
              $this->CI->lang->load('slider_cloud', 'turkish');             
              $this->CI->load->helper('language');//lang kısaltması icin gerekli          
    }
    
    function index($site_id, $extra_id, $mode){         
         $str = array();
         $data = array();
         $p_data  = array();
         
         $p_data['photos'] = $this->_get_sliders($site_id, $extra_id);
         
         $str['mode'] = $mode; //admin mi yoksa normal user mi
         
         $str['sliderView'] = $this->CI->load->view('extensions/sliders_view', $p_data, true);
         $str['slider_cloud_id'] = $extra_id;

         $data['icon'] = array("photo_upload icon_position_2 sliderUploadBut", "edit_icon sliderOpenBut");
         $data['html'] = $this->CI->load->view('extensions/slider_cloud_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id, $prefix = null){
       $result =  $this->CI->db->insert('slider_cloud', array('site_id' => $site_id));
       if($result == TRUE){
            $id = $this->CI->db->insert_id();
       }else{
           $id = FALSE;
       }
      
       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        
        $data['callback'] = "slider_cloud.firstRun($id)";
 
       return $data;           
    }
    
    public function delete($site_id, $cloud_id){
        $this->CI->db->delete('slider_cloud', array('slider_cloud_id' => $cloud_id));
        $this->CI->db->delete('sliders', array('slider_cloud_id' => $cloud_id));
        
        return true;
    }
    
    
    private function _get_sliders($site_id, $cloud_id){
           $this->CI->load->model('extensions/slider_cloud_model');
           $data = $this->CI->slider_cloud_model->get_sliders($site_id, $cloud_id);
           
           return $data;
    }
}