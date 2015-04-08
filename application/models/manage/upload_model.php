<?php

class Upload_model extends CI_Model {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->library('image_lib');
        $this->user_id = $this->auth->get_user_id();
       
    }

    public function check_token($token){
        $this->db->where(array('token' => $token));
        $query = $this->db->get('upload_tokens');
        $row = $query->row();  
        
        if($row){
            $data = array(
                'user_id' => $row->user_id,
                'site_id' => $row->site_id
            );
            return $data;
        }else{
            return false;
        }
    }
    //upload icin session islemedinden güvenli bir tokken
    public function set_token($user_id, $site_id){
        
        //benzersiz bir anahtar yarat
        $token = microtime();
        $token = "AbsE".microtime();
        $token = md5($token);
        
        //kontrol et eger varsa update et yoksa yarat
        $this->db->where(array('user_id' => $user_id, 'site_id' => $site_id));
        $query = $this->db->get('upload_tokens');
        $row = $query->row();
        
        if($row){
            $data = array('token' => $token);  
            $this->db->where(array('user_id' => $user_id, 'site_id' => $site_id));
            $this->db->update('upload_tokens', $data);
        }else{
            $data = array('user_id' => $user_id, 'site_id' => $site_id, 'token' => $token);
            $this->db->insert('upload_tokens', $data);
        }
        
        return $token;
    }
 
    public function process_document($site_id, $path, $code)
    {   
  
        $this->load->helper('tr_karakter');
        //Get File Data Info
        $uploads = array($this->upload->data());

        $syy = 0;        
        //Move Files To User Folder
        foreach($uploads as $key[] => $value)
        {                            
           //Move Uploaded Files with NEW Random name
            $filename = $this->security->sanitize_filename($value['raw_name']);
            $filename = tr_karakter($filename);
            $filename = $filename;

            rename($value['full_path'], $path.$filename.$value['file_ext']);
            
            //Make Some Variables for Database
            $imagename = $value['raw_name'];
            $ext = $value['file_ext'];
            $filesize = $value['file_size'];

           /* $filesize = $value['file_size'];
            $width = $value['image_width'];
            $height = $value['image_height'];
            $timestamp = time();
            */
            //bilgileri dondur
            
            $data = array(
                'user_id' => $this->user_id,
                'site_id' => $site_id,
                'real_name' => $filename,
                'name'  => $filename,
                'path' => $code,
                'ext' => $ext,
                'file_size' => $filesize
            );
            
            return $data;
        }
    }
    
    public function process_pic($path, $thums, $code)
    {   
  
        //Get File Data Info
        $uploads = array($this->upload->data());

        $syy = 0;        
        //Move Files To User Folder
        foreach($uploads as $key[] => $value)
        {
         if($syy == 0): list($width, $height, $type, $attr) = getimagesize($value['full_path']); endif;//sadece bi kere al performans
         $syy++;
         
        $newimagename = 'photo'.$value['file_ext'];    

            //Creat Thumbnail
            $config['image_library'] = 'GD2';
            $config['source_image'] = $value['full_path'];
            $config['create_thumb'] = TRUE;
            $config['master_dim'] = 'width';
            $config['quality'] = 90;
            $config['new_image'] = $newimagename;
          
            
            $totalthum = count($thums) - 1; //-1 array 0 dan basladigi icin
            
            for ($i = 0; $i <= $totalthum; $i++) {
                
                $config['maintain_ratio'] = $thums[$i]['ratio'];//boyuta göre otomatik mi width height alsin?
                
                $config['thumb_marker'] = $thums[$i]['name'];   
                
                $config['width'] = $thums[$i]['width'];
                $config['height'] = $thums[$i]['height'];
                //$this->image_lib->clear();
                if($thums[$i]['only_bigger'] == true and $thums[$i]['width'] > $width){//boyutu büyükse orjinal gibi kaydet
                    $oldfile = $value['full_path'];
                    $newfile = $path."photo".$thums[$i]['name'].$value['file_ext'];
                        copy($oldfile, $newfile);
                }else{

                    //smart image cropper
                    if ($thums[$i]['smart'] == TRUE) {   
                        // önce resize et                     
                        $config['maintain_ratio'] = TRUE;
                        $config['thumb_marker'] = $thums[$i]['name'] . "_original";   
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        
                        //resize edilmiş fotoğrafın adresini al
                        $photo_name = $value['file_path'] . 'photo' .  $thums[$i]['name'] . '_original'. $value['file_ext'];
                        $prop = $this->get_image_properties($photo_name);
                        // fotoğrafın ortasını bul
                        $xy = $this->get_smart_x_y($prop['width'], $prop['height'], $config['width'], $config['height']);
                        $config['source_image'] = $photo_name;
                        $config['maintain_ratio'] = FALSE;
                        $config['x_axis'] = $xy['x'];
                        $config['y_axis'] = $xy['y'];
                        $config['thumb_marker'] = $thums[$i]['name'];   
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->crop();  
                        // default ayarlara dön
                        $config['source_image'] = $value['full_path'];
                        $config['x_axis'] = 0;
                        $config['y_axis'] = 0;
                    } else {
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();                          
                    }
        
                }
            }
            
            //Move Uploaded Files with NEW Random name
            rename($value['full_path'], $path.$newimagename);
            
            //Make Some Variables for Database
            $fullname = $value['file_name'];
            $imagename = $value['raw_name'];
            $ext = $value['file_ext'];
            
           /* $filesize = $value['file_size'];
            $width = $value['image_width'];
            $height = $value['image_height'];
            $timestamp = time();
            */
            //bilgileri dondur
            
            $data = array(
                'fullname' => $fullname,
                'path' => $code,
                'ext' => $ext,
                'height' => $height,
                'width' => $width
            );
            
            return $data;

        }
    }
 
    
    public function set_photo_db($user_id, $site_id, $datas){
        //gelen dataları vt ye ekle
        foreach($datas as $data){
            $indata = array(
                'user_id' => $user_id,
                'site_id' => $site_id,
                'path' => $data['path'],
                'ext' => $data['ext'],
                'height' => $data['height'],
                'width' => $data['width']
            );
            $this->db->insert('pictures', $indata);
            return $this->db->insert_id();
        }
    }

    public function set_document_db($datas){
        //gelen dataları vt ye ekle
        foreach($datas as $data){
            $this->db->insert('files', $data);
            return $this->db->insert_id();
        }
    }
 

    public function get_smart_x_y($width, $height, $cropWidth, $cropHeight) {
        $centreX = round($width / 2);
        $centreY = round($height / 2);

        $cropWidthHalf  = round($cropWidth / 2); // could hard-code this but I'm keeping it flexible
        $cropHeightHalf = round($cropHeight / 2);

        $x1 = max(0, $centreX - $cropWidthHalf);
        $y1 = max(0, $centreY - $cropHeightHalf);

        $x2 = min($width, $centreX + $cropWidthHalf);
        $y2 = min($height, $centreY + $cropHeightHalf);  
        return array('x' => $x1, 'y' => $y1);      
    }   
    /**
     * Get image properties
     *
     * A helper function that gets info about the file
     *
     * @access    public
     * @param    string
     * @return    mixed
     */            
    function get_image_properties($path = '', $return = TRUE)
    {
        // For now we require GD but we should
        // find a way to determine this using IM or NetPBM
        
        if ($path == '')
            $path = $this->full_src_path;
                
        if ( ! file_exists($path))
        {
            $this->set_error('imglib_invalid_path');        
            return FALSE;                
        }
        
        $vals = @getimagesize($path);
        
        $types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');
        
        $mime = (isset($types[$vals['2']])) ? 'image/'.$types[$vals['2']] : 'image/jpg';
                
        if ($return == TRUE)
        {
            $v['width']            = $vals['0'];
            $v['height']        = $vals['1'];
            $v['image_type']    = $vals['2'];
            $v['size_str']        = $vals['3'];
            $v['mime_type']        = $mime;
            
            return $v;
        }
        
        $this->orig_width    = $vals['0'];
        $this->orig_height    = $vals['1'];
        $this->image_type    = $vals['2'];
        $this->size_str        = $vals['3'];
        $this->mime_type    = $mime;
        
        return TRUE;
    } 
}