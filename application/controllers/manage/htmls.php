<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Htmls extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('extensions/htmls_model');
 
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
            $this->user_id = $this->auth->get_user_id();
 
        }

        public function get_html(){
            $html_id = $this->input->post('html_id');
            $row = $this->htmls_model->get_html($html_id);
            
            $data['str'] = $row->content;
            
            $this->load->view('print_view', $data);
            
        }
        
        public function set_html(){
            $site_id = $this->__get_site_id();

            $html_id = $this->input->post('html_id');
            $content = $this->input->post('content');
            

            // REMOVE ADSENSE ADS
            $this->load->library('remove_ads');
            $content = $this->remove_ads->clear($site_id, $content);
            // END REMOVE ADSENSE ADS
            //save
            $this->htmls_model->set_html($site_id, $html_id, $content);
           
            echo $content;
        }
}