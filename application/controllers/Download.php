<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Download extends CI_Controller
{
    private $token_ = "_{ptZD^ei_u=ZFyV9Y|j_v1VOYXLPB|7}gTBl^hEP4vx}hpk-ichsan";
    private $DEVICE_ID = "iphone";


    public function __construct()
    {
        parent::__construct();

        $this->load->model('surat_masuk_model');
        $this->load->model('master_model');
        $this->load->model('pegawai_model');
        $this->load->model('tim_model');
    }



    public function surat_masuk($file_surat)
    {
        //load the download helper
        $this->load->helper('download');
        // $params = array(
        //     'id_surat' => $id_surat,
        //     'username' => $this->session->userdata('username')
        // );
        // $this->surat_model->add_download($params);
        //$this->transaksi_model->update_read($id_transaksi);

        header("Content-Type:  application/pdf ");
        force_download("upload_file/surat_masuk/" . $file_surat, NULL);
    }
    
    public function surat_keluarxxx($file_surat)
    {

        //load the download helper
        // 		$this->load->helper('download');
        $file_name = $file_surat;

        //$this->transaksi_model->update_read($id_transaksi);

        // 		header("Content-Type:  application/pdf ");
        // 		force_download("upload_file/surat/" . $file_surat, NULL);

        $folder = 'surat';
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
    public function surat_keluar($file_surat)
    {

        //load the download helper
        // 		$this->load->helper('download');
        $file_name = $file_surat;

        //$this->transaksi_model->update_read($id_transaksi);

        // 		header("Content-Type:  application/pdf ");
        // 		force_download("upload_file/surat/" . $file_surat, NULL);

        header("Content-Type:  application/pdf ");
        force_download("upload_file/surat/" . $file_surat, NULL);
    }
}
