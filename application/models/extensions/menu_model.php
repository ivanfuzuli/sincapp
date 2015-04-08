<?php

class Menu_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    /**
    *  Save new menu page
    * @param int $site_id
    * @param int $menu_id
    * @param int $page_id
    */
    public function save($site_id, $menu_id, $page_id) {
        $sort = $this->_get_last_sort($menu_id);

        $data = array(
                'site_id' => $site_id,
                'menu_id' => $menu_id,
                'page_id' => $page_id,
                'sort' => $sort
            );
        $this->db->insert('menu_pages', $data);

        return true;
    }

    /**
    * Getter for last item of menu pages
    * @param int $menu_id
    * @return int 
    *
    */
    private function _get_last_sort($menu_id){
            $this->db->order_by('sort', 'desc');
            $query = $this->db->get_where('menu_pages', array('menu_id' => $menu_id), 1, 0);   
            $row = $query->row();
            
            if($row){
                 $data = $row->sort;
            }else{
                $data = 0;
            }

            $data = $data + 1;
            return $data;
            
    }

    public function sort($site_id, $subPages) {
        $listening = 1;
        foreach($subPages as $value) {
            $this->db->where(array('site_id'=>$site_id, 'id' => $value));
            $this->db->update('menu_pages', array('sort' => $listening));   
            //birer birer arttır
            $listening++;
        }
    }

    /**
     * Delete menu page
     * @param int $site_id
     * @param int $id
     * @return bool
     */
    public function delete($site_id, $id) {
        $this->db->delete('menu_pages', array('site_id' => $site_id, 'id' => $id));
        return true;
    }
    /**
    * Delete menu
    * @param int $site_id
    * @param int $id 
    * @return bool
    */
    public function remove($site_id, $id){
        $query = $this->db->get_where('menus', array('site_id' => $site_id, 'id' => $id), 1, 0);
        $row = $query->row();
        $cnt = $row->cnt;
        if($cnt <= 1) {
            $this->db->where(array('site_id' => $site_id, 'id' => $id));
            $this->db->delete('menus');
            $this->db->delete('menu_pages', array('menu_id' => $id));     
        } else {
            $cnt--;
            $this->db->where(array('site_id' => $site_id, 'id' => $id));
            $this->db->update('menus', array('cnt' => $cnt));
        }

        return true;
    }
    public function get_pages($site_id, $menu_id){
        $this->db->order_by('sort');
        $query = $this->db->get_where('menu_pages', array('site_id' => $site_id, 'menu_id' => $menu_id));
        
        $result = $query->result();
        // arama yapabilmek için idleri diziye yığ
        $page_ids = array();
        foreach($result as $row) {
           $page_ids[] = $row->page_id;
        }

        // sayfaları hafıza at
        if(count($page_ids)) {
            $this->db->select('site_id, title, prefix, external, url, page_id');
            $this->db->where_in('page_id', $page_ids);
            $query2 = $this->db->get('pages');
            $result2 = $query2->result();          
        } else {
            return false;
        }


        $data  = array();
        foreach($result as $row) {
            $obj = new stdClass();
            $obj = $this->_search_in_object($result2, $row->page_id);
            $obj->menu_page_id = $row->id;
            $data[] = $obj;
        }

        return $data;
    }

    private function _search_in_object($result, $search) {
        foreach($result as $row) {
            if ($row->page_id == $search) {
                return $row;
            } 
        }

        return false;
    }
}