<?php

class Forms_model extends CI_Model {
    var $user_id;
    var $site_id;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
        
    }
    
    public function get_fields($site_id, $form_cloud_id){
        $this->db->order_by('sort');
        $query = $this->db->get_where('forms', array('site_id' => $site_id, 'form_cloud_id' => $form_cloud_id));
        $result = $query->result();
        
        return $result;        
    }
    
    public function get_settings($site_id, $form_cloud_id){
        $query = $this->db->get_where('form_cloud', array('site_id' => $site_id, 'form_cloud_id' => $form_cloud_id));
        $row = $query->row();
        
        return $row;
    }
    
    public function update($site_id, $form_cloud_id, $field_ids, $statu, $label, $required, $set_data){
        $this->site_id = $site_id;
        
        $this->_update_set($form_cloud_id, $set_data);
        
        $i = 0;        
        foreach($field_ids as $id){

            switch ($statu[$i]){
                case "update":
                    $data = array('sort'=> $i, 'label' => $label[$i], 'required' => $required[$i]);

                    $this->_update_db($id, $data);//veritabanına isle                    
                    break;
                case "delete":
                    $this->_delete_db($id);
                    break;
                
                case "input":
                        $data = array('site_id' => $site_id, 'form_cloud_id' => $form_cloud_id, 'sort'=> $i, 'label' => $label[$i], 'type' => 'input', 'required' => (int)$required[$i]);      
                        $this->_insert_db($data);
                    break;
                case "textarea":
                        $data = array('site_id' => $site_id, 'form_cloud_id' => $form_cloud_id, 'sort'=> $i, 'label' => $label[$i], 'type' => 'textarea', 'required' => (int)$required[$i]);      
                        $this->_insert_db($data);
                    break;
                default:
                
                    break;
                
            }

            $i++;
        }
        
        return true;
    }
    
    private function _update_set($form_id, $data){//ayarlari kaydetmece
        $site_id = $this->site_id;
        
        $this->db->where(array('site_id'=>$site_id, 'form_cloud_id' => $form_id));
        $this->db->update('form_cloud', $data);          
        
    }
    private function _update_db($field_id, $data){
        $site_id = $this->site_id;
        
        $this->db->where(array('site_id'=>$site_id, 'form_id' => $field_id));
        $this->db->update('forms', $data);  
    }
    
    private function _delete_db($field_id){
        $site_id = $this->site_id;        
        
        $this->db->where(array('site_id'=>$site_id, 'form_id' => $field_id));
        $this->db->delete('forms');
    }
    
    private function _insert_db($data){
        $this->db->insert('forms', $data);
    }
}