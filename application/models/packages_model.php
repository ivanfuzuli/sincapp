<?php

class Packages_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
    * Getter for all email addres by site id
    * @param int $site_id
    * @return object
    */
    public function get_package($name) {
      $query = $this->db->get_where('packages', array('name' => $name));

      return $query->row();
    }

    public function get_package_by_domain($domain) {
        $query = $this->db->get_where('domains', array('domain' => $domain, 'status' => 0));

        $row = $query->row();
        if($row) {
            return $row->package;
        } else {
            return false;
        }
    }

    public function get_package_name_by_site_id($site_id) {
        $query = $this->db->get_where('domains', array('site_id' => $site_id, 'status' => 0));

        $row = $query->row();
        if($row) {
            return $row->package;
        } else {
            return 'free';
        }
    }

    public function get_storage_quota($site_id) {
        $total = 0;
        $f = './files/documents/'.$site_id.'/';
        $io = popen('/usr/bin/du -sk ' . $f, 'r');
        $size = fgets($io, 4096);
        $size = substr($size, 0, strpos($size, "\t"));
        pclose($io);

        $total += $size;
        $f = './files/photos/'.$site_id.'/';
        $io = popen('/usr/bin/du -sk ' . $f, 'r');
        $size = fgets($io, 4096);
        $size = substr($size, 0, strpos($size, "\t"));
        pclose($io);
        $total += $size;
        return $total;
    }
    public function is_premium($site_id) {
        $this->db->select('site_id');
        $query = $this->db->get_where('domains', array('site_id' => $site_id, 'status' => 0));

        $row = $query->row();
        if($row) {
            return true;
        } else {
            return false;
        }
    }
}
