<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor extends Editor_Controller {
    private $_site_id = null;
    private $_page_id = null;
    private $_js_files = null;
    private $_css_files = null;
    private $_no_active_page = false;

    private $_extension_extra = array();
        public function __construct() {
            parent::__construct();
              $this->load->model('site_model');
              $this->load->model('manage/pages_model');
              $this->load->model('manage/extensions_model');
              
              $this->lang->load('editor', 'turkish');
              $this->lang->load('pages', 'turkish');
              $this->load->helper('language');//lang kısaltması icin gerekli            
        }
       
       /**
       * Setter for extra extension information
       */
        private function _set_extension_extra($extension, $method, $id) {
            $this->_extension_extra[$extension][$method] = $id;
        }

        public function wellcome($site_id, $url_or_prefix = 'index', $page = 'index'){
            $this->load->model('packages_model');
//$this->output->enable_profiler(TRUE);
            $site_id = (int)$site_id;

            // Remove ? for pagination
            $explode = explode('?', $url_or_prefix);
            if(count($explode) > 1) {
                $url_or_prefix = $explode[0];                
            }
            $explode = explode('?', $page);
            if(count($explode) > 1) {
                $page = $explode[0];
            }
            // END remvoe ? for pagination

            //blog post
            if($url_or_prefix == "article") {
                $this->load->model('extensions/posts_model');
                $this->load->model('extensions/blog_model');
                $this->load->model('extensions/blog_cloud_model');
                $post = $this->posts_model->set_site_id($site_id)->get_post_by_slug($page);
                $url_or_prefix = $this->blog_model->get_blog_prefix($post->blog_id);
                $this->_page_id = $this->blog_cloud_model->set_site_id($site_id)->get_page_id_by_blog_id($post->blog_id);
                $this->_set_extension_extra('blog_cloud', 'post', $post->id);
                //aktif sayfa olmasın
                $this->_no_active_page = true;
            }

            if($url_or_prefix == 'en') {
                $prefix = 'en';
                $url = $page;
                $data['lang_switch_img'] = "england-21";
                $this->load->model('manage/language_model');
                $data['language_setup'] = $this->language_model->get_english_status($site_id);
            } else {
                $prefix = null;
                $url = $url_or_prefix;
                $data['lang_switch_img'] = "turkey-21";
                $data['language_setup'] = 0;
            }
            //yetki kontrol
            $this->get_site_auth($site_id);
            
            //site id'yi ata
            $this->_set_site_id($site_id);
            $this->site_model->set_settings($site_id, $prefix);//ayarlari modelde hafizaya at
            
            //page id'yi ata, blogdan geliyorsa page id zaten atanmıştır
            if ($this->_page_id == null) {
                $this->_set_page_id($url, $prefix);
            }
            $page_id = $this->_get_page_id();
            
            $data['prefix'] = $prefix;
            $data['main_settings'] = $this->site_model->get_main_settings();
            $data['theme'] = $this->_theme($prefix);
            
            $data['css'] = $this->_get_css();
          //  $data['js_files'] = $this->_get_js_files();

            $data['site_url'] = $this->site_model->get_siteurl();//for here
            $p_editor = $this->_get_pages_editor($prefix);
            $data['pages_editor']  = $p_editor['editor'];
            $data['pages_switcher'] = $p_editor['switcher'];   
            $data['site_id'] = $site_id;
            $data['page_id'] = $page_id;
            $data['is_premium']  = $this->packages_model->is_premium($site_id);

            if($data['main_settings']['tour'] == true){
                $data['tour'] = 0;
            } else {
                $data['tour'] = 1;
            }
            //bfcache bug fix
            $this->output->set_header("Cache-Control: no-store, no-cache");
            $this->load->view('editor_view', $data); 
        }
        
        public function get_middle(){
            $page_id = (int)$this->_get_page_id();
            $site_id = $this->_get_site_id();
            $ext_data = $this->extensions_model->get_extensions($site_id, $page_id, "admin", $this->_extension_extra);            
            $ext_data['grids'] = $this->site_model->get_grids($site_id, $page_id); 
            return $this->load->view('manage/middle_view', $ext_data, true);                    
        }
        
        private function _theme($prefix){
            $site_id = $this->_get_site_id();
            $page_id = $this->_get_page_id();
            
            //tema bilgilerini al
            $t_data = $this->site_model->get_theme();
            $theme_path = $t_data->theme_path;
            $theme_css = $t_data->theme_css;
            
            //logoyu ayarla
            $logo_data = $this->site_model->get_logo();
            $logo_data['admin'] = true;
            $data['logo'] = $this->load->view('logo_view', $logo_data, true);

            // Cover photo
            $c_data = $this->site_model->get_cover();
            if ($c_data) {
            $cover_data = array(
                'image' => $c_data
                );
            $data['cover_photo'] = $this->load->view('cover_view', $cover_data, true);
            } else {
                $data['cover_photo'] = null;
            }
            // Cover photo
            //language
                $this->load->model('manage/language_model');
                $en_status = $this->language_model->is_active_english_exist($site_id);
                $l_data = array(
                        'base_path' => base_url() . 'manage/editor/wellcome/' . $site_id . "/",
                        'language' => $en_status
                    );
                $data['language_view'] = $this->load->view('language_view', $l_data, true);
            // end language
            // Social
             $this->load->model('manage/social_model');

            $s_data = array();
            $s_data = $this->social_model->get_social($site_id, $prefix);
            $data['social'] = $this->load->view('social_view', $s_data, true);
            // Social End        
            //navigasyonu ayarla
            if (!$prefix) {
                $base_path = base_url()."manage/editor/wellcome/".$site_id."/";
            } else {
                $base_path = base_url()."manage/editor/wellcome/".$site_id."/" . $prefix . "/";
            }
            $nav['pages'] = $this->pages_model->get_pages($site_id, $page_id, $base_path, $prefix, $this->_no_active_page);
            $data['navigation'] = $this->load->view('theme/'.$theme_path.'/navigation_view', $nav, true);            
            
            //eklentileri ayarla

            $data['middle'] = $this->get_middle();            
            //footer
            $data['footer'] = $this->site_model->get_footer();
            $theme = $this->load->view('theme/'.$theme_path.'/index_view', $data, true);
            
            //js ve cssleri ayarla            
           // $this->_set_js_files($ext_data['js']);  
            $this->_set_css($theme_css);
            
            return $theme;
        }
        
        private function _get_pages_editor($prefix){
            $page_id = (int)$this->_get_page_id();
            $site_id = $this->_get_site_id();
            $nav['page_id'] = $page_id;
            $nav['prefix'] = $prefix;
            $nav['pages'] = $this->pages_model->get_pages_admin($site_id, $prefix);
            $a_data['pages_content'] = $this->load->view('manage/pages_content_view', $nav, true); 

            $data['editor'] = $this->load->view('manage/pages_view', $a_data, true);

            $data['switcher'] = $this->load->view('manage/pages_switch_view', $nav, true);
            return $data;
        }
        
        private function _set_site_id($site_id){
            $this->_site_id = $site_id;
        }
        
        private function _get_site_id(){
            return $this->_site_id;
        }
        private function _set_page_id($url, $prefix){
           $url = str_replace(".html", "", $url);//.html'i sil
            
           $site_id = $this->_get_site_id();
           $data = $this->site_model->get_page_id($site_id, $url, false, $prefix);  
           if($data == false){
                $this->_page_id = false;             
           }else{
                $this->_page_id = $data['page_id'];
           }
        }
        
        private function _get_page_id(){
            return $this->_page_id;
        }
        
        
        private function _set_js_files($files){
            $this->_js_files = $files;
        }
        
        private function _get_js_files(){
            return $this->_js_files;
        }
        
        private function _set_css($files){
            $this->_css_files = $files;
        }
        
        private function _get_css(){
             return $this->_css_files;
           
        }
}