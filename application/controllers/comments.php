<?php
class Comments extends Public_Controller {

        public function __construct() {
              parent:: __construct();  
              $this->load->model('comments_model');
              
              $this->lang->load('comment', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli

        }
        
        public function commentDo(){
            $data = array();

            $data['entry_id'] = (int)$this->input->post('entry_id');

            $data['comment'] = $this->input->post('comment', true);
            $data['name'] = $this->input->post('name', true);
            $data['email'] = $this->input->post('email', true);
            $data['website'] = $this->input->post('website', true);    
            $data['comment_date'] = date('Y-m-d H:i:s');
            $data['comment_gm_date'] = gmdate('Y-m-d H:i:s');

            $data['comment_id'] = $this->comments_model->set_comment($data);
            
            $this->load->view('extensions/comment_view', $data);
        }
}