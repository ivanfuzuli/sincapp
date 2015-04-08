<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Htmls {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
                      
        $this->CI->lang->load('paragraph', 'turkish');             
        $this->CI->load->helper('language');//lang kısaltması icin gerekli        
    }
    
    function index($site_id, $extra_id, $mode){
         $str['data'] = $this->_get_html($site_id, $extra_id);
         
         $data = array();
         $data['icon'] = 'edit_icon htmlEditBut';
         $data['html'] = $this->CI->load->view('extensions/html_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id, $prefix = null){
       $result =  $this->CI->db->insert('htmls', array('site_id' => $site_id));
       
       if($result == TRUE){
            $id = $this->CI->db->insert_id();
       }else{
           $id = FALSE;
       }
       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        $data['callback'] = "htmls.firstRun($id)";
        
       return $data;        
    }
    
    public function delete($site_id, $html_id){
        $this->CI->db->delete('htmls', array('html_id' => $html_id));
        return true;
    }
    
    private function _get_html($site_id, $html_id){
        $query = $this->CI->db->get_where('htmls', array('site_id' => $site_id, 'html_id' => $html_id));
        
        return $query->row();
    }
}