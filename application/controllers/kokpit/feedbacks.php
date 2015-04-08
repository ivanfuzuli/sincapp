<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedbacks extends Admin_Controller {
    
        public function __construct() {
            parent::__construct();
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('kokpit/feedback_model');
            $this->load->helper('time_converter');
 
        }
        
        public function index($page = 0){
            //sayfalama basla
            $limit = 10;
            $this->load->library('pagination');
                $config['uri_segment'] = 4;
                $config['base_url'] = base_url().'kokpit/contacts/index/';
                $config['total_rows'] = $this->feedback_model->get_message_count(0);
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
            $data['feedbacks']  = $this->feedback_model->get_messages(0, $limit, $page);
            $middle = $this->load->view('kokpit/feedback_view', $data, true);
            $this->_render($middle);
        }
        
        public function feed_do(){
            $user_id = (int)$this->input->post('user_id');
            $feed = $this->input->post('message');
            $this->feedback_model->set_feed($user_id, $feed);
            $data['feed'] = $this->feedback_model->get_feeds($user_id);
        
            $this->load->view('kokpit/feed_view', $data);
        }
        
        public function read($thread_id){
           $data['thread_id'] = $thread_id;
           $data['messages'] = $this->feedback_model->get_thread(0, $thread_id);
           $middle = $this->load->view('kokpit/read_view', $data, true);
           $this->_render($middle);
        }
        
        public function reply(){
            $thread_id = $this->input->post('thread_id');
            $user_id = $this->input->post('user_id');
            $message = $this->input->post('message');
            $response = $this->feedback_model->reply($user_id, $thread_id, $message);
            if($response == false){
                echo "Opps. bir hata olustu";
                return false;
            }
            $data = array(
               'message' => array(
                   'send_date' => time(),
                   'email' => 'admin',
                   'message' => $message
               )  
            );
            $this->load->view('kokpit/read_single_view', $data);
        }
        private function _render($middle){
            $data['middle'] = $middle;
            $data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $data['order_statu'] = $this->kokpit_model->get_unread_orders();
           
            $this->load->view('kokpit/index_view', $data);            
        }
}