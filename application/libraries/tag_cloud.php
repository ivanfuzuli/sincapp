<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tag_cloud {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
        $this->CI->lang->load('tag_cloud', 'turkish');             
        $this->CI->load->helper('language');//lang kısaltması icin gerekli               
      
    }
    
    function index($extra_id, $mode){
         $str['data'] = $this->_get_tags($extra_id);
         
         $data = array();
         $data['icon'] = false;
         $data['html'] = $this->CI->load->view('extensions/tag_cloud_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id, $prefix = null){
       $result =  $this->CI->db->insert('tag_cloud', array('site_id' => $site_id,'page_id'=> $page_id));
       
       if($result == TRUE){
            $id = $this->CI->db->insert_id();
       }else{
           $id = FALSE;
       }
      
       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        $data['callback'] = "none";
 
       return $data;           
    }
    
    public function delete($cloud_id){
        $this->CI->db->delete('tag_cloud', array('cloud_id' => $cloud_id));
        return true;
    }
    
    
    private function _get_tags($cloud_id){
        $data = array();
        $this->CI->db->select('page_id');
        $query = $this->CI->db->get_where('tag_cloud', array('cloud_id' => $cloud_id));
        $row = $query->row();
        $page_id = $row->page_id;
        
        //genel sorgu
        $this->CI->db->order_by('tag_name');
        $this->CI->db->where(array('page_id' => $page_id));
        $query = $this->CI->db->get('tags');
        $data['tags'] = $query->result();
        
        //yüzdelik dilimi bilebilmek için
        $this->CI->db->select_max('tag_count', 'max_size');
        $query = $this->CI->db->get('tags');
        
        $data['max_size'] = $query->row()->max_size;
        
        return $data;

    }
}