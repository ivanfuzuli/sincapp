<?php
use Gregwar\Captcha\CaptchaBuilder;

class Form extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
           $inputs = $this->input->post();
           $this->load->model('form_model');

           if($this->session->userdata('phrase') != $this->input->post('phrase')) {
              $succ['str'] = 'phrase_error';
              $this->load->view('print_view', $succ);
           } else {
               if($inputs){
                $succ['str'] = $this->form_model->send($inputs);
               }else{
                 $succ['str'] = "Opps.";
               }
               $this->load->view('print_view', $succ);
              $this->builder = new CaptchaBuilder;
              $this->builder->build();
              
              $this->session->set_userdata(array('phrase' => $this->builder->getPhrase()));                          
           }
    }

    public function refresh() {
        $builder = new CaptchaBuilder;
        $builder->build();
              
        $this->session->set_userdata(array('phrase' => $builder->getPhrase()));
        header('Content-type: image/jpeg');
        $builder->output();
    }

    public function password() {
        $password = $this->input->post('password');
        $this->session->set_flashdata('page_password', $password);
        redirect($_SERVER['HTTP_REFERER']);
    }
}