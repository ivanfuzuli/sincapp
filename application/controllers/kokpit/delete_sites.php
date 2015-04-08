<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delete_sites extends Admin_Controller {
    
        public function __construct() {
            parent::__construct();
            
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('kokpit/sites_model');
 
        }
        
        public function index($page = 0){
            //sayfalama basla
            $limit = 10;
            $this->load->library('pagination');
                $config['uri_segment'] = 4;
                $config['base_url'] = base_url().'kokpit/delete_sites/index/';
                $config['total_rows'] = $this->kokpit_model->get_site_count(true);
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
            $data['pages'] = $this->pagination->create_links();
            //sayfalama bitti
            $data['sites']  = $this->sites_model->get_sites($limit, $page, true);
            
            $p_data['middle']  = $this->load->view('kokpit/delete_site_view', $data, true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();
            
            $this->load->view('kokpit/index_view', $p_data);
        }
        
        //onaylandi sil
        public function confirm(){
            $site_id = $this->input->post('site_id');
            $this->sites_model->delete_admin($site_id);
            
            echo "success";
        }
        
        public function cancel(){
            $site_id = $this->input->post('site_id');            
            $this->sites_model->cancel($site_id);
            echo "success";
        }
}