<?php

class Form_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function send($inputs){
        $data = array();
        $i = 0;
            foreach($inputs as $key => $input){

            // if it isn't captcha
            if($key != 'phrase'){  
               $id = explode('_', $key);
               $id = $id[1];
               $label = $this->_get_label($id);

               //güvenlik kodunu dışarı at             
                   $data[] = array('label' => $label, 'value' => $input);
                   
                   if($i == 0){//tek bir seferlik form_cloud bilgilerini al
                       $info = $this->_get_cloud($id);
                   } 
            }           
               $i++;
            }
            
            $email = $info->email;
            $subject = $info->subject;
            $success = $info->str_send;
            
            $message = $this->_input_to_str($data);
            
            $this->_send_email($email, $subject, $message);
            return $success;
    }
    
    private function _send_email($email, $subject, $message){
        $this->load->library('email');
        
        $this->email->set_newline("\r\n"); 
        $this->email->from('noreply@sincapp.com', 'Sincapp');
        $this->email->to($email); 

        $this->email->subject($subject);
        $this->email->message($message);	

        $this->email->send();
        
    }
    
    private function _get_label($field_id){
        $this->db->limit(1);
        $query = $this->db->get_where('forms', array('form_id' => $field_id));
        $row = $query->row();
        
        return $row->label;
    }
    
    private function _get_cloud($field_id){
        $this->db->limit(1);
        $this->db->select('form_cloud_id');
        
        $query = $this->db->get_where('forms', array('form_id' => $field_id));
        $row = $query->row();
        $form_cloud_id = $row->form_cloud_id;
        
        $this->db->limit(1);
        $this->db->select('email, subject, str_send');
        $query2 = $this->db->get_where('form_cloud', array('form_cloud_id' => $form_cloud_id));
        $row2 = $query2->row();
        
        return $row2;
    }
    
    private function _input_to_str($arr){
        $str = "<table border=\"0\">";
        foreach($arr as $input){
            $str .= "<tr>";
            $str .= "<td><strong>".$input['label']."</strong></td>\n";
            $str .= "<td>".$input['value']."</td>\n";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }
    
}