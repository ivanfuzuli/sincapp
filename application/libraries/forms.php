<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forms {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
              $this->CI->lang->load('forms', 'turkish');             
              $this->CI->load->helper('language');//lang kısaltması icin gerekli 
    }
    
    function index($site_id, $extra_id, $mode, $prefix = null){    
        $data = array();
        $form_data = array();
        $str = array();
        
         $form_data['fields'] = $this->_get_form($site_id, $extra_id);

         $str['form_id'] = $extra_id;
         $str['formView'] = $this->CI->load->view('extensions/form_view', $form_data, true);
         
         $data['icon'] = 'edit_icon formsEditBut';
         $data['html'] = $this->CI->load->view('extensions/form_cloud_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id){
       $email = $this->CI->auth->get_email();
       $subject = lang('succ_send_subject');
       $str_send = lang('succ_send_mail');
       $result =  $this->CI->db->insert('form_cloud', array('site_id' => $site_id,'email'=> $email, 'subject' => $subject, 'str_send' => $str_send));//default meridyen
       
       if($result == TRUE){
            $id = $this->CI->db->insert_id();
       }else{
           $id = FALSE;
       }
       
       $this->_create_form($site_id, $id);
       
       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        $data['callback'] = "null";
       return $data;        
    }
    
    public function delete($site_id, $form_id){
        $this->CI->db->delete('form_cloud', array('form_cloud_id' => $form_id));
        $this->CI->db->delete('forms', array('form_cloud_id' => $form_id));
        
        return true;
    }
    
    private function _create_form($site_id, $c_id){
        $label = lang('label_name_sirname');
        $type = "input";
        $sort = 1;        
        $data = array('site_id' => $site_id, 'form_cloud_id' => $c_id, 'label' => $label, 'type' => $type, 'required' => true, 'sort' => $sort);
        
        $this->_set_form($data);
 
        $label = lang('label_email');
        $type = "input";
        $sort = 2;        
        $data = array('site_id' => $site_id, 'form_cloud_id' => $c_id, 'label' => $label, 'type' => $type, 'required' => true, 'sort' => $sort);
        
        $this->_set_form($data);
        
        $label = lang('label_message');
        $type = "textarea";
        $sort = 3;        
        $data = array('site_id' => $site_id, 'form_cloud_id' => $c_id, 'label' => $label, 'type' => $type, 'required' => true, 'sort' => $sort);
        
        $this->_set_form($data);        
    }
    
    private function _set_form($data){
         $this->CI->db->insert('forms', $data);
       
    }
    private function _get_form($site_id, $form_cloud_id){
        $this->CI->db->order_by('sort');
        $query = $this->CI->db->get_where('forms', array('site_id' => $site_id, 'form_cloud_id' => $form_cloud_id));
        $result = $query->result();
        
        
        return $result;
    }
    
}