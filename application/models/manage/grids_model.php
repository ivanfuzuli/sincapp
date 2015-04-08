<?php

class Grids_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();

    }
    
    public function set_width($site_id, $data){
                foreach($data as $key => $value){
                    $this->db->where(array('site_id'=>$site_id, 'grid_id' => $key));
                    $this->db->update('grids', array('width' => $value));                       
                }
                
                return true;

    }
    
    public function merge($site_id, $before_id, $after_id, $width, $empty){
        //eger sonraki element bos degilse
        if($empty=="delete"){
        //eskileri yeni yere tasiyalim
            $sort = $this->_get_set_sort($after_id);
            
            $this->db->select('ext_id');
            $this->db->order_by('sort', 'asc');
            $query = $this->db->get_where('extensions', array('site_id'=>$site_id, 'grid_id' => $before_id));
            $result = $query->result();
            
            foreach($result as $row){
                $this->db->where(array('ext_id' => $row->ext_id));
                $this->db->update('extensions', array('grid_id' => $after_id, 'sort' => $sort));
                $sort++;
            }
        //eski gridi silelim
        $this->db->delete('grids', array('site_id' => $site_id, 'grid_id' => $before_id));
        
        }elseif($empty=="stop"){
            //sonraki eleman bos ise önceki id'yi alalim
            $after_id = $before_id;
        }

        //yeni yerin uzunlugunu arttıralim
        if($empty!="nochild"){
            $this->db->where(array('site_id'=>$site_id, 'grid_id' => $after_id));
            $this->db->update('grids', array('width' => $width));       
        }else{
            //eger önceki elemanin cocugu yoksa gridi silelim baska da bi islem yok
            $this->db->delete('grids', array('site_id' => $site_id, 'grid_id' => $before_id));

        }
        
        return true;
    }
    
    public function sort_grids($site_id, $grid_id, $ext_ids){
        $listening = 1;
        if(!is_array($ext_ids)): return false; endif;
        
        foreach($ext_ids as $ext_id){
                 $this->db->where(array('site_id'=>$site_id, 'ext_id' => $ext_id));
                 $this->db->update('extensions', array('sort' => $listening, 'grid_id' => $grid_id));
                 $listening++;
        }
    }
    
    public function add_grid($site_id, $before_id, $ext_id, $width){
        $sortData = $this->_get_sort($before_id);
        $page_id = $sortData->page_id;
        $sort = $sortData->sort;
        $par_sort = $sortData->parent_sort;
        
        //ilk önce gridi yaratalim
        $this->db->insert('grids', array('site_id' => $site_id, 'page_id' => $page_id, 'parent_sort' => $par_sort, 'sort' => $sort, 'width' => $width));
        //gridini idsini alip eklentimizin yeni yerini ayartlalim
        $grid_id = $this->db->insert_id();
        $this->_single_ext($site_id, $ext_id, $grid_id);
        
        return $grid_id;
    }
    
    public function add_table($site_id, $page_id, $ext_id, $parId){
        $parSort = 1;
        
        if($parId=="firstGrid"){
        //eskileri birer arttir
                 $this->db->set('parent_sort', 'parent_sort+1', FALSE);
                 $this->db->where(array('site_id'=>$site_id, 'page_id' => $page_id));
                 $this->db->update('grids');
                 $parSort = 1;
        }else{
            //en büyük ana gridi alalim ve bir arttıralim
                $this->db->order_by('parent_sort', 'desc');
                $query = $this->db->get_where('grids', array('site_id'=>$site_id, 'page_id' => $page_id), 1, 0);   
                $row = $query->row();     
            $parSort = $row->parent_sort;
            $parSort++;
        }
       //yeni tabloyu yaratalim
        $this->db->insert('grids', array('site_id' => $site_id, 'page_id' => $page_id, 'parent_sort' => $parSort, 'sort' => 1, 'width' => '940'));
        //gridini idsini alip eklentimizin yeni yerini ayartlalim
        $grid_id = $this->db->insert_id();
        $this->_single_ext($site_id, $ext_id, $grid_id);
        
        return $grid_id;
        
    }
    
    //verilen iddeki gridin özelliklerini al bakiim
    private function _get_sort($grid_id){
        $query = $this->db->get_where('grids', array('grid_id' => $grid_id), 1, 0);   
            $row = $query->row();        
            return $row;
    }
    
    private function _single_ext($site_id, $ext_id, $grid_id){
                 $this->db->where(array('site_id'=>$site_id, 'ext_id' => $ext_id));
                 $this->db->update('extensions', array('sort' => 1, 'grid_id' => $grid_id));
                 return true;
    }
    
    //birlestirirken ufak yer kayma bug'i olmasin
    private function _get_set_sort($grid_id){
        $sort = 0;
        $this->db->order_by('sort', 'asc');
        $query = $this->db->get_where('extensions', array('grid_id' => $grid_id));
        $result = $query->result();
        
        if($result):
            foreach($result as $row){
                $this->db->where(array('ext_id' => $row->ext_id));
                $this->db->update('extensions', array('sort' => $sort));
                $sort++;
            }
        endif;
        return $sort;
    }

}