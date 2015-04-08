<?php

class Slider_cloud_model extends CI_Model {

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
            $this->db->insert('sliders', array('site_id' => $site_id, 'slider_cloud_id' => $cloud_id, 'pic_id' => $pic_id, 'sort' => $sort));
            $sort++;
        }

        return true;
    }
    
    public function get_sliders($site_id, $cloud_id){
       $this->db->order_by('sort');        
       $query = $this->db->get_where('sliders', array('site_id' => $site_id, 'slider_cloud_id' => $cloud_id));
       $result = $query->result();
       
       $data = array();
       foreach($result as $row){
           $slider_id = $row->slider_id;
           $pic_data = $this->_get_pic_url($row->pic_id);

           $data[] = array(
            'slider_id' => $slider_id, 
            'path' => $pic_data['path'], 
            'ext' => $pic_data['ext'],
            'title' => $row->title,
            'link' => $row->link
            );
           
       }
       return $data;
        
    }

    public function update_slider($site_id, $slider_id, $data) {
        $this->db->where(array('site_id'=>$site_id, 'slider_id' => $slider_id));
        $this->db->update('sliders', $data);  

        return true;
    }

        public function sort_sliders($site_id, $slider_id){
        //sirasini
        $listening = 1;
        //döngüye sok ve sıralamayı kaydet
        foreach($slider_id as $key){
                    $key = (int)$key;
                    
                    $this->db->where(array('site_id'=>$site_id, 'slider_id' => $key));
                    $this->db->update('sliders', array('sort' => $listening));   
                    //birer birer arttır
                    $listening++;
        }
    }
    
    public function delete_slider($site_id, $slider_id){
        $this->db->where(array('site_id' => $site_id, 'slider_id' => $slider_id));
        $this->db->delete('sliders');   
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
            $query = $this->db->get_where('sliders', array('slider_cloud_id' => $cloud_id), 1, 0);   
            $row = $query->row();
            if(!$row){
                return 1;
            }
            
            $data = $row->sort;
            return $data++;
            
    }
    
}