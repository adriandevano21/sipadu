<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Rapat
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 *
 */
class Dashboard_event extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('aktivitas_model');
        $this->load->model('rapat_model');
        $this->load->model('master_model');
        $this->load->model('pegawai_model');
    }

    public function list()
    {
        $data['ruang_rapat'] = $this->rapat_model->get_all_ruang_rapat();
        $data['rapat'] = $this->rapat_model->get_all();
        $this->load->vars($data);
        $this->template->load('template_dash/template_dash', 'dashboard_event/list');
    }


    public function lihat($id_rapat)
    {
        $data['peserta_rapat_eksternal'] = $this->rapat_model->peserta_rapat_eksternal_id_rapat($id_rapat);
        $data['peserta_rapat'] = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
        $data['detail_rapat'] = $this->rapat_model->get_id($id_rapat);
        $data['dokumentasi_rapat'] = $this->rapat_model->dokumentasi_rapat_id_rapat($id_rapat);

        $this->load->vars($data);
        $this->template->load('template_dash/template_dash', 'dashboard_event/lihat');
    }

    function pegawai($username = "", $bulan = '', $tahun = '')
    {
        if ($this->input->get('bulan') == '') {
            $bulan = date('m');
        } else {
            $bulan = $this->input->get('bulan');
        }
        if ($this->input->get('tahun') == '') {
            $tahun = date('Y');
        } else {
            $tahun = $this->input->get('tahun');
        }
        $username = $this->input->get('username');
        // $data['aktivitas'] = $this->aktivitas_model->get_all_bulan_pegawai($username, $bulan, $tahun);
        $data['aktivitas'] = $this->aktivitas_model->get_all_pegawai($username);
        $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
        $data['pegawai'] = $this->pegawai_model->get_pegawai($username);
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->vars($data);
        $this->template->load('template_dash/template_dash', 'dashboard_event/event_pegawai');
    }
}


/* End of file Rapat.php */
/* Location: ./application/controllers/Rapat.php */