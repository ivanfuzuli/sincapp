<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
            $this->user_id = $this->auth->get_user_id();
            $this->load->model('extensions/posts_model');
            $this->load->model('extensions/blog_cloud_model');
        }

        public function add_blog() {
            $this->load->model('extensions/blog_model');
            $this->load->helper('form');

            $site_id = $this->__get_site_id();
            $name = $this->input->post('name', TRUE);
            $prefix = $this->input->post('prefix', TRUE);

            $data['blog_id'] = $this->blog_model->set_prefix($prefix)->set_site_id($site_id)->add($name);
            $data['blogs'] = $this->blog_model->set_site_id($site_id)->set_prefix($prefix)->get_blogs_for_dropdown();
            $this->load->view('extensions/print_blog_dropdown_view', $data);
        }

        public function remove_blog() {
            $this->load->model('extensions/blog_model');
            $this->load->helper('form');

            $blog_id = (int)$this->input->post('blog_id');
            $prefix = $this->input->post('prefix', TRUE);
            $site_id = $this->__get_site_id();
            $data = array();
            $p_data = array();
            // if it is default blog, don't remove it
            if ($this->blog_model->is_default($blog_id) == TRUE) {
                    $p_data['statu'] = 'error';
                    $p_data['error_text'] = "<div class=\"error\">Varsayılan Blog'u silemezsiniz...</div>";
            } else {
                $p_data['statu'] = 'success';
                $data['blog_id'] = 0;
                // remove from database
                $this->blog_model->set_site_id($site_id)->remove($blog_id);
                $this->blog_model->delete_all_posts($blog_id);

                $data['blogs'] = $this->blog_model->set_prefix($prefix)->get_blogs_for_dropdown();
                $p_data['dropdown'] = $this->load->view('extensions/print_blog_dropdown_view', $data, true);                 
            }



            echo json_encode($p_data);
        }
        public function edit_cloud() {
            $site_id = $this->__get_site_id();
            $this->load->model('extensions/blog_cloud_model');
            $this->load->model('extensions/blog_model');
            $this->load->helper('form');

            $blog_cloud_id = (int)$this->input->post('blog_cloud_id');
            $prefix = $this->input->post('prefix', true);

            $data = array();
            $data['site_id'] = $site_id;
            $data['limit_counts'] = $this->_get_limit_counts();
            $data['blogs'] = $this->blog_model->set_site_id($site_id)->set_prefix($prefix)->get_blogs_for_dropdown();
            $data['blog_cloud'] = $this->blog_cloud_model->set_site_id($site_id)->get_cloud($blog_cloud_id);

            $this->load->view('extensions/edit_blog_cloud_view', $data);
        }

        public function update_cloud() {
            $site_id = $this->__get_site_id();
            $blog_id = (int)$this->input->post('blog_id');
            $blog_cloud_id = (int)$this->input->post('blog_cloud_id');
            $this->load->model('extensions/blog_cloud_model');
            // Check box checker
            if($this->input->post('view_here')) {
                $this->blog_cloud_model->set_site_id($site_id)->reset_view_here($blog_id);
                $view_here = true;
            } else {
                $view_here = false;
            }

            $data = array(
                'blog_id' => $blog_id,
                'layout' => $this->input->post('layout', true),
                'limit_count' => (int)$this->input->post('limit_count'),
                'pagination' => (int)$this->input->post('pagination'),
                'view_here' => $view_here
            );
            $this->blog_cloud_model->set_site_id($site_id)->update($blog_cloud_id, $data);

            $this->print_content($blog_cloud_id, $blog_id);
        }

        private function _get_limit_counts() {
            $data = array();
            for($i =1; $i < 26; $i++) {
                $data[$i] = $i;
            }

            return $data;
        }
        public function add() {
        	$data = array();
        	$data['site_id'] = $this->__get_site_id();
        	$data['cloud_id'] = (int)$this->input->post('cloud_id');
        	$data['blog_id'] = (int)$this->input->post('blog_id');
        	$this->load->view('extensions/add_post_view', $data);
        }

        public function photo(){
            $this->load->model('extensions/blog_model');
            $site_id = $this->__get_site_id();
            $paragraph_id = $this->input->post('paragraph_id');
            $pic_id = $this->input->post('photos');
            $blog_id = (int)$this->input->post('blog_id');
            $data = $this->blog_model->set_site_id($site_id)->photo($blog_id, $pic_id);
            echo json_encode($data);
        }

        public function resize(){
            $this->load->model('extensions/blog_model');

            $site_id = $this->__get_site_id();
            $width = (int)$this->input->post('width');
            $height = (int)$this->input->post('height');
            $blog_pic_id = (int)$this->input->post('blog_pic_id');
            
            $this->blog_model->set_site_id($site_id)->resize($blog_pic_id, $width, $height);
            
            $data['str'] = "<div class=\"success\"> Fotoğraf başarılı bir şekilde yeniden boyutlandırıldı.</div>";
            $this->load->view('print_view', $data);
        }

        public function edit() {
        	$site_id = $this->__get_site_id();
        	$cloud_id = (int)$this->input->post('cloud_id');
        	$blog_id = (int)$this->input->post('blog_id');
        	$post_id = (int)$this->input->post('post_id');

         	$data = array();
        	$data['post'] = $this->posts_model->set_site_id($site_id)->get_single_post($post_id, false);
        	$data['site_id'] = $this->__get_site_id();
        	$data['cloud_id'] = $cloud_id;
        	$data['blog_id'] = $blog_id;
        	$this->load->view('extensions/add_post_view', $data);       	
        }

        public function update() {
        	$site_id = $this->__get_site_id();
        	$title = $this->input->post('post-title');
        	$content = $this->input->post('post-content');
        	$blog_id = (int)$this->input->post('blog_id');
        	$blog_cloud_id = (int)$this->input->post('blog_cloud_id');
        	$post_id = (int)$this->input->post('post_id');
        	$author = $this->user_id;

        	$this->posts_model->set_blog_id($blog_id);
        	$this->posts_model->set_site_id($site_id);
        	$this->posts_model->update($post_id, $title, $content, $author);

        	$this->print_content($blog_cloud_id, $blog_id);
        }

        public function post() {
        	$site_id = $this->__get_site_id();
        	$title = $this->input->post('post-title');
        	$content = $this->input->post('post-content');
        	$blog_id = $this->input->post('blog_id');
        	$blog_cloud_id = $this->input->post('blog_cloud_id');
        	$author = $this->user_id;

        	$this->posts_model->set_blog_id($blog_id);
        	$this->posts_model->set_site_id($site_id);
        	$this->posts_model->post($title, $content, $author);

        	$this->print_content($blog_cloud_id, $blog_id);
        }

        public function delete() {
        	$site_id = $this->__get_site_id();
        	$blog_id = (int)$this->input->post('blog_id');
        	$post_id = (int)$this->input->post('post_id');
        	$blog_cloud_id = (int)$this->input->post('blog_cloud_id');

        	$this->posts_model->set_blog_id($blog_id);
        	$this->posts_model->set_site_id($site_id);

        	$this->posts_model->delete($post_id);

        	$this->print_content($blog_cloud_id, $blog_id);
      	
        }

        private function print_content($blog_cloud_id, $blog_id) {
        	 $site_id = $this->__get_site_id();        	
        	 $this->posts_model->set_site_id($site_id);
             $this->blog_cloud_model->set_site_id($site_id);
             $blog_cloud = $this->blog_cloud_model->get_cloud($blog_cloud_id);
             $limit = $blog_cloud->limit_count;
             $pagination = $blog_cloud->pagination;
	         $data['no_parent'] = true;
	         $data['mode'] = 'admin';
	         $data['site_id'] = $site_id;
	         $data['cloud_id'] = $blog_cloud_id;
	         $data['blog_id'] = $blog_id;
             $data['pagination'] = $pagination;
	         $data['posts'] = $this->posts_model->set_blog_id($blog_id)->get_posts($limit, 0);
             $data['pages'] = null;
             if($pagination):
             $data['pages'] = $this->_paginate($blog_cloud_id, $blog_id, 0, $blog_cloud->page_id, $limit);
             endif;
			$this->load->view('extensions/blog_layouts/' . $blog_cloud->layout . '_view', $data);	              	
        }

        private function _get_full_path($page_id) {
            $this->load->model('manage/pages_model');
            $site_id = $this->__get_site_id();
            $page = $this->pages_model->get_page_by_id($page_id);
            
            $slug = $page->url;
            $slug = $slug .".html";

            $prefix = null;
            if($page->prefix != null) {
               $prefix = $prefix ."/";
            }

            $url = base_url() . "manage/editor/wellcome/".$site_id."/".$prefix.$slug;
            return $url;
        }

        private function _paginate($blog_cloud_id, $blog_id, $page, $page_id, $limit) {
                //sayfalama basla
                    $base_url = $this->_get_full_path($page_id);
                    $this->load->library('pagination');
                    $config['page_query_string'] = TRUE;
                    $config['base_url'] = $base_url;
                    $config['first_url'] = $base_url;
                    
                    $config['total_rows'] = $this->posts_model->set_blog_id($blog_id)->get_posts_count();
                    $config['per_page'] = $limit; 
                    $config['query_string_segment'] = 'page';
                    $config['use_page_numbers'] = TRUE;
                    $config['cur_page'] = $page;
                    $config['cur_tag_open'] = '<li class="active"><a href="#">';
                    $config['cur_tag_close'] = '</a></li>';
                    $config['suffix'] = '&blog='.$blog_cloud_id;                
                    $config['next_tag_open'] = '<li>';
                    $config['next_tag_close'] = '</li>';
                    
                    $config['prev_tag_open'] = '<li>';
                    $config['prev_tag_close'] = '<li>';

                    $config['num_tag_open'] = '<li>';
                    $config['num_tag_close'] = '</li>';
                    $config['custom_string'] = TRUE;// ben ekledim bunu

                    $this->pagination->initialize($config); 
                return $this->pagination->create_links();
                //sayfalama bitti

        }        
 }