<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pinger extends Admin_Controller {
    
        public function __construct() {
            parent::__construct();
            
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('kokpit/pinger_model');
 
        }
        
        public function index(){
            $this->load->helper('time_converter');
            $data['sitemaps']  = $this->pinger_model->get_sitemaps();
            
            $p_data['middle']  = $this->load->view('kokpit/pinger_view', $data, true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();
            
            $this->load->view('kokpit/index_view', $p_data);
        }
        
        public function ping(){
            //gelen idler
            $pings = $this->input->post('ping');
            $this->pinger_model->ping($pings);
            
            $this->index();
        }
}