<?php

class Pinger_model extends CI_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function get_sitemaps(){
        
        //iki tablomuz var lastmod sayfada degisiklik yapilinca degisir
        //sitemapsend ise sitemapin son gonderildigi tarihi tutar
        //eger sitemapsend degeri kucukse sitemap gonderilmemis demektir
        $this->db->limit(20);
        $this->db->order_by('lastmod');
        $this->db->select('sites.site_id, sites.sitename, sites.sitemapsend, pages.lastmod');
        $this->db->group_by('page_id');
        $this->db->having('sites.sitemapsend < pages.lastmod');
        $this->db->join('sites', 'sites.site_id = pages.site_id');
        $query = $this->db->get('pages');
        
        return $query->result();
    }
    
    public function ping($pings){
            //pingi baslat
            $ch = curl_init();
            foreach($pings as $site_id){
                $url = "http://www.google.com/webmasters/tools/ping?sitemap=";//google ping adresi
                $url .= $this->_get_sitemap_url($site_id);
                
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//ekrana bastirma
                curl_exec($ch);
                $info = curl_getinfo($ch);//bilgileri al
                $statu = $info['http_code'];//status code
                
                //eger statu succes(200) ise pingi guncelle
                if($statu == 200){
                    $this->_update_send_date($site_id);
                }
            }
            curl_close($ch);        
    }
    
    private function _update_send_date($site_id){
        $time = time();
        $this->db->where('site_id', $site_id);
        $this->db->update('sites', array('sitemapsend' => $time));
        return true;
    }
    private function _get_sitemap_url($site_id){
        $this->db->select('sitename');
        $query = $this->db->get_where('sites', array('site_id' => $site_id));
        $row = $query->row();
        $domain = $this->_get_domain_by_site_id($site_id);
        if($domain) {
            $url = 'http://www.'.$domain.'/sitemap.xml';
        } else {
            $url = 'http://'.$row->sitename.'.sincapp.com/sitemap.xml';  
        }
        
        $url = urlencode($url);//urli encode edelim
        return $url;
    }

    private function _get_domain_by_site_id($site_id) {
        $query = $this->db->get_where('domains', array('site_id' => $site_id, 'status' => 0));
        
        $row = $query->row();
        if($row) {
            return $row->domain;
        } else {
            return false;
        }
    }
}