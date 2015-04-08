<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('extensions/forms_model');
 
              $this->lang->load('forms', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli       
                                 
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
            $this->user_id = $this->auth->get_user_id();
 
        }

        public function edit(){
            $site_id = $this->__get_site_id();
            
            $form_id = (int)$this->input->post('form_id');
            $data['site_id'] = $site_id;
            $data['form_cloud_id'] = $form_id;
            $data['form_settings'] = $this->forms_model->get_settings($site_id, $form_id);
            $data['fields'] = $this->forms_model->get_fields($site_id, $data['form_cloud_id']);
            
            $this->load->view('extensions/form_edit_view', $data);
        }
        
        public function edit_do(){
            $site_id = $this->__get_site_id();
            
            $form_cloud_id = (int)$this->input->post('form_id');
            
            $email = trim($this->input->post('email'));
            $subject = trim($this->input->post('subject'));
            $str_send = trim($this->input->post('str_send'));
            $set_data = array('email' => $email, 'subject' => $subject, 'str_send' => $str_send);
            
            
            $ids = $this->input->post('field_id');
            $status = $this->input->post('statu');
            $labels = $this->input->post('label');
            $requireds = $this->input->post('required');
            
            $this->forms_model->update($site_id, $form_cloud_id, $ids, $status, $labels, $requireds, $set_data);
            
            $p_data = array();
            $p_data['info'] = "<div class=\"success\">".lang('succ_save_form')."</div>";
            $p_data['html'] = $this->_get_form_view($form_cloud_id);
            echo json_encode($p_data);  
        }
        
        private function _get_form_view($form_cloud_id){
         $site_id = $this->__get_site_id();

         $str['form_id'] = $form_cloud_id;
         $str['fields'] = $this->forms_model->get_fields($site_id, $form_cloud_id);
         
         $data = $this->load->view('extensions/form_view', $str, true);
         
         return $data;
        }
}