<?php

class Forgot_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function add_to_db($email, $token){
        $checker = $this->_validate($email);//gercekten öyle birisi var mı?
        if($checker==false){
            return "noemail";
        }
        $count = 0;
        $time = time();
        $yesterday = $time - (24 * 60 * 60);
        $query = $this->db->get_where('forgot', array('email' => $email));
        $row = $query->row();
       //bir günde en fazla üç tane gönderebilir
        if($row){
            $count = $row->send_count;
            //eger bugün gönderilmişse
            if($row->send_date > $yesterday){
                //iki taneden fazla gönderilmişse
                if($count > 2){
                    return "timeerror";
                }
            }else{
                //artik timeout olmus olanlari sil
                $count = 0;
                $this->db->delete('forgot', array('email' => $email)); //dogrulama bölümünü sil
            }
        }
        
        if($count == 0){
            $this->db->insert('forgot', array('email' => $email, 'token' => $token, 'send_date' => $time, 'send_count' => 1));
        }else{
            $this->db->where('email', $email);            
            $this->db->update('forgot', array('email' => $email, 'token' => $token, 'send_count' => $count+1));
        }
        return "success";
    }
    
    public function change_password($email, $password){
        
        $this->db->delete('forgot', array('email' => $email)); //dogrulama bölümünü sil

        $this->db->where('email', $email);
        $this->db->update('users',array('password' => $password));
        return true;
    }
    
    public function check_token($token){
        $query = $this->db->get_where('forgot', array('token' => $token));
        $row = $query->row();
        $data = array();
        if($row){
            //en gec iki saatlik token olsun
            $twohour = time() - (2 * 60 * 60); 
            if($row->send_date > $twohour){
                $data['statu'] = "success";
                $data['email'] = $row->email;
            }else{
                $data['statu'] = "timeout";
            }
        }else{
            $data['statu'] = "denied";
        }
        
        return $data;
    }

    private function _validate($email){
        $query = $this->db->get_where('users', array('email' => $email));
        $row = $query->row();
        
        if($row){
            return true;
        }else{
            return false;
        }
    }
}