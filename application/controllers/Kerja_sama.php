<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kerja_sama extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
        $this->load->model('kerja_sama_model');
        $this->load->model('master_model');
    }

    public function index()
    {

        $data['kerja_sama'] = $this->kerja_sama_model->get_all();
        // $data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();
        $this->load->vars($data);
        $this->template->load('template/template', 'kerja_sama/list');
    }

    // format RB: B-001/RB/BPS/1100/04/2021
    // format umum: B.001/BPS/11560/4/2021

    public function tambah_kerja_sama()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul', 'judul', 'required');
        $this->form_validation->set_rules('instansi', 'instansi', 'required');
        if ($this->form_validation->run()) {

            // 			$kategori= $this->input->post('kategori');
            $judul = $this->input->post('judul');
            $instansi = $this->input->post('instansi');
            $no = $this->input->post('no');
            $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
            $jenis = $this->input->post('jenis');
            $unit_kerja = '1100'; // sementara hanya yang dimasukan di unit kerja provinsi


            $config['upload_path']          = './upload_file/kerja_sama/';
            $config['allowed_types']        = 'pdf';
            $config['max_size']             = 10000;
            // $config['max_width']            = 2048;
            // $config['max_height']           = 1000;
            //   $config['encrypt_name'] 		= true;
            $this->load->library('upload', $config);

            if (!empty($_FILES['upload_file']['name'])) {

                $_FILES['file']['name'] = $_FILES['upload_file']['name'];
                $_FILES['file']['type'] = $_FILES['upload_file']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['upload_file']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['upload_file']['error'];
                $_FILES['file']['size'] = $_FILES['upload_file']['size'];

                if ($this->upload->do_upload('file')) {

                    $uploadData = $this->upload->data();
                    $file_path = $uploadData['full_path'];

                    // Panggil API untuk mengunggah file
                    $api_url = 'http://sipadu.bpsaceh.com/api/uploadFile';
                    $post_data = array(
                        'file' => new CURLFile($file_path),
                        'folder' => 'kerja_sama'
                    );

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $api_url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $data_api = json_decode($response, true);
                    if ($response['status']) {

                        $params = array(
                            'unit_kerja' => $unit_kerja,
                            'tanggal' => $tanggal,
                            'judul' => $judul,
                            'instansi' => $instansi,
                            'jenis' => $jenis,
                            'no'  => $no,
                            'nama_file' => $data_api['data']['file_name'],
                            'username_created' => $this->session->userdata('username'),
                        );

                        $this->master_model->insert('kerja_sama', $params);
                    } else {
                        $this->session->set_flashdata('gagal', "Gagal Upload File");
                        $this->load->library('user_agent');
                        redirect($this->agent->referrer());
                    }
                } else {
                    // echo 'gagal upload file';
                    // echo  $this->upload->display_errors('<p>', '</p>');
                    $this->session->set_flashdata('gagal', "Gagal Upload File: " . $this->upload->display_errors('<p>', '</p>'));
                    $this->load->library('user_agent');
                    redirect($this->agent->referrer());
                }
            }

            $this->session->set_flashdata('sukses', "Data berhasil ditambahkan");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        } else {
            $data['kerja_sama'] = $this->kerja_sama_model->get_all();
            $data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();

            $this->session->set_flashdata('gagal', "Gagal membuat no kerja_sama");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        $data = null;
        $this->load->vars($data);
        $this->template->load('template/template', 'kerja_sama/list');
    }
    public function edit()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perihal', 'perihal', 'required');
        if ($this->form_validation->run()) {
            $id_kerja_sama = $this->input->post('id_kerja_sama');
            $kerja_sama = $this->master_model->get_id('kerja_sama', 'id_kerja_sama', $id_kerja_sama);
            // 			$kategori= $this->input->post('kategori');
            $sifat = $this->input->post('sifat');
            $no = $this->input->post('no');
            $unit_kerja = $this->input->post('unit_kerja');
            $perihal = $this->input->post('perihal');
            $tujuan = $this->input->post('tujuan');
            $klasifikasi = $this->input->post('klasifikasi');
            $klasifikasi = explode(",", $klasifikasi);
            $kode = $klasifikasi[0];
            $id_klasifikasi = $klasifikasi[1];
            $no_kerja_sama = $sifat . $no . '/' . $unit_kerja . '/' . $kode . '/' . $kerja_sama['bulan'] . '/' . $kerja_sama['tahun'];

            $params = array(
                'unit_kerja' => $unit_kerja,
                'perihal' => $perihal,
                'tujuan' => $tujuan,
                'awalan' => $sifat,
                'kode'  => $klasifikasi[0],
                'id_klasifikasi'  => $klasifikasi[1],
                'no_kerja_sama' => $no_kerja_sama,
            );
            $this->master_model->update('kerja_sama', 'id_kerja_sama', $id_kerja_sama, $params);

            $this->session->set_flashdata('sukses', "Data berhasil diupdate");
            $this->session->set_flashdata('no_kerja_sama_baru', $no_kerja_sama);
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        } else {
            $data['kerja_sama'] = $this->kerja_sama_model->get_all();
            $data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();

            $this->session->set_flashdata('gagal', "Gagal membuat no kerja_sama");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        $data = null;
        $this->load->vars($data);
        $this->template->load('template/template', 'kerja_sama/list');
    }

    public function hapus($id_kerja_sama)
    {
        $this->master_model->delete('kerja_sama', 'id', $id_kerja_sama);
        $this->session->set_flashdata('sukses', "Data berhasil dihapus");
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }

    public function download($id_surat, $file_name)
    {

        //load the download helper
        $this->load->helper('download');


        //$this->transaksi_model->update_read($id_transaksi);

        // 		header("Content-Type:  application/pdf ");
        // 		force_download("upload_file/surat/" . $file_surat, NULL);

        $folder = 'kerja_sama';
        $api_url = 'http://sipadu.bpsaceh.com/api/downloadFile/' . $folder . '/' . $file_name;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $file_data = curl_exec($ch);
        curl_close($ch);

        if ($file_data) {
            // Mendapatkan ekstensi file dari nama file
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

            // Mengirim file ke browser
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"$file_name\"");
            echo $file_data;
        } else {
            $this->session->set_flashdata('gagal', "Gagal mengunduh file.");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }
    }
}
