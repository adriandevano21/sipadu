<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatankepala extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('master_model');
        $this->load->model('aktivitas_model');
        $this->load->model('pegawai_model');
    }

    function index()
    {
       
        $username = "ahmadriswan";
        
        $data['aktivitas'] = $this->aktivitas_model->get_perorang($username);

        $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
        $data['judul'] = 'Kegiatan';
        $this->load->vars($data);
        
        $this->template->load('template/templatePublic', 'aktivitas/lihat_aktivitas_kepala');
    }
    
}