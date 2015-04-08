<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Extensions extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();

            $this->load->model('manage/extensions_model');

              $this->lang->load('extensions', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli    
                        
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }
        
        public function set_ext(){            
             $site_id = $this->__get_site_id();

             $page_id = (int)$this->input->post('page_id');
             $ext_type = $this->input->post('ext_type', true);
             $prefix = $this->input->post('prefix', true);
             $ext_data = $this->extensions_model->set_ext($site_id, $page_id, $ext_type, $prefix);
             $statu = $ext_data['statu'];
            
             if($statu === true){  //eger isleme tamamsa devam           
                 $ext_id = $ext_data['ext_id'];
                 $extra_id = $ext_data['extra_id'];
                 $ext_js = $ext_data['ext_js'];
                 $callback = $ext_data['callback'];
                 
                 $data['ext_id'] = $ext_id;
                 $data['ext_title'] = $ext_data['ext_title'];
                 
                 $r_data = $this->extensions_model->call_extension($ext_type, $site_id, $extra_id, "admin");
                 
                 $data['ext_icon_class'] = $r_data['icon'];                 
                 $data['ext_html'] = $r_data['html'];
                 
                 $ext_viewer = $this->load->view('manage/ext_printer', $data, true);

                 $j_data = array('statu'=> true, 'ext_id' => $ext_id, 'ext_js' => $ext_js, 'callback' => $callback, 'html' => $ext_viewer);
             }else{//hata varsa
                $err = "<div class=\"error\">".$ext_data['str']."</div>";
                $j_data = array('statu' => false, 'err' => $err);  
             }
             
             echo json_encode($j_data);  
        }
        
        public function delete(){
            $site_id = $this->__get_site_id();

            $ext_id = $this->input->post('ext_id');
            
            $statu = $this->extensions_model->delete_ext($site_id, $ext_id);
            
          if($statu === true){
           $err = false;
           $html = "<div class=\"info\">".lang('succ_ext_delete')."</div>";
          }else{
           $err = true;
           $html = "<div class=\"error\">".$statu."</div>";
          }
          
            $j_data = array('error' => $err, 'html' => $html);            
            $data['str'] = json_encode($j_data);   
           $this->load->view('print_view', $data);
        }
}
