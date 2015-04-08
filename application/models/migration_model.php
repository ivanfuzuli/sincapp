<?php
class Migration_model extends CI_Model {
	public $from_site_id = null;
	public $to_site_id = null;


	/**
	* Setter for from site id
	* @param int $id
	* @return object
	*/
	public function set_from_site_id_from_theme_id($theme_id) {
		$query = $this->db->get_where('themes', array('theme_id' => $theme_id));
		$row = $query->row();

		$this->from_site_id = $row->base_site_id;
		return $this;
	}

	/**
	* Setter for to site id
	* @param int $id
	* @return object
	*/

	public function set_to_site_id($id) {
		$this->to_site_id = $id;
		return $this;
	}

	/**
	* Copy Entire site to another site
	*/
	public function migrate() {
		/**
		* @var int $from_site_id
		* @var int $to_site_id
		* @var object $result -> page
		*/
		$from_site_id = $this->from_site_id;
		$to_site_id  = $this->to_site_id;

		if (!$from_site_id || !$to_site_id) {
			return false;
		}

        $this->db->order_by('sort');
        $query = $this->db->get_where('pages', array('site_id' => $from_site_id));
        $result = $query->result();

        foreach($result as $row) {
        	// Sayfaları kaydet
	        $this->db->insert('pages', array('site_id' => $to_site_id, 'title' => $row->title, 'url' => $row->url, 'sort' => $row->sort));
       		$to_page_id = $this->db->insert_id();
       		// Gridleri kaydet
       		$this->_set_grids($row->page_id, $to_page_id);
        }

        return true;
	}

	/**
	* Save new site's cover photo
	* @return bool
	*/
	public function set_cover_photo()
	{
		$query = $this->db->get_where('settings', array('site_id' => $this->from_site_id));
		$row = $query->row();
        $this->db->where('site_id', $this->to_site_id);
        $this->db->update('settings', array('cover_photo' => $row->cover_photo));
        return true;
	}

	private function _set_grids($from_page_id, $to_page_id) {
		$query = $this->db->get_where('grids', array('site_id' => $this->from_site_id, 'page_id' => $from_page_id));
		$result = $query->result();
		foreach($result as $row) {
        	$this->db->insert('grids', array('site_id' => $this->to_site_id, 'page_id' => $to_page_id, 'parent_sort' => $row->parent_sort, 'width' => $row->width, 'sort' => $row->sort));
        	$grid_id = $this->db->insert_id();
        	$this->_set_extensions($row->grid_id, $grid_id, $to_page_id);
		}
	}

	private function _set_extensions($from_grid_id, $to_grid_id, $to_page_id) {
		$query = $this->db->get_where('extensions', array('site_id' => $this->from_site_id, 'grid_id' => $from_grid_id));
		$result = $query->result();
		foreach($result as $row) {
			switch ($row->ext_name) {
				case 'paragraphs':
					$ext = $this->_set_paragraph($row->extra_id);
					break;
				case 'maps':
					$ext = $this->_set_maps($row->extra_id);
					break;
				case 'forms':
					$ext = $this->_set_forms($row->extra_id);
					break;
				default:
					$ext = null;
					break;
			}

			if($ext) {
				$this->db->insert('extensions', array('site_id' => $this->to_site_id, 'page_id' => $to_page_id, 'grid_id' => $to_grid_id, 'ext_name' => $ext['name'], 'extra_id' => $ext['id'], 'sort' => $row->sort));
			}
		}
	}

	private function _set_paragraph($paragraph_id)
	{
		$query = $this->db->get_where('paragraphs', array('paragraph_id' => $paragraph_id));
        $row = $query->row();
        $this->db->insert('paragraphs', 
        		array(
	        		'site_id' => $this->to_site_id, 
	        		'content' => $row->content
        		)
        	);
        $paragraph_id = $this->db->insert_id();

        return array(
        		'id' => $paragraph_id,
        		'name' => 'paragraphs'
        	);
	}

	private function _set_maps($map_id)
	{
		$query = $this->db->get_where('maps', array('map_id' => $map_id));
		$row = $query->row();

        $this->db->insert('maps', 
        		array(
	        		'site_id' => $this->to_site_id, 
	        		'map_title' => $row->map_title,
	        		'latitude' => $row->latitude,
	        		'longitude' => $row->longitude,
	        		'zoom' => $row->zoom
        		)
        	);
        $map_id = $this->db->insert_id();

        return array(
        		'id' => $map_id,
        		'name' => 'maps'
        	);
	}	

	private function _set_forms($form_id)
	{
		$this->load->library('forms');
		$data = $this->forms->create($this->to_site_id, 0);
		return array(
			'id' => $data['str'],
			'name' => 'forms'
			);
	}
}
