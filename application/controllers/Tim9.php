<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tim9 extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }

        $this->load->model('master_model');
        $this->load->model('aktivitas_model');
        $this->load->model('pegawai_model');
    
        $this->load->model('mood_model');
    }
    public function index(){
       $this->template->load('template/template', 'tim9/dashboard');
    }
    
    public function tambah() // fungsi ini digunakan untuk menambahkan aktivitas
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('aktivitas', 'aktivitas', 'required');



        if ($this->form_validation->run()) {


            if (!empty($this->input->post('penugasan'))) {
                $username = $this->input->post('username');
                $username_pemberi_aktivitas =
                    $this->session->userdata('username');
            } else {
                $username = $this->session->userdata('username');
                $username_pemberi_aktivitas = NULL;
            }

            if (!empty($this->input->post('tanggal'))) {
                $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
            } else {
                $tanggal = date("Y-m-d");
            }

            $aktivitas = $this->input->post('aktivitas');
            $status_kerja = $this->input->post('status_kerja');


            $params = array(
                'username'              => $username,
                'aktivitas'             => $aktivitas,
                'status_kerja'          => $status_kerja,
                'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                'tanggal'               => $tanggal

            );

            $this->master_model->insert("aktivitas", $params);

            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

            redirect('aktivitas/tambah');
        } else {


            $data['pegawai'] = $this->pegawai_model->get_all_pegawai();
            $this->load->vars($data);
            $this->template->load('template/template', 'aktivitas/tambah_aktivitas');
        }
    }
    
    function lihat($bulan = '', $tahun = '')
    {
        if($this->input->get('bulan') == ''){
            $bulan = date('m');
        } else {
            $bulan = $this->input->get('bulan');
        }
        if($this->input->get('tahun') == ''){
            $tahun = date('Y');
        } else {
            $tahun = $this->input->get('tahun');
        }
        $data['aktivitas'] = $this->aktivitas_model->get_all_bulan($bulan, $tahun);
        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas');
    }

    function lihat444()
    {
        $data['aktivitas'] = $this->aktivitas_model->get_all();
        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;

        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas');
    }
    function sendiri444()
    {
        $data['aktivitas'] = $this->aktivitas_model->get_sendiri();
        
        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;

        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas');
    }
    
    function sendiri($bulan = '', $tahun = '')
    {
        if($this->input->get('bulan') == ''){
            $bulan = date('m');
        } else {
            $bulan = $this->input->get('bulan');
        }
        if($this->input->get('tahun') == ''){
            $tahun = date('Y');
        } else {
            $tahun = $this->input->get('tahun');
        }
        
        // exit;        
        $data['aktivitas'] = $this->aktivitas_model->get_sendiri_bulan($bulan, $tahun);
        
        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;
        
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas_sendiri');
    }

    function selesai()
    {
        $output = $this->input->post('output');
        $id = $this->input->post('id_aktivitas');
        $params = array(
            'tanggal_selesai' => date("Y-m-d"),
            'output'               => $output,
            'status_aktivitas' => "selesai"
        );

        $this->master_model->update("aktivitas", "id", $id, $params);

        $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

        // redirect('aktivitas/lihat');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }
    function hapus()
    {
        
        $id = $this->input->post('id_aktivitas');
        

        $this->master_model->delete("aktivitas", "id", $id);

        $this->session->set_flashdata('sukses', "Data yg anda berhasil dihapus");

        // redirect('aktivitas/lihat');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }
    public function edit($id) // fungsi ini digunakan untuk menambahkan aktivitas
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('aktivitas', 'aktivitas', 'required');

        if ($this->form_validation->run()) {


            if (!empty($this->input->post('penugasan'))) {
                $username = $this->input->post('username');
                $username_pemberi_aktivitas =
                    $this->session->userdata('username');
            } else {
                $username = $this->session->userdata('username');
                $username_pemberi_aktivitas = NULL;
            }

            if (!empty($this->input->post('tanggal'))) {
                $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
            } else {
                $tanggal = date("Y-m-d");
            }

            $aktivitas = $this->input->post('aktivitas');
            $status_kerja = $this->input->post('status_kerja');


            $params = array(
                'username'              => $username,
                'aktivitas'             => $aktivitas,
                'status_kerja'          => $status_kerja,
                'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                'tanggal'               => $tanggal

            );

            $this->master_model->update("aktivitas", "id", $id, $params);
            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

            redirect('aktivitas/lihat');
        } else {

            $data['data'] = $this->master_model->get_id("aktivitas", "id", $id);
            $data['pegawai'] = $this->pegawai_model->get_all_pegawai();
            $this->load->vars($data);
            $this->template->load('template/template', 'aktivitas/edit_aktivitas');
        }
    }
}