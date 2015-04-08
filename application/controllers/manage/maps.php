<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maps extends Editor_Controller {
    
        public function __construct() {
            parent::__construct();
              $this->load->model('extensions/maps_model');
              $this->lang->load('maps', 'turkish');             
              $this->load->helper('language');//lang kısaltması icin gerekli    
            //cagirilinca site numarasini hafizaya at
            $this->__set_site_id();
 
        }        

	public function index()
	{

	}
        
        public function save(){
            $site_id = $this->__get_site_id();

            $map_id = (int)$this->input->post('map_id');
            $map_title = $this->input->post('map_title', true);
            $latitude = $this->input->post('latitude', true);
            $longitude = $this->input->post('longitude', true);
            $zoom = (int)$this->input->post('zoom');
            
            $data = array('site_id' => $site_id, 'latitude' => $latitude, 'longitude' => $longitude, 'zoom' => $zoom, 'map_title' => $map_title);
            
            $this->maps_model->save_do($site_id, $map_id, $data);
            
            $p_data['str'] = "<div class=\"info\">".lang('succ_update_map')."</div>";
            
            $this->load->view('print_view', $p_data);
        }
}