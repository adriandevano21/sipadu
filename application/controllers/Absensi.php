<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
        $this->load->model('absensi_model');
    }
    public function index()
    {
        $data['judul'] = 'Absensi';
        $this->load->vars($data);
        $this->template->load('template/template', 'absensi/absensi');
    }
    public function absensiku()
    {
        $data['data'] = $this->absensi_model->get_absensiku();
       $data['judul'] = 'Absensi';
        $this->load->vars($data);
        $this->template->load('template/template', 'absensi/absensi');
    }
    public function absensi()
    {
        $data['data'] = $this->absensi_model->get_all();
        $data['judul'] = 'Absensi';
        $this->load->vars($data);
        $this->template->load('template/template', 'absensi/absensi');
    }
}
