<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_archive {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
        $this->CI->lang->load('blog_archive', 'turkish');             
        $this->CI->load->helper('language');//lang kısaltması icin gerekli       
    }
    
    function index($extra_id, $mode){
         $str['data'] = $this->_get_archive($extra_id);
         
         $data = array();
         $data['icon'] = false;
         $data['html'] = $this->CI->load->view('extensions/blog_archive_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id, $prefix = null){

        $data = array();
        $data['statu'] = true;
        $data['str'] = $page_id;
        $data['callback'] = "none";
        
       return $data;        
    }
    
    public function delete($cloud_id){
        return true;
    }
    
    
    private function _get_archive($page_id){
        
        $this->CI->db->select('entry_date, count(*) as total');
        $this->CI->db->order_by('entry_date', 'desc');
        $this->CI->db->group_by('MONTH(entry_date), YEAR(entry_date)');
        
        $this->CI->db->where(array('page_id' => $page_id));
        $query = $this->CI->db->get('entries');
        $data = $query->result();
        return $data;
    }
}