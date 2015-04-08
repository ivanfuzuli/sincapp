<?php

class Posts_model extends CI_Model {
    private $user_id = false;
    private $site_id = false;
    private $blog_id = false;
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();        
    }

    /**
    * Setter for site_id
    * @param int $site_id
    */
    public function set_site_id($site_id) {
    	$this->site_id = $site_id;
        return $this;
    }

    /**
    * Setter for blog_id
    * @param int $blog_id
    */
    public function set_blog_id($blog_id) {
    	$this->blog_id = $blog_id;
        return $this;
    }

    /**
     * Getter for site_id
     * @return int
     */
    private function _get_site_id() {
        return $this->site_id;
    }

    /**
     * Getter for prefix
     */
    private function _get_blog_id() {
        return $this->blog_id;
    }

    /**
     * Post a post
     * @param string $title
     * @param string $content
     * @param int $author
     */
    public function post($title, $content, $author) {
        $site_id = $this->_get_site_id();
        $blog_id = $this->_get_blog_id();

        $data = array(
                'slug' => $this->_uni_url($title),
                'site_id' => $site_id,
                'blog_id' => $blog_id,
                'author' => $author,
                'post_date' => date("Y-m-d H:i:s"),
                'post_date_gmt' => gmdate("Y-m-d H:i:s"),
                'title' => $title,
                'content' => $content,
                'status' => 'published',
                'comment_status' => 'open',
                'modified' => date("Y-m-d H:i:s"),
                'modified_gmt' => gmdate("Y-m-d H:i:s"),
                'comment_count' => 0,
                'ping_status' => false
            );
        $this->db->insert('posts', $data);
        return true;
    }

     /* Update post
     * @param string $title
     * @param string $content
     * @param int $author
     */
    public function update($post_id, $title, $content, $author) {
        $site_id = $this->_get_site_id();
        $blog_id = $this->_get_blog_id();

        $data = array(
                'author' => $author,
                'title' => $title,
                'content' => $content,
                'modified' => date("Y-m-d H:i:s"),
                'modified_gmt' => gmdate("Y-m-d H:i:s")
            );
        $this->db->where(array('site_id' => $site_id, 'id' => $post_id));
        $this->db->update('posts', $data);
        return true;
    }

    /**
     * delete post
     * @param int $post_id
     * @return bool
     */
    public function delete($post_id) {
        $site_id = $this->_get_site_id();
        $this->db->delete('posts', array('site_id' => $site_id, 'id' => $post_id));
        return true;
    }

    public function get_single_post($post_id, $no_read_more = true) {
        $site_id = $this->_get_site_id();
        $query = $this->db->get_where('posts', array('site_id' => $site_id, 'id' => $post_id), 1, 0);
        $row = $query->row();
        if($row) {
            if($no_read_more) {
                $content = preg_replace('/<p><img class="read_more" (.*)\/><\/p>/', '', $row->content);
                $content = preg_replace('/<img class="read_more" (.*)\/>/', '', $row->content);
            } else {
                $content = $row->content;
            }

            $obj = new stdClass();
            $obj->id = $row->id;
            $obj->title = $row->title;
            $obj->slug = $row->slug;
            $obj->content = $content;
            $obj->post_date = $row->post_date;
            return $obj;
        } else {
            return false;
        };
    }

    public function get_post_by_slug($slug) {
        $slug = str_replace(".html", "", $slug);//.html'i sil
        $site_id = $this->_get_site_id();
        $query = $this->db->get_where('posts', array('site_id' => $site_id, 'slug' => $slug), 1, 0);
        $row = $query->row();
        if($row) {
            return $row;
        } else {
            return false;
        }
    }
    /*
     * Benzersiz url olusturma
     */
    private function _uni_url($url){
        $site_id = $this->_get_site_id();
        //türkçe karakterleri ve boşluklar vs. süzelim
         $this->load->helper('tr_karakter');
         $url = tr_karakter($url);
            //eger sayfa varsa url , url-2 olsun deyuu
            $i = 2;
            $url_default = $url;
            $stopper = false;

            //hic ayni isme sahip olmayan bir sey bulana kadar zorla
            while (!$stopper) {
            $query = $this->db->get_where('posts', array('site_id' =>$site_id, 'slug' => $url));
                if($query->num_rows() != 1){
                    $stopper = true;
                }else{
                    $url = $url_default.'-'.$i;
                    $i++;
                }
            }
        
            return $url;
    }

    /**
     * Getter for posts
     * @return object|bool
     */
    public function get_posts($limit, $page) {
        $page = $page * $limit;        
        $blog_id = $this->_get_blog_id();
        $this->db->order_by('id', 'desc'); 
        $this->db->limit($limit, $page);
        if($this->site_id) {
            $list['site_id'] = $this->site_id;
        }
        $list['blog_id'] = $blog_id; 
        $query = $this->db->get_where('posts', $list);
        $result = $query->result();

        if($result) {
            $data = array();
            foreach ($result as $row) {
                $content = explode('<img class="read_more"', $row->content);
                if (count($content) > 1) {
                    $read_more = true;
                    $post_content = $content[0];
                } else {
                    $read_more = false;
                    $post_content = $row->content;
                }
                
                $obj = new stdClass();
                $obj->slug = $row->slug;
                $obj->id = $row->id;
                $obj->title = $row->title;
                $obj->post_date = $row->post_date;
                $obj->content = $post_content;
                $obj->read_more = $read_more;
                $data[] = $obj;
            }
            return $data;
        } else {
            return false;
        }
    }

    public function get_posts_count(){
         $blog_id = $this->_get_blog_id();

         $this->db->select('id');
         $this->db->where('blog_id', $blog_id);
         
         $query = $this->db->get('posts');
         $total = $query->num_rows();
         if($total == 0){
             return false;
         }else{
             return $total;
         }         
    }

}