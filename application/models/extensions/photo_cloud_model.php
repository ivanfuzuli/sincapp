<?php

class Photo_cloud_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function set_photos($site_id, $cloud_id, $photos){
        if(!$photos){
            return false;
        }
        
        $sort = $this->_get_last_sort($cloud_id);
        foreach($photos as $pic_id){
            $this->db->insert('photos', array('site_id' => $site_id, 'photo_cloud_id' => $cloud_id, 'pic_id' => $pic_id, 'sort' => $sort));
            $sort++;
        }

        return true;
    }
    
    public function get_photos($site_id, $cloud_id){
       $this->db->order_by('sort');        
       $query = $this->db->get_where('photos', array('site_id' => $site_id, 'photo_cloud_id' => $cloud_id));
       $result = $query->result();
       
       $data = array();
       foreach($result as $row){
           $photo_id = $row->photo_id;
           $pic_data = $this->_get_pic_url($row->pic_id);
           
           $data[] = array(
            'photo_id' => $photo_id, 
            'path' => $pic_data['path'], 
            'ext' => $pic_data['ext'],
            'title' => $row->title
            );
       }
       return $data;
        
    }

        public function sort_photos($site_id, $photo_id){
        //sirasini
        $listening = 1;
        //döngüye sok ve sıralamayı kaydet
        foreach($photo_id as $key){
                    $key = (int)$key;
                    
                    $this->db->where(array('site_id'=>$site_id, 'photo_id' => $key));
                    $this->db->update('photos', array('sort' => $listening));   
                    //birer birer arttır
                    $listening++;
        }
    }
    
    public function delete_photo($site_id, $photo_id){
        $this->db->where(array('site_id' => $site_id, 'photo_id' => $photo_id));
        $this->db->delete('photos');   
        return true;
    }

    public function update_photo($site_id, $photo_id, $data) {
        $this->db->where(array('site_id'=>$site_id, 'photo_id' => $photo_id));
        $this->db->update('photos', $data);  

        return true;
    }

    private function _get_pic_url($pic_id){
        $this->db->limit(1);
        $query = $this->db->get_where('pictures', array('pic_id' => $pic_id));
       
        $row = $query->row();
        
        if(!$row){
            return false;
        }
        $pic_path = CDN.'photos/'.$row->site_id.'/'.$row->path;
        $pic_ext = $row->ext;
        
        $data = array('path' => $pic_path, 'ext' => $pic_ext);
        return $data;
    }
    
    //en son siralama numarasini al ve arttir yeni sayfa yaratirken lazım
    private function _get_last_sort($cloud_id){
            $this->db->order_by('sort', 'desc');
            $query = $this->db->get_where('photos', array('photo_cloud_id' => $cloud_id), 1, 0);   
            $row = $query->row();
            if(!$row){
                return 1;
            }
            
            $data = $row->sort;
            return $data++;
            
    }
    
}