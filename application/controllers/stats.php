<?php
class Stats extends Auth_Controller {
        private $_client;

        public function __construct() {
              parent:: __construct();
              $this->load->model('metrica_model');
        }

        public function index($site_id) {
          $user_id = $this->auth->get_user_id();
          $this->load->model('stats_model');
          // Check auth
          $this->load->model('auth_model');
          $this->auth_model->check_auth($site_id);
          //End Check auth
          $data = array();
          $data['site_id'] = $site_id;
          $data['is_exist'] = $this->metrica_model->is_metrica_exist($site_id);
          $this->load->view('stats/index_view', $data);
        }

        public function yandex() {
          $this->load->model('site_model');
            //state is site_id
          $site_id = (int)$this->input->get('state');
          $code = $this->input->get('code', TRUE);
          // Check auth
          $this->load->model('auth_model');
          $this->auth_model->check_auth($site_id);
          //End Check auth

          //get id and password from config
          $this->config->load('metrica');
          $client_id = $this->config->item('client_id');
          $client_secret = $this->config->item('client_secret');

          $this->_client = new GuzzleHttp\Client();
          $this->_client->setDefaultOption('verify', false);

          try {
            $response = $this->_client->post('https://oauth.yandex.com/token', [
                'body' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'client_id' => $client_id,
                    'client_secret' => $client_secret
                ]
            ]);            
          } catch(GuzzleHttp\Exception\RequestException $e) {
             die('Oppss. Bir hata olustu. Lutfen daha sonra tekrar deneyin.');
          }

          $json = $response->json();
          $token = $json['access_token'];
          $metrica = $this->metrica_model->get_metrica($site_id);

          $site_url = $this->site_model->get_siteurl($site_id);

          if(!$metrica) {
            // insert metrica
             $this->_add_counter($site_id, $site_url, $token);
          } else {
            // update metrica url
            if($metrica->site_url != $site_url){
                $this->_update_counter($site_id, $site_url, $metrica->counter_id, $token);
            }
            //redirect metrica
            $this->_redirect($metrica->counter_id);
          }
        }

        private function _update_counter($site_id, $site_url, $metrica_id, $token) {
            try {
              $response = $this->_client->put('http://api-metrika.yandex.com.tr/counter/'.$metrica_id.'?pretty=1&oauth_token='.$token, 
              ['json' => ['site' => $site_url]]);
            } catch(GuzzleHttp\Exception\RequestException $e) {
               echo $e->getResponse();
               die('Bir hata olustu. Lutfen daha sonra tekrar deneyin.');
            }

            $data = array(
                'site_url' => $site_url
            );

            $this->metrica_model->update($site_id, $data);
        }

        private function _redirect($counter_id) {
            redirect('https://metrica.yandex.com.tr/stat/dashboard/?counter_id=' . $counter_id);
        }

        private function _add_counter($site_id, $site_url, $token) {
          $data = array(
              'name' => 'Deneme'
          );
          try {
            $response = $this->_client->post('http://api-metrika.yandex.com.tr/counters.json?pretty=1&oauth_token='.$token, 
            ['json' => ['site' => $site_url, 'code_options' => ['visor' => 1, 'clickmap' => 1]]]);
          } catch(GuzzleHttp\Exception\RequestException $e) {
             echo $e->getResponse();
             die('Bir hata olustu. Lutfen daha sonra tekrar deneyin.');
          }

          $json = $response->json();

          if(!$json['counter']) {
            echo "Bir hata var.";
          }
          // insert data
          $data = array();
          $data['site_id'] = $site_id;
          $data['site_url'] = $site_url;
          $data['code'] = $json['counter']['code'];
          $data['counter_id'] = $json['counter']['id'];
          $data['visor'] = 1;
          $data['click_map'] = 1;
          $data['external_links'] = 0;
          $data['denial'] = 0;
          
          $this->metrica_model->insert($data);

          $this->_redirect($json['counter']['id']);
        }
}