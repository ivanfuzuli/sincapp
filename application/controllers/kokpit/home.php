<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Admin_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('kokpit/kokpit_model');
 
        }
        
        public function index(){
            
            $data['site_count'] = $this->kokpit_model->get_site_count();
            $data['user_count'] = $this->kokpit_model->get_user_count();
            
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();

            $p_data['middle']     = $this->load->view('kokpit/home_view', $data, true);
            $this->load->view('kokpit/index_view', $p_data);
        }
}
        
        