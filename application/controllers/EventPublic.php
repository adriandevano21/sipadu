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

class EventPublic extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    
    $this->load->model('rincian_gaji_model');
    $this->load->model('rapat_model');
    $this->load->model('master_model');
    $this->load->model('pegawai_model');
  }

  public function index()
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
    $data['ruang_rapat'] = $this->rapat_model->get_all_ruang_rapat();
    $data['rapat'] = $this->rapat_model->get_all_bulan($bulan, $tahun);
    $data['bulan'] = $bulan;
    $data['tahun'] = $tahun;

    $this->load->vars($data);
    $this->template->load('template/templatePublic', 'event/listPublic');
  }

}


/* End of file Rapat.php */
/* Location: ./application/controllers/Rapat.php */