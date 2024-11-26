<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('kegiatan_model');
        $this->load->model('tim_model');
    }

    // Tampilan daftar kegiatan
    public function index()
    {
        $data['kegiatan'] = $this->kegiatan_model->semua_kegiatan();
        $data['subtim'] = $this->tim_model->get_all_subtim();
        $this->load->vars($data);
        $this->template->load('template/template', 'kegiatan/list_kegiatan');
    }

    // Tambah kegiatan
    public function tambah()
    {
        $this->load->library('form_validation');

        // Set aturan validasi untuk form tambah kegiatan
        $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required');
        $this->form_validation->set_rules('kode_subtim', 'Kode Subtim', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan kembali form tambah kegiatan
            $this->template->load('template/template', 'kegiatan/tambah_kegiatan');
        } else {
            // Jika validasi berhasil, tambahkan kegiatan ke dalam database
            $data = array(
                'nama_kegiatan' => $this->input->post('nama_kegiatan'),
                'kode_subtim' => $this->input->post('kode_subtim')
            );

            $this->kegiatan_model->tambah_kegiatan($data);
            redirect('kegiatan');
        }
    }

    // Detail kegiatan
    public function detail($id)
    {
        $data['kegiatan'] = $this->kegiatan_model->detail_kegiatan($id);
        $this->load->view('detail_kegiatan', $data);
    }

    // Edit kegiatan
    public function edit($id)
    {
        $this->load->library('form_validation');

        // Set aturan validasi untuk form edit kegiatan
        $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required');
        $this->form_validation->set_rules('kode_subtim', 'Kode Subtim', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Ambil detail kegiatan dari database
            $data['kegiatan'] = $this->kegiatan_model->detail_kegiatan($id);
            $this->load->vars($data);
            $this->template->load('template/template', 'kegiatan/edit_kegiatan');
        } else {
            // Jika validasi berhasil, update kegiatan di dalam database
            $data = array(
                'nama_kegiatan' => $this->input->post('nama_kegiatan'),
                'kode_subtim' => $this->input->post('kode_subtim')
            );

            $this->kegiatan_model->update_kegiatan($id, $data);
            redirect('kegiatan');
        }
    }

    // Hapus kegiatan
    public function hapus($id)
    {
        $this->kegiatan_model->hapus_kegiatan($id);
        redirect('kegiatan');
    }
}
