<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Admin_Controller {
        private $error = false;

        public function __construct() {
            parent::__construct();
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('kokpit/blog_model');

        }
        private function _set_error($error){
            $this->error = $error;
        }
        
        private function _get_error(){
            return $this->error;
        }

        public function index($page = 0){
            $this->load->helper('time_converter');
            //sayfalama basla
            $limit = 10;
            $this->load->library('pagination');
                $config['uri_segment'] = 4;
                $config['base_url'] = base_url().'kokpit/blog/index/';
                $config['total_rows'] = $this->blog_model->get_blog_count();
                $config['per_page'] = $limit;

                $config['cur_tag_open'] = '<li class="active"><a href="#">';
                $config['cur_tag_close'] = '</a></li>';

                $config['next_tag_open'] = '<li>';
                $config['next_tag_close'] = '</li>';

                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '<li>';

                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';


            $this->pagination->initialize($config);
            $data['pages'] = $this->pagination->create_links();
            //sayfalama bitti
            $data['posts']  = $this->blog_model->get_posts($limit, $page);

            $p_data['middle']  = $this->load->view('kokpit/blog_view', $data, true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();

            $this->load->view('kokpit/index_view', $p_data);
        }

        public function post() {
            $data = array();
            $data['title'] = $this->input->post('title');
            $data['photo_path'] = $this->input->post('photo_path');
            $data['photo_ext'] = $this->input->post('photo_ext');
            $data['body'] = $this->input->post('post');
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->blog_model->save($data);
            redirect('kokpit/blog');
        }

        public function delete($id) {
            $this->blog_model->delete($id);
            redirect('kokpit/blog');
        }

        public function create(){
            $path = './files/photos/sincapp/blog/';

            //olusturulacak thumb'in ismi ve boytlari
            $thums = array(
                    array('ratio' => false,'name' => '_670', 'height' => 377, 'width' => 670, 'only_bigger' => false, 'smart' => false),
                    array('ratio' => false,'name' => '_430', 'height' => 176, 'width' => 430, 'only_bigger' => false, 'smart' => false),
                );
            //imagename ve exti döndürdü
            $data = $this->process($thums, $path);
            
            //hata kontrol
            $errors = $this->_get_error();
            
            if($errors != false){
                $this->session->set_flashdata('error', $errors);
                redirect('kokpit/blog');
                return false;//islemi kes
            }
            
            //gelen datalari vtye isle
            $val['picPath'] = base_url()."files/photos/sincapp/blog/".$data[0]['path']."/photo_670".$data[0]['ext'];
            $val['photo_ext'] = $data[0]['ext'];
            $val['photo_path'] = $data[0]['path'];
            $this->create_view($val);
            
        }
        
        public function create_view($data) {
            $p_data['middle']  = $this->load->view('kokpit/blog_create_view', $data, true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();

            $this->load->view('kokpit/index_view', $p_data);            
        }
        private function process($thums, $path){
             $this->load->model('manage/upload_model');
   
        $config['allowed_types'] = 'gif|jpeg|jpg|png';
        $config['max_size']    = '2048'; //2 meg

        $this->load->library('upload');
        
        $data = array();
        
        foreach($_FILES as $key => $value)
        {
        //benzersiz klasör yaratalım ve kodu alalım
        $code = $this->_generate_dir($path);   
        $newPath = $path.$code.'/';
        
        $config['upload_path'] = $newPath;  
            if( $key == 'filename')
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
}
