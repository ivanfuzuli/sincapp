<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logins extends Admin_Controller {
    
        public function __construct() {
            parent::__construct();
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('kokpit/login_details_model');
        }
        
        public function index(){

            //sayfalama bitti
            $p_data['middle']  = $this->load->view('kokpit/logins_view', '', true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();

            $this->load->view('kokpit/index_view', $p_data);
        }

        public function get_data() {
            $this->load->library('datatables');
            $this->datatables
                 ->select('id,user_id,ip,login_date')
                 ->from('logins');
            echo $this->datatables->generate('json');           
        }
}