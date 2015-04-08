<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paragraphs {

    var $CI;
    function __construct() {
        $this->CI =& get_instance();
        
        $this->CI->load->model('extensions/paragraphs_model');
              
        $this->CI->lang->load('paragraph', 'turkish');             
        $this->CI->load->helper('language');//lang kısaltması icin gerekli        
    }
    
    function index($site_id, $extra_id, $mode){
         $str['mode'] = $mode;
         $str['data'] = $this->CI->paragraphs_model->get_html($site_id, $extra_id);
         
         $data = array();
         $data['icon'] = false;
         $data['html'] = $this->CI->load->view('extensions/paragraph_view', $str, true);
         return $data;
    }
    
    public function create($site_id, $page_id, $prefix = null){
       $result =  $this->CI->db->insert('paragraphs', array('site_id' => $site_id,'content'=> null));
       
       if($result == TRUE){
            $id = $this->CI->db->insert_id();
       }else{
           $id = FALSE;
       }
       $data = array();
        $data['statu'] = true;
        $data['str'] = $id;
        $data['callback'] = "none";
       return $data;        
    }
    
    public function delete($site_id, $paragraph_id){
        $this->CI->db->delete('paragraphs', array('paragraph_id' => $paragraph_id));
        //copleri topla
        $this->CI->db->select('p_pics.pic_id, p_pics.paragraph_id, p_pics.sub_id, pictures.pic_id, pictures.site_id, pictures.path, pictures.ext');
        $this->CI->db->where('paragraph_id', $paragraph_id);
        $this->CI->db->join('pictures', 'p_pics.pic_id = pictures.pic_id');
        $query = $this->CI->db->get('p_pics');
        $result = $query->result();
        
        foreach($result as $row){
            $file = './files/photos/'.$row->site_id.'/'.$row->path.'/photo_prg_'.$row->paragraph_id.'_'.$row->sub_id.$row->ext;
        
            if(!unlink($file)){            
                //dosya yok ya da silinemedi
            };
        }
        return true;
    }
}