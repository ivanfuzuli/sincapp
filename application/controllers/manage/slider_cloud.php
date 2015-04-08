<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slider_cloud extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();
              $this->load->model('extensions/slider_cloud_model');
            
              $this->lang->load('slider_cloud', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli                            
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }

        public function add(){
            $site_id = $this->__get_site_id();

            $cloud_id = $this->input->post('cloud_id');
            $photos = $this->input->post('photos');
            
            $this->slider_cloud_model->set_photos($site_id, $cloud_id, $photos);
            
            $data['photos'] = $this->slider_cloud_model->get_sliders($site_id, $cloud_id);
           
           $j_data = array();
           
           $j_data['main'] = $this->load->view('extensions/sliders_view', $data, true);
           
           echo json_encode($j_data);
        }
        
        public function get_modal() {
            $site_id = $this->__get_site_id();
            $cloud_id = $this->input->post('cloud_id');

            $data = array();

            $data['site_id'] = $site_id;
            $data['cloud_id'] = $cloud_id;
            $data['photos'] = $this->slider_cloud_model->get_sliders($site_id, $cloud_id);
            $this->load->view('manage/slider_modal_view', $data);
        }

        public function set_settings() {
            $site_id = $this->__get_site_id();
            $cloud_id = $this->input->post('cloud_id');

            $ids = $this->input->post('id');
            $titles = $this->input->post('title');
            $links = $this->input->post('link');
            $removeds = $this->input->post('removed');
            
            for($i = 0; $i < count($ids); $i++) {
                if($removeds[$i] == 1) {
                    $this->slider_cloud_model->delete_slider($site_id, $ids[$i]);
                } else {
                    $data = array(
                        'title' => $titles[$i],
                        'link' => $links[$i],
                        'sort' => $i + 1
                    );
                    $this->slider_cloud_model->update_slider($site_id, $ids[$i], $data);
                }
            }
            $data['photos'] = $this->slider_cloud_model->get_sliders($cloud_id);
            $this->load->view('extensions/sliders_view', $data);
        }

        public function sort(){
          $site_id = $this->__get_site_id();

          $sliderSet = $this->input->post('sliderSet');
          
          $this->slider_cloud_model->sort_sliders($site_id, $sliderSet);
          
          $data['str'] = "<div class=\"success\">".lang('succ_slider_sort')."</div>";
          $this->load->view('print_view', $data);
        }   
        
        public function delete(){
           $site_id = $this->__get_site_id();

          $slider_id = $this->input->post('slider_id');
          
          $this->slider_cloud_model->delete_slider($site_id, $slider_id);
          
          $data['str'] = "<div class=\"info\">".lang('succ_slider_delete')."</div>";
          $this->load->view('print_view', $data);            
        }
}
        