<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documents extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('extensions/documents_model');   
            $this->load->model('manage/files_model');   
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }
        
        
        public function index(){
            echo "Opps";
        }

        public function update() {
           $site_id = $this->__get_site_id();
           $document_id = (int)$this->input->post('document_id');
           $file_id = (int)$this->input->post('file_id');
           $this->documents_model->update($site_id, $document_id, $file_id);

           $data = array();
           $data['noParent'] = true;
           $data['file'] = $this->files_model->get_file($site_id, $file_id);

           $this->load->view('extensions/document_view', $data);
        }
}