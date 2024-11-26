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
include_once(dirname(__FILE__) . "/Qrcode_kegiatan.php");
class Projek extends Qrcode_kegiatan
{
  private $token_ = "_{ptZD^ei_u=ZFyV9Y|j_v1VOYXLPB|7}gTBl^hEP4vx}hpk-ichsan";
  private $DEVICE_ID = "iphone";

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in')) {
    } else {
      redirect('login');
    }
    $this->load->model('rincian_gaji_model');
    $this->load->model('rapat_model');
    $this->load->model('master_model');
    $this->load->model('projek_model');
  }

  public function list()
  {

    $data['projek'] = $this->projek_model->get_all();
    $data['judul'] = 'Projek';
    $this->load->vars($data);
    $this->template->load('template/template', 'projek/list');
  }

  public function tambah() // fungsi ini digunakan untuk menambahkan aktivitas
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nama_projek', 'nama_projek', 'required');

    if ($this->form_validation->run()) {

      $username = $this->session->userdata('username');
      $id_tim = $this->input->post('id_tim');
      $id_iku = $this->input->post('id_iku');
      $nama_projek = $this->input->post('nama_projek');
      $tahun = '2024';

      $params = array(
        'id_tim'    => $id_tim,
        'id_iku'    => $id_iku,
        'username'             => $username,
        'nama_projek'      => $nama_projek,
        'tahun'               => $tahun,
      );
      //   print_r($params);
      //   exit;

      $id_rapat = $this->master_model->insert("projek", $params);

      $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");
      redirect('projek/list');
    } else {
      $data['iku'] = $this->master_model->get_all('iku');
      $data['judul'] = 'Projek';
      $this->load->vars($data);
      $this->template->load('template/template', 'projek/tambah');
    }
  }
  public function edit($id)
  {
    // Ambil data input dari form
    // $id = $this->input->post('id');
    $id_tim = $this->input->post('id_tim');
    $id_iku = $this->input->post('id_iku');
    $nama_projek = $this->input->post('nama_projek');
    $tahun = $this->input->post('tahun');
    $username = $this->session->userdata('username');
    $this->load->library('form_validation');

    // Validasi data input
    $this->form_validation->set_rules('id_tim', 'Id Tim', 'required');
    $this->form_validation->set_rules('nama_projek', 'Nama Projek', 'required');
    $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');

    // Cek apakah validasi berhasil
    if ($this->form_validation->run() == TRUE) {
      // Buat array data untuk update
      $data = array(
        'id_tim' => $id_tim,
        'id_iku' => $id_iku,
        'nama_projek' => $nama_projek,
        'tahun' => $tahun,
        'username' => $username
      );

      // Panggil fungsi update dari model dengan parameter id dan data
      $this->master_model->update('projek', 'id', $id, $data);

      // Buat pesan sukses
      $this->session->set_flashdata('success', 'Data projek berhasil diupdate');

      // Redirect ke halaman index
      redirect('projek/list');
    } else {
      $data['iku'] = $this->master_model->get_all('iku');
      $data['projek'] = $this->projek_model->get_by_id($id);
      $data['judul'] = 'Projek';
      $this->load->vars($data);
      $this->template->load('template/template', 'projek/edit');
    }
  }


  public function lihat($id_rapat)
  {
    $data['peserta_rapat_eksternal'] = $this->rapat_model->peserta_rapat_eksternal_id_rapat($id_rapat);
    $data['peserta_rapat'] = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
    $data['detail_rapat'] = $this->rapat_model->get_id($id_rapat);
    $data['dokumentasi_rapat'] = $this->rapat_model->dokumentasi_rapat_id_rapat($id_rapat);
    $data['judul'] = 'Projek';
    $this->load->vars($data);
    $this->template->load('template/template', 'event/lihat');
  }



  public function hapus($id)
  {

    $hasil_cek = $this->projek_model->cek_projek($id);
    if ($hasil_cek) {
      $this->master_model->delete('projek', 'id', $id); // hapus projek
      $this->session->set_flashdata('sukses', "Berhasil hapus projek");
    } else {
      $this->session->set_flashdata('gagal', "Gagal hapus projek karena sudah ada kegiatannya");
    }

    $this->load->library('user_agent');
    redirect($this->agent->referrer());
  }
}


/* End of file Rapat.php */
/* Location: ./application/controllers/Rapat.php */