<?php if (!defined('BASEPATH')) exit('No direct access allowed.');

class Upload extends CI_Controller {
 var $site_id;
 var $user_id;
 
 private $error = false;
 
    function __construct() {
        parent::__construct();
       $this->load->model('manage/upload_model');
       
       $token = $this->input->post('token');
       
       //güvenlik için check et
       $checker = $this->upload_model->check_token($token);
       if($checker == false){
           $this->output->set_status_header('401');
           die('access denied.');
           
       }else{
         $this->site_id = $checker['site_id'];
         $this->user_id = $checker['user_id'];
       }
    }
        
    private function _get_site_id(){
        return $this->site_id;
    }
    
    private function _set_error($error){
        $this->error = $error;
    }
    
    private function _get_error(){
        return $this->error;
    }
    
    public function upload_document() {
        $this->load->helper('format_size_units');
        $this->load->model('packages_model');

        $site_id = $this->_get_site_id();
          $package_name = $this->packages_model->get_package_name_by_site_id($site_id);
          $storage = $this->packages_model->get_package($package_name)->storage;
          $used_storage = $this->packages_model->get_storage_quota($site_id);

          //MB TO KB
          if($storage * 1024 < $used_storage) {
                echo "storage_limit_error";
                return false;
          }

        $data = $this->process_document();
        //hata kontrol
        $errors = $this->_get_error();
            
        if($errors != false){
            $this->_error($errors);//hata varsa islemeye yolla
            return false;//islemi kes
        }

        //gelen datalari vtye isle
        $val['document_id'] = $this->upload_model->set_document_db($data);
        $val['name'] = $data[0]['name'];
        $val['ext'] = $data[0]['ext'];
        $val['file_size'] = $data[0]['file_size'];
        $val['selected'] = TRUE;
        $val['docPath'] = base_url()."files/documents/$site_id/".$data[0]['path']."/".$data[0]['real_name'].$data[0]['ext'];
        $val['statu'] = "active_doc"; //yükler yüklemez seçili olsun deyu
        $this->load->view('manage/single_file_view', $val);

    }

        public function doupload(){
        $this->load->helper('format_size_units');
        $this->load->model('packages_model');

            $site_id = $this->_get_site_id();
          $package_name = $this->packages_model->get_package_name_by_site_id($site_id);
          $storage = $this->packages_model->get_package($package_name)->storage;
          $used_storage = $this->packages_model->get_storage_quota($site_id);

          if($storage * 1024 < $used_storage) {
                echo "storage_limit_error";
                return false;
          }
            //olusturulacak thumb'in ismi ve boytlari
            $thums = array(
                    array('ratio' => false,'name' => '_100', 'height' => 75, 'width' => 100, 'only_bigger' => false, 'smart' => true),
                    array('ratio' => false,'name' => '_48', 'height' => 48, 'width' => 48, 'only_bigger' => false, 'smart' => false),
                    array('ratio' => true,'name' => '_800', 'height' => 1, 'width' => 800, 'only_bigger' => true, 'smart' => false),
                    array('ratio' => false,'name' => '_960', 'height' => 300, 'width' => 960, 'only_bigger' => false, 'smart' => true)
                );
            //imagename ve exti döndürdü
            $data = $this->process($thums);
            //hata kontrol
            $errors = $this->_get_error();
            
            if($errors != false){
                $this->_error($errors);//hata varsa islemeye yolla
                return false;//islemi kes
            }
            //gelen datalari vtye isle
           $val['pic_id'] = $this->upload_model->set_photo_db($this->user_id, $this->site_id, $data);
            $val['picPath'] = base_url()."files/photos/$site_id/".$data[0]['path']."/photo_100".$data[0]['ext'];
            $val['statu'] = "active_pic"; //yükler yüklemez seçili olsun deyu
            $this->load->view('manage/single_photo_view', $val);
            
        }

        private function process_document(){
    
        $site_id = $this->_get_site_id();
            $path = './files/documents/'.$site_id.'/';

        $config['allowed_types'] = 'txt|pdf|doc|docx|xls|odt|odp|ods|ppt';
        $config['max_size']    = '20240'; //2 meg

        $this->load->library('upload');
        
        $data = array();
        
        foreach($_FILES as $key => $value)
        {
        //benzersiz klasör yaratalım ve kodu alalım
        $code = $this->_generate_dir($path);   
        $newPath = $path.$code.'/';
        
        $config['upload_path'] = $newPath;  
        
            if( $key == 'Filedata')
            {              
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload($key))
                {
                    $errors[] = $this->upload->display_errors();
                    $this->_set_error($errors);
                    return false;
                }    
                else
                {
                  $data[] =  $this->upload_model->process_document($site_id, $newPath, $code);
                }
             }else{
                 return false;
             }
        
        }
        
        return $data;

        }

        private function process($thums){
        $site_id = $this->_get_site_id();

        $path = './files/photos/'.$site_id.'/';

        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']    = '10240'; //10 meg

        $this->load->library('upload');
        
        $data = array();
        
        foreach($_FILES as $key => $value)
        {
        //benzersiz klasör yaratalım ve kodu alalım
        $code = $this->_generate_dir($path);   
        $newPath = $path.$code.'/';
        
        $config['upload_path'] = $newPath;  
        
            if( $key == 'Filedata')
            {              
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload($key))
                {
                    $errors[] = $this->upload->display_errors();
                    $this->_set_error($errors);
                    return false;
                }    
                else
                {
                  $data[] =  $this->upload_model->process_pic($newPath, $thums, $code);
                }
             }else{
                 return false;
             }
        
        }
        
        return $data;

        }
        
    //benzersiz isimli bir klasör yaratalım
    private function _generate_dir($path, $length = 10){
    
                if ($length <= 0)
                {
                    return false;
                }
            
                $code = "";
                $chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
                srand((double)microtime() * 1000000);
                for ($i = 0; $i < $length; $i++)
                {
                    $code = $code . substr($chars, rand() % strlen($chars), 1);
                }
                
                $newPath = $path.$code.'/';

                mkdir($newPath);
                chmod($newPath, 0777);         
                return $code;
            
    }
    
    private function _error($errors){
        $this->output->set_status_header('405');
        print_r($errors);
        echo $errors;
    }
}