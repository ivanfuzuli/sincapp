<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grids extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('manage/grids_model');

              $this->lang->load('grids', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli    
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }

        public function set_width(){
            $site_id = $this->__get_site_id();

            $width = $this->input->post('width');

            $this->grids_model->set_width($site_id, $width);
            $data['str'] = "<div class=\"success\">".lang('succ_width_change')."</div>";
            
            $this->load->view('print_view', $data);
        }
        
        public function merge(){
            $site_id = $this->__get_site_id();
            
            $before_id = (int)$this->input->post('before_id');
            $after_id = (int)$this->input->post('after_id');
            $width = (int)$this->input->post('width');
            $empty = $this->input->post('empty');
           
            $this->grids_model->merge($site_id, $before_id, $after_id, $width, $empty);
            
            $data['str'] = "<div class=\"success\">".lang('succ_merge_box')."</div>";
            
            $this->load->view('print_view', $data);            
            
        }
        
        public function sort(){
            $site_id = $this->__get_site_id();
            
            $grid_id = $this->input->post('grid_id');
            $ext_ids = $this->input->post('ext');
            
            $this->grids_model->sort_grids($site_id, $grid_id, $ext_ids);
            
            $data['str'] = "<div class=\"success\">".lang('succ_ext_sorting')."</div>";
            
            $this->load->view('print_view', $data);                 
        }
        
        public function new_grid(){
            $site_id = $this->__get_site_id();

             $before_id = $this->input->post('before_id');
             $ext_id = $this->input->post('ext_id');
             $width = $this->input->post('width');
             
             $grid_id = $this->grids_model->add_grid($site_id, $before_id, $ext_id, $width);
             
             $data = array('grid_id' => $grid_id, 'width' => $width, 'table' => false);
             
            $data['str'] = $grid_id;
            
            $this->load->view('print_view', $data);       
        }
        
        public function new_table(){
            $site_id = $this->__get_site_id();

             $page_id = $this->input->post('page_id');
             $ext_id = $this->input->post('ext_id');
             $parId = $this->input->post('parId');
            
           $grid_id = $this->grids_model->add_table($site_id, $page_id, $ext_id, $parId);

           $data = array('grid_id' => $grid_id, 'width' => "960", 'ext' => '', 'table' => true);
           
            $data['str'] = $grid_id;
            
            $this->load->view('print_view', $data);      

        }
        
}