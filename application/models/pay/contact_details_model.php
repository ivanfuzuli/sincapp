<?php

class Contact_details_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }
 
    /**
     * Save new domain contact details
     * @param int $user_id
     * @param array $data
     * @return bool 
     */
    public function save($user_id, $data){
        $data['user_id'] = $this->user_id;
        $this->db->insert('domain_contacts', $data);
        return true;
    }

    /**
    * Update domain contact details
    */
    public function update($user_id, $data){
        $this->db->where('user_id', $this->user_id);
        $this->db->update('domain_contacts', $data);
        return true;
    }

    /**
    * Update domain customer details
    */
    public function update_customer_id($user_id, $customer_id){
        $this->db->where('user_id', $user_id);
        $status = $this->db->update('domain_contacts', array('customer_id' => $customer_id));

        return true;
    }  

    /**
    * Update domain contact details
    */
    public function update_contact_id($user_id, $contact_id){
        $this->db->where('user_id', $user_id);
        $this->db->update('domain_contacts', array('contact_id' => $contact_id));
        return true;
    }  

    /**
     * Daha önce kurulmuş mu?
     * 
     * @return bool
     * 
     */
    public function get_contact($user_id){
        $this->db->where(array('user_id' => $user_id));
        $this->db->from('domain_contacts');
        
        $query = $this->db->get();
        $row = $query->row();
        if($row){
            return $row;
        }else{
            return false;
        }
    }

    public function get_contact_array($user_id) {
        $this->db->where(array('user_id' => $user_id));
        $this->db->from('domain_contacts');
        
        $query = $this->db->get();
        $row = $query->row();
        if($row){
            return array(
                'name' => $row->name,
                'phone' => $this->_trim_phone($row->phone),
                'email' => $row->email,
                'city' => $row->city,
                'zipcode' => $row->zipcode,
                'address' => $row->address,
                'customer_id' => $row->customer_id,
                'contact_id' => $row->contact_id
            );
        }else{
            return false;
        }        
    }
    

    private function _trim_phone($phone) {
        $search = array('(', ')', ' ', '-');
        $phone = str_replace($search, "", $phone);
        return $phone;
    }
    /**
     * Is user exits? 
     * @param int $user_id
     * @return bool
     */
    public function is_existing($user_id){
            $query = $this->db->get_where('domain_contacts', array('user_id' => $user_id));
            $check = $query->num_rows();
            if($check >= 1){
                return true;
            }
            return false;
    }
       
}