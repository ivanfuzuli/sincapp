<?php

class Sites_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_sites($limit, $where, $removed = false){
        $this->db->limit($limit, $where);
        
        if($removed == true){//sadece silinme talebinde bulunanlari gosterir
            $this->db->where('statu', 2);
        }
        $this->db->order_by('site_id', 'desc');
        $query = $this->db->get('sites');
        $result = $query->result();
        return $result;
    }
    
    public function passive_site($site_id, $statu){
        $this->db->where('site_id', $site_id);
        $this->db->update('sites', array('statu' => $statu));
        
        return $statu;
    }
    /**
     * Site silme islemi
     * @param type user_id
     * @param type $site_id
     * @param type $password 
     * 
     * @return bool
     */
    public function delete_standart($user_id, $site_id, $password){
        $password = md5($password);
        
        //eger sifre dogru degilse islemi kes
        $query = $this->db->get_where('users', array('user_id' => $user_id, 'password' => $password));
        if($query->num_rows() < 1){
            return "nomatch";
        }
        
        //eger kullanici sitenin sahibi degilse islemi kes
        $query2 = $this->db->get_where('sites', array('site_id' => $site_id, 'user_id' => $user_id));
        if($query2->num_rows() < 1){
            return "noaccess";
        }    
        
        //eger ayarlar olusturulmusa adminden onay al yoksa direk sil
        $this->db->select('site_id');
        $query3 = $this->db->get_where('settings', array('site_id' => $site_id));
        if($query3->num_rows() > 0){
            $this->db->where('site_id', $site_id);
            $this->db->update('sites', array('statu' => 2));
        }else{
            //sorgusuz sualsiz sil
            $this->delete_admin($site_id);
        }
        
        return "success";
    }    
    /**
     * siteyi tamamen silme
     * @param type $site_id
     * @return type 
     */
    public function delete_admin($site_id){
        $site_id = (int)$site_id;
        //siteyi sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('sites');
        
        //ayarlari sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('settings');
        
        //sayfalari sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('pages');
        
        //gridleri sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('grids');
        
        //eklentileri sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('extensions');
        
        //paragraflari sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('paragraphs');
        
        //haritalari sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('maps');
        
        //htmlleri sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('htmls');
        
        //formlari sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('form_cloud');
        
        $this->db->where('site_id', $site_id);
        $this->db->delete('forms');  
        
        //sliderlari sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('sliders');
 
        $this->db->where('site_id', $site_id);
        $this->db->delete('slider_cloud');   
        
        //fotolari sil
        $this->db->where('site_id', $site_id);
        $this->db->delete('photos');

        $this->db->where('site_id', $site_id);
        $this->db->delete('photo_cloud');  
        
        //foto fiziksel dosyalari sil
        $this->db->select('path');
        $query = $this->db->get_where('pictures', array('site_id' => $site_id));
        $result = $query->result();
        
        foreach($result as $row){
            $dirPath = './files/photos/'.$site_id.'/'.$row->path.'/';

            $files = glob($dirPath . '*', GLOB_MARK);

            foreach ($files as $file) {
                unlink($file);
            }        
            rmdir($dirPath);            
        }
        $picPath = './files/photos/'.$site_id.'/';
        rmdir($picPath);
        
        $this->db->where('site_id', $site_id);
        $this->db->delete('pictures');          
        //dökümanları sil
        $docPath = './files/documents/'.$site_id.'/';
        rmdir($docPath);        
        
        return true;
    }
    
    /**
     * Site silmeyi iptal et
     * @param type $site_id
     * @return type 
     */
    public function cancel($site_id){
        $site_id = (int)$site_id;
            $this->db->where('site_id', $site_id);
            $this->db->update('sites', array('statu' => 0));
            return true;
    }
}