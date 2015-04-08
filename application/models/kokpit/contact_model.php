<?php

class Contact_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function get_contact_count(){
        return $this->db->count_all('contacts');
    }
    
    public function get_contacts($limit, $where){
        $this->db->limit($limit, $where);
        $this->db->order_by('contact_id', 'desc');
        $query = $this->db->get('contacts');
        $result = $query->result();
       
        //okunmayanları okundu olarak isaretle
        $this->db->limit($limit, $where);
        $this->db->where('statu', 0);
        $this->db->update('contacts', array('statu' => 1));
        return $result;
    }

    //okunmadı yapp
    public function unread($id){
        $this->db->where('contact_id', $id);
        $this->db->update('contacts', array('statu' => 0));
        return true;
    }
    
    //sil
    public function delete($id){
        $this->db->where('contact_id', $id);
        $this->db->delete('contacts');
        return true;
    }
}