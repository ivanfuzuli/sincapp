<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logo extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();
              $this->load->model('manage/logo_model');
              $this->lang->load('logo', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli    
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }

        public function update_footer(){
            $site_id = $this->__get_site_id();
            
            $footer_str = trim($this->input->post('text'));
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }
            $data = array('footer_str' => $footer_str);
            
            $this->logo_model->update_footer($site_id, $data, $prefix);
            
            echo "<div class=\"success\">".lang('succ_update_footer')."</div>";
        }
        
        public function update_logo(){
            $site_id = $this->__get_site_id();
            $prefix = $this->input->post('prefix');

            if(!$prefix) {
                $prefix = null;
            }
            $logo = $this->input->post('logo');
            
            $this->logo_model->update($site_id, $logo, $prefix);
            
            echo "<div class=\"success\">".lang('succ_update_logo')."</div>";
        }
        
        public function mode_text(){
            $site_id = $this->__get_site_id();
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }
            $value = $this->logo_model->mode_text($site_id, $prefix);
            $value['ajax'] = true;//divin üst bölümünü iptal etmek için
            $value['admin'] = true;
            
            $data = array();
            $data['info'] = "<div class=\"success\">".lang('succ_change_mode')."</div>";
            $data['html'] = $this->load->view('logo_view', $value, true);
            
            echo json_encode($data);
        }
        
        public function position(){
            $site_id = $this->__get_site_id();

            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }
            $data = array();
            $data['logo_top'] = (int)$this->input->post('top');
            $data['logo_left'] = (int)$this->input->post('left');
            
            $this->logo_model->update_position($site_id, $data, $prefix);
            
            echo "<div class=\"success\">".lang('succ_update_position')."</div>";
        }
        
        public function resize(){
            $site_id = $this->__get_site_id();
            $width = (int)$this->input->post('width');
            $height = (int)$this->input->post('height');
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }
            $this->logo_model->resize_logo($site_id, $width, $height, $prefix);
            echo "<div class=\"success\">".lang('succ_resize')."</div>";
            
        }
        
        public function update_image(){
            $site_id = $this->__get_site_id();
            $pic_id = $this->input->post('pic_id');
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }            
            $value = $this->logo_model->update_image($site_id, $pic_id, $prefix);
            $value['ajax'] = true;//divin üst bölümünü iptal etmek için
            $value['admin'] = true;
            $data = array();
            $data['info'] = "<div class=\"success\">".lang('suc_update_img')."</div>";
            $data['html'] = $this->load->view('logo_view', $value, true);
            
            echo json_encode($data);
        }
}