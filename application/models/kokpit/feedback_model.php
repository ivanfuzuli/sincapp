<?php

class Feedback_model extends CI_Model {
    private $cache = array();
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function set_message($sender_id, $to_id, $thread_id, $message){
        //eger konu yoksa olustur
        if($thread_id == 0){
            $idata = array(
              'sender_id' => $sender_id,
              'to_id'     => $to_id,
              'sender_read' => 1,
              'to_read' => 0,
              'active_date' => time()
            );
            $this->db->insert('threads', $idata);
            $thread_id = $this->db->insert_id();
            //eger konu varsa
        }else{
            $this->db->where('thread_id', $thread_id);
            $this->db->update('threads', array('to_read' => 0, 'active_date' => time()));
        }
        
       //mesajı isle 
        $this->_insert_message($thread_id, $sender_id, $message);//konu baslatan oldugu icin reply false
        
        return true;
    }
    
    private function _insert_message($thread_id, $user_id, $message){
        $data = array(
            'thread_id' => $thread_id,
            'user_id' => $user_id,
            'message' => $message,
            'send_date' => time()
        );
        $this->db->insert('messages', $data);        
    }
    
    public function reply($user_id, $thread_id, $message){
        //reply security
        $this->db->limit(1);
        $this->db->select('sender_id, to_id');
        $this->db->where(array('thread_id' => $thread_id, 'sender_id' => $user_id));
        $this->db->or_where(array('thread_id' => $thread_id, 'to_id' => $user_id));
        $query = $this->db->get('threads');
        $row = $query->row();
        
        //tabloda yoksa islemi kes
        if(!$row){
            return false;
        }
        
        //eger threadi baslatan ayniysa giden yeri okunmadi yap
        if($row->sender_id == $user_id){
            $sender_read = true;
            $to_read = false;
        }else{
            $sender_read = false;
            $to_read = true;
        }
        
        //threadi güncelle
        $this->db->where('thread_id', $thread_id);
        $this->db->update('threads', array('sender_read' => $sender_read, 'to_read' => $to_read, 'active_date' => time()));
        //simdi de isle
        $this->_insert_message($thread_id, $user_id, $message);
        return true;
    }
    
    public function get_message_count($user_id){
         $this->db->select('thread_id');
         $this->db->where('to_id', $user_id);
         $this->db->or_where('sender_id', $user_id);
         
         $query = $this->db->get('threads');
         $total = $query->num_rows();
         if($total == 0){
             return false;
         }else{
             return $total;
         }         
    }
    
    public function get_messages($user_id, $limit, $where){
        $this->db->order_by('active_date', 'desc');
        $this->db->limit($limit, $where);
        $this->db->where('to_id', $user_id);
        $this->db->or_where('sender_id', $user_id);
        $query = $this->db->get('threads');
        
        $data = array();
        $result = $query->result();
        //en son mesajlari al ve arraye yig
        foreach($result as $row){
            
            $this->db->limit(1);
            $this->db->select('messages.user_id, messages.message');
            $this->db->order_by('message_id', 'desc');
            $this->db->where(array('thread_id' => $row->thread_id));
            $query2 = $this->db->get('messages');
            $row2 = $query2->row();
            
            $message = $row2->message;
            //eger mesaj uzunsa kısalt
            if(strlen($message) > 50){
                $message = substr($message, 0, 50)."...";
            }
            if($user_id == $row->sender_id and $row->sender_read == true or $user_id == $row->to_id and $row->to_read == true){
                $read = true;
            }else{
                $read = false;
            }
            $data[] = array(
                'email' => $this->_get_email($row2->user_id), 
                'thread_id' => $row->thread_id, 
                'message' => $message,
                'read' => $read,
                'date' => $row->active_date
                );
        }
        return $data;
    }
    
    public function get_thread($user_id, $thread_id){
        //security
        $this->db->select('sender_id, to_id');
        $this->db->where(array('thread_id' => $thread_id, 'sender_id' => $user_id));
        $this->db->or_where(array('thread_id' => $thread_id, 'to_id' => $user_id));
        $query = $this->db->get('threads');  
        $row = $query->row();
        if(!$row){
            return false;
        }
        
        //okundu olarak isaretle
        $this->db->where('thread_id', $thread_id);
        if($row->sender_id == $user_id){
            $this->db->update('threads', array('sender_read' => true));
        }else{
            $this->db->update('threads', array('to_read' => true));            
        }
        
        //kayitlari dondur
        $this->db->select('messages.user_id, messages.message, messages.send_date');
        $this->db->where('thread_id', $thread_id);
        $query2 = $this->db->get('messages');
        $result2 = $query2->result();
        $data = array();
        foreach($result2 as $row2){
            $data[] = array(
                'email' => $this->_get_email($row2->user_id, $user_id),
                'message' => $row2->message,
                'send_date' => $row2->send_date
            );
        }

        return $data;
    }    
    
    private function _get_email($user_id){
        //bellekte varsa
        $cache = $this->cache;
        if(array_key_exists('u'.$user_id, $cache)){
            return $cache['u'.$user_id];
        }

        $this->db->limit(1);
        $this->db->select('email');
        $query = $this->db->get_where('users', array('user_id' => $user_id));
        $row = $query->row();
        if($row){
            $email = $row->email;
        }else{
            $email = 'Sincapp';
        }
        
        $this->cache['u'.$user_id] = $email;
        return $email;
    }
}

