<?php

class Blog_model extends CI_Model {
    private $user_id;
    private $site_id;
    private $prefix;

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
    * Setter for prefix
    * @param int $prefix
    */
    public function set_prefix($prefix) {
        if($prefix == "") {
            $prefix = null;
        }
    	$this->prefix = $prefix;

        return $this;
    }

    /**
     * Getter for site_id
     * @return int
     */
    private function _get_site_id() {
        if (!$this->site_id) die('Site id required!! in blog model');
        return $this->site_id;
    }

    /**
     * Getter for prefix
     */
    private function _get_prefix() {
        return $this->prefix;
    }

    /**
     * Add new blog
     * @param string $name
     * @return int last insert id
     */
    public function add($name) {
        $site_id = $this->_get_site_id();
        $prefix = $this->_get_prefix();
        $data = array(
            'site_id' => $site_id,
            'name' => $name,
            'prefix' => $prefix
        );
        $this->db->insert('blogs', $data);
        return $this->db->insert_id();
    }

    public function is_exist($blog_id) {
        $query = $this->db->get_where('blogs', array('id' => $blog_id), 1, 0);
        if($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /**
     * Remove Blog
     * @param int $blog_id
     * @return int
     */
    public function remove($blog_id) {
        $site_id = $this->_get_site_id();
        $this->db->where(array('site_id' => $site_id, 'id' => $blog_id));
        $this->db->delete('blogs');
        return true;
    }

    /**
     * IS BLOG DEFAULT?
     * @param int $blog_id
     * @return bool
     */
    public function is_default($blog_id) {
        $query = $this->db->get_where('blogs', array('id' => $blog_id, 'is_default' => TRUE), 1,0);
        if( $query->num_rows() > 0 ){
            return TRUE; 
        } else { 
            return FALSE; 
        }
    }

    public function delete_all_posts($blog_id) {
        $site_id = $this->_get_site_id();
        $this->db->where(array('site_id' => $site_id, 'blog_id' => $blog_id));
        $this->db->delete('posts');

        return true;
    }

    public function get_blog($id) {
        $site_id = $this->_get_site_id();
        $query = $this->db->get_where('blogs', array('site_id' => $site_id, 'id' => $id), 1,0);
        $row = $query->row();
        if($row) {
            return $row;
        } else {
            return false;
        }
    }

    public function get_blogs_for_dropdown() {
        $site_id = $this->_get_site_id();
        $prefix = $this->_get_prefix();
        $this->db->select('id, name');
        $query = $this->db->get_where('blogs', array('site_id' => $site_id, 'prefix' => $prefix));
        $result = $query->result();
        $data = array();
        if ($result) {
            foreach($result as $row) {
                $data[$row->id] = $row->name;
            }
        }
        return $data;
    }    
    /**
    * Create new blog, blog cloud and first post
    * @param int $site_id
    * @param int $page_id
    */
    public function create_if_dont_exists() {
    	if(!$this->is_default_exists()) {
    		$this->create_default_blog();
    	};
    }

    /**
    * Checker for default blog existing
    * @param int $site_id
    * @return bool
    */
    public function is_default_exists() {
    $site_id = $this->_get_site_id();
    $prefix = $this->_get_prefix();

	$this->db->where(array('site_id' => $site_id, 'prefix' => $prefix));
	$query = $this->db->get('blogs');
		if( $query->num_rows() > 0 ){
		 	return TRUE; 
		} else { 
			return FALSE; 
		}
    }

    public function get_blog_prefix($blog_id) {
        $this->db->select('prefix');
        $query = $this->db->get_where('blogs', array('id' => $blog_id));
        $row = $query->row();
        if($query->row()) {
            return $row->prefix;
        } else {
            return null;
        }
    }
    /**
     * Setter for default blog
     * @param int $site_id
     * @return bool
     */
    public function create_default_blog() {
        $site_id = $this->_get_site_id();
        $prefix = $this->_get_prefix();
    	$data = array(
    		'site_id' => $site_id,
            'prefix' => $prefix,
    		'name' => 'Varsayılan Blog',
    		'is_default' => true
    		);
    	$this->db->insert('blogs', $data);
    	return true;
    }

    public function photo($blog_id, $pic_ids){
        $site_id = $this->_get_site_id();
        $this->load->library('resize');
        //ilk once kac tane var onlari alalim
        $this->db->limit(1);
        $this->db->order_by('sub_id', 'desc');
        $this->db->select('sub_id');
        $this->db->where(array('site_id' => $site_id, 'blog_id' => $blog_id));
        $query = $this->db->get('blog_pics');
        $row = $query->row();
        if($row){
            $sub_id = (int)$row->sub_id;
        }else{//yoksa sifirdan basla
            $sub_id = 0;
        }
        
        $p_data = array();
        //yeni eklenenleri db ye isleyelim
        foreach($pic_ids as $pic_id){
           $sub_id++; 
           $data = array(
               'site_id' => $site_id,
               'blog_id' => $blog_id,
               'pic_id' => $pic_id,
               'sub_id' => $sub_id
           );
           
           $this->db->insert('blog_pics', $data);
           $blog_pic_id = $this->db->insert_id();
           
           $thumb = '_blog_'.$blog_id . '_'. $sub_id . '_' .$blog_pic_id;
           
            $config = array(
                'site_id' => $site_id,
                'pic_id' => $pic_id,
                'path' => $thumb,
                'width' => 200
            );
            
           $r_data = $this->resize->resize_pic($config);//boyutlandir
           //array'e yig
           $p_data['photos'][] = array(
               'blog_pic_id' => $blog_pic_id, 
               'path'=> CDN.'photos/'.$site_id.'/'.$r_data['path'].'/photo'.$thumb.$r_data['ext'],//yolu
               'ratio' => $r_data['ratio']//oran
               );
        }
        
        return $p_data;
    }  

    public function resize($blog_pic_id, $width){
        $site_id = $this->_get_site_id();
        $this->db->select('id, blog_id, sub_id, pic_id');
        $query = $this->db->get_where('blog_pics', array('site_id' => $site_id, 'id' => $blog_pic_id));
        $row = $query->row();

        if($row){
            $this->load->library('resize');
            $thumb = '_blog_'.$row->blog_id.'_'.$row->sub_id.'_'.$row->id;
            $config = array(
                'site_id' => $site_id,
                'pic_id' => $row->pic_id,
                'path' => $thumb,
                'width' => $width
            );
           $r_data = $this->resize->resize_pic($config);//boyutlandir   
        }
    }      
}