<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends Admin_Controller {
    
        public function __construct() {
            parent::__construct();
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('kokpit/contact_model');
 
        }
        
        public function index($page = 0){
            //sayfalama basla
            $limit = 10;
            $this->load->library('pagination');
                $config['uri_segment'] = 4;
                $config['base_url'] = base_url().'kokpit/contacts/index/';
                $config['total_rows'] = $this->contact_model->get_contact_count();
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
            $data['contacts']  = $this->contact_model->get_contacts($limit, $page);
            
            $p_data['middle']  = $this->load->view('kokpit/contact_view', $data, true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();            
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();

            $this->load->view('kokpit/index_view', $p_data);            
        }
        
        //okunmadı yap
        public function unread(){
            $contact_id = $this->input->post('contact_id');
            $this->contact_model->unread($contact_id);
            echo "1";
        }
        
        //sil
        public function delete(){
            $contact_id = $this->input->post('contact_id');
            $this->contact_model->delete($contact_id);
            echo "1";            
        }
}