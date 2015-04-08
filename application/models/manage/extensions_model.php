<?php

class Extensions_model extends CI_Model {
    var $user_id;
    private $_site_id;
    private $_page_id;
    private $_prefix;
    private $_mode;
    
    function __construct()
    {
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
        $this->lang->load('ext_names', 'turkish');             
        
        $this->config->load('extensions');       
    }


    public function set_ext($site_id, $page_id, $ext_name, $prefix){
        $this->_set_site_id($site_id);
        $this->_set_page_id($page_id);
        $this->_set_prefix($prefix);
         $site_id = $this->_get_site_id();
         $page_id = $this->_get_page_id();
        //güvenlik için eklenti kayıtlı mı confige bak, kayıtlı değilse dur
        if(!$this->config->item($ext_name)){
            return FALSE;
        }
        
        $js_arr = $this->config->item($ext_name);
        
        $ext_js = json_encode($js_arr);

        //hiiç bir şey yokken eklenti vardı, karadelik gibi bir şey ilk önce onu yarat :)

        //teee library'den dönen id
        $response = $this->_create_extension($ext_name);
        if($response['statu'] === true){//eger hersey tamamsa yola devam etmek icin extra id'yi isle
            $extra_id = $response['str'];
            $callback = $response['callback'];
        }else{//hata varsa hatayi return et
            return array('statu' => false, 'str' => $response['str']);
        }
        
        //islem yarida kesilirse yine de sayfada kalsin diye en buyk grid id al
        $grid_id = $this->_get_top_grid();
        $sort = 1;
        //sonra eklentinin adresi oldu ^ yukarı bak :)
        $result = $this->db->insert('extensions', array('site_id' => $site_id, 'page_id' => $page_id, 'grid_id' => $grid_id, 'ext_name' => $ext_name, 'extra_id'=> $extra_id, 'sort' => $sort));
        if($result == TRUE){
            $ext_id = $this->db->insert_id();
        }else{
            $ext_id = false;
        }        
        
        $ext_title = $this->_get_ext_title($ext_name);
        $data = array('statu' => true, 'extra_id' => $extra_id, 'ext_title' => $ext_title, 'ext_id' => $ext_id, 'ext_js' => $ext_js, 'callback' => $callback);
        //eklenti yaratildi simdi id dön
        return $data;
    }

    
    //en büyük gridi alıp kayıt edelim ki, eklentimiz
    private function _get_top_grid(){
         $site_id = $this->_get_site_id();
         $page_id = $this->_get_page_id();
         
         $this->db->select('grid_id');         
         $this->db->order_by('parent_sort');
         $query = $this->db->get_where('grids', array('site_id'=>$site_id, 'page_id' => $page_id), 1, 0);   
         $row = $query->row();  
         
         if($row){
            $grid_id = $row->grid_id;
         }else{
             $grid_id = 0;
         }
         return $grid_id;
    }
    
   public function delete_ext($site_id, $ext_id){
         $data = array('site_id' => $site_id, 'ext_id' => $ext_id);
         
         $this->db->select('ext_name, extra_id');
         $query = $this->db->get_where('extensions', $data);  
         $row = $query->row();       
         
         $ext_name = $row->ext_name;
         $extra_id = $row->extra_id;
 
         //libraryie de de silsin
         $cevap = $this->_delete_extension($site_id, $ext_name, $extra_id);
         
         //silme basariliysa extensions tablosundan da silsin
         if($cevap === true){
            $this->db->delete('extensions', $data);
         }
         return $cevap;
   }

    public function get_extensions($site_id, $page_id, $mode = "admin", $extra_data = null){
        $this->db->order_by('sort');
        $query = $this->db->get_where('extensions', array('page_id' => $page_id));  
        $result = $query->result();
        
        $extensions = array();
        $js_files = array();
        //eklentileri grid idsine göre array'e yığ, view'de grid idsine göre çağıracak
        foreach($result as $row){
            
            $ext_title = $this->_get_ext_title($row->ext_name);
                
                $ext_js = $this->_get_ext_js($row->ext_name, $mode);//eklenecek js dosyalari
                if($ext_js != null){
                    foreach($ext_js as $js){
                        $js_files[$js] = true;//array key'ler true olsun
                    }
                }
            if(isset($extra_data[$row->ext_name])) {
                $r_data = $this->call_extension($row->ext_name, $site_id, $row->extra_id, $mode, $extra_data[$row->ext_name]);//eklentinin index fonksiyonundan gelenler    
            } else {
                $r_data = $this->call_extension($row->ext_name, $site_id, $row->extra_id, $mode);//eklentinin index fonksiyonundan gelenler    
            }
            $extensions[$row->grid_id][] = array('ext_id' => $row->ext_id, 'ext_title' => $ext_title, 'ext_html' => $r_data['html'], 'ext_icon_class' => $r_data['icon'] );
        }

        $js_files = $this->_make_js_array($js_files, $mode);//javascript array'e dönüştür
        $data = array('extensions' => $extensions, 'js' => $js_files);
        return $data;
        
    }
    //eklentileri cagirmaca
    
    public function call_extension($ext_name, $site_id, $extra_id, $mode = "admin", $extra_data = null){
        $this->load->library($ext_name);
       $data = $this->$ext_name->index($site_id, $extra_id, $mode, $extra_data);

       return $data;
    }    
    
    private function _get_ext_title($ext_name){
    
        $data = $this->lang->line($ext_name);

        return $data;
    }
    
    //@return array
    private function _get_ext_js($ext_name, $mode){
        
        if($mode == "admin"){//moduna göre array al
            $ext_js = $this->config->item($ext_name);  
        }else{
            $ext_js = $this->config->item($ext_name.'_general');              
        }
        return $ext_js;
    }
    
    //istenni al libraryi gönder library veritabanin islesin idyi döndersin
    private function _create_extension($ext_name){
       $site_id = $this->_get_site_id();
       $page_id = $this->_get_page_id();
       $prefix = $this->_get_prefix();
       $this->load->library($ext_name);
       $data = $this->$ext_name->create($site_id, $page_id, $prefix);

       return $data;
    }
    
    private function _delete_extension($site_id, $ext_name, $ext_id){
       $this->load->library($ext_name);
       $data = $this->$ext_name->delete($site_id, $ext_id);

       return $data;        
    }
    
    private function _make_js_array($dynArr, $mode){
      if($mode == "admin"){
          return $this->_admin_js($dynArr);
      }else{
          return $this->_general_js($dynArr);
      }
    }
    
    private function _general_js($dynArr){
        return $dynArr;
    }
    
    private function _admin_js($dynArr){
        $defaultArr = array('grids' => true, 'toolbar' => true, 'logo' => true);   
        
        $arr = array_merge($defaultArr, $dynArr);
        $keys = array_keys($arr);
        
        $script = "var jsFiles = ['";
        $script = $script . implode("','", $keys) . "'];";
        
        return $script;        
    }
    
    private function _set_prefix($prefix) {
        if($prefix == "") {
            $prefix = null;
        }
        
        $this->_prefix = $prefix;
    }    
    private function _set_site_id($site_id){
        $this->_site_id = $site_id;
    }
    
    private function _get_site_id(){
        return $this->_site_id;
    }
    private function _get_prefix() {
        return $this->_prefix;
    }
    private function _set_page_id($page_id){
        $this->_page_id = $page_id;
    }
    
    private function _get_page_id(){
        return $this->_page_id;
    }
}