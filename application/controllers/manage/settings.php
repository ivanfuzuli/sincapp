<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('manage/settings_model');

              $this->lang->load('settings', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli    
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }
        
        public function index(){
            $site_id = $this->__get_site_id();
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }

            $data = $this->settings_model->get_settings($site_id, $prefix);
            $this->load->view('manage/settings_view', $data);
        }
        
        public function set_settings(){
            $site_id = $this->__get_site_id();
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }
            $title = $this->input->post('title');
            $site_desc = $this->input->post('site_desc');
            $header_code = $this->input->post('header_code');
            $footer_code = $this->input->post('footer_code');
            $data = array('title' => $title, 'site_desc' => $site_desc, 'header_code' => $header_code, 'footer_code' => $footer_code);
            
            $this->settings_model->set_settings($site_id, $prefix, $data);
            
            $p_data['str'] = "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>".lang('succ_update_settings')."</div>";
            
            $this->load->view('print_view', $p_data);
        }
        
        //turu tamamla
        public function tourComplete(){
            $site_id = $this->__get_site_id();
            $this->settings_model->set_tour_complete($site_id);
        }
}