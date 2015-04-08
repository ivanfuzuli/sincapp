<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('extensions/menu_model');
     
    }
    
    function index($site_id, $extra_id, $mode){
         $str['mode'] = $mode;
         $str['ajax'] = false;
         $str['menu_id'] = (int)$extra_id;
         $str['pages'] = $this->CI->menu_model->get_pages($site_id, (int)$extra_id);
         
         $data = array();
         $data['icon'] = 'edit_icon menuEditBut';
         $data['html'] = $this->CI->load->view('extensions/menu_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id, $prefix = null){
       $result =  $this->CI->db->insert('menus', array('site_id' => $site_id, 'cnt' => 1));
       
       if($result == TRUE){
            $id = $this->CI->db->insert_id();
            $this->_create_first_menu_element($site_id, $id, $page_id);
       }else{
           $id = FALSE;
       }

       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        $data['callback'] = "menus.firstRun($id)";
        
       return $data;        
    }
    
    public function delete($site_id, $menu_id){
        $this->CI->menu_model->remove($site_id, $menu_id);
        return true;
    }
    
    private function _create_first_menu_element($site_id, $id, $page_id) {
        $this->CI->db->insert('menu_pages', array('site_id' => $site_id, 'menu_id' => $id, 'page_id' => $page_id, 'sort' => 1));
    }


}