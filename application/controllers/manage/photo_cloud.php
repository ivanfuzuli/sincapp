<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo_cloud extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();
              $this->load->model('extensions/photo_cloud_model');
            
              $this->lang->load('photo_cloud', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli                            
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }
     
        public function add(){
            $site_id = $this->__get_site_id();

            $cloud_id = $this->input->post('cloud_id');
            $photos = $this->input->post('photos');
            
            $this->photo_cloud_model->set_photos($site_id, $cloud_id, $photos);
            
            $data['photos'] = $this->photo_cloud_model->get_photos($site_id, $cloud_id);
            $this->load->view('extensions/photos_view', $data);
            
        }

        public function get_modal() {
            $site_id = $this->__get_site_id();
            $cloud_id = $this->input->post('cloud_id');

            $data = array();

            $data['site_id'] = $site_id;
            $data['cloud_id'] = $cloud_id;
            $data['photos'] = $this->photo_cloud_model->get_photos($site_id, $cloud_id);
            $this->load->view('manage/photo_cloud_modal_view', $data);
        }

        public function set_settings() {
            $site_id = $this->__get_site_id();
            $cloud_id = $this->input->post('cloud_id');

            $ids = $this->input->post('id');
            $titles = $this->input->post('title');
            $removeds = $this->input->post('removed');
            
            for($i = 0; $i < count($ids); $i++) {
                if($removeds[$i] == 1) {
                    $this->photo_cloud_model->delete_photo($site_id, $ids[$i]);
                } else {
                    $data = array(
                        'title' => $titles[$i],
                        'sort' => $i + 1
                    );
                    $this->photo_cloud_model->update_photo($site_id, $ids[$i], $data);
                }
            }
            $data['photos'] = $this->photo_cloud_model->get_photos($site_id, $cloud_id);
            $this->load->view('extensions/photos_view', $data);
        }

        public function sort(){
            $site_id = $this->__get_site_id();

          $photo = $this->input->post('photo');
          
          $this->photo_cloud_model->sort_photos($site_id, $photo);
          
          $data['str'] = "<div class=\"success\">".lang('succ_photo_sort')."</div>";
          $this->load->view('print_view', $data);
        }   
        
        public function delete(){
          $site_id = $this->__get_site_id();

          $photo_id = $this->input->post('photo_id');
          
          $this->photo_cloud_model->delete_photo($site_id, $photo_id);
          
          $data['str'] = "<div class=\"info\">".lang('succ_photo_delete')."</div>";
          $this->load->view('print_view', $data);            
        }
}
        