<?php

class Entries_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
         $this->load->helper('tr_karakter');
        
    }
    public function delete_comment($site_id, $comment_id){
       $this->db->limit(1);
       $query = $this->db->get_where('comments', array('comment_id' => $comment_id)); 
       $entry_id = $query->row()->entry_id;
       
       $query2 = $this->db->get_where('entries', array('entry_id' => $entry_id));       
       $check_site_id = $query2->row()->site_id;
       //güvenlik için site idleri karsilastir
       if($site_id != $check_site_id){
           return false;
       }
       
       //entries tablosunda yorum sayısını bir azalt
        $this->db->set('comment_count', 'comment_count-1',FALSE);
        $this->db->where_in('entry_id', $entry_id); // '1' test value here ?
        $this->db->update('entries'); 
        
        //yorumu sil
        $this->db->delete('comments', array('comment_id' => $comment_id));       
    }
    public function get_entries($page_id, $start = 0){
        $this->db->limit('5', $start);
        $this->db->order_by('entry_id', 'desc');
        $query = $this->db->get_where('entries', array('page_id' => $page_id));
        $result = $query->result();
        $data = array();
        foreach($result as $row){
            $entry_id = $row->entry_id;
            $title = $row->title;
                        
            $body = $row->body;         
            $body = $this->_read_more_short($body);
            
            $url = $row->url;
            $entry_date = $row->entry_date;
            $comment_count = $row->comment_count;
            
            $tags = $this->_get_tags($row->entry_id);
            $data[] = array('entry_id' => $entry_id,'title' => $title, 'body' => $body, 'url' => $url, 'entry_date' => $entry_date, 'comment_count' => $comment_count, 'tags' => $tags);
        }
        return $data;
    }
   //acilan yeni popupdaki entry bilgileri
    public function get_three_entry($site_id, $page_id, $entry_id){
        $data = array();
        $data['entry'] = $this->get_single_entry($entry_id, true);
        $data['comments'] = $this->get_comments($entry_id);
        
        $data['next'] = $this->_get_next_entry($site_id, $page_id, $entry_id);
        $data['prev'] = $this->_get_prev_entry($site_id, $page_id, $entry_id);
        return $data;
    }
    
    public function get_comments($entry_id){
        $this->db->order_by('comment_id', 'desc');
        $query = $this->db->get_where('comments', array('entry_id' => $entry_id));
        $result = $query->result();
        $data = array();
        
        foreach($result as $row){
            $comment_id = $row->comment_id;
            $comment = $row->comment;
            
            $name = $row->name;
            $email = $row->email;
            $website = $row->website;
            $comment_date = $row->comment_date;
            $data[] = array('comment_id' => $comment_id,'comment' => $comment, 'name' => $name, 'email' => $email, 'website' => $website, 'comment_date' => $comment_date);
        }  
        
        return $data;
    }
    
    private function _get_prev_entry($site_id, $page_id, $entry_id){
        $this->db->select('entry_id, title');
        $this->db->order_by('entry_id','asc');
        $this->db->limit(1);
        $query = $this->db->get_where('entries', array('entry_id >' => $entry_id));
        $row = $query->row();
        
        if($row){
            return $row;
        }       
        return "null";        
    }
    
    private function _get_next_entry($site_id, $page_id, $entry_id){
        $this->db->select('entry_id, title');
        $this->db->order_by('entry_id','desc');
        $this->db->limit(1);
        $query = $this->db->get_where('entries', array('entry_id <' => $entry_id));
        $row = $query->row();
        
        if($row){
            return $row;
        }       
        return "null";        
    }
  
    
    public function get_single_entry($entry_id, $full=true){
        $query = $this->db->get_where('entries', array('entry_id' => $entry_id));
        $row = $query->row();
            $entry_id = $row->entry_id;
            $title = $row->title;       
            $body = $row->body;
            
            if($full == false){
                $body = $this->_read_more_short($body);
                
            }
            $url = $row->url;
            $entry_date = $row->entry_date;
            $comment_count = $row->comment_count;
            
            $tags = $this->_get_tags($row->entry_id);
            $data = array('entry_id' => $entry_id,'title' => $title, 'body' => $body, 'url' => $url, 'entry_date' => $entry_date, 'comment_count' => $comment_count, 'tags' => $tags);
            return $data;
    }
    
    private function _read_more_short($str){
            $str = preg_split('/<hr(.*?)class=\"more\">/',$str); 
            $str = $str[0];        
            return $str;
    }
    
    private function _get_tags($entry_id){
        $this->db->select('*');
        $this->db->from('tags_relation');
        $this->db->where(array('entry_id' => $entry_id));
        $this->db->join('tags', 'tags_relation.tag_id = tags.tag_id');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function delete_entry($site_id, $entry_id){
        $tags = $this->_get_tags($entry_id);
        $delWhere = array('site_id' => $site_id, 'entry_id' => $entry_id);
        //önce tüm ilgili tagleri al
        foreach($tags as $tag){
            $count = $tag->tag_count;
            $tagId = $tag->tag_id;
            $here = array('site_id' => $site_id, 'tag_id' => $tagId);
            
            //tag sayisi 1 ise  tags den sil degilse 1 azalt
            if($count <= 1){
                $this->db->delete('tags', $here);
            }else{
                 $newCount = $count - 1;
                 $this->db->where($here);
                 $this->db->update('tags', array('tag_count' => $newCount));                   
            }
        }
        
        $this->db->delete('tags_relation', $delWhere);
        $res = $this->db->delete('entries', $delWhere);
        
        if($res == true){
            $this->db->delete('comments', array('entry_id' => $entry_id));
        }
        return true;
    }
    
    
    //düzenleme bölümü
    public function edit_entry($data){
        $site_id = $data['site_id'];
        $entry_id = $data['entry_id'];
        $page_id = $data['page_id'];
        
        $values['title'] = $data['title'];
        $values['body'] = $data['body'];
        
        if($data['tags']){
            $tags = $data['tags'];
        }else{
            $tags = null;
        }
        
        if($data['deltags']){
            $deltags = $data['deltags'];
        }else{
            $deltags = null;
        }
        
             $this->db->where(array('site_id' => $site_id, 'entry_id' => $entry_id));
             $this->db->update('entries', $values);                   
       //yeni etiketleri ekleme
       if($tags!=null){      
         foreach($tags as $tag){
             $this->_tag_create($site_id, $page_id, $entry_id, $tag);
         }
       }
       
      //eski etiketleri silme
     if($deltags!=null){      
 
       foreach($deltags as $dtag){
           $tag_url = tr_karakter($dtag); 
           
           $c_data = $this->_tag_count($tag_url, $site_id, $page_id);
           $tag_count = $c_data['tag_count'];
           $tag_id = $c_data['tag_id'];
           
           if($tag_count <= 1){//eger tek etiket varsa tamamen sil
               $this->db->delete('tags', array('site_id' => $site_id, 'tag_url' => $tag_url));
           }else{//baska ayni isimli etiket varsa sayisi azalt
                 $newCount = $tag_count - 1;
                 $this->db->where(array('site_id' => $site_id, 'tag_url' => $tag_url));
                 $this->db->update('tags', array('tag_count' => $newCount));                   
           }
           
            $this->db->delete('tags_relation', array('tag_id' => $tag_id));
       }
     }
    }
    
    //ekleme bölümü buradan baslar
    public function add_entry($values, $tags){
        $site_id = $values['site_id'];
        $page_id = $values['page_id'];
        $title = $values['title'];
        $values['url'] = $this->_uni_url($site_id, $title);
        
        $this->db->insert('entries', $values);
        $entry_id = $this->db->insert_id();
        
        if($tags){
            foreach($tags as $tag){
                $this->_tag_create($site_id, $page_id, $entry_id, $tag);
            }
        }
        return $entry_id;
    }
    
    
    private function _tag_create($site_id, $page_id, $entry_id, $tag){
         $tag_url = tr_karakter($tag); 

        $count = $this->_tag_count($tag_url, $site_id, $page_id);
       //eger daha önceden yaratılmamışsa olustur
       if($count == false){
        //türkçe karakterleri ve boşluklar vs. süzelim
         
           $this->db->insert('tags', array('tag_name' => $tag, 'site_id' => $site_id, 'page_id' => $page_id, 'tag_url' => $tag_url, 'tag_count' => '1'));
           $tag_id = $this->db->insert_id();
           $tag_count = 1;
           //daha önce yaratilmissa
       }else{          
          $tag_id = $count['tag_id'];
          $tag_count = $count['tag_count'];
          //oncekinden bir fazla oldu simdi
          $tag_count++;
          $this->db->where(array('tag_id' => $tag_id));
          $this->db->update('tags', array('tag_count' => $tag_count));
       }
       //ilgili tabloya isleyelim
       $this->db->insert('tags_relation', array('site_id' => $site_id, 'tag_id' => $tag_id, 'entry_id' => $entry_id));       
        
    }
    
    private function _tag_count($tag_url, $site_id, $page_id){

        $this->db->limit('1');
        $query = $this->db->get_where('tags', array('site_id' => $site_id, 'tag_url' => $tag_url, 'page_id' => $page_id));
        $row = $query->row();
        
        if($row){
            $data = array(
                'tag_id' => $row->tag_id,
                'tag_count' => $row->tag_count,
            );
            return $data; 
        }else{
            return false;
        }
    }

       private function _get_tag_id($site_id, $tag_url){

        $this->db->limit('1');
        $query = $this->db->get_where('tags', array('site_id' => $site_id, 'tag_url' => $tag_url));
        $row = $query->row();
        
        if($row){

            return $row->tag_id; 
        }else{
            return false;
        }
    } 
    private function _uni_url($site_id, $url){
        //türkçe karakterleri ve boşluklar vs. süzelim
         $url = tr_karakter($url);
            //eger sayfa varsa url , url-2 olsun deyuu
            $i = 2;
            $url_default = $url;
            $stopper = false;

            //hic ayni isme sahip olmayan bir sey bulana kadar zorla
            while (!$stopper) {
            $query = $this->db->get_where('entries', array('site_id' =>$site_id, 'url' => $url));
                if($query->num_rows() != 1){
                    $stopper = true;
                }else{
                    $url = $url_default.'-'.$i;
                    $i++;
                }
            }
        
            return $url;
    }    
}