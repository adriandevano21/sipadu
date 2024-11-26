<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail_kegiatan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('detail_kegiatan_model');
        $this->load->model('kegiatan_model');
        $this->load->model('master_model');
        $this->load->model('anggota_subtim_model');
    }

    // Read
    public function index()
    {
        $data['detail_kegiatan'] = $this->detail_kegiatan_model->semua_kegiatan_detail();
        $data['data'] = $this->detail_kegiatan_model->semua_rekap_kegiatan_pegawai();
        $data['judul'] = "Detail Kegiatan" ;
        $this->load->vars($data);
        $this->template->load('template/template', 'detail_kegiatan/list_detail_kegiatan');
    }

    // Read
    public function rekap_perpegawai()
    {
        $data['data'] = $this->detail_kegiatan_model->semua_rekap_kegiatan_pegawai();
        $this->load->vars($data);
        $this->template->load('template/template', 'detail_kegiatan/list_detail_kegiatan');
    }

    // Create
    public function tambah()
    {
        $this->load->library('form_validation');

        // Set aturan validasi untuk form tambah detail kegiatan
        $this->form_validation->set_rules('id_kegiatan', 'ID Kegiatan', 'required');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
        // ... aturan validasi untuk field lainnya

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan kembali form tambah detail kegiatan
            $data['kegiatan'] = $this->kegiatan_model->semua_kegiatan();
            $data['pegawai'] = $this->anggota_subtim_model->get_all();
            $data['kedeputian'] = $this->master_model->get_all('kedeputian');
            $data['tujuan_pk'] = $this->master_model->get_all('tujuan_pk');

            $this->load->vars($data);
            $this->template->load('template/template', 'detail_kegiatan/tambah_detail_kegiatan');
        } else {
            // Jika validasi berhasil, tambahkan detail kegiatan ke dalam database
            $data = array(
                'id_kegiatan' => $this->input->post('id_kegiatan'),
                'tanggal_mulai' => date("Y-m-d", strtotime($this->input->post('tanggal_mulai'))),
                'tanggal_selesai' => date("Y-m-d", strtotime($this->input->post('tanggal_selesai'))),
                'output' => $this->input->post('output'),
                'output' => $this->input->post('output'),
                'output' => $this->input->post('output'),
                'output' => $this->input->post('output'),
                'output' => $this->input->post('output'),
            );

            $this->detail_kegiatan_model->tambah_detail_kegiatan($data);
            redirect('detail_kegiatan');
        }
    }

    // Read detail
    public function detail($id)
    {
        $data['detail_kegiatan'] = $this->detail_kegiatan_model->detail_detail_kegiatan($id);
        $this->load->vars($data);
        $this->template->load('template/template', 'kegiatan/detail_detail_kegiatan');
    }

    // Update
    public function edit($id)
    {
        $data['detail_kegiatan'] = $this->detail_kegiatan_model->detail_detail_kegiatan($id);

        $this->form_validation->set_rules('id_kegiatan', 'ID Kegiatan', 'required');
        $this->form_validation->set_rules('tanggal_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('tanggal_selesai', 'Tanggal Selesai', 'required');
        // ... tambahkan aturan validasi untuk field lainnya

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan kembali form edit detail kegiatan dengan pesan kesalahan
            $this->load->vars($data);
            $this->template->load('template/template', 'kegiatan/edit_detail_kegiatan');
        } else {
            // Jika validasi berhasil, ambil data dari form untuk diupdate ke dalam database
            $updated_data = array(
                'id_kegiatan' => $this->input->post('id_kegiatan'),
                'tanggal_mulai' => $this->input->post('tanggal_mulai'),
                'tanggal_selesai' => $this->input->post('tanggal_selesai'),
                'output' => $this->input->post('output'),
                'id_indikator_pk' => $this->input->post('id_indikator_pk'),
                'id_kedeputian' => $this->input->post('id_kedeputian'),
                'keterangan' => $this->input->post('keterangan'),
                // ... tambahkan field lainnya yang ingin diupdate
            );

            // Panggil fungsi dari model untuk melakukan update data
            $this->detail_kegiatan_model->update_detail_kegiatan($id, $updated_data);

            // Redirect kembali ke halaman daftar detail kegiatan
            redirect('detail_kegiatan');
        }
    }
    // Delete
    public function hapus($id)
    {
        $this->detail_kegiatan_model->hapus_detail_kegiatan($id);
        redirect('detail_kegiatan');
    }
}
