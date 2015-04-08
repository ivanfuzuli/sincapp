<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
    private $_site_id = null;
    private $_page_id = null;
    private $_js_files = null;
    private $_css_files = null;
    private $_page_title = null;
    private $_page_desc = null;
    private $_extension_extra = null;
    private $_no_active_page = false;
    private $_title_suffix = null;
    private $_password = null;

        public function __construct() {
              parent:: __construct();  
              $this->load->model('site_model');
              $this->load->model('manage/pages_model');
              $this->load->model('manage/extensions_model');

        }
       /**
       * Setter for extra extension information
       */
        private function _set_extension_extra($extension, $method, $id) {
            $this->_extension_extra[$extension][$method] = $id;
        }

    	public function index()
    	{
                $this->router();
    	}
        
        public function router($url_or_prefix = 'index', $page = 'index'){ 
        $this->load->model('packages_model');
        $this->load->model('metrica_model');
           $this->_set_site_id(); //site idsini ayarlasin
           $site_id = $this->_get_site_id();
           //eger sitemap ise
           if($url_or_prefix == "sitemap.xml"){
               $this->_sitemap_parse();
               return false;//islemi kes
           }
          
                      //blog post
            if($url_or_prefix == "article") {
                $this->load->model('extensions/posts_model');
                $this->load->model('extensions/blog_model');
                $this->load->model('extensions/blog_cloud_model');
                $post = $this->posts_model->set_site_id($site_id)->get_post_by_slug($page);
                $this->_title_suffix = $post->title;

                $url_or_prefix = $this->blog_model->get_blog_prefix($post->blog_id);
                $this->_page_id = $this->blog_cloud_model->set_site_id($site_id)->get_page_id_by_blog_id($post->blog_id);     
                if(!$this->_page_id) {
                    $this->_not_found();
                    return false;
                }
                $this->_set_extension_extra('blog_cloud', 'post', $post->id);
                //aktif sayfa olmasın
                $this->_no_active_page = true;
            }

            if ($url_or_prefix == 'en') {
                // ingilizce aktif değilse 404 ver
                $this->load->model('manage/language_model');
                $en_statu = $this->language_model->is_active_english_exist($site_id);
                if(!$en_statu) {
                    $this->_not_found();
                    return false;                   
                }
                // end ingilizce aktif değilse 404 ver
                $prefix = $url_or_prefix;
                $url = $page;
            } else {
                $prefix = null;
                $url = $url_or_prefix;
            }
            $this->site_model->set_settings($site_id, $prefix);//ayarlari modelde hafizaya at
           
           if($this->_page_id == null) {
               $this->_set_page_id($url, $prefix); //pageisini ve basligi ayarlasin
           } else {
               $this->_set_page_id($url, $prefix, $this->_page_id); //pageisini ve basligi ayarlasin

           }
           $page_id = $this->_get_page_id();
           //sayfa bulunamadıysa
           if($page_id == false){
               $this->_not_found();
               return false;
           }
            
            $data['metrica'] = $this->metrica_model->get_code($site_id);
            $data['is_premium']  = $this->packages_model->is_premium($site_id);
            $data['main_settings'] = $this->site_model->get_main_settings();
            $data['theme'] = $this->_theme($prefix);
            $data['prefix'] = $prefix;
            $data['css'] = $this->_get_css();
            $data['js_files'] = $this->_get_js_files();
            $this->load->view('site_view', $data);
        }
        
        
        private function _theme($prefix){
            $site_id = $this->_get_site_id();
            $page_id = $this->_get_page_id();
            //tema bilgilerini al
            $t_data = $this->site_model->get_theme();
            $theme_path = $t_data->theme_path;
            $theme_css = $t_data->theme_css;
            
            //logoyu ayarla
            $logo_data = $this->site_model->get_logo($prefix);
            $logo_data['admin'] = false;
            
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
                    'base_path' => base_url(),
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
            $data['page_title'] = $this->_get_page_title();
            $data['page_description'] = $this->_get_page_description();
            //navigasyonu ayarla
            $nav['basePath'] = base_url();
            if ($prefix == 'en') {
                $nav['basePath'] = base_url() . 'en/';
            }
            $nav['pages'] = $this->pages_model->get_pages($site_id, $page_id, $nav['basePath'], $prefix, $this->_no_active_page);
            $data['navigation'] = $this->load->view('theme/'.$theme_path.'/navigation_view', $nav, true);            
            

            //şifre var mı??
            $password = $this->_get_password();
            $page_password = $this->session->flashdata('page_password');

            if($page_password == $password) {
            //eklentileri ayarla
                $ext_data = $this->extensions_model->get_extensions($site_id, $page_id, "site", $this->_extension_extra);            
                $ext_data['grids'] = $this->site_model->get_grids($site_id, $page_id); 
                $data['middle'] = $this->load->view('theme/middle_view', $ext_data, true);                    
            } else {
                $ext_data = null;
                $pass_data['password'] = $page_password;
                $data['middle'] = $this->load->view('theme/password_view', $pass_data, true);
            }
        
            
            //footer
            $data['footer'] = $this->site_model->get_footer();
            $theme = $this->load->view('theme/'.$theme_path.'/index_view', $data, true);
            
            //js ve cssleri ayarla
            
            $this->_set_js_files($ext_data['js']);  
            $this->_set_css($theme_css);
            return $theme;
        }
        
        private function _set_site_id(){
            $site_id = $this->_get_domain();//urlden site idsini alalim
            $this->_site_id = $site_id;
        }
        
        private function _get_site_id(){
            return $this->_site_id;
        }
        
        /**
         *
         * Seo Bilgileri
         * 
         */
        private function _get_page_title(){
            $title = $this->_page_title;
            if($this->_title_suffix) {
                $title = $this->_title_suffix . " - " . $this->_page_title;
            }
            return $title;
        }

        private function _get_page_description(){
            $description = $this->_page_desc;

            if($this->_title_suffix) {
                $description = $this->_title_suffix . " - " . $description;
            }
            return $description;
        }
        /**
         *
         * seo bilgileri bitti
         * 
         */
        private function _get_domain(){
            $this->load->model('router_model');
            $domain = $_SERVER['HTTP_HOST'];
            $www = false;
            //www var mı yok mu
           if (preg_match("/www./i", $domain)) {
                 $domain = str_replace('www.', '', $domain);//www'yu atalim
                 $www = true;
            } 

            $subdomain_arr = explode('.', $domain); //creates the various parts  
            $subdomain = $subdomain_arr[0]; //subdomain neymis
            $main_domain = $subdomain_arr[1];//ana domain de buymus

            if($main_domain == "sincapp"){
                 if($www==true){//www varsa olmayan haline redirect et seo icin demo.sincapp.com
                     redirect('http://'.$domain.$_SERVER['REQUEST_URI']);
                 }                 
                 $site_id = $this->router_model->_get_id_by_sub($subdomain);
                 
            }else{
                if($www==false){//www yoksa olan haline redirect et seo icin www.domain.com
                     redirect('http://www.'.$domain.$_SERVER['REQUEST_URI']);
                 }
                $site_id = $this->router_model->_get_id_by_main($domain);                
            }
            
            return $site_id;
        }
        //sitemap yapmaca
        
        private function _sitemap_parse(){
            $site_id = $this->_get_site_id();
            
            $result = $this->site_model->get_pages_for_sitemap($site_id);
            if($result == false){
                $this->_not_found();
                return false;
            }
            $data = array();
            $data['pages'] = $result;
            $this->load->view('sitemap_view', $data);
        }
        
        private function _set_page_id($url, $prefix, $page_id = null){
           $url = str_replace(".html", "", $url);//.html'i sil
            
           $site_id = $this->_get_site_id();
           if($page_id == null) {
                $data = $this->site_model->get_page_id($site_id, $url, false, $prefix);  
           }else {
                $data = $this->site_model->get_page_by_page_id($site_id, $page_id);
           }

           if($data == false){
               $this->_page_id = false;
               $this->_page_title = false;
               $this->_page_desc = false;
               $this->_password = false;
           }else{
               $this->_page_id = $data['page_id'];
               $this->_page_title = $data['seo_title'];
               $this->_page_desc = $data['seo_description'];
               $this->_password = $data['password'];
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
        
        private function _get_password() {
            return $this->_password;
        }

        private function _get_css(){
             return $this->_css_files;
           
        }
        
        private function _not_found(){
            $this->output->set_status_header('404');            
            $this->load->view('error/404_view');
        }
}