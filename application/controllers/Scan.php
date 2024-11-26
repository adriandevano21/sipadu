<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
        $this->load->model('master_model');
    }
    public function index()
    {
        $data['judul'] = "ScanQR" ;
        $this->load->vars($data);
        $this->template->load('template/template', 'scan/scan');
    }
    public function absen()
    {
        $cek_rapat = $this->master_model->get_id("rapat", "qrcode", $this->input->post('qrcode'));
        if (!empty($cek_rapat)) {

            $params = array(
                'status' => 1
            );

            $data_pk = array(
                'username' => $this->session->userdata('username'),
                'id_rapat' => $cek_rapat['id'],
            );

            $this->master_model->update_array_biasa('peserta_rapat', $data_pk, $params);
        } else {
        }

        $cek = $this->master_model->get_id("qrcode", "qrcode", $this->input->post('qrcode'));
        if (!empty($cek)) {
            if ($cek['aktif'] == 1) {
                $params = array(
                    'username'            => $this->session->userdata('username'),
                    'qrcode'             => $this->input->post('qrcode'),
                    'kegiatan' => $cek['kegiatan']
                );

                $this->master_model->insert("absensi", $params);
                $data = "Absen sukses";
                echo json_encode($data);
            } else {
                $data = "kegiatan anda tidak aktif";
                echo json_encode($data);
            }
        } else {
            $data = "QRcode anda tidak terdaftar";
            echo json_encode($data);
        }
    }
}
