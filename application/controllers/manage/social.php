<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('manage/social_model');
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }
        
        public function index(){
            $site_id = $this->__get_site_id();
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }

            $data = $this->social_model->get_social($site_id, $prefix);
            $this->load->view('manage/social_view', $data);
        }

        public function post() {
            $site_id = $this->__get_site_id();
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }

            $data = array();
            $data['site_id'] = $site_id;
            $data['facebook'] = $this->input->post('facebook');
            $data['twitter'] = $this->input->post('twitter');
            $data['google'] = $this->input->post('google');

            $this->social_model->insert_or_update($site_id, $prefix, $data);

            $this->load->view('social_view', $data);
        }
}