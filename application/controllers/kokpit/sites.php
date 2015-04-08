<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sites extends Admin_Controller {
    
        public function __construct() {
            parent::__construct();
            
            $this->load->model('kokpit/kokpit_model');
            $this->load->model('kokpit/sites_model');
 
        }
        
        public function index(){
            $p_data['middle']  = $this->load->view('kokpit/sites_view', '', true);
            $p_data['contact_statu'] = $this->kokpit_model->get_unread_contact();
            $p_data['feedback_statu'] = $this->kokpit_model->get_unread_feedback();
            $p_data['delete_statu'] = $this->kokpit_model->get_delete_request();
            $p_data['order_statu'] = $this->kokpit_model->get_unread_orders();

            $this->load->view('kokpit/index_view', $p_data);
        }
        
        public function passive(){
            $site_id = (int)$this->input->post('site_id');
            $statu = (int)$this->input->post('statu');
            
            $statu = $this->sites_model->passive_site($site_id, $statu);
            echo $statu;
        }

        public function get_data() {
            $this->load->library('datatables');
            $this->datatables
            ->select('site_id,user_id,sitename,statu')
            ->from('sites')
            ->unset_column('domain')
            ->edit_column('sitename', $this->get_link('$1'), 'sitename')
            ->add_column('Actions', '','')
            ->add_column('Yönet', $this->get_manage_link('$1'), 'site_id');
            echo $this->datatables->generate('json');           
        }          

        public function get_manage_link($site_id) {
            return '<a href="'.base_url().'manage/editor/wellcome/'.$site_id.'" class="btn">Yönet</a>';
        } 

        public function get_link($sitename) {
            return '<a href="http://'. $sitename .'.sincapp.com">'.$sitename.'</a>';
        }
}
        
        