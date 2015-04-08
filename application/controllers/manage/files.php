<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('manage/upload_model');
            $this->load->model('manage/files_model');

              $this->lang->load('photos', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli    
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }
        
        
        public function index(){
            echo "Opps";
        }
        public function add(){
          $this->load->helper('format_size_units');
          $this->load->model('packages_model');
           $user_id = $this->auth->get_user_id();
           $site_id = $this->__get_site_id();

          $package_name = $this->packages_model->get_package_name_by_site_id($site_id);
          $data['package'] = $this->packages_model->get_package($package_name);
          $data['storage_quota'] = $this->packages_model->get_storage_quota($site_id);
          $data['storage_percentage'] = number_format(($data['storage_quota'] / ($data['package']->storage * 1000)) * 100, 2);

           $data['files'] = $this->files_model->get_files($site_id);
           //burada güvenlik için bir token yarat
           $data['token'] = $this->upload_model->set_token($user_id, $site_id);
           $this->load->view('manage/files_view', $data);
           
        }
        
        public function remove(){
           $site_id = $this->__get_site_id();

           $file_id = $this->input->post('file_id');
           
           $this->files_model->remove($site_id, $file_id);
           $data['str'] = "<div class=\"info\">Döküman başarılı bir şekilde silinmiştir.</div>";
           
           $this->load->view('print_view', $data);
        }

        public function rename() {
            $site_id = $this->__get_site_id();
            $file_id = (int)$this->input->post('file_id');
            $name = $this->input->post('name', TRUE);

            $this->files_model->rename($site_id, $file_id, $name);
        }

        private function _multi($multi){
            if($multi == 1){
                return "";
            }else{
               return "noMulti";
            }
        }
}