<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ErkanaAuth by Michael Wales
 */

class Auth {

    var $CI;
/*    PHP 5 i�in*/
    function __construct() {
        $this->CI =& get_instance();
        log_message('debug', 'Authorization class initialized.');
        
        $this->CI->load->database();
    }
   
// php 4 icin
/*
    function Auth() {
        $this->CI =& get_instance();
        log_message('debug', 'Authorization class initialized.');
		$this->CI->load->database();
    }

    function logged_in() {
        // Checks if the user is logged in.
        if ($this->CI->session->userdata('user_id')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }   
  */ 
    function try_login($condition = array()) {
        $this->CI->db->select('user_id');

        //for facebook login
        if ($condition['password'] == false) {
            $query = $this->CI->db->get_where('users', array('email' => $condition['email']), 1, 0);
        } else {
        //for regular login
            $query = $this->CI->db->get_where('users', array('email' => $condition['email'], 'password' => $condition['password']), 1, 0);
        }

        if ($query->num_rows != 1) {
            $this->increase_attempt($condition['email']);
            return FALSE;
        } else {
            $row = $query->row();
            //giris dogru hadi isle
            $this->logged($row->user_id, $condition['remember']);
            $this->reset_attempt($condition['email']);
            return TRUE;
        }
    }
    
    public function get_attempt_count($email) {
        $query = $this->CI->db->get_where('users', array('email' => $email), 1, 0);
        $row = $query->row();
        if($row) {
            return $row->attempt;
        } else {
            return 0;
        }
    }
    private function increase_attempt($email) {
        $query = $this->CI->db->get_where('users', array('email' => $email), 1, 0);
        $row = $query->row();
        $attempt = $row->attempt;
        if(!$attempt) {
            $attempt = 0;
        }
        $attempt++;

        $this->CI->db->where(array('email' => $email));
        $this->CI->db->update('users', array('attempt' => $attempt));
    }

    private function reset_attempt($email) {
        $this->CI->db->where(array('email' => $email));
        $this->CI->db->update('users', array('attempt' => 0));        
    }
    function remember_login($token){
        $query = $this->CI->db->get_where('users', array('remember' => $token), 1, 0);
            if ($query->num_rows == 1) {
                $row = $query->row();
                $this->logged($row->user_id, true);
            }
        }
    private function logged($user_id, $remem = false){
            $this->CI->session->set_userdata(array('user_id'=>$user_id));
            //girişi kaydet
            $data = array(
                    'user_id' => $user_id,
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'login_date' => date("Y-m-d H:i:s")
                );
            $this->CI->db->insert('logins', $data);

            //beni hatirla varsa
            if($remem == true){
                $this->CI->load->helper('cookie');
                $encr = $this->CI->config->item('encryption_key');
                $token = md5(microtime().$user_id.$encr);
                //60 gün sonra cerz iptal
                $expire = 86400*60;
               
                $this->CI->input->set_cookie('token', $token, $expire);
                
                //cerezler tamam simdi vtye yaz
                $this->CI->db->where('user_id', $user_id);
                $this->CI->db->update('users', array('remember' => $token));
            }      
        
    }
    
     function logout() {
        $this->CI->session->set_userdata(array('user_id'=>FALSE));
        $this->CI->load->helper('cookie');
        delete_cookie("token");
        
    }
    
/*
user i�in row �ekiyor. 
	$this->auth->get_user($this->session->userdata('user_id'))->username  
olarak da kullan�labilir.    
*/
    function get_user($id) {
        if ($id) {
            $query = $this->CI->db->get_where('users', array('users.user_id'=>$id), 1, 0);
            if ($query->num_rows() == 1) {
                $row = $query->row();
                //eger kullanıcı askıya alınmışssa
                if($row->statu == 1): return 'suspended'; endif;
                //yok normalse
                return $query->row();
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    function get_user_id(){
        return $this->CI->session->userdata('user_id');
    }
    
    function get_email(){
        $this->CI->db->select('email');
        $query = $this->CI->db->get_where('users', array('user_id' => $this->get_user_id()));
        $row = $query->row();
        return $row->email; 
    }
    
    //kulanıcının durumu admin mi bak bakiim
    public function get_statu(){
         $this->CI->db->select('statu');
        $query = $this->CI->db->get_where('users', array('user_id' => $this->get_user_id()));
        $row = $query->row();
        if(!$row): return false; endif;
        return $row->statu;        
    }
    
	function set_language($language)
	{
		$this->CI->session->set_userdata(array('lang'=>$language));
	}
	
//XXX dil belli deilse ingilizce oluyor.	
	function get_language()
	{
		if($this->CI->session->userdata('lang')) return $this->CI->session->userdata('lang');
		else return "en";
	}	
	
	function secure_password($email, $password)
	{
		$salt = sha1($password.$this->CI->config->item('encryption_key'));
		return sha1($salt.$email);
	}
}

?>