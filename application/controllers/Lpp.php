<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller lpp
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 *
 */

class Lpp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }


        $cek = $this->db->select('*')->from("user_lpp")->where('username', $this->session->userdata('username'))->get()->row_array();
        if (!empty($cek) || $this->session->userdata('admin_lpp') == 1) {
        } else {
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }
        $this->load->model('rincian_gaji_model');
        $this->load->model('lpp_model');
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
        $data['isi_lpp'] = $this->lpp_model->get_isi_all_bulan($bulan, $tahun, $this->session->userdata('username'));
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        // print_r($data);
        $this->load->vars($data);
        $this->template->load('template/template', 'lpp/list');
    }
    public function pdf()
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
        
        $namaBulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        $bulanIndonesia = $namaBulan[$bulan];
        $data['isi_lpp'] = $this->lpp_model->get_isi_all_bulan($bulan, $tahun, $this->session->userdata('username'));
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['minggu_lpp'] =  $this->lpp_model->get_minggu_lpp($bulan, $tahun, $this->session->userdata('username'));
        $data['bulanIndonesia'] = $bulanIndonesia;
        $data['tanggal'] = $this->tanggal_indonesia(date('Y-m-d'));
        $data['satker'] = $this->master_model->get_id('master_satker', 'kode_satker', $this->session->userdata('kode_satker'));
        
        
        // $this->load->vars($data);
        // $this->template->load('template/template', 'lpp/pdf');
        // $this->load->view('lpp/pdf',$data);
        
        $this->load->helper('pdf');
        $html = $this->load->view('lpp/pdf', $data, true);

        // Generate PDF
        generate_pdf($html, 'example', 'A4', 'portrait');
    }
    public function list_lpp()
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
        $data['list_lpp'] = $this->lpp_model->get_all_bulan($bulan, $tahun);
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        // print_r($data);
        $this->load->vars($data);
        $this->template->load('template/template', 'lpp/list_lpp');
    }

    function weekOfMonth($date)
    {
        //Get the first day of the month.
        $firstOfMonth = strtotime(date("Y-m-01", $date));
        //Apply above formula.
        return $this->weekOfYear($date) - $this->weekOfYear($firstOfMonth) + 1;
    }

    function weekOfYear($date)
    {
        $weekOfYear = intval(date("W", $date));
        if (date('n', $date) == "1" && $weekOfYear > 51) {
            // It's the last week of the previos year.
            return 0;
        } else if (date('n', $date) == "12" && $weekOfYear == 1) {
            // It's the first week of the next year.
            return 53;
        } else {
            // It's a "normal" week.
            return $weekOfYear;
        }
    }

    function tanggal_indonesia($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    public function tambah() // fungsi ini digunakan untuk menambahkan aktivitas
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pekerjaan[]', 'pekerjaan', 'required');

        if ($this->form_validation->run()) {
            $id_lpp = $this->input->post('id_lpp');
            $username = $this->session->userdata('username');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            if (empty($id_lpp)) {
                $params_lpp = array(
                    'username' => $username,
                    'bulan' => $bulan,
                    'tahun' => $tahun
                );
                $id_lpp = $this->master_model->insert("lpp", $params_lpp);
            }

            $pekerjaan = $this->input->post('pekerjaan');
            $output = $this->input->post('output');
            $tanggal = $this->input->post('tanggal');
            $jam_mulai = $this->input->post('jam_mulai');
            $jam_selesai = $this->input->post('jam_selesai');
            $id_jenis_pekerjaan = $this->input->post('id_jenis_pekerjaan');

            foreach ($pekerjaan as $key => $value) {
                $minggu = $this->weekOfMonth(strtotime($tanggal[$key]));
                $params_isi_lpp[$key] = array(
                    'id_lpp'              => $id_lpp,
                    'tanggal'             => $tanggal[$key],
                    'jam_mulai'        => $jam_mulai[$key],
                    'jam_selesai'               => $jam_selesai[$key],
                    'id_jenis_pekerjaan'             => $id_jenis_pekerjaan[$key],
                    'pekerjaan'               => $pekerjaan[$key],
                    'output' => $output[$key],
                    'minggu'    => $minggu,
                );
            }
            $this->master_model->insert_batch("isi_lpp", $params_isi_lpp);
            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('gagal', $this->upload->display_errors());
        }
    }

    public function Upload()
    {
        $id_lpp = $this->input->post('id_lpp');
        $this->load->library('upload');

        $config['upload_path'] = './upload_file/lpp/'; //path folder
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '10000'; //maksimum besar file 2M

        $this->upload->initialize($config);

        // $files = $_FILES['template'];
        // $this->upload->do_upload('template');

        if ($this->upload->do_upload('file_lpp')) {
            $gbr[] = $this->upload->data();
            $nama_file = $gbr['0']['file_name'];
            $file_path = $gbr['0']['full_path'];
            // print_r($gbr);
        } else {
            echo 'gagal upload file';
            echo  $this->upload->display_errors('<p>', '</p>');
            $this->session->set_flashdata('gagal', "Gagal Upload Laporan: " . $this->upload->display_errors('<p>', '</p>'));
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
            //return false;
        }
        // Panggil API untuk mengunggah file
        $api_url = 'http://sipadu.bpsaceh.com/api/uploadFile';
        $post_data = array(
            'file' => new CURLFile($file_path),
            'folder' => 'lpp'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        // print_r($data);

        // Tampilkan respon dari API
        // echo $response;
        if ($response['status']) {
            $params = array(
                'nama_file' => $data['data']['file_name'],
                'tanggal_upload' => date('Y-m-d H:i:s'),
            );
            $update = $this->lpp_model->update($id_lpp, $params);
        } else {
            $this->session->set_flashdata('gagal', "Gagal Upload lpp");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        if ($update['error']) { //jika gagal
            $this->session->set_flashdata('gagal', "Gagal Upload lpp");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('sukses', "Berhasil Upload lpp");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }
    }

    public function download($file_name)
    {
        $folder = 'lpp';
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
    public function lihat($id_lpp)
    {
        $data['peserta_lpp_eksternal'] = $this->lpp_model->peserta_lpp_eksternal_id_lpp($id_lpp);
        $data['peserta_lpp'] = $this->lpp_model->peserta_lpp_id_lpp($id_lpp);
        $data['detail_lpp'] = $this->lpp_model->get_id($id_lpp);
        $data['dokumentasi_lpp'] = $this->lpp_model->dokumentasi_lpp_id_lpp($id_lpp);
        $this->load->vars($data);
        $this->template->load('template/template', 'lpp/lihat');
    }

    public function kirim_undangan($id_lpp)
    {
        $penerima = $this->lpp_model->peserta_lpp_id_lpp($id_lpp);
        $lpp = $this->lpp_model->get_id($id_lpp);
        foreach ($penerima as $key => $value) {
            $mulai = substr($lpp['pukul'], 0, 5);
            $selesai = substr($lpp['selesai'], 0, 5);
            $param = [
                "pesan" => "*Undangan lpp*

Yth. $value[nama_pegawai] 
Dengan ini saudara/i diundang untuk mengikuti lpp dengan

Topik : $lpp[topik]
Tanggal : $lpp[tanggal]
Waktu : $mulai s.d $selesai WIB
Tempat : $lpp[nama_ruangan]
Narahubung : $lpp[notulis]

Demikian untuk dilaksanakan, atas perhatian dan kerjasamanya diucapkan terima kasih
",
                "no_wa" => $value["no_wa"],
            ];
            //   print_r($param);
            //   echo "<br>";
            $this->send($param);
        }
    }
    public function send($params)
    {
        try {
            $dataSending = array();
            $dataSending["api_key"] = "59N5INDJF6I683Z4";
            $dataSending["number_key"] = "W4VNFb2ffPlQihxt";
            $dataSending["phone_no"] = $params["no_wa"];
            $dataSending["message"] = $params["pesan"];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($dataSending),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: alppication/json'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            // echo $response;
            $response = json_decode($response);
            $insert_params = [

                "status" => $response->status,
                "message" => $response->message,
                "worker_by" => $response->worker_by,
                "ack" => $response->ack,

            ];
            $this->master_model->insert("status_watzap", $insert_params);
        } catch (Exception $e) {
            print_r($e);
        }
    }
    function apiKirimWaRequest($params)
    {
        $curl = curl_init();
        $token = $this->token_;
        $method = $params["method"] ?? "GET";
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token",
            "Content-Type:alppication/json",
        ]);

        curl_setopt($curl, CURLOPT_URL, $params["url"]);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params["payload"]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        // 		echo $result;
        return $result;
    }
}


/* End of file lpp.php */
/* Location: ./alppication/controllers/lpp.php */