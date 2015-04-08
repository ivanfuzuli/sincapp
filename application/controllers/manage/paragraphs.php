<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paragraphs extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();
              $this->load->model('extensions/paragraphs_model');
            
              $this->lang->load('paragraph', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli    
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }

	public function index(){

	}
        
        public function set_html(){
            $site_id = $this->__get_site_id();
            $page_id = (int)$this->input->post('page_id');
            $pr_id = (int)$this->input->post('paragraph_id');
            $content = trim($this->input->post('html'));
            /*$content = tidy_repair_string(
                                         $content,
                                         array(
                                                   'show-errors' => false,
                                                   'drop-font-tags'    => true,  //removes style definitions like style and class
                                                   'logical-emphasis' => true,
                                                    'show-body-only' => true,
                                                   'doctype' => '-//W3C//DTD XHTML 1.0 Transitional//EN',
                                                   'output-xhtml' => true,
                                         ),
                                         'UTF8'
                );
              */ 
            // Clear google Adsense Ads
            $this->load->library('remove_ads');
            $content = $this->remove_ads->clear($site_id, $content);
            $this->paragraphs_model->set_html($site_id, $page_id, $pr_id, $content);
            // End Clear google Adsense Ads
            $data['info'] = "<div class=\"info\">".lang('str_update_succ')."</div>";
            
            if(!$content or $content == "<p> </p>"){
                $html = lang('str_click_to_edit');
               
            }else{
                 $html = $content;
            }
            
            $data['content'] = $html;
            
            echo json_encode($data);
        }
        
        public function photo(){
            $site_id = $this->__get_site_id();
            $paragraph_id = $this->input->post('paragraph_id');
            $pic_id = $this->input->post('photos');
            
            $data = $this->paragraphs_model->photo($site_id, $paragraph_id, $pic_id);
            echo json_encode($data);
        }
        
        public function resize(){
            $site_id = $this->__get_site_id();
            $width = (int)$this->input->post('width');
            $height = (int)$this->input->post('height');
            $p_pic_id = (int)$this->input->post('p_pic_id');
            
            $this->paragraphs_model->resize($site_id, $p_pic_id, $width, $height);
            
            $data['str'] = "<div class=\"success\">".lang('str_resize_succ')."</div>";
            $this->load->view('print_view', $data);
        }
}