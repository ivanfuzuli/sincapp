<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Documents {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('extensions/documents_model');
     
    }
    
    function index($site_id, $extra_id, $mode){
        $this->CI->load->model('manage/files_model');
         $str = array();
         $str['mode'] = $mode;
         $str['ajax'] = false;
         $str['document_id'] = (int)$extra_id;
         $document = $this->CI->documents_model->get_document($site_id, (int)$extra_id);
         $str['file'] = $this->CI->files_model->get_file($site_id, $document->file_id);
         $data = array();
         $data['icon'] = 'edit_icon documentEditBut';
         $data['html'] = $this->CI->load->view('extensions/document_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id, $prefix = null){
       $result =  $this->CI->db->insert('documents', array('site_id' => $site_id, 'file_id' => 0));
       
       if($result == TRUE){
            $id = $this->CI->db->insert_id();
       }else{
           $id = FALSE;
       }

       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        $data['callback'] = "documents.firstRun($id)";
        
       return $data;        
    }
    
    public function delete($site_id, $document_id){
        $this->CI->documents_model->remove($site_id, $document_id);
        return true;
    }

}