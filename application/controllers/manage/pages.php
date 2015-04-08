<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('manage/pages_model');
 
              $this->lang->load('pages', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli            
            
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
            $this->_set_page_id();
 
        }
        var $info = null;
        var $page_id = null;
    private function _set_page_id() {
        $this->page_id = (int)$this->input->post('page_id');
    } 

    private function _get_page_id() {
        return $this->page_id;
    }

	public function index()	{
            $site_id = $this->__get_site_id();

            $pages = $this->pages_model->get_pages_admin($site_id);
            $p_data['pages_left'] = $this->load->view('manage/pages_left_view', array('pages'=> $pages), true);
            
            $this->load->view('manage/pages_view', $p_data);
      }
          
        private function _set_info($str){
            $this->info = $str;
        }
        
        
         private function _get_info(){
             return $this->info;
         }
         
        private function _do_json(){
                $site_id = $this->__get_site_id();
                $page_id = $this->_get_page_id();

                $prefix = $this->input->post('prefix');
                if (!$prefix) {
                    $prefix =  null;
                }
                $this->load->model('site_model');
                $this->site_model->set_settings($site_id, $prefix);
                $t_data = $this->site_model->get_theme();
                $theme_path = $t_data->theme_path;

                
                //navigasyonu ayarla
               $base_path = base_url()."manage/editor/wellcome/".$site_id."/";
                $nav['page_id'] = $page_id;
                $nav['pages'] = $this->pages_model->get_pages($site_id, null, $base_path, $prefix);
 
                $data['navigation'] = $this->load->view('theme/'.$theme_path.'/navigation_view', $nav, true);            
                
                $nav['prefix'] = $prefix;
                $nav['pages'] = $this->pages_model->get_pages_admin($site_id, $prefix);
                $data['pages_content'] = $this->load->view('manage/pages_content_view', $nav, true);
                $data['pages_switcher'] = $this->load->view('manage/pages_switch_view', $nav, true);

                $data['info'] = $this->_get_info();
                
                echo json_encode($data);                 
        }

      public function sort(){
          $site_id = $this->__get_site_id();
          $pg = $this->input->post('pg');
          
          $this->pages_model->sort_pages($site_id, $pg);
                $this->_set_info("<div class=\"info\">".lang('succ_sorting')."</div>");
                //jsonu isle
                $this->_do_json();
      }      
            

            public function add_do(){
            $site_id = $this->__get_site_id();

                $title = $this->input->post('pagename');
                $prefix = $this->input->post('prefix');
                if(!$prefix) {
                    $prefix = null;
                }
                $this->pages_model->set_page($site_id, $title, $prefix);
                
                $this->_set_info("<div class=\"success\">".lang('succ_add_page')."</div>");
                //jsonu isle
                $this->_do_json();

            }
            public function edit(){
            $site_id = $this->__get_site_id();

                
                $page_ids = $this->input->post('page_ids');  
                $data['pages'] = $this->pages_model->edit_pages($site_id, $page_ids);
                
                $this->load->view('manage/pages_edit_view', $data);
            }
            
            public function seo(){
            $site_id = $this->__get_site_id();
   
                $page_ids = $this->input->post('page_ids');  
                $data['pages'] = $this->pages_model->get_seo_pages($site_id, $page_ids);
                
                $this->load->view('manage/pages_seo_view', $data);            
                
           }
            
            public function delete_do(){
            $site_id = $this->__get_site_id();

                $page_ids = $this->input->post('page_ids');
                $pages = $this->pages_model->get_pages($site_id);

                $statu = $this->pages_model->delete_pages($site_id, $page_ids);
                if($statu == false){
                    $this->_set_info("<div class=\"error\">".lang('error_delete_least')."</div>");                    
                }else{
                    $this->_set_info("<div class=\"info\">".lang('succ_delete')."</div>");
                }
                
                $this->_do_json();
            }
            
            public function edit_do(){
            $site_id = $this->__get_site_id();

                
                $ids = $this->input->post('id');
                $names = $this->input->post('name');
                $urls = $this->input->post('url');
                $hiddens = $this->input->post('hidden');
                $externals = $this->input->post('external');
                $passwords = $this->input->post('password');
                $this->pages_model->edit_pages_do($site_id, $ids, $names, $urls, $hiddens, $externals, $passwords);
                

                 $this->_set_info("<div class=\"info\">".lang('succ_edit')."</div>");
                
                $this->_do_json();
          }
          
            public function seo_do(){
            $site_id = $this->__get_site_id();

                
                $ids = $this->input->post('id');
                $seos = $this->input->post('seo');
                $titles = $this->input->post('title');
                $descriptions = $this->input->post('description');
                $this->pages_model->seo_pages_do($site_id, $ids, $seos, $titles, $descriptions);
                

                 $this->_set_info("<div class=\"info\">".lang('succ_edit_seo')."</div>");
                
                $this->_do_json();
          }          
}