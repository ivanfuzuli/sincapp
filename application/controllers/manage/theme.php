<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Theme extends Editor_Controller {

        public function __construct() {
            parent::__construct();
              $this->load->model('manage/theme_model');
              $this->load->model('site_model');

              $this->lang->load('theme', 'turkish');
              $this->load->helper('language');//lang kısaltması icin gerekli
        }

        public function index($site_id){
            $site_id = (int)$site_id;
            $this->get_site_auth($site_id);//yetki kontrol

            $data['site_id'] = $site_id;
            $data['site_url'] = $this->site_model->get_siteurl($site_id);
            $data['themes'] = $this->theme_model->get_themes();
            $data['theme_id']  = $this->theme_model->get_theme_id($site_id);

            $this->load->view('manage/theme_view', $data);
        }

        public function select($site_id, $template_id){
            $site_id = (int)$site_id;
            $template_id = (int)$template_id;

            $this->get_site_auth($site_id);//yetki kontrol

            $this->theme_model->set_theme($site_id, $template_id);
            
            $site_url = $this->site_model->get_siteurl($site_id);
            redirect($site_url);
        }
}
