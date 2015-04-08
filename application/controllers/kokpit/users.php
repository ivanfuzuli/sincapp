<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller {
    
        public function __construct() {
            parent::__construct();
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('kokpit/users_model');
 
        }
        
        public function index($page = 0){

            //sayfalama bitti
            $p_data['middle']  = $this->load->view('kokpit/users_view', '', true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();
            
            $this->load->view('kokpit/index_view', $p_data);
        }
        
        public function passive(){
            $user_id = (int)$this->input->post('user_id');
            $statu = (int)$this->input->post('statu');
            
            $prnt = $this->users_model->passive_user($user_id, $statu);
            
            echo $prnt;
        }

        public function get_data() {
            $this->load->library('datatables');
            $this->datatables
            ->select('user_id,email,ref,statu')
            ->from('users')
            ->add_column('Actions', '','');

            echo $this->datatables->generate('json');           
        }   
}