<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cover extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();
              $this->load->model('manage/cover_model');
              $this->lang->load('cover', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli    
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }
        
        /**
        * Getter for edit mode image it is 960_original
        * @return json
        */
        public function get_editor_image() {
            $site_id = $this->__get_site_id();
            $data = $this->cover_model->get_editor_image($site_id);
            $data['info'] = "<div class=\"success\">".lang('succ_update_img')."</div>";
            echo json_encode($data);
        }

        /**
        * Updater for cover image
        * @return json
        */
        public function update_image(){
            $site_id = $this->__get_site_id();
            $pic_id = $this->input->post('pic_id');
            
            $image = $this->cover_model->update_image($site_id, $pic_id);
            return $this->get_editor_image();
        }

        /**
        * Cropper for image
        */
        public function crop_image()
        {
            $this->load->library('image_lib');

            $y = (int)$_POST['y'];

            $site_id = $this->__get_site_id();
            
            $image = $this->cover_model->get_crop_image($site_id);

            $config['maintain_ratio'] = TRUE;            
            //resize edilmiş fotoğrafın adresini al
            $photo_name = './files/photos/' . $site_id . '/' .  $image['path']. '/photo_960_original'. $image['ext'];
            $new_image = './files/photos/' . $site_id . '/' .  $image['path']. '/photo_960'. $image['ext'];
            // fotoğrafın ortasını bul
            $config['source_image'] = $photo_name;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 960;
            $config['height'] = 300;
            $config['x_axis'] = 0;
            $config['y_axis'] = -1 * $y;
            $config['new_image']  =  $new_image;           
            $this->image_lib->initialize($config);
            if( !$this->image_lib->crop()) {
                echo $this->image_lib->display_errors();
            };              
            echo "<div class=\"success\">".lang('succ_update_x_axis')."</div>";

        }


        /**
        * Updates cover mode to no cover mode
        */
        public function no_cover() {
            $this->cover_model->no_cover($this->__get_site_id());

            echo "<div class=\"success\">".lang('succ_no_cover')."</div>";
        }
}