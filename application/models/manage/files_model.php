<?php

class Files_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    
    }

    /**
     * Getter for file
     * @param int $site_id
     * @param int $file_id
     * @return object|bool
    */
    public function get_file($site_id, $file_id) {
    	$query = $this->db->get_where('files', array('site_id' => $site_id, 'id' => $file_id), 1, 0);
    	$row = $query->row();
    	$obj = new stdClass();
    	if($row) {
    		$obj->id = $row->id;
    		$obj->path = CDN.'documents/'.$row->site_id.'/'.$row->path .'/'. $row->real_name;
    		$obj->ext = $row->ext;
    		$obj->name = $row->name;
            $obj->real_name = $row->real_name;
            $obj->file_size = $row->file_size;
    		return $obj;
    	} else {
    		return false;
    	}
    }

    /**
     * Get ALL files
     * @param int $site_id
     * @return object|bool
     */
    public function get_files($site_id) {
        $this->db->order_by('id', 'desc');
    	$query = $this->db->get_where('files', array('site_id' => $site_id));
    	$result = $query->result();
    	if(!$result) {
    		return false;
    	}

    	$data = array();
    	foreach($result as $row) {
    		$obj = new stdClass();
    		$obj->id = $row->id;
    		$obj->path = CDN.'documents/'.$row->site_id.'/'.$row->path .'/'. $row->real_name;
    		$obj->ext = $row->ext;
    		$obj->name = $row->name;
            $obj->real_name = $row->real_name;
            $obj->file_size = $row->file_size;
    		$data[] = $obj;
    	}

    	return $data;
    }

    public function remove($site_id, $file_id) {
        $site_id = (int)$site_id;
        
        $query = $this->db->get_where('files', array('site_id' => $site_id, 'id' => $file_id));
        $row = $query->row();
        $path = $row->path;
        $ext = $row->ext;
        
        $this->db->delete('files', array('site_id' => $site_id, 'id' => $file_id));
        $this->db->delete('documents', array('site_id' => $site_id, 'file_id' => $file_id));
        
        $dirPath = './files/documents/'.$site_id.'/'.$path.'/';
        
        $files = glob($dirPath . '*', GLOB_MARK);
        
        foreach ($files as $file) {
            unlink($file);
        }        
        rmdir($dirPath);        
    }


    /**
     * Rename document file
     * @param int $site_id
     * @param int $document_id
     * @param string $name
     * @return bool
     *
     */
    public function rename($site_id, $file_id, $name) {
        $this->db->where(array('site_id' => $site_id, 'id' => $file_id));
        $this->db->update('files', array('name' => $name));

        return true;
    }
}