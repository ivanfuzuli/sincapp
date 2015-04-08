<?php

class Blog_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }

    /**
     *  Save new post to Sincapp Blog
     *  @param array $data
     *  @return true
     */
    public function save($data) {
    	$this->db->insert('sincapp_posts', $data);
    	return true;

    }

    /**
     * Delete Sincapp Blog Post
     * @param int $id
     * @return true
     */
    public function delete($id) {
    	$this->db->where('id', $id);
    	$this->db->delete('sincapp_posts');
    	return true;
    }

    /**
     * Getter for count of all posts
     * @return int
     */
    public function get_blog_count(){
        $query = $this->db->get('sincapp_posts');    
        return $query->num_rows();
    }

    /**
     * Getter for next post id
     * @return int|bool
     */
    public function next($id) {
    	$query = $this->db->get_where('sincapp_posts', array('id >' => $id), 1, 0);
    	$row = $query->row();

    	if ($row) {
    		return $row->id;
    	} else {
    		return false;
    	}
    }

    /**
     * Getter for previous post id
     * @return int|bool
     */
    public function prev($id) {
    	$query = $this->db->get_where('sincapp_posts', array('id <' => $id), 1, 0);
    	$row = $query->row();

    	if ($row) {
    		return $row->id;
    	} else {
    		return false;
    	}
    }

    /**
    * Getter for blog posts
    * @param int $limit
    * @param int $where
    * @return object array
    */
    public function get_posts($limit, $where){
        $this->db->limit($limit, $where);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('sincapp_posts');
        $result = $query->result();
        $data = array();

        foreach($result as $row) {
        	$data[] = $this->_row_to_array($row);
        }
        return $data;
    }

    public function get_single_post($id) {
    	$this->db->where('id', $id);
    	$query = $this->db->get('sincapp_posts');
    	$row = $query->row();
    	return $this->_row_to_array($row);
    }

    private function _row_to_array($row) {
    	$timestamp = strtotime($row->created_at);

		$aylar = array(
			1 => "Ocak",
			2 => "Şubat",
			3 => "Mart",
			4 => "Nisan",
			5 => "Mayıs",
			6 => "Haziran",
			7 => "Temmuz",
			8 => "Ağustos",
			9 => "Eylül",
			10 => "Ekim",
			11 => "Kasım",
			12 =>"Aralık"
		);

		$data =  array(
        		'id' => $row->id,
        		'title' => $row->title,
        		'body' => $row->body,
        		'photo_path' => $row->photo_path,
        		'photo_ext' => $row->photo_ext,
        		'day' => date('d', $timestamp),
        		'month' => $aylar[date('n', $timestamp)],
        		'year' => date('Y', $timestamp)
        		);
		return $data;
    }
}