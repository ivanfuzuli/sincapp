<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

        	$this->load->model('manage/language_model');
 
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
            $this->user_id = $this->auth->get_user_id();
 
        }

        public function get_modal() {
        	$site_id = $this->__get_site_id();
        	$prefix = $this->input->post('prefix');
        	if(!$prefix) {
        		$prefix = null;
        	}
        	$data = array();
        	$data['english_status'] = $this->language_model->is_active_english_exist($site_id);
        	$data['prefix'] = $prefix;
        	$this->load->view('manage/language_view', $data);
        }

        public function get_setup() {
            $this->load->model('manage/language_model');
            $site_id = $this->__get_site_id();
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }
            $data = array();
            $data['site_id'] = $site_id;
            $data['prefix'] = $prefix;
            $data['settings'] = $this->language_model->get_settings($site_id, $prefix);

            $this->load->view('manage/language_setup_view', $data);
        }

        public function set_setup() {
            $this->load->model('manage/language_model');
            $site_id = $this->__get_site_id();
            $prefix = $this->input->post('prefix');
            if(!$prefix) {
                $prefix = null;
            }

            $data = array(
                    'title' => $this->input->post('title'),
                    'site_desc' => $this->input->post('description'),
                    'status' => 0
                );

            $this->load->model('manage/settings_model');
            $this->settings_model->set_settings($site_id, $prefix, $data);
        }

        public function set_language() {
        	$this->load->model('manage/pages_model');
        	$site_id = $this->__get_site_id();
        	$statu = $this->input->post('statu');

        	if ($statu == 0) {
        		// make passive
        		$this->language_model->passive_settings($site_id);
        	} else {
        		// Make active
        		$settings_statu = $this->language_model->is_english_exist($site_id);
        		// settings yoksa yeni yarat yoksa varolanı güncelle
        		if ($settings_statu == false) {
        			//create settings
        			$this->language_model->create_english_settings($site_id);
                    //create social
                    $this->language_model->create_social($site_id);
        			//create index page
        			$this->pages_model->set_page($site_id, 'Home', 'en', 'index');

        		} else {
        			$this->language_model->active_settings($site_id);
        		}
        	}

                $en_status = $this->language_model->is_active_english_exist($site_id);
                $l_data = array(
                        'base_path' => base_url() . 'manage/editor/wellcome/' . $site_id . "/",
                        'language' => $en_status
                    );
                $data['language_view'] = $this->load->view('language_view', $l_data);            
        }
}