<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

        	$this->load->model('manage/language_model');
 
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
            $this->user_id = $this->auth->get_user_id();
 
        }

        public function get_modal() {
            $this->load->model('manage/pages_model');
        	$site_id = $this->__get_site_id();
        	$menu_id = (int)$this->input->post('menu_id');
            $prefix = $this->input->post('prefix', TRUE);
            if(!$prefix) $prefix = null;

        	$data = array();
            $data['pages'] = $this->pages_model->get_pages_admin($site_id, $prefix);
        	$data['site_id'] = $site_id;
        	$data['menu_id'] = $menu_id;
            $data['prefix'] = $prefix;
        	$this->load->view('manage/menu_modal_view', $data);
        }

        public function add() {
            $this->load->model('manage/pages_model');
            $this->load->model('extensions/menu_model');
            $site_id = $this->__get_site_id();
            $menu_id = (int)$this->input->post('menu_id');
            $page_id = (int)$this->input->post('page_id');
            
            $prefix = $this->input->post('prefix', TRUE);
            if(!$prefix){
              $prefix = null;  
            } 

            $page_type = $this->input->post('page_type', TRUE);
            $page_id = (int)$this->input->post('page_id');
            $title = $this->input->post('title', TRUE);

            if($page_type == 'new') {
                $page_id = $this->pages_model->set_page($site_id, $title, $prefix, null, $menu_id);
            }

            $this->menu_model->save($site_id, $menu_id, $page_id, $prefix);

            $data = array();


            $content = $this->get_left_pages($site_id, $page_id, $prefix);
            $data['pages_content'] = $content['pages_content'];
            $data['pages_switcher'] = $content['pages_switcher'];
            $my_data = array(
                    'mode' => 'admin',
                    'ajax' => true,
                    'menu_id' => $menu_id,
                    'pages' => $this->menu_model->get_pages($site_id, $menu_id)
            );
            $data['main'] = $this->load->view('extensions/menu_view', $my_data, true);

            echo json_encode($data);
        }

        public function get_left_pages($site_id, $page_id, $prefix) {
            $nav = array();
            $nav['prefix'] = $prefix;
            $nav['pages'] = $this->pages_model->get_pages_admin($site_id, $prefix);
            
            $data['pages_content'] = $this->load->view('manage/pages_content_view', $nav, true);
            $data['pages_switcher'] = $this->load->view('manage/pages_switch_view', $nav, true); 
            return $data;        
        }

        public function sort() {
            $this->load->model('extensions/menu_model');            
            $site_id = $this->__get_site_id();
            $subPage = $this->input->post('subPage');
            $this->menu_model->sort($site_id, $subPage);
        }

        public function remove() {
            $this->load->model('extensions/menu_model');
            $site_id = $this->__get_site_id();
            $id = (int)$this->input->post('id');
            $this->menu_model->delete($site_id, $id);
            $my_data = array(
                    'mode' => 'admin',
                    'ajax' => true,
                    'menu_id' => null,
                    'pages' => $this->menu_model->get_pages($site_id, $id)
            );

            $this->load->view('extensions/menu_view', $my_data);
        }
}