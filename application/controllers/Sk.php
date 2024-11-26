<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Sk extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
        $this->load->model('sk_model');
        $this->load->model('master_model');
        $this->load->model('pegawai_model');
    }

    public function index()
    {
        $data['sk'] = $this->sk_model->get_all();
        $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
        // $data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();
        $data['judul'] = 'SK';
        $this->load->vars($data);
        $this->template->load('template/template', 'sk/list');
    }

    public function tambah_sk()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul', 'judul', 'required');
        if ($this->form_validation->run()) {

            // 			$kategori= $this->input->post('kategori');
            $judul = $this->input->post('judul');
            $instansi = $this->input->post('instansi');
            $no = $this->input->post('no');
            $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
            $sifat = $this->input->post('sifat');
            $username = $this->input->post('username');
            $unit_kerja = '1100'; // sementara hanya yang dimasukan di unit kerja provinsi


            $config['upload_path']          = './upload_file/sk/';
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
                    
                    $params = array(
                            'unit_kerja' => $unit_kerja,
                            'tanggal' => $tanggal,
                            'judul' => $judul,
                            'username' => $username,
                            'sifat' => $sifat,
                            'no'  => $no,
                            'nama_file' => $uploadData['file_name'],
                            'username_created' => $this->session->userdata('username'),
                        );

                        $this->master_model->insert('sk', $params);
                   
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
            $data['sk'] = $this->sk_model->get_all();
            $data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();

            $this->session->set_flashdata('gagal', "Gagal membuat no sk");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        $data = null;
        $data['judul'] = 'SK';
        $this->load->vars($data);
        $this->template->load('template/template', 'sk/list');
    }
    public function edit()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perihal', 'perihal', 'required');
        if ($this->form_validation->run()) {
            $id_sk = $this->input->post('id_sk');
            $sk = $this->master_model->get_id('sk', 'id_sk', $id_sk);
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
            $no_sk = $sifat . $no . '/' . $unit_kerja . '/' . $kode . '/' . $sk['bulan'] . '/' . $sk['tahun'];

            $params = array(
                'unit_kerja' => $unit_kerja,
                'perihal' => $perihal,
                'tujuan' => $tujuan,
                'awalan' => $sifat,
                'kode'  => $klasifikasi[0],
                'id_klasifikasi'  => $klasifikasi[1],
                'no_sk' => $no_sk,
            );
            $this->master_model->update('sk', 'id_sk', $id_sk, $params);

            $this->session->set_flashdata('sukses', "Data berhasil diupdate");
            $this->session->set_flashdata('no_sk_baru', $no_sk);
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        } else {
            $data['sk'] = $this->sk_model->get_all();
            $data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();

            $this->session->set_flashdata('gagal', "Gagal membuat no sk");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        $data = null;
        $data['judul'] = 'SK';
        $this->load->vars($data);
        $this->template->load('template/template', 'sk/list');
    }

    public function hapus($id_sk)
    {
        $this->master_model->delete('sk', 'id', $id_sk);
        $this->session->set_flashdata('sukses', "Data berhasil dihapus");
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }

    public function download($id_surat, $file_name)
    {

        //load the download helper
        $this->load->helper('download');

		header("Content-Type:  application/pdf ");
		force_download("upload_file/sk/" . $file_name, NULL);

    }
    public function tambah_sk333()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul', 'judul', 'required');
        if ($this->form_validation->run()) {

            // 			$kategori= $this->input->post('kategori');
            $judul = $this->input->post('judul');
            $instansi = $this->input->post('instansi');
            $no = $this->input->post('no');
            $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
            $sifat = $this->input->post('sifat');
            $username = $this->input->post('username');
            $unit_kerja = '1100'; // sementara hanya yang dimasukan di unit kerja provinsi


            $config['upload_path']          = './upload_file/sk/';
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
                        'folder' => 'sk'
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
                            'username' => $username,
                            'sifat' => $sifat,
                            'no'  => $no,
                            'nama_file' => $data_api['data']['file_name'],
                            'username_created' => $this->session->userdata('username'),
                        );

                        $this->master_model->insert('sk', $params);
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
            $data['sk'] = $this->sk_model->get_all();
            $data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();

            $this->session->set_flashdata('gagal', "Gagal membuat no sk");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        $data = null;
        $data['judul'] = 'SK';
        $this->load->vars($data);
        $this->template->load('template/template', 'sk/list');
    }
}
