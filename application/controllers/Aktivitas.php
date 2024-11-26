<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aktivitas extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }

        $this->load->model('master_model');
        $this->load->model('aktivitas_model');
        $this->load->model('pegawai_model');
        $this->load->model('indikator_pk_model');
        $this->load->model('mood_model');
        $this->load->model('projek_model');
        $this->load->model('quote_model');
    }
    
    public function tambah() // fungsi ini digunakan untuk menambahkan aktivitas
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('aktivitas', 'aktivitas', 'required');


        if ($this->form_validation->run()) {
            
            $aktivitas = $this->input->post('aktivitas');
            $status_kerja = $this->input->post('status_kerja');
            $id_pk  = (!empty($this->input->post('id_pk'))) ? $this->input->post('id_pk') : null;
            $id_projek = (!empty($this->input->post('id_projek'))) ? $this->input->post('id_projek') : null;
            
            if (!empty($this->input->post('penugasan'))) {
                $username_peserta = $this->input->post('username_peserta2');
                if(!empty($username_peserta)){
                    if (isset($username_peserta)) {
                        $username2 = explode(" ", $username_peserta);
                    };
                };
                $username_pemberi_aktivitas =$this->session->userdata('username');
            } else {
                $username2 = $this->session->userdata('username');
                $username_pemberi_aktivitas = NULL;
            }
            
            if (!empty($this->input->post('range'))) {
                  $dateTimeRange = $this->input->post('range');
                  // Memisahkan tanggal dan waktu mulai serta tanggal dan waktu selesai
                  // Memecah tanggal mulai dan selesai
                  list($startDateTime, $endDateTime) = explode(" - ", $dateTimeRange);
                //   print_r($startDateTime) ;
                //   print_r($endDateTime) ;
                //   exit;
            
                  // Konversi format tanggal ke format yang sesuai untuk database
                  $startDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $startDateTime);
                  $endDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $endDateTime);
                  
                  // Mendapatkan tanggal mulai dan selesai
                  $startDate = $startDateTimeObj->format('Y-m-d');
                  $endDate = $endDateTimeObj->format('Y-m-d');
            
                  // Mendapatkan jam mulai dan selesai
                  $startTime = $startDateTimeObj->format('H:i:s');
                  $endTime = $endDateTimeObj->format('H:i:s');
                  // Mendapatkan tanggal dan waktu dalam format yang diinginkan
                  $tanggal = $startDate;
                  $pukul = $startTime;
                  $tanggal_selesai = $endDate;
                  $selesai = $endTime;
                  if (is_array($username2)) {
                        foreach ($username2 as $username){
                             $params = array(
                                'username'              => $username,
                                'aktivitas'             => $aktivitas,
                                'status_kerja'          => $status_kerja,
                                'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                                'tanggal'               => $tanggal,
                                'id_pk'                 => $id_pk,
                                'id_projek'               => $id_projek,
                                'pukul'                 => $pukul,
                                'tanggal_selesai'      => $tanggal_selesai,
                                'selesai'                 => $selesai,
                            );
                            $this->master_model->insert("aktivitas", $params);
                         };
                    } else {
                        
                        $params = array(
                            'username'              => $username2,
                            'aktivitas'             => $aktivitas,
                            'status_kerja'          => $status_kerja,
                            'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                            'tanggal'               => $tanggal,
                            'id_pk'                 => $id_pk,
                            'id_projek'               => $id_projek,
                            'pukul'                 => $pukul,
                            'tanggal_selesai'      => $tanggal_selesai,
                            'selesai'                 => $selesai,
                        );
                        $this->master_model->insert("aktivitas", $params);
                    };
            } else {
                    print_r($username2);
                    $tanggal = date("Y-m-d");
                    $selesai = date("Y-m-d");
                    foreach ($username2 as $username){
                        $params = array(
                        'username'              => $username,
                        'aktivitas'             => $aktivitas,
                        'status_kerja'          => $status_kerja,
                        'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                        'tanggal'               => $tanggal,
                        'id_pk'                 => $id_pk,
                        'id_projek'               => $id_projek,
                        'tanggal_selesai' => $selesai
        
                    );
                    $this->master_model->insert("aktivitas", $params);
                    };
                    
            }
            
            // if (!empty($this->input->post('tanggal'))) {
            //     $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
            // } else {
            //     $tanggal = date("Y-m-d");
            // }

            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

            redirect('aktivitas/tambah2');
        } else {

            $data['pegawai'] = $this->pegawai_model->get_all_pegawai();
            $data['projek'] = $this->projek_model->get_all();
            $data['indikator_pk'] = $this->indikator_pk_model->get_all_aktif();
            $data['pk'] = $this->master_model->get_all('pk');
            $data['judul'] = 'Kegiatan';
            $this->load->vars($data);
            $this->template->load('template/template', 'aktivitas/tambah_aktivitas_2');
        }
    }
    
    public function tambah2() // fungsi ini digunakan untuk menambahkan aktivitas
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('aktivitas', 'aktivitas', 'required');


        if ($this->form_validation->run()) {
            
            $aktivitas = $this->input->post('aktivitas');
            $status_kerja = $this->input->post('status_kerja');
            $id_pk  = (!empty($this->input->post('id_pk'))) ? $this->input->post('id_pk') : null;
            $id_projek = (!empty($this->input->post('id_projek'))) ? $this->input->post('id_projek') : null;
            
            if (!empty($this->input->post('penugasan'))) {
                $username_peserta = $this->input->post('username_peserta2');
                if(!empty($username_peserta)){
                    if (isset($username_peserta)) {
                        $username2 = explode(" ", $username_peserta);
                    };
                };
                $username_pemberi_aktivitas =$this->session->userdata('username');
            } else {
                $username2 = $this->session->userdata('username');
                $username_pemberi_aktivitas = NULL;
            }
            
            if (!empty($this->input->post('range'))) {
                  $dateTimeRange = $this->input->post('range');
                  // Memisahkan tanggal dan waktu mulai serta tanggal dan waktu selesai
                  // Memecah tanggal mulai dan selesai
                  list($startDateTime, $endDateTime) = explode(" - ", $dateTimeRange);
                //   print_r($startDateTime) ;
                //   print_r($endDateTime) ;
                //   exit;
            
                  // Konversi format tanggal ke format yang sesuai untuk database
                  $startDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $startDateTime);
                  $endDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $endDateTime);
                  
                  // Mendapatkan tanggal mulai dan selesai
                  $startDate = $startDateTimeObj->format('Y-m-d');
                  $endDate = $endDateTimeObj->format('Y-m-d');
            
                  // Mendapatkan jam mulai dan selesai
                  $startTime = $startDateTimeObj->format('H:i:s');
                  $endTime = $endDateTimeObj->format('H:i:s');
                  // Mendapatkan tanggal dan waktu dalam format yang diinginkan
                  $tanggal = $startDate;
                  $pukul = $startTime;
                  $tanggal_selesai = $endDate;
                  $selesai = $endTime;
                  if (is_array($username2)) {
                        foreach ($username2 as $username){
                             $params = array(
                                'username'              => $username,
                                'aktivitas'             => $aktivitas,
                                'status_kerja'          => $status_kerja,
                                'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                                'tanggal'               => $tanggal,
                                'id_pk'                 => $id_pk,
                                'id_projek'               => $id_projek,
                                'pukul'                 => $pukul,
                                'tanggal_selesai'      => $tanggal_selesai,
                                'selesai'                 => $selesai,
                            );
                            $this->master_model->insert("aktivitas", $params);
                         };
                    } else {
                        
                        $params = array(
                            'username'              => $username2,
                            'aktivitas'             => $aktivitas,
                            'status_kerja'          => $status_kerja,
                            'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                            'tanggal'               => $tanggal,
                            'id_pk'                 => $id_pk,
                            'id_projek'               => $id_projek,
                            'pukul'                 => $pukul,
                            'tanggal_selesai'      => $tanggal_selesai,
                            'selesai'                 => $selesai,
                        );
                        $this->master_model->insert("aktivitas", $params);
                    };
            } else {
                    print_r($username2);
                    $tanggal = date("Y-m-d");
                    $selesai = date("Y-m-d");
                    foreach ($username2 as $username){
                        $params = array(
                        'username'              => $username,
                        'aktivitas'             => $aktivitas,
                        'status_kerja'          => $status_kerja,
                        'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                        'tanggal'               => $tanggal,
                        'id_pk'                 => $id_pk,
                        'id_projek'               => $id_projek,
                        'tanggal_selesai' => $selesai
        
                    );
                    $this->master_model->insert("aktivitas", $params);
                    };
                    
            }
            
            // if (!empty($this->input->post('tanggal'))) {
            //     $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
            // } else {
            //     $tanggal = date("Y-m-d");
            // }

            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

            redirect('aktivitas/tambah2');
        } else {

            $data['pegawai'] = $this->pegawai_model->get_all_pegawai();
            $data['projek'] = $this->projek_model->get_all();
            $data['indikator_pk'] = $this->indikator_pk_model->get_all_aktif();
            $data['pk'] = $this->master_model->get_all('pk');
            $data['judul'] = 'Kegiatan';
            $this->load->vars($data);
            $this->template->load('template/template', 'aktivitas/tambah_aktivitas_2');
        }
    }

    function lihat($bulan = '', $tahun = '')
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
        $data['aktivitas'] = $this->aktivitas_model->get_all_bulan($bulan, $tahun);
        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;
        $data['judul'] = 'Kegiatan';
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas');
    }

    function lihat444()
    {
        $data['aktivitas'] = $this->aktivitas_model->get_all();
        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;

        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas');
    }
    function sendiri444()
    {
        $data['aktivitas'] = $this->aktivitas_model->get_sendiri();

        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;
        $data['judul'] = 'Kegiatan';
        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas');
    }

    function sendiri($bulan = '', $tahun = '')
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

        // exit;        
        $data['aktivitas'] = $this->aktivitas_model->get_sendiri_bulan($bulan, $tahun);

        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['judul'] = 'Kegiatan';
        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas_sendiri');
    }
    
    function home($bulan = '', $tahun = '')
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
        
        // // Load the cURL library
        // $this->load->library('curl');

        // // Set the URL
        // $url = 'https://quran-api-id.vercel.app/random';

        // // Initialize cURL
        // $this->curl->create($url);

        // // Execute the cURL request
        // $json_data = $this->curl->execute();

        // // Decode the JSON response
        // $data['quran_verse'] = json_decode($json_data, true);
        
        // persiapkan curl
        $ch = curl_init(); 
    
        // set url 
        curl_setopt($ch, CURLOPT_URL, "https://quran-api-id.vercel.app/random");
    
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    
        // $output contains the output string 
        $output = curl_exec($ch); 
    
        // tutup curl 
        curl_close($ch);      
    
        // menampilkan hasil curl
        //echo $output;
        // print_r($output);
        $data['quran_verse'] = json_decode($output, true);
        

        // exit;        
        $data['aktivitas'] = $this->aktivitas_model->get_sendiri_bulan($bulan, $tahun);
        $data['quote'] = $this->quote_model->get_random();
        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $data['rekap_mood'] = $this->master_model->get_id("rekap_mood", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['judul'] = 'Home';
        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/home');
    }
    
    function perorang()
    {
       if ($this->input->post('username') == '') {
            $username = $this->session->userdata('username');
        } else {
            $username = $this->input->post('username');
            // print_r(date('Y-m'));
        }
        $data['aktivitas'] = $this->aktivitas_model->get_perorang($username);

        $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
        $data['judul'] = 'Kegiatan';
        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas_perorang');
    }

    function selesai()
    {
        $output = $this->input->post('output');
        $id = $this->input->post('id_aktivitas');
        $params = array(
            'tanggal_selesai' => date("Y-m-d"),
            'output'               => $output,
            'status_aktivitas' => "selesai"
        );

        $this->master_model->update("aktivitas", "id", $id, $params);

        $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

        // redirect('aktivitas/lihat');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }
    function hapus()
    {

        $id = $this->input->post('id_aktivitas');


        $this->master_model->delete("aktivitas", "id", $id);

        $this->session->set_flashdata('sukses', "Data yg anda berhasil dihapus");

        // redirect('aktivitas/lihat');
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }
    public function edit($id) // fungsi ini digunakan untuk menambahkan aktivitas
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('aktivitas', 'aktivitas', 'required');

        if ($this->form_validation->run()) {


            if (!empty($this->input->post('penugasan'))) {
                $username = $this->input->post('username');
                $username_pemberi_aktivitas =
                    $this->session->userdata('username');
            } else {
                $username = $this->session->userdata('username');
                $username_pemberi_aktivitas = NULL;
            }

            if (!empty($this->input->post('tanggal'))) {
                $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
            } else {
                $tanggal = date("Y-m-d");
            }

            $aktivitas = $this->input->post('aktivitas');
            // $status_kerja = $this->input->post('status_kerja');

            if (!empty($this->input->post('range'))) {
                  $dateTimeRange = $this->input->post('range');
                  // Memisahkan tanggal dan waktu mulai serta tanggal dan waktu selesai
                  // Memecah tanggal mulai dan selesai
                  list($startDateTime, $endDateTime) = explode(" - ", $dateTimeRange);
                //   print_r($startDateTime) ;
                //   print_r($endDateTime) ;
                //   exit;
            
                  // Konversi format tanggal ke format yang sesuai untuk database
                  $startDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $startDateTime);
                  $endDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $endDateTime);
                  
                  // Mendapatkan tanggal mulai dan selesai
                  $startDate = $startDateTimeObj->format('Y-m-d');
                  $endDate = $endDateTimeObj->format('Y-m-d');
            
                  // Mendapatkan jam mulai dan selesai
                  $startTime = $startDateTimeObj->format('H:i:s');
                  $endTime = $endDateTimeObj->format('H:i:s');
                  // Mendapatkan tanggal dan waktu dalam format yang diinginkan
                  $tanggal = $startDate;
                  $pukul = $startTime;
                  $tanggal_selesai = $endDate;
                  $selesai = $endTime;
                  
                    $params = array(
                        'username'              => $username,
                        'aktivitas'             => $aktivitas,
                        'status_kerja'          => $status_kerja,
                        'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                        'tanggal'               => $tanggal,
                        'id_pk'                 => $id_pk,
                        'id_projek'               => $id_projek,
                        'pukul'                 => $pukul,
                        'tanggal_selesai'      => $tanggal_selesai,
                        'selesai'                 => $selesai,
        
                    );
                    
                    $params = array(
                    'username'              => $username,
                    'aktivitas'             => $aktivitas,
                    // 'status_kerja'          => $status_kerja,
                    'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                    'tanggal'               => $tanggal,
                    'pukul'                 => $pukul,
                    'tanggal_selesai'      => $tanggal_selesai,
                    'selesai'                 => $selesai,
                    
                    );
            } else {
                    $params = array(
                    'username'              => $username,
                    'aktivitas'             => $aktivitas,
                    // 'status_kerja'          => $status_kerja,
                    'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                    
                    );
            }

            

            $this->master_model->update("aktivitas", "id", $id, $params);
            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

            redirect('aktivitas/sendiri');
        } else {

            $data['data'] = $this->master_model->get_id("aktivitas", "id", $id);
            $data['pegawai'] = $this->pegawai_model->get_all_pegawai();
            $this->load->vars($data);
            $this->template->load('template/template', 'aktivitas/edit_aktivitas');
        }
    }

    public function getAktivitasByDateAndUsername()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bulan', 'bulan', 'required');
        $this->form_validation->set_rules('tahun', 'tahun', 'required');
        // $this->form_validation->set_rules('usernames', 'usernames', 'required');


        if ($this->form_validation->run()) {
            $bulan =  $this->input->post('bulan');
            $tahun =  $this->input->post('tahun');
            $usernames = $this->input->post('usernames');
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
            $data['result'] = $this->aktivitas_model->getAktivitasByDateAndUsername($bulan, $tahun, $usernames);
            // print_r($data['result']);
            // exit;
            $data['judul'] = 'Kegiatan';
            $this->load->vars($data);
            $this->template->load('template/template', 'aktivitas/list_by_username');
        } else {

            $bulan = date('m');
            $tahun = date('Y');
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
            $data['result'] = NULL;
            $data['judul'] = 'Kegiatan';
            $this->load->vars($data);
            $this->template->load('template/template', 'aktivitas/list_by_username');
        }
    }
    
    function testing()
    {
        $this->template->load('template/template', 'aktivitas/testing');
    }
    
    public function kirim_peringatan()
    {
        $query = $this->db->query("select nama_pegawai from sipadu_master_pegawai where username not in (select username from sipadu_aktivitas where tanggal = curdate()) and kode_satker = 1100 and status_pegawai = 'PNS'");
        $datas = $query->result_array();
        $list_nama = "";
        foreach ($datas as $data) {
            $list_nama .= "\n" . $data['nama_pegawai'];
        }
        $param = [
				"pesan" => "*[Pengingat Pengisian Kegiatan Harian SIPADU]*
                
Jangan lupa ya untuk mengisi kegiatan hari ini di s.id/sipadu1100
                
Berikut nama yang belum mengisi kegiatan harian :
$list_nama 
                
terima kasih
                ",
				"no_wa" => "6282285993357",
			];
            //print_r($param);
			//echo "<br>";
			$this->send($param);
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
          'Content-Type: application/json'
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      // echo $response;

      $response = json_decode($response);
      //   print_r($response);
      //   exit;

      if (!empty($response->worker_by)) {
        $insert_params = [

          "status" => $response->status,
          "message" => $response->message,
          "worker_by" => $response->worker_by,
          "ack" => $response->ack,
          "no_wa" => $params['no_wa'],
          "ket" => "undangan event"

        ];
        $update_params = [

          "notif_wa" => 1,
          "message" => $response->message,

        ];
        $data_pk = [
          "no_wa" => $params['no_wa'],
          "id_rapat" => $params['id_rapat'],
        ];
        
        $this->master_model->update_array_biasa('peserta_rapat', $data_pk, $update_params);
        $this->master_model->insert("status_watzap", $insert_params);
      } else {
        $this->session->set_flashdata('gagal', "Data yg anda masukan berhasil tetapi tidak berhasil kirim notif WA, silahkan hubungi admin $response->message");
        redirect('event/list');
      }
    } catch (Exception $e) {
    //   print_r($e);
    }
  }
  
  
  //SUPER INPUT
  public function input() // fungsi ini digunakan untuk menambahkan aktivitas
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('aktivitas', 'aktivitas', 'required');
        
        if ($this->form_validation->run()) {
            
            $aktivitas = $this->input->post('aktivitas');
            $status_kerja = $this->input->post('status_kerja');
            $id_pk  = (!empty($this->input->post('id_pk'))) ? $this->input->post('id_pk') : null;
            $id_projek = (!empty($this->input->post('id_projek'))) ? $this->input->post('id_projek') : null;
            
            if (!empty($this->input->post('penugasan'))) {
                $username = $this->input->post('username');
                $username_pemberi_aktivitas =
                    $this->session->userdata('username');
            } else {
                $username = $this->session->userdata('username');
                $username_pemberi_aktivitas = NULL;
            }
            
            if (!empty($this->input->post('range'))) {
                  $dateTimeRange = $this->input->post('range');
                  // Memisahkan tanggal dan waktu mulai serta tanggal dan waktu selesai
                  // Memecah tanggal mulai dan selesai
                  list($startDateTime, $endDateTime) = explode(" - ", $dateTimeRange);
                //   print_r($startDateTime) ;
                //   print_r($endDateTime) ;
                //   exit;
            
                  // Konversi format tanggal ke format yang sesuai untuk database
                  $startDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $startDateTime);
                  $endDateTimeObj = DateTime::createFromFormat('d-m-Y H:i', $endDateTime);
                  
                  // Mendapatkan tanggal mulai dan selesai
                  $startDate = $startDateTimeObj->format('Y-m-d');
                  $endDate = $endDateTimeObj->format('Y-m-d');
            
                  // Mendapatkan jam mulai dan selesai
                  $startTime = $startDateTimeObj->format('H:i:s');
                  $endTime = $endDateTimeObj->format('H:i:s');
                  // Mendapatkan tanggal dan waktu dalam format yang diinginkan
                  $tanggal = $startDate;
                  $pukul = $startTime;
                  $tanggal_selesai = $endDate;
                  $selesai = $endTime;
                  
                    $params = array(
                        'username'              => $username,
                        'aktivitas'             => $aktivitas,
                        'status_kerja'          => $status_kerja,
                        'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                        'tanggal'               => $tanggal,
                        'id_pk'                 => $id_pk,
                        'id_projek'               => $id_projek,
                        'pukul'                 => $pukul,
                        'tanggal_selesai'      => $tanggal_selesai,
                        'selesai'                 => $selesai,
        
                    );
            } else {
                    $tanggal = date("Y-m-d");
                    $selesai = date("Y-m-d");
                    
                    $params = array(
                        'username'              => $username,
                        'aktivitas'             => $aktivitas,
                        'status_kerja'          => $status_kerja,
                        'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                        'tanggal'               => $tanggal,
                        'id_pk'                 => $id_pk,
                        'id_projek'               => $id_projek,
                        'tanggal_selesai' => $selesai
        
                    );
            }
            
            // if (!empty($this->input->post('tanggal'))) {
            //     $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
            // } else {
            //     $tanggal = date("Y-m-d");
            // }
            $this->master_model->insert("aktivitas", $params);

            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

            redirect('aktivitas/input');
        } else {

            $data['pegawai'] = $this->pegawai_model->get_all_pegawai();
            $data['projek'] = $this->projek_model->get_all();
            $data['indikator_pk'] = $this->indikator_pk_model->get_all_aktif();
            $data['pk'] = $this->master_model->get_all('pk');
            $data['judul'] = 'Kegiatan';
            $this->load->vars($data);
            $this->template->load('template/template', 'aktivitas/super_input');
        }
    }
  
  
  
}
