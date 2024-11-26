<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mood extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
    }
    public function tambah()
    {

        $params = array(
            'username'         => $this->session->userdata('username'),
            'mood'             => $this->input->post('mood'),

        );


        $this->master_model->insert("mood_pegawai", $params);
        // $this->load->vars($data);
        // $this->template->load('template/template', 'home');
    }
}
