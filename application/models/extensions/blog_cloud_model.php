<?php

class Blog_cloud_model extends CI_Model {
    private $user_id;
    private $site_id;
    private $page_id;
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
    * Setter for page_id
    * @param int $page_id
    */
    public function set_page_id($page_id) {
    	$this->page_id = $page_id;
        return $this;
    }

    /**
     * Setter for prefix
     */

    public function set_prefix($prefix) {
        if($prefix == "") $prefix = null;
        $this->prefix = $prefix;
        return $this;
    }
    /**
     * Getter for site_id
     * @return int
     */
    private function _get_site_id() {
        if (!$this->site_id) die('Site id required!! in blog cloud model');
        return $this->site_id;
    }

    /**
     * Getter for prefix
     */
    private function _get_page_id() {
        if(!$this->page_id) die('Page id required!! in blog cloud model');
        return $this->page_id;
    }

    /**
     * Getter for prefix
     */
    private function _get_prefix() {
        return $this->prefix;
    }

    /**
    *
    */
    public function delete($blog_cloud_id) {
        $site_id = $this->_get_site_id();
        $query = $this->db->get_where('blog_cloud', array('site_id' => $site_id, 'id' => $blog_cloud_id), 1,0);
        $row = $query->row();


        $this->db->where(array('site_id' => $site_id, 'id' => $blog_cloud_id));
        $this->db->delete('blog_cloud');

        if($row) {
            if($row->view_here == TRUE) {
                $this->db->limit(1);
                $this->db->where(array('site_id' => $site_id, 'blog_id' => $row->blog_id));
                $this->db->update('blog_cloud', array('view_here' => 1));
            }
        }
        return true;
    }
    /**
     * Create blog cloud
     * @return int
     */
    public function create() {
        $site_id = $this->_get_site_id();
        $page_id = $this->_get_page_id();
        $blog_id = $this->get_default_blog();
        $data = array(
                'site_id' => $site_id,
                'page_id' => $page_id,
                'blog_id' => $blog_id,
                'layout' => 'default',
                'limit_count' => 10,
                'pagination' => true,
                'view_here' => $this->is_view_herable($blog_id)
            );

        $this->db->insert('blog_cloud', $data);

        return $this->db->insert_id();
    }

    /**
     * Reset view here
     */
    public function reset_view_here($blog_id) {
        $site_id = $this->_get_site_id();
        $this->db->where(array('site_id' => $site_id, 'blog_id' => $blog_id, 'view_here' => TRUE));
        $this->db->update('blog_cloud', array('view_here' => FALSE));
        return true;
    }
    /**
     *  Getter for page id
     * @param int $blog_id
     * @return int|bool
     */
    public function get_page_id_by_blog_id($blog_id) {
        $site_id = $this->_get_site_id();
        $query = $this->db->get_where('blog_cloud', array('site_id' => $site_id, 'blog_id' => $blog_id, 'view_here' => true), 1, 0);
        $row = $query->row();
        if($row) {
            return $row->page_id;
        } else {
            return false;
        }
    }
    /**
     *  Getter for page id
     * @param int $blog_id
     * @return int|bool
     */
    public function get_page_id($blog_cloud_id) {
        $site_id = $this->_get_site_id();
        $query = $this->db->get_where('blog_cloud', array('site_id' => $site_id, 'id' => $blog_cloud_id), 1, 0);
        $row = $query->row();
        if($row) {
            return $row->page_id;
        } else {
            return false;
        }
    }

    /**
     * Update blog cloud table
     * @param int $blog_cloud_id
     * @param array $data
     * @return bool
     */
    public function update($blog_cloud_id, $data) {
        $site_id = $this->_get_site_id();
        $this->db->where(array('site_id' => $site_id, 'id' => $blog_cloud_id));
        $this->db->update('blog_cloud', $data);
        return true;
    }
    /**
     * Get true if view here doesn't exist
     * @param int $blog_id
     * @return bool
     */
    public function is_view_herable($blog_id) {
    $site_id = $this->_get_site_id();
    $prefix = $this->_get_prefix();
    $this->db->where(array('site_id' => $site_id, 'blog_id' => $blog_id, 'view_here' => true));
    $query = $this->db->get('blog_cloud');

        if($query->num_rows() > 0) {
            return false;
        }
        return true;
    }

    /**
     * Getter for default blog id
     * @return int
     */
    public function get_default_blog() {
        $prefix = $this->_get_prefix();
        $site_id = $this->_get_site_id();
        $this->db->select('id');
        $query = $this->db->get_where('blogs', array('prefix' => $prefix, 'site_id' => $site_id), 1, 0);
        $row = $query->row();

        if($row) {
            return $row->id;
        } else {
            return 0;
        }
    }

    /**
     * Getter for blog cloud
     * @param int $site_id
     * @param int $id
     * @return bool|object
     */
    public function get_cloud($id) {
        $site_id = $this->_get_site_id();

        $query = $this->db->get_where('blog_cloud', array('site_id' => $site_id, 'id' => $id), 1, 0);
        $row = $query->row();
        if($row) {
            return $row;
        } else {
            return false;
        }
    }
}