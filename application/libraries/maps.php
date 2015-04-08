<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Maps {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();

        $this->CI->lang->load('maps', 'turkish');             
        $this->CI->load->helper('language');//lang kısaltması icin gerekli        
    }
    
    function index($site_id, $extra_id, $mode){
         $map_data = $this->_get_map($site_id, $extra_id);
         
         $str['mode'] = $mode;
         
         $str['latitude'] = $map_data['latitude'];
         $str['longitude'] = $map_data['longitude'];
         $str['zoom'] = $map_data['zoom'];
         $str['map_title'] = $map_data['map_title'];
         
         $str['map_id'] = $extra_id;
         
         $data = array();
         $data['icon'] = false;
         $data['html'] = $this->CI->load->view('extensions/map_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id, $prefix = null){
       $result =  $this->CI->db->insert('maps', array('site_id' => $site_id,'latitude'=> '39.92077', 'longitude' => '32.85410999999999', 'zoom' => 8));//default meridyen
       
       if($result == TRUE){
            $id = $this->CI->db->insert_id();
       }else{
           $id = FALSE;
       }
       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        $data['callback'] = "maps.firstRun()";
       return $data;        
    }
    
    public function delete($site_id, $map_id){
        $this->CI->db->delete('maps', array('map_id' => $map_id));
        return true;
    }
    
    private function _get_map($site_id, $map_id){
        $query = $this->CI->db->get_where('maps', array('site_id' => $site_id, 'map_id' => $map_id));
        $row = $query->row();
        $data = array('latitude' => $row->latitude, 'longitude' => $row->longitude, 'map_title' => $row->map_title, 'zoom' => $row->zoom);
        
        return $data;
    }
}