<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Public_Controller {
    
        public function __construct() {
            parent::__construct();       
            $this->load->model('kokpit/blog_model');
        }

	public function index($page = 0)	{
            //sayfalama basla
            $limit = 1;
            $this->load->library('pagination');
            $p_data = array();

                $config['uri_segment'] = 3;
                $config['base_url'] = base_url().'blog/index/';
                $config['total_rows'] = $this->blog_model->get_blog_count();
                $config['per_page'] = $limit;

                $config['cur_tag_open'] = '<li class="active"><a href="#">';
                $config['cur_tag_close'] = '</a></li>';

                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';

                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '<li>';

                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';


                $this->pagination->initialize($config);
            $p_data['pages'] = $this->pagination->create_links();
            //sayfalama bitti

        $data = array();
        $data['title'] = "Sincapp Blog";
        $data['description'] = "Sincapp hakkında yenilikler, bilgiler ve daha fazlasının bulunduğu blog sayfası.";

        $p_data['posts'] = $this->blog_model->get_posts($limit, $page);
        $data['content'] = $this->load->view('home/blog_posts_view', $p_data, true);
        $data['last_posts'] = $this->blog_model->get_posts(5, 0);        
        $this->load->view('home/blog_template_view', $data);
	}

    public function post($id) {
        
        $data = array();
        $p_data = array();
        $data['last_posts'] = $this->blog_model->get_posts(5, 0);
        $p_data['next'] = $this->blog_model->next($id);
        $p_data['prev'] = $this->blog_model->prev($id);
        $p_data['post'] = $this->blog_model->get_single_post($id);

        $data['content'] = $this->load->view('home/blog_post_view', $p_data, true);
        $data['title'] = $p_data['post']['title'] . " - Sincapp Blog";
        $data['description'] = $p_data['post']['title'] . " başlığı hakkında Sincapp yöneticilerinin yazısı.";
        $this->load->view('home/blog_template_view', $data);
    }


}