<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_cloud {

    var $CI;
    private $_prefix = null;
    function __construct() {
        $this->CI =& get_instance();
         $this->CI->load->model('extensions/posts_model');

        $this->CI->lang->load('maps', 'turkish');             
        $this->CI->load->helper('language');//lang kısaltması icin gerekli        
    }
    
    function index($site_id, $extra_id, $mode, $extra_data = null){
        $this->CI->load->model('extensions/blog_cloud_model');
        $this->CI->load->model('extensions/blog_model');

        $blog_cloud_id = $extra_id;

        $cloud = $this->CI->blog_cloud_model->set_site_id($site_id)->get_cloud($blog_cloud_id);
        $this->_prefix = $this->CI->blog_model->set_site_id($site_id)->get_blog_prefix($cloud->blog_id);

        $blog_id = $cloud->blog_id;
        $page_id = $cloud->page_id;
        $str = array();
        $str['mode'] = $mode;
        $str['site_id'] = $site_id;
        $str['cloud_id'] = $blog_cloud_id;
        $str['blog_id'] = $blog_id;
        //extra_data post id veya page'i içerir
        if($extra_data['post']) {
          $str['post'] = $this->CI->posts_model->set_blog_id($blog_id)->get_single_post($extra_data['post']);
          $data = array();
          $data['icon'] = false;
          $data['html'] = $this->CI->load->view('extensions/blog_post_view', $str, true);

        } else {
          $page = 0;
          $limit = $cloud->limit_count;
          $pagination = $cloud->pagination;
          $blog = (int)$this->CI->input->get('blog');
          if($blog == $blog_cloud_id) {
             $page = (int)$this->CI->input->get('page');
          }
          if($page === 0) {
            $page = 1;
          } 

          $str['blog_status'] = $this->CI->blog_model->is_exist($blog_id);

          $str['pagination'] = $pagination;
          if($pagination) {
              $str['pages'] = $this->_paginate($blog_cloud_id, $page_id, $blog_id, $mode, $page, $limit);
          } else {
            $str['pages'] = null;
          }    
          //page start 1
          $page = $page - 1;
          $str['posts'] = $this->CI->posts_model->set_site_id($site_id)->set_blog_id($blog_id)->get_posts($limit, $page );
          $data = array();
          $data['icon'] = 'edit_icon blogEditBut';
          
          // Blog template
          $templates = array(
             'default',
             'only_title'
          );
          //
          //if layout does'nt exist, implement default layout
          if(in_array($cloud->layout, $templates)) {
            $layout = $cloud->layout;
          } else {
            $layout = 'default';
          }
          $data['html'] = $this->CI->load->view('extensions/blog_layouts/'.$layout.'_view', $str, true);
       }
      return $data;          

    }

    private function _paginate($blog_cloud_id, $page_id, $blog_id, $mode, $page, $limit) {
            //sayfalama basla
                $base_url = $this->_get_full_path($page_id, $mode);
                $this->CI->load->library('pagination');
                $config['first_link'] = '&lsaquo; İlk Sayfa';
                $config['last_link'] = 'Son Sayfa &rsaquo;';

                $config['page_query_string'] = TRUE;
                $config['base_url'] = $base_url;
                $config['first_url'] = $base_url;
                $config['total_rows'] = $this->CI->posts_model->set_blog_id($blog_id)->get_posts_count();
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

                $this->CI->pagination->initialize($config); 
                return $this->CI->pagination->create_links();
            //sayfalama bitti

    }

    private function _get_full_path($page_id, $mode) {
        $this->CI->load->model('manage/pages_model');
        $page = $this->CI->pages_model->get_page_by_id($page_id);
        if($mode == 'admin') {
            $slug = $page->url;
            $slug = $slug .".html";
            $prefix = null;
            if($this->_prefix != null) {
               $prefix = $this->_prefix ."/";
            }
            $url = base_url() . "manage/editor/wellcome/" . $page->site_id. "/" . $prefix . $slug;
            return $url;

        } else {
                $url = base_url().$_SERVER['REQUEST_URI'];
                $urlex = explode('?', $url);
                return $urlex[0];
        }
    }
    public function create($site_id, $page_id, $prefix = null){
       $this->CI->load->model('extensions/blog_model');
       $this->CI->load->model('extensions/blog_cloud_model');

       $this->CI->blog_model->set_site_id($site_id)->set_prefix($prefix);
       // if default blog doesn't exist, create a default blog
       $this->CI->blog_model->create_if_dont_exists($site_id, $page_id);

       $this->CI->blog_cloud_model->set_site_id($site_id)->set_page_id($page_id)->set_prefix($prefix);
       //create blog cloud
       $id = $this->CI->blog_cloud_model->create();
       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        $data['callback'] = "blog.firstRun()";
       return $data;        
    }
    
    public function delete($site_id, $blog_cloud_id){
       $this->CI->load->model('extensions/blog_cloud_model');
       $this->CI->blog_cloud_model->set_site_id($site_id)->delete($blog_cloud_id);
      return true;
    }    
}