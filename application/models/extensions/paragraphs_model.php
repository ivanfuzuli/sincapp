<?php

class Paragraphs_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function get_html($site_id, $extra_id){
         $query = $this->db->get_where('paragraphs', array('site_id' => $site_id, 'paragraph_id' => $extra_id));
        $row = $query->row();
        return $row;

    }
    
    public function set_html($site_id, $page_id, $pr_id, $content){
        $data = array('content' => $content);
        
        $this->db->where(array('site_id'=>$site_id, 'paragraph_id' => $pr_id));
        $this->db->update('paragraphs', $data);
        
        //cop toplama
        //kac tane paragrafla ilgili fotograf var
        $this->db->select('p_pics.paragraph_id, p_pics.sub_id, p_pics.pic_id, pictures.path, pictures.ext');
        $this->db->where('p_pics.site_id', $site_id);
        $this->db->where('paragraph_id', $pr_id);
        $this->db->join('pictures', 'p_pics.pic_id = pictures.pic_id');
        $query = $this->db->get('p_pics');
        $result = $query->result();
        
        foreach($result as $row){
            $file = "photo_prg_".$row->paragraph_id."_".$row->sub_id.$row->ext;
            $pattern = "/".$file."/i";
            
            if(!preg_match($pattern, $content)){//eger eslesen yoksa sil
                $path = "./files/photos/".$site_id."/".$row->path."/".$file;
                $this->db->where('pic_id', $row->pic_id);
                $this->db->where('paragraph_id', $row->paragraph_id);                
                $this->db->where('sub_id', $row->sub_id);                
                $this->db->delete('p_pics');
                if(!unlink($path)){                
                    //dosya yok ya da silinemedi
                };
            }
        }
        
        //sayfanin son duzenleme tarihini degistir sitemapler icin
        $this->db->where(array('site_id'=>$site_id, 'page_id' => $page_id));
        $this->db->update('pages', array('lastmod' => time()));
        return true;
    }
    
    public function photo($site_id, $par_id, $pic_ids){
        $this->load->library('resize');
        //ilk once kac tane var onlari alalim
        $this->db->limit(1);
        $this->db->order_by('sub_id', 'desc');
        $this->db->select('sub_id');
        $this->db->where(array('site_id' => $site_id, 'paragraph_id' => $par_id));
        $query = $this->db->get('p_pics');
        $row = $query->row();
        if($row){
            $sub_id = (int)$row->sub_id;
        }else{//yoksa sifirdan basla
            $sub_id = 0;
        }
        
        $p_data = array();
        //yeni eklenenleri db ye isleyelim
        foreach($pic_ids as $pic_id){
           $sub_id++; 
           $data = array(
               'site_id' => $site_id,
               'paragraph_id' => $par_id,
               'pic_id' => $pic_id,
               'sub_id' => $sub_id
           );
           
           $this->db->insert('p_pics', $data);
           $p_pic_id = $this->db->insert_id();
           
           $thumb = '_prg_'.$par_id.'_'.$sub_id;
           
            $config = array(
                'site_id' => $site_id,
                'pic_id' => $pic_id,
                'path' => $thumb,
                'width' => 200
            );
            
           $r_data = $this->resize->resize_pic($config);//boyutlandir
           //array'e yig
           $p_data['photos'][] = array(
               'p_pic_id' => $p_pic_id, 
               'path'=> CDN.'photos/'.$site_id.'/'.$r_data['path'].'/photo'.$thumb.$r_data['ext'],//yolu
               'ratio' => $r_data['ratio']//oran
               );
        }
        
        return $p_data;
    }
    
    public function resize($site_id, $p_pic_id, $width){
        $this->db->select('pic_id, paragraph_id, sub_id');
        $query = $this->db->get_where('p_pics', array('site_id' => $site_id, 'p_pic_id' => $p_pic_id));
        $row = $query->row();
        
        if($row){
            $this->load->library('resize');
            $thumb = '_prg_'.$row->paragraph_id.'_'.$row->sub_id;
            $config = array(
                'site_id' => $site_id,
                'pic_id' => $row->pic_id,
                'path' => $thumb,
                'width' => $width
            );
           $r_data = $this->resize->resize_pic($config);//boyutlandir            
        }
    }
}