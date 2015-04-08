<?php

class Site_model extends CI_Model {
    private $_site_id = null;
    private $_settings = null;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_page_id($site_id, $url, $admin = false, $prefix = null){
        $this->db->select('page_id, title, seo, seo_title, seo_description, password');
        $query = $this->db->get_where('pages', array('site_id' => $site_id, 'url' => $url, 'prefix' => $prefix));
        $row = $query->row();
        if(!$row){
            return false;
        }
        if($admin == true){//eger editordeyse sadece pageid yeter
            return $row->page_id;
        }
        $data['page_id'] = $row->page_id;
        $data['password'] = $row->password;
        //seo ayarlamalari
        if($row->seo == 0){
            //seo yoksa settingsden al bilgileri birlestir ve isle
          $row_seo = $this->_get_settings();
            //eger indexse varsayilan gibi isle
            if($url == "index"){
                $data['seo_title'] = $row_seo->title;
                $data['seo_description'] = $row_seo->site_desc;
            }else{
                $data['seo_title'] = $row->title." - ".$row_seo->title;
                $data['seo_description'] = $row->title." - ".$row_seo->site_desc;
            }
            
        }else{
            $data['seo_title'] = $row->seo_title;
            $data['seo_description'] = $row->seo_description;
        }
        return $data;
    }
    
    public function get_page_by_page_id($site_id, $page_id, $admin = false){
        $this->db->select('page_id, title, seo, seo_title, seo_description, url, password');
        $query = $this->db->get_where('pages', array('site_id' => $site_id, 'page_id' => $page_id));
        $row = $query->row();
        if(!$row){
            return false;
        }
        if($admin == true){//eger editordeyse sadece pageid yeter
            return $row->page_id;
        }
        $data['page_id'] = $row->page_id;
        $data['password'] = $row->password;
        //seo ayarlamalari
        if($row->seo == 0){
            //seo yoksa settingsden al bilgileri birlestir ve isle
          $row_seo = $this->_get_settings();
            //eger indexse varsayilan gibi isle
            if($row->url == "index"){
                $data['seo_title'] = $row_seo->title;
                $data['seo_description'] = $row_seo->site_desc;
            }else{
                $data['seo_title'] = $row->title." - ".$row_seo->title;
                $data['seo_description'] = $row->title." - ".$row_seo->site_desc;
            }
            
        }else{
            $data['seo_title'] = $row->seo_title;
            $data['seo_description'] = $row->seo_description;
        }
        return $data;
    }

    public function get_grids($site_id, $page_id){
        $this->db->select('grid_id ,width, parent_sort');
        $this->db->order_by("parent_sort"); 
        $this->db->order_by('sort');
        $query = $this->db->get_where('grids', array('site_id' => $site_id, 'page_id' => $page_id));
        $result  = $query->result();
        return $result;        
    }


    public function set_settings($site_id, $prefix){
        $query = $this->db->get_where('settings', array('site_id' => $site_id, 'prefix' => $prefix));
        $row = $query->row();
        
        $this->_site_id = $site_id;
        $this->_settings = $row;
    }
    
    private function _get_settings(){
        return $this->_settings;
    }
    
    public function get_main_settings(){
        $row = $this->_get_settings();
        $data = array(
            'title' => $row->title,
            'site_desc' => $row->site_desc,
            'header_code' => $row->header_code,
            'footer_code' => $row->footer_code,
            'tour' => $row->tour
        );
        
        return $data;
    }
    
    public function get_cover() {
        $row = $this->_get_settings();
        $pic_id = $row->cover_photo;
        $query = $this->db->get_where('pictures', array('pic_id' => $pic_id));
        $row = $query->row();
        if (!$row) {
            return false;
        }
        $file = CDN . 'photos/'.$row->site_id.'/'.$row->path.'/photo_960'.$row->ext;
        return $file;
    }

    public function get_logo($mode = 'normal'){
        $row = $this->_get_settings();
        
        $style = $this->_make_logo_css($row->logo_top, $row->logo_left);
        //eger logo yazıysa onun degerleri
        if($row->logo_type == 0){
            $logo = $row->logo_str;
            $ratio = null;
            
        }else{//yok logo fotoysa ona gore
            $pic_id = $row->logo_img_id;
            $info = $this->_get_logo_img($row->site_id, $pic_id);
            $logo = $info['file'];
            $ratio = $info['ratio'];
        }
        
        if($mode != 'ajax'){
            $ajax = false;
        }else{
            $ajax = true;
        }
        
            $data = array('logo' => $logo, 'ratio' => $ratio,  'logo_style' => $style, 'ajax' => $ajax);
            
            return $data;        
    }
    
    public function get_pages_for_sitemap($site_id){
        $site_id = (int)$site_id;
        if($site_id == 0){
            return false;
        }
        
        $this->db->select('url, external, lastmod, prefix');
        $query = $this->db->get_where('pages', array('site_id' => $site_id, 'prefix' => null));
        $result = $query->result();
        
        $this->load->model('manage/language_model');
        $en_statu = $this->language_model->is_active_english_exist($site_id);
        if ($en_statu) {
        $this->db->select('url, external, lastmod, prefix');
        $query2 = $this->db->get_where('pages', array('site_id' => $site_id, 'prefix' => 'en'));
        $result2 = $query2->result();
        $result = array_merge($result, $result2);          
        }
        return $result;
    }

    //logo fotosunun yolunu ayarlar
    private function _get_logo_img($site_id, $pic_id){
        $query = $this->db->get_where('pictures', array('pic_id' => $pic_id));
        $row = $query->row();
        
       $file = CDN.'photos/'.$row->site_id.'/'.$row->path.'/photo_logo'.$row->ext;
       
       $ratio = $row->width / $row->height;
       $data = array('file' => $file, 'ratio' => $ratio);
       return $data;
    }


    
    //logonun pozisyonunu ayarlayan css kodunu olusturur
    private function _make_logo_css($top, $left){
        $style = "";
        if($left != -1){
            $style = "style=\"left:".$left."px; top: ".$top."px\"";
        }
        
        return $style;
        
    }
    
    public function get_footer(){
        return $this->_settings->footer_str;
    }
    
    public function get_siteurl($site_id = null){
        
        if($site_id == null){//temadan degeri alirken siteidyi set etmek ilazim
            $site_id = $this->_site_id;
        }
        $this->db->select('sitename');
        $query = $this->db->get_where('sites', array('site_id' => $site_id));
        $row = $query->row();
        $domain = $this->get_domain_by_site_id($site_id);
        if ($domain) {
            return "http://www.".$domain."/";
        } else {
            return "http://".$row->sitename.".sincapp.com/";
        }
    }

    public function is_purchased($site_id) {
        $domain = $this->get_domain_by_site_id($site_id);
        if ($domain) {
            return true;
        } else {
            return false;
        }
    }

    public function get_domain_by_site_id($site_id) {
        $query = $this->db->get_where('domains', array('site_id' => $site_id, 'status' => 0));
        
        $row = $query->row();
        if($row) {
            return $row->domain;
        } else {
            return false;
        }
    }

    public function get_theme(){
        $theme_id = $this->_settings->theme_id;
        $query = $this->db->get_where('themes', array('theme_id' => $theme_id));
        $row = $query->row();
        
        return $row;
    }
    
    public function get_css_for_admin($site_id){
        $this->db->select('settings.theme_id, themes.theme_css');
        $this->db->where('site_id', $site_id);
        $this->db->join('themes', 'settings.theme_id = themes.theme_id');
        $query = $this->db->get('settings');
        return $query->row()->theme_css;
    }
    
}