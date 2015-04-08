<?php

class Cover_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    
    }

    /**
    * Updatter for cover image
    * @param int $site_id
    * @param int $pic_id
    * @return bool
    */
    public function update_image($site_id, $pic_id){
        $this->db->where(array('site_id'=>$site_id));
        $this->db->update('settings', array('cover_photo' => $pic_id));   
        return true;       
    }

    /**
    * Setter for no cover image
    * @param int $site_id
    * @return bool
    */

    public function no_cover($site_id) {
        $this->db->where(array('site_id'=>$site_id));
        $this->db->update('settings', array('cover_photo' => null));   
        return true;
    }

    /**
    * @Getter for normal cover image
    * @param int $pic_id
    * @return string
    */
    public function get_picture($pic_id){
        $query = $this->db->get_where('pictures', array('pic_id' => $pic_id));
        $row = $query->row();

            $pic_id = $row->pic_id;
            $picture = CDN.'photos/'.$row->site_id.'/'.$row->path . '/photo_960'. $row->ext;
        return $picture;
    }


    /**
    * Getter for editor image, this image will be used in image editor mode
    * @param string $site_id
    * @return array
    */
    public function get_editor_image($site_id){
        $query = $this->db->get_where('settings', array('site_id' => $site_id));
        $row = $query->row();
        $pic_id = $row->cover_photo;

        $query = $this->db->get_where('pictures', array('pic_id' => $pic_id));
        $row = $query->row();

            $pic_id = $row->pic_id;
            $picture = CDN.'photos/'.$row->site_id.'/'.$row->path . '/photo_960_original'. $row->ext;
        return array('image' => $picture);
    }  

    /**
    * Return image which will be cropped
    * @param int $site_id
    * @return string
    */
    public function get_crop_image($site_id) {
        $query = $this->db->get_where('settings', array('site_id' => $site_id));
        $row = $query->row();
        $pic_id = $row->cover_photo;

        $query = $this->db->get_where('pictures', array('pic_id' => $pic_id));
        $row = $query->row();

        return array(
            'path' => $row->path,
            'ext' => $row->ext
        );
    }  
}