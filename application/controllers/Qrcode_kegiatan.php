<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qrcode_kegiatan extends CI_Controller
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
        $data['kegiatan'] = $this->master_model->get_all_last("qrcode");
        $data['judul'] = 'QR';
        $this->load->vars($data);
        $this->template->load('template/template', 'qrcode_kegiatan/lihat');
    }
    public function tambah()
    {
        $qrcode = $this->input->post('qrcode');
        $kegiatan = $this->input->post('kegiatan');
        $tanggal = $this->input->post('tanggal');
        $random = $this->random_str(8);


        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assetsQR/'; //string, the default is application/cache/
        $config['errorlog']     = './assetsQR/'; //string, the default is application/logs/
        $config['imagedir']     = './assetsQR/images/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = $random . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = $random; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 100;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        $data_insert = array(
            'qrcode'               => $random,
            'tanggal'              => $tanggal,
            'kegiatan'             => $kegiatan,
            'username'             => $this->session->userdata('username'),
            'nama_gambar'          => $image_name,
            'aktif'                => 1

        );
        $this->master_model->insert('qrcode', $data_insert); //simpan ke database
        $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");
        redirect('qrcode_kegiatan'); //redirect ke mahasiswa usai simpan data
    }

    public function buat_qr($kegiatan, $tanggal)
    {

        $random = $this->random_str(8);

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assetsQR/'; //string, the default is application/cache/
        $config['errorlog']     = './assetsQR/'; //string, the default is application/logs/
        $config['imagedir']     = './assetsQR/images/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name = $random . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = $random; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 100;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        $data_insert = array(
            'qrcode'               => $random,
            'tanggal'              => $tanggal,
            'kegiatan'             => $kegiatan,
            'username'             => $this->session->userdata('username'),
            'nama_gambar'          => $image_name,
            'aktif'                => 1

        );
        $this->master_model->insert('qrcode', $data_insert); //simpan ke database
        if ($this->db->affected_rows() > 0) {

            return $random;
        } else {
            return FALSE;
        }


        // $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");
        // redirect('qrcode_kegiatan'); //redirect ke mahasiswa usai simpan data
    }

    function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public function download($nama_gambar)
    {
        $this->load->helper('download');
        // $this->load->helper(array('download'));
        force_download('./assetsQR/images/' . $nama_gambar, NULL);
    }
}
