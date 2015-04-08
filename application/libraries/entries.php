<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Entries {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
        
        $this->CI->load->model('extensions/entries_model');
              
        $this->CI->lang->load('entries', 'turkish');             
        $this->CI->load->helper('language');//lang kısaltması icin gerekli        
    }
    
    function index($page_id, $mode){
         $ext['updater'] = true;
         $ext['start'] = 5;
         $ext['entries'] = $this->CI->entries_model->get_entries($page_id);
        
         $data = array();
         $data['icon'] = false;
         $data['html'] = $this->CI->load->view('extensions/entries_view', $ext, true);
         return $data;
    }

    public function create($site_id, $page_id, $prefix = null){
       $data = array();
       $count = $this->_ext_count($page_id);
       if($count > 0){
          $data['statu'] = false;
          $data['str'] = lang('err_create_only_one');
       }else{
          $data['statu'] = true;
          $data['str'] = $page_id;
          $data['callback'] = "entries.firstRun()";
          
       }
       
       return $data;        
    }
    
    public function delete($page_id){

          $count = $this->_entry_count($page_id);
          if ($count > 0){
              $err = lang('err_entry_exits');
              
              return $err;
          }
       // baska silinecek bir sey varsa buraya gelsin
        return true;
    }  
    
    private function _entry_count($page_id){
          $this->CI->db->select('entry_id');
         $query = $this->CI->db->get_where('entries', array('page_id' => $page_id)); 
         
         return $query->num_rows();
    }
    
    private function _ext_count($page_id){
          $this->CI->db->select('ext_id');
         $query = $this->CI->db->get_where('extensions', array('ext_name' => 'entries', 'page_id' => $page_id)); 
         
         return $query->num_rows();        
    }
}