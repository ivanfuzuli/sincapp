<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entries extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('extensions/entries_model');

              $this->lang->load('entries', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli    
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
            $this->user_id = $this->auth->get_user_id();
 
        }

        public function index(){
            
        }
        
        public function getEntry(){
              $this->lang->load('comment', 'turkish');             
            
           $site_id = (int)$this->input->post('site_id');
           $page_id = (int)$this->input->post('page_id');
           $post_id = $this->input->post('postId');
           
           $j_data = array();
           
           $data = $this->entries_model->get_three_entry($site_id, $page_id, $post_id);
           $p_data = array('entry' => $data['entry'], 'comments' => $data['comments']);
           
           $j_data['entry'] = $this->load->view('extensions/blog_entry_view', $p_data, true);
           $j_data['title'] = $data['entry']['title'];
           //ileri geri tuslarinin bilgileri
           $j_data['next'] = $data['next'];
           $j_data['prev'] = $data['prev'];
           
           echo json_encode($j_data);
        }
        
        public function add(){
            $site_id = $this->__get_site_id();
            
            $values = array(
                'site_id' => $site_id,
                'user_id' => $this->user_id,
                'page_id' => $this->input->post('page_id'),
                'title' => $this->input->post('title'),
                'body' => $this->xml_replace($this->input->post('body')),
                'entry_date' => date('Y-m-d H:i:s'),
                'entry_gm_date' => gmdate('Y-m-d H:i:s')
            );
            
            $tags = $this->input->post('tag');
            $entry_id = $this->entries_model->add_entry($values, $tags);
            
            $data['entry'] = $this->entries_model->get_single_entry($entry_id, false);
            $this->load->view('extensions/entry_single_view', $data);
            
        }
        
        public function delete(){
            $site_id = $this->__get_site_id();

            $entry_id = $this->input->post('entry_id');
            $this->entries_model->delete_entry($site_id, $entry_id);
            
            $data['str'] = "<div class=\"info\">".lang('str_entry_delete_succ')."</div>";
            
            $this->load->view('print_view', $data);
        }
        
        public function edit(){
            $site_id = $this->__get_site_id();

            $entry_id = $this->input->post('entry_id');
            $data['entry'] = $this->entries_model->get_single_entry($entry_id);
            $this->load->view('extensions/entry_edit_view', $data);
        }
        
        public function editDo(){
            $data = array();
            $site_id = $this->__get_site_id();

            $data['page_id'] = $this->input->post('page_id');
            $data['entry_id'] = $this->input->post('entry_id');
            $data['title'] = $this->input->post('title');
            $data['body'] = $this->xml_replace($this->input->post('body'));
            $data['tags'] = $this->input->post('tag');
            $data['deltags'] = $this->input->post('deltag');
            
            $this->entries_model->edit_entry($data);
            
            //düzenleme bittikten sonra tekrar basmaca
            $p_data['entry'] = $this->entries_model->get_single_entry($data['entry_id']);
            $this->load->view('extensions/entry_single_view', $p_data);

        }
        
         public function deleteComment(){
            $site_id = $this->__get_site_id();

            $comment_id = $this->input->post('comment_id');
            $this->entries_model->delete_comment($site_id, $comment_id);
            
            $data['str'] = "<div class=\"info\">".lang('str_comment_delete_succ')."</div>";
            
            $this->load->view('print_view', $data);
        }
        
        public function page(){
            $page_id = $this->input->post('page_id');
            $data = array();

            $start= (int)$this->input->post('start');
            
            $data['entries'] = $this->entries_model->get_entries($page_id, $start);
            
            $data['updater'] = false;
            
            $data['start'] = $start + 5;
           $this->load->view('extensions/entries_view', $data);
        }
        
        private function xml_replace($str){
            
            
            $str = preg_replace('/<div(.*?)>(.*?)<\/div>/', '<p$1>$2</p>', $str);
            $str = preg_replace('/<(.*?)>/', '<'.strtolower('\\1').'>', $str);//DIV i div yapar

            return $str;
        }
}