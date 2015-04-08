<?php

class Dashboard_model extends CI_Model {
    var $user_id;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->user_id = $this->auth->get_user_id();
    }
    
    public function get_unread_message($user_id){
        $user_id = (int)$user_id;
         $this->db->select('thread_id');
         $this->db->where('to_id= '.$user_id.' and to_read = 0 or sender_id = '.$user_id.' and sender_read = 0', null, false);
         
         $query = $this->db->get('threads');
         $total = $query->num_rows();
         if($total == 0){
             return false;
         }else{
             return $total;
         }       
    }
    /**
     * Get sites
     * 
     * @return array
     *
     */
    public function get_sites(){
        $this->load->model('site_model');
        $this->load->model('packages_model');
        $query = $this->db->get_where('sites', array('user_id' => $this->user_id));
        $result = $query->result();
        $data = array();
        
        foreach($result as $row){
            $url = $this->site_model->get_siteurl($row->site_id);
            $settings = $this->_get_settings($row->site_id);
            if($settings == false){
                $setup = true;
                $title = "";
                $theme_css = "notheme";
            }else{
                $setup = false;
                $title = $settings['title'];
                $theme_css = $settings['theme_css'];
            }
            $package_name = $this->packages_model->get_package_name_by_site_id($row->site_id);
            $package = $this->packages_model->get_package($package_name);
            $disk_quota = $this->packages_model->get_storage_quota($row->site_id);
            $storage_percentage = number_format(($disk_quota / ($package->storage * 1000)) * 100, 2);

            $is_purchased = $this->site_model->is_purchased($row->site_id);
            $data[] = array('site_id' => $row->site_id, 'url' => $url,'is_purchased' => $is_purchased, 'title' => $title, 'theme_css' => $theme_css, 'setup' => $setup, 'statu' => $row->statu, 'package' => $package, 'storage_quota' => $disk_quota, 'storage_percentage' => $storage_percentage);
        }
        return $data;
    }
    
    /**
     * Email changing
     *
     * @param type $new_email
     * @param type $password
     * 
     * @return string 
     */
    
    public function change_email($new_email, $password){
        //güvenlik için şifreyi doğrula
        $pass_check = $this->check_password($password);
        if($pass_check == false){
            return 2;
        }
        //baskasinin email ile cakismasin
        $checker = $this->check_email($new_email);
              if($checker == false){
                $this->db->where('user_id', $this->user_id);
                $this->db->update('users', array('email' => $new_email)); 
                return 0;
              }else{
                  return 1;
              }

    }
    
    /**
     * Daha önce kurulmuş mu?
     * 
     * @return bool
     * 
     */
    private function _get_settings($site_id){
        $this->db->select('title');
        $this->db->where(array('site_id' => $site_id));
        $this->db->from('settings');
        $this->db->select('theme_css');
        $this->db->join('themes', 'themes.theme_id = settings.theme_id');
        
        $query = $this->db->get();
        $row = $query->row();
        if($row){
            return array('title' => $row->title, 'theme_css' => $row->theme_css);
        }else{
            return false;
        }
    }
    
    /**
     * Is email exits? 
     * @return bool
     */
    private function check_email($email){
            $query = $this->db->get_where('users', array('email' => $email, 'user_id !=' => $this->user_id));
            $check = $query->num_rows();
            if($check >= 1){
                return true;
            }
            return false;
            }
    
    /**
     * Is password true?
     * 
     * @param type $password
     * @return bool 
     */
    private function check_password($password){
            $password = md5($password);
            $query = $this->db->get_where('users', array('password' => $password, 'user_id' => $this->user_id));
            $check = $query->num_rows();
            if($check >= 1){
                return true;
            }
            return false;
            }        
    /**
     * Is sitename exits?
     * 
     * @return bool
     */
    public function check_sitename($sitename){
        $query = $this->db->get_where('sites', array('sitename' => $sitename));
        $check = $query->num_rows();
        if($check >= 1){
            return true;
        }
        return false;        
    }
    
    /**
     * Change password
     * @param type $old_password
     * @param type $new_password
     * @return string 
     */
    public function change_password($old_password, $new_password){
         $pass_check = $this->check_password($old_password);
        if($pass_check == false){
            return false;
        }else{
             $this->db->where('user_id', $this->user_id);
             $this->db->update('users', array('password' => $new_password)); 
             return true;            
        }  
    }
    
    /**
     * Add site
     * @param type $sitename
     * @return bool 
     */
    public function add_site($sitename){
        //eger bossa hata dondur
        if(!$sitename){
            return false;
        }
        //site adi daha once alinmisa islem yapma
        $check = $this->check_sitename($sitename);
        if($check == true){
            return false;       
        }else{
            $this->db->insert('sites', array('user_id' => $this->user_id, 'sitename' => $sitename));
            $site_id = $this->db->insert_id();
            
            //foto klasörünü yarat
            $pathPic = './files/photos/'.$site_id.'/';
                mkdir($pathPic);
                chmod($pathPic, 0777);  
                
            $pathDoc = './files/documents/'.$site_id.'/';
                mkdir($pathDoc);
                chmod($pathDoc, 0777); 
            return true;
        }
    }
    
    /**
     *
     * @param type $site_id
     * @param type $title
     * @param type $description
     * @param type $theme_id
     * @return bool 
     */
    public function setup($site_id, $title, $description, $theme_id){
        $s_exits = $this->_settings_exits($site_id);//ayarlar yoksa işlemleri yap
            if($s_exits == false){                 
                 //settingsi kayit edelim
                 $logo = substr($title, 0, 30); //logo için 30 karakter al
                 $footer = "Copyright © ".$title;
                 $data = array(
                     'site_id'      => $site_id,
                     'logo_top'     => -1,
                     'logo_left'    => -1,
                     'logo_type'    => 0,
                     'logo_str'     => $logo,
                     'footer_str'   => $footer,
                     'title'        => $title,
                     'site_desc'    => $description,
                     'theme_id'     => $theme_id,
                     'cover_photo'  => null //672
                     );
                 
                 $this->db->insert('settings', $data);
                //eski siteyi yenisine taşıyalım
                 $this->load->model('migration_model');
                 $this->migration_model->set_from_site_id_from_theme_id($theme_id)->set_to_site_id($site_id)->migrate();
                 $this->migration_model->set_cover_photo();
                // $this->load->model('manage/pages_model');
                // $this->pages_model->set_page($site_id, 'Ana Sayfa', null, index');
 
                 return true;
            }
    }
    
    /**
     *
     * @param type $theme_id
     * @return bool 
     */
    public function theme_exits($theme_id){
       $this->db->select('theme_id');
       $query = $this->db->get_where('themes', array('theme_id' => (int) $theme_id));
       $count = $query->num_rows();
       if($count != 1){
           return false;
       }else{
           return true;
       }        
    }

    /**
     *Contact Form Sender
     * @param type $name
     * @param type $email
     * @param type $message 
     */
    public function set_contact($name, $email, $message){
        $data = array(
                      'name' => $name,
                      'email' => $email,
                      'message' => $message,
                      'send_date' => date('Y-m-d H:i:s'),
                      'statu' => 0
                );
        $this->db->insert('contacts', $data);
    }

    /**
     *
     * @param type $site_id
     * @return bool 
     * 
     */
    
    private function _settings_exits($site_id){
       $this->db->select('site_id');
       $query = $this->db->get_where('settings', array('site_id' => (int) $site_id));
       $count = $query->num_rows();
       if($count < 1){
           return false;
       }else{
           return true;
       }
    }
        
}