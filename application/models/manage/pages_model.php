<?php

class Pages_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
 
     public function get_pages_admin($site_id, $prefix){
        $this->db->order_by('sort');
        $query = $this->db->get_where('pages', array('site_id' => $site_id, 'prefix' => $prefix));
        $result = $query->result();
        
        $data = array();
        foreach($result as $row){
            $data[$row->sub_id][] = array('page_id' => $row->page_id, 'title' => $row->title, 'url' => $row->url, 'hidden' => $row->hidden, 'external' => $row->external, 'seo' => $row->seo);
        }
        
        return $data;
    }

    public function get_page_by_id($id) {
        $query = $this->db->get_where('pages', array('page_id' => $id), 1, 0);
        return $query->row();
    }

    public function get_pages($site_id, $page_id = null, $base_path = null, $prefix = null, $no_active_page = false){
        if ($base_path == null) {
            $base_path = base_url();
        } 
        $this->db->order_by('sort');
        $query = $this->db->get_where('pages', array('site_id' => $site_id, 'prefix' => $prefix));
        $result = $query->result();
        
        $data = array();
        foreach($result as $row){
            //sayfa aktif mi değil mi
            if($page_id == $row->page_id && !$no_active_page){
                $class="class=\"active-element\"";
            }else{
                $class="";
            }
             if($row->external == true){
                $url = $row->url;
             }else{
                $url = $base_path.$row->url.".html";
            }
             if($row->url == 'index'){
                $url = $base_path;
             }

            if(!$row->hidden) {// Eger sayfa gizliyse gösterme
                $data[$row->sub_id][] = array('page_id' => $row->page_id, 'class' => $class, 'title' => $row->title, 'url' => $url, 'external' => $row->external, 'seo' => $row->seo);
            }
        }
        
        return $data;
    }
    //seo düzenleme sayfası için gerekli get islemi
    
    public function get_seo_pages($site_id, $ids){
            $this->db->where_in('page_id', $ids);
            $query = $this->db->get('pages');
            $result = $query->result();
            
            $data = array();
            foreach($result as $row){
                $title = $row->title;
                $seo = $row->seo;
                $page_id = $row->page_id;
                //eger seo varsa tablodan bilgileri cek
                if($seo != 0){
                   $seo_title = $row->seo_title;
                   $seo_description = $row->seo_description;
                }else{                   
                   $query = $this->db->get_where('settings', array('site_id' => $site_id));
                   $row_seo = $query->row();
                   $seo_title = $title." - ".$row_seo->title;
                   $seo_description = $title." - ".$row_seo->site_desc;
                }
                
                $data[] = array('page_id' => $page_id, 'title' => $title, 'seo' => $seo, 'seo_title' => $seo_title, 'seo_description' => $seo_description);
            }
            
            return $data;
    }
    
    
    public function sort_pages($site_id, $page_id){
        //sirasini
        $listening = 1;
        $subList = array();
        //döngüye sok ve sıralamayı kaydet
        foreach($page_id as $key => $value){
                    $value = (int)$value;
                    //eger deger sifirdan farkliysa kendi gurubu icinde siralama yap
                    if($value != 0){
                        
                        //key yoksa birden baslat
                        if(!isset($subList[$value])){
                           $subList[$value] = 1;
                        }else{
                          $subList[$value]++;
                        }
                        
                      $liste = $subList[$value];
                    //ana grup siralamasi  
                    }else{
                      $liste = $listening;  
                    }
                    
                    $this->db->where(array('site_id'=>$site_id, 'page_id' => $key));
                    $this->db->update('pages', array('sort' => $liste, 'sub_id' => $value));   
                    //birer birer arttır
                    $listening++;
        }
    }
    
    public function delete_pages($site_id, $page_ids){
        //anasayfa knotrol
        if(!is_array($page_ids)) return false;
        foreach($page_ids as $id){
            if($this->_check_index($id)): return false; endif;
        }
        //page_id array[] ona göre
        $this->db->where('site_id', $site_id);
        $this->db->where_in('page_id', $page_ids);
        $this->db->delete('pages');
        
        $this->_db_garbage($site_id, $page_ids);
        return true;
    }
    
    //sayfa silinince ortada kalan db kayıtlarını da silsin
    private function _db_garbage($site_id, $page_ids){
        foreach($page_ids as $page_id):
                //gridlerisil
                $this->db->where(array('site_id' => $site_id, 'page_id' => $page_id));
                $this->db->delete('grids');   
                //eklentileri sil
                $query = $this->db->get_where('extensions', array('site_id' => $site_id, 'page_id' => $page_id));
                $result = $query->result();

                foreach($result as $row){
                    $ext_name = $row->ext_name;//eklenti adini alalim
                    $extra_id = $row->extra_id;

                    $this->load->library($ext_name);
                    $this->$ext_name->delete($site_id, $extra_id);
                }

                //kalan eklenti bilgilerini sil
                $this->db->where(array('site_id' => $site_id, 'page_id' => $page_id));
                $this->db->delete('extensions'); 

                $this->db->where(array('site_id' => $site_id, 'page_id' => $page_id));
                $this->db->delete('menu_pages');                  
        
        endforeach;
    }
    
    //eger anasayfaysa silme
    private function _check_index($page_id){
        $query = $this->db->get_where('pages', array('page_id' => $page_id), 1, 0);   
            $row = $query->row();
            if(!$row){
                return false;
            }
            
            $url = $row->url;
            if($url == "index"){
                return true;
            }
            return false;
    }
    public function edit_pages($site_id, $ids){
            
            $this->db->where_in('page_id', $ids);
            $query = $this->db->get('pages');
           
            return $query->result();

    }
    
    public function edit_pages_do($site_id, $ids, $names, $urls, $hiddens, $externals, $passwords){
                $i = 0;
                foreach($ids as $id){
                $data = array(null);
                $data['id'] = $id;     
                
                $external = (int)$externals[$i];
                if($external == 0){//eger url iceri gidiyorsa replace et checket
                    $url = $this->_uni_url($site_id, $urls[$i], $id);
                }else{
                    //url disari gidiyorsa check etmeye luzum yok
                    $url = $urls[$i];
                }
                $password = $passwords[$i];
                if(!$password) {
                    $password = null;
                }
                $data = array(
                    'title' => $names[$i],
                    'url' => $url,
                    'hidden' => (int)$hiddens[$i],
                    'external' => $external,
                    'password' => $password
                 );
                    
                    $this->db->where(array('site_id'=>$site_id, 'page_id' => $ids[$i]));
                    $this->db->update('pages', $data); 
                    
                    $i++;
                }
                
                return true;
    }
    
        //yeni sayfayaratma
    /**
    * Set new page
    * @param int $site_id
    * @param string $title
    * @param string $prefix
    * @param string $f_url
    * @param integer|bool $menu_id
    */
    public function set_page($site_id, $title, $prefix = null, $f_url = null, $menu_id = false){
        if($menu_id) {
            $hidden = true;
        } else {
            $hidden = false;
        }

        //id benzersiz olsun
        if($f_url == null){
            $url = $this->_uni_url($site_id, $title);
        }else{
            $url = $f_url;
        }
        //en sona at siralamayi
        $sort = $this->_get_last_sort($site_id);
        
        $this->db->insert('pages', array('site_id' => $site_id, 'title' => $title, 'url' => $url, 'sort' => $sort, 'prefix' => $prefix, 'hidden' => $hidden));
        
        $page_id = $this->db->insert_id();
        
        $this->_set_grid($site_id, $page_id, $menu_id);
        //ilk paragraf eklentisini ve gridi yaratalim
        return $page_id;
    }
    
    //yeni sayfa yaratilinca ilk giridi yarat
    private function _set_grid($site_id, $page_id, $menu_id){
        $this->db->insert('grids', array('site_id' => $site_id, 'page_id' => $page_id, 'parent_sort' => 1, 'width' => '600', 'sort' => 1));
        $grid_id = $this->db->insert_id();
    
       if($menu_id == false){
           $this->_set_paragraph($site_id, $page_id, $grid_id);
       } else {
           $this->_set_menu($site_id, $page_id, $grid_id, $menu_id);
       }
        
       return true;
    }
    //paragraf eklentisini yaratalım
    private function _set_menu($site_id, $page_id, $grid_id, $menu_id){
        $query = $this->db->get_where('menus', array('site_id' => $site_id, 'id' => $menu_id), 1, 0);
        $row = $query->row();
        $cnt = $row->cnt;
        $cnt++;
        $this->db->where('id', $menu_id);
        $this->db->update('menus', array('cnt' => $cnt));
        //eklentiyi kayıt et
        $this->db->insert('extensions', array('site_id' => $site_id, 'page_id' => $page_id, 'grid_id' => $grid_id, 'ext_name' => 'menu', 'extra_id' => $menu_id, 'sort' => 1));
        
        return true;
    }

    //paragraf eklentisini yaratalım
    private function _set_paragraph($site_id, $page_id, $grid_id){
        $this->load->library('paragraphs');
        $extra= $this->paragraphs->create($site_id, $page_id);//paragraf yaratıldı
        $extra_id = $extra['str'];
        //eklentiyi kayıt et
        $this->db->insert('extensions', array('site_id' => $site_id, 'page_id' => $page_id, 'grid_id' => $grid_id, 'ext_name' => 'paragraphs', 'extra_id' => $extra_id, 'sort' => 1));
        
        return true;
    }
    //en son siralama numarasini al ve arttir yeni sayfa yaratirken lazım
    private function _get_last_sort($site_id){
            $this->db->order_by('sort', 'desc');
            $query = $this->db->get_where('pages', array('site_id' => $site_id, 'sub_id' => 0), 1, 0);   
            $row = $query->row();
            
            if($row){
                 $data = $row->sort;
            }else{
                $data = 0;
            }
            return $data++;
            
    }
    
    /*
     * Seo Ayarlarını Kaydetme
     * 
     */
    
    public function seo_pages_do($site_id, $page_ids, $seos, $titles, $descriptions){
        $i = 0;
        foreach($page_ids as $page_id){
            $seo = (int)$seos[$i];
            $title = $titles[$i];
            $description = $descriptions[$i];
            
            if($seo==1){//eger seo varsa yeni bilgileri kaydet
                $data = array('seo' => $seo, 'seo_title' => $title, 'seo_description' => $description);
            }else{
                $data = array('seo' => $seo);
            }
            
                 $this->db->where(array('site_id'=>$site_id, 'page_id' => $page_id));
                 $this->db->update('pages', $data);   
            $i++;
        }
    }
    
    
    /*
     * Benzersiz url olusturma
     */
    private function _uni_url($site_id, $url, $page_id = false){
        //türkçe karakterleri ve boşluklar vs. süzelim
         $this->load->helper('tr_karakter');
         $url = tr_karakter($url);
            //eger sayfa varsa url , url-2 olsun deyuu
            $i = 2;
            $url_default = $url;
            $stopper = false;
            //eger notda deger varsa onu haric tut
            if($page_id != false){
                $this->db->or_where('page_id !=', $page_id); 
            }
            //hic ayni isme sahip olmayan bir sey bulana kadar zorla
            while (!$stopper) {
            $query = $this->db->get_where('pages', array('site_id' =>$site_id, 'url' => $url));
                if($query->num_rows() != 1){
                    $stopper = true;
                }else{
                    $url = $url_default.'-'.$i;
                    $i++;
                }
            }
        
            return $url;
    }
}