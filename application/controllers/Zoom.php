<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/coba zoom/api_zoom.php';
require_once APPPATH . 'libraries/api_watzap.php';

class Zoom extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
        $this->load->model('login_model');
        $this->load->model('master_model');
        $this->load->model('zoom_meeting_model');
        $this->load->model('admin_model');
        // $this->tele['secret_token'] = '2043978587:AAHHT-opLzlXuLGlt5U2oqXO2u-fbQ58YIU';
    }

    public function index()
    {
        // $data['zoom'] = $this->zoom_meeting_model->get_username($this->session->userdata('username'));
        $data['zoom'] = $this->zoom_meeting_model->get_all();
        $data['judul'] = 'Zoom';
        $this->load->vars($data);
        $this->template->load('template/template', 'zoom/list');
    }
    public function list()
    {
        $data['judul'] = 'Kegiatan';
        $data['zoom'] = $this->zoom_meeting_model->get_all();
        $this->load->vars($data);
        $this->template->load('template/template', 'zoom/list');
    }


    function batal()
    {
        $id = $this->input->post('id');
        $data = $this->zoom_meeting_model->get_id($id);
        $result = deleteMeeting($data);

        $tanggal = date('Y-m-d', strtotime($data['start_date']));
        $jam = substr($this->input->post('time'), 0, 2);
        $menit = substr($this->input->post('time'), 3, 2);
        $tgl_indo = $this->tgl_indo($tanggal);
        $waktu = $jam . ":" . $menit;
        $insert_params = $this->kirim_wa_pembatalan($data['nama_pegawai'], $data['no_wa'], $tgl_indo, $waktu, $result['id'], $data['password_zoom'], $data['topik']);
        $this->master_model->insert("status_watzap", $insert_params);

        $arr['id_zoom'] = null;
        $arr['start_url'] = null;
        $arr['join_url'] = null;
        $arr['status'] = "99";

        $this->master_model->update('zoom_meeting', 'id', $id, $arr);

        // $this->master_model->insert('detail_email', $params);
        $this->session->set_flashdata('sukses', "Data yg anda batalkan berhasil");
        redirect('zoom/list');
    }

    public function buat()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('topik', 'topik', 'required');
        $this->form_validation->set_rules('date', 'date', 'required');

        if ($this->form_validation->run()) {

            $start = strtotime($this->input->post('start_time'));
            $end = strtotime($this->input->post('end_time'));
            $duration = ($end - $start) / 60;

            $tanggal = date('Y-m-d', strtotime($this->input->post('date')));
            $jam = substr($this->input->post('start_time'), 0, 2);
            $menit = substr($this->input->post('start_time'), 3, 2);
            $start_date = $tanggal . " " . $jam . ":" . $menit;

            $jam_selesai = substr($this->input->post('end_time'), 0, 2);
            $menit_selesai = substr($this->input->post('end_time'), 3, 2);
            $end_date = $tanggal . " " . $jam_selesai . ":" . $menit_selesai;

            $arr['topic'] = $this->input->post('topik');
            $arr['start_date'] = date($start_date);
            $arr['end_date'] = date($end_date);
            $arr['duration'] = $duration;
            $arr['password'] = $this->input->post('password');
            $arr['type'] = '2';
            $arr['username'] = $this->session->userdata('username');
            $arr['target_peserta'] = $this->input->post('target_peserta');
            $arr['peserta'] = $this->input->post('peserta');
            $arr['dibuat'] = "berhasil";
            $arr['status'] = "1"; // pembuatan awal, akan di verifikasi oleh admin


            $tgl_indo = $this->tgl_indo($tanggal);

            $akun_tersedia = $this->zoom_meeting_model->cek_ketersediaan_akun($arr['start_date'], $arr['end_date']);

            if ($akun_tersedia) {
                $arr['id_akun_zoom'] = $akun_tersedia;
                // echo "Akun yang tersedia: " . $akun_tersedia;
            } else {
                // echo "Tidak ada akun yang tersedia saat ini.";
                $this->session->set_flashdata('gagal', "Maaf, pada jam tersebut meeting telah penuh");
                redirect('zoom/list');
            }
            
            

            $duplikat = $this->cekDuplikat($arr['topic'], $arr['start_date']);
            if ($duplikat) {
                $this->session->set_flashdata('gagal', "Meeting sudah ada");
                redirect('zoom/list');
            } else {
                $id = $this->master_model->insert('zoom_meeting', $arr);
            }

            $admin = $this->admin_model->get_aktif();
            foreach ($admin as $key => $value) {
                $no_wa = $value['no_wa'];
                $insert_params = $this->kirim_via_wa($no_wa, $arr['topic'], $value['nama_pegawai'], $value['email'], $tgl_indo, $jam . ":" . $menit, $id, $value['username'], $this->session->userdata('nama_pegawai'), $arr['target_peserta'], $arr['peserta']);
                $this->master_model->insert("status_watzap", $insert_params);
            }

            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

            redirect('zoom/list');
        } else {
            redirect('zoom/list');
        }
    }


    public function kirim_via_wa($no_wa, $topik,  $nama, $tujuan, $tanggal, $waktu, $id, $username, $pemohon, $target_peserta, $peserta)
    {


        $param = [
            "pesan" => '*Notifikasi Ngezoom*
				
Yth ' . $nama . '
di 
Tempat 

Permintaan penggunaan lisensi zoom dengan rincian sebagai berikut:
Pemohon        : ' . $pemohon . '
Topik          : ' . $topik . '
Tanggal        : ' . $tanggal . '
Waktu          : ' . $waktu . ' WIB
Target Peserta : ' . $target_peserta . '
Peserta        : ' . $peserta . '

Jika anda menyutujui permohonan lisensi zoom tersebut silahkan klik link berikut: ' . base_url() . '/adminZoomplmqaz/verifikasiViaWa/' . $username . '/' . $id,

            "no_wa" => $no_wa,
        ];
        //   print_r($param);
        //   echo "<br>";
        return send($param);
    }


    function cekDuplikat($topic, $start_date)
    {
        $this->db->where('topic', $topic)->where('start_date', $start_date);
        $query = $this->db->get('zoom_meeting');
        if ($query->num_rows() > 0) {
            return true; //ada duplikat
        } else {
            return false; // tidak ada duplikat
        }
    }

    //cekSlot ini digunakan untuk mengecek lisensi zoom yang lebih dari 100 (zoom bps aceh)
    function cekSlot($start_date, $duration)
    {
        $tanggal = substr($start_date, 0, 10);
        $jam_mulai = substr($start_date, 11, 5);

        //calcutate jam selesai 
        $jam_selesai = date('H:i', strtotime($jam_mulai . ' + ' . $duration . ' minutes'));

        $this->db->like('start_date', $tanggal)->where('id_akun_zoom', 1)->where('status', 2);
        $query = $this->db->get('zoom_meeting');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            foreach ($data as $key => $value) {
                $start_date_db = $value['start_date'];
                $jam_mulai_db = substr($start_date_db, 11, 5);
                $jam_selesai_db = date('H:i', strtotime($jam_mulai_db . ' + ' . $value['duration'] . ' minutes'));
                // cek jam mulai
                if ($jam_mulai < $jam_mulai_db && $jam_selesai < $jam_mulai_db) {
                    return true; // ada slot kosong
                } elseif ($jam_mulai > $jam_selesai_db) {
                    return true; // ada slot kosong
                } elseif ($jam_mulai >= $jam_mulai_db && $jam_mulai <= $jam_selesai_db) {
                    return false; // tidak ada slot kosong
                }
            }
        } else {
            return true; // ada slot kosong
        }
    }

    //cekSlot_kecil ini digunakan untuk mengecek lisensi zoom yang kurang dari 100 (kasiejarkom)
    function cekSlot_kecil($start_date, $duration)
    {
        $tanggal = substr($start_date, 0, 10);
        $jam_mulai = substr($start_date, 11, 5);

        //calcutate jam selesai 
        $jam_selesai = date('H:i', strtotime($jam_mulai . ' + ' . $duration . ' minutes'));

        $this->db->like('start_date', $tanggal)->where('id_akun_zoom', 2)->where('status', 2);
        $query = $this->db->get('zoom_meeting');
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            // print_r($data);

            foreach ($data as $key => $value) {
                $start_date_db = $value['start_date'];
                $jam_mulai_db = substr($start_date_db, 11, 5);
                $jam_selesai_db = date('H:i', strtotime($jam_mulai_db . ' + ' . $value['duration'] . ' minutes'));

                // echo "jam mulai " . $jam_mulai . '<br>';
                // echo "jam mulai db" . $jam_mulai_db . '<br>';
                // echo "jam selesai db " . $jam_selesai_db . '<br>';
                // echo "jam selesai " . $jam_selesai . '<br>';

                // cek jam mulai
                if ($jam_mulai < $jam_mulai_db && $jam_selesai < $jam_mulai_db) {
                    // echo "true 1" . '<br>';
                    $status = true; // ada slot kosong

                    // return true; // ada slot kosong
                } elseif ($jam_mulai > $jam_selesai_db) {
                    // echo
                    // "true 2" . '<br>';
                    $status = true; // ada slot kosong

                    // return true; // ada slot kosong
                } elseif ($jam_mulai >= $jam_mulai_db && $jam_mulai <= $jam_selesai_db) {
                    // echo
                    // "false 1" . '<br>';
                    $status = false; // tidak slot kosong
                    // return false; // tidak ada slot kosong
                    break;
                }
            }
            // exit();
            return $status;
        } else {
            return true; // ada slot kosong
        }
    }

    public function verifikasi()
    {
        $id = $this->input->post('id');
        $data = $this->zoom_meeting_model->get_id($id);
        if (!empty($data['id_zoom'])) {
            $this->load->view('sukses');
            // exit();
        } else {
            $time = substr($data['start_date'], 11);
            $tanggal = date('Y-m-d', strtotime($data['start_date']));
            $jam = substr($time, 0, 2);
            $jam = $jam - 7;
            $menit = substr($time, 3, 2);
            $start_date = $tanggal . "T" . $jam . ":" . $menit . ':00Z';
            $arr['topic'] = $data['topic'];
            $arr['start_date'] = $start_date; // selisih 7 jam
            $arr['duration'] = $data['duration'];
            $arr['password'] = $data['password_zoom'];
            $arr['type'] = '2';
            $arr['id_akun_zoom'] = $data['id_akun_zoom'];

            $result = createMeeting($arr);
            // if ($arr['id_akun_zoom'] == 1) {
            //     $result = createMeeting($arr);
            // } else {
            //     $result = createMeeting($arr);
            // }

            if (isset($result['id'])) {

                $jam = $jam - 7;
                $start_date = $tanggal . " " . $jam . ":" . $menit;
                // $arr['start_date'] = date($start_date); // selisih 7 jam
                $arr_update['username_verifikasi'] = $this->session->userdata('username');;
                $arr_update['timestamp_verifikasi'] = date('Y-m-d h:i:s');
                $arr_update['id_zoom'] = $result['id'];
                $arr_update['start_url'] = $result['start_url'];
                $arr_update['join_url'] = $result['join_url'];
                $arr_update['dibuat'] = "berhasil";
                $arr_update['status'] = "2";

                $this->master_model->update('zoom_meeting', 'id', $id, $arr_update);

                $tgl_indo = $this->tgl_indo($tanggal);
                $waktu = substr($time, 0, 2) . ":" . $menit;

                if ($data['id_akun_zoom'] == 1) {
                    // $detail_kirim = $this->kirim_email($data['nama_pegawai'], $data['email'], $tgl_indo, $jam . ":" . $menit, $result->join_url, $result->id, $data['password_zoom'], $arr['topic']);
                    $insert_params = $this->setuju_kirim_via_wa1($data['nama_pegawai'], $data['no_wa'], $tgl_indo, $waktu, $result['join_url'], $result['id'], $data['password_zoom'], $arr['topic']);
                    $this->master_model->insert("status_watzap", $insert_params);
                } else if($data['id_akun_zoom'] == 2){
                    $insert_params = $this->setuju_kirim_via_wa2($data['nama_pegawai'], $data['no_wa'], $tgl_indo, $waktu, $result['join_url'], $result['id'], $data['password_zoom'], $arr['topic']);
                    $this->master_model->insert("status_watzap", $insert_params);
                } else if($data['id_akun_zoom'] == 3){
                    $insert_params = $this->setuju_kirim_via_wa3($data['nama_pegawai'], $data['no_wa'], $tgl_indo, $waktu, $result['join_url'], $result['id'], $data['password_zoom'], $arr['topic']);
                    $this->master_model->insert("status_watzap", $insert_params);
                }

                // $this->master_model->insert('detail_email', $params);
            } else {

                // print_r($result);
            }
            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");
            redirect('zoom/list');
            // $this->load->view('sukses');
        }
    }

    function tgl_indo($tanggal)
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

    public function upload_adm()
    {
        $id = $this->input->post('id');
        $this->load->library('upload');

        $config['upload_path'] = './upload_file/adm/'; //path folder
        $config['allowed_types'] = 'rar|pdf|zip'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '500000'; //maksimum besar file 2M

        $this->upload->initialize($config);

        if (!empty($_FILES['file']['name'])) {
            if ($this->upload->do_upload('file')) {
                $gbr = $this->upload->data();
                $params['file_adm'] = $gbr['file_name'];
                $params['timestamp_file_adm'] = date('Y-m-d h:i:s');
                $this->master_model->update('meeting', 'id', $id, $params);

                $this->session->set_flashdata('sukses', "File yg anda upload berhasil");
                $this->load->library('user_agent');
                redirect($this->agent->referrer());
            } else {
                echo 'gagal upload file';
                $this->response = $this->upload->display_errors();
                print_r($this->upload->display_errors());
                //return false;
            }
        } else {
            $this->session->set_flashdata('gagal', "File yg anda upload gagal");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }
    }

    public function download_adm($file)
    {
        //load the download helper
        $this->load->helper('download');

        // $this->model_download->insert_($file, $id, $jenis, $trans);
        //$this->transaksi_model->update_read($id_transaksi);

        header("Content-Type:  application/pdf, application/rar, application/zip, ");
        force_download("upload_file/adm/" . $file, NULL);
    }

    function sendMessage($telegram_id, $message_text, $secret_token)
    {
        $url = "https://api.telegram.org/bot" . $secret_token . "/sendMessage?parse_mode=markdown&chat_id=" . $telegram_id;
        $url = $url . "&text=" . urlencode($message_text);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            echo 'Pesan gagal terkirim, error :' . $err;
        } else {
            // echo 'Pesan terkirim';
        }
    }

    public function kirim_wa_pembatalan($nama, $tujuan, $tanggal, $waktu,  $meeting_id, $password, $topik)
    {


        $param = [
            "pesan" => '
Yth Bapak/Ibu ' . $nama . '
Permintaan penggunaan lisensi zoom anda telah dibatalkan, dengan rincian sebagai berikut:
                
Topik      : ' . $topik . '
Tanggal    : ' . $tanggal . '
Waktu      : ' . $waktu . ' WIB
Meeting ID : ' . $meeting_id . '
Passcode   : ' . $password . '

Zoom tersebut tidak dapat lagi digunakan',

            "no_wa" => $tujuan,
        ];
        //   print_r($param);
        //   echo "<br>";
        return send($param);
    }

    public function setuju_kirim_via_wa1($nama, $tujuan, $tanggal, $waktu, $link_zoom, $meeting_id, $password, $topik)
    {


        $param = [
            "pesan" => '
Yth Bapak/Ibu ' . $nama . '
Permintaan penggunaan lisensi zoom anda telah disetujui, dengan rincian sebagai berikut:
                
Topik      : ' . $topik . '
Tanggal    : ' . $tanggal . '
Waktu      : ' . $waktu . ' WIB
Meeting ID : ' . $meeting_id . '
Passcode   : ' . $password . '

Link zoom  : ' . $link_zoom . '

Tata Cara Penggunaan Lisensi Zoom:

*LOGIN*
Pada saat login zoom, pilih "Sign in with Google" 

Kemudian masukkan: 
email: bpsaceh.zm',

            "no_wa" => $tujuan,
        ];
        //   print_r($param);
        //   echo "<br>";
        return send($param);
    }

    public function setuju_kirim_via_wa2($nama, $tujuan, $tanggal, $waktu, $link_zoom, $meeting_id, $password, $topik)
    {


        $param = [
            "pesan" => '
Yth Bapak/Ibu ' . $nama . '
Permintaan penggunaan lisensi zoom anda telah disetujui, dengan rincian sebagai berikut:
                
Topik      : ' . $topik . '
Tanggal    : ' . $tanggal . '
Waktu      : ' . $waktu . ' WIB
Meeting ID : ' . $meeting_id . '
Passcode   : ' . $password . '

Link zoom  : ' . $link_zoom . '

Tata Cara Penggunaan Lisensi Zoom:

*LOGIN*
Pada saat login zoom, pilih login biasa

Kemudian masukkan: 
email: kasiejarkom1100@gmail.com',

            "no_wa" => $tujuan,
        ];
        //   print_r($param);
        //   echo "<br>";
        return send($param);
    }
    public function setuju_kirim_via_wa3($nama, $tujuan, $tanggal, $waktu, $link_zoom, $meeting_id, $password, $topik)
    {


        $param = [
            "pesan" => '
Yth Bapak/Ibu ' . $nama . '
Permintaan penggunaan lisensi zoom anda telah disetujui, dengan rincian sebagai berikut:
                
Topik      : ' . $topik . '
Tanggal    : ' . $tanggal . '
Waktu      : ' . $waktu . ' WIB
Meeting ID : ' . $meeting_id . '
Passcode   : ' . $password . '

Link zoom  : ' . $link_zoom . '

Tata Cara Penggunaan Lisensi Zoom:

*LOGIN*
Pada saat login zoom, pilih login biasa

Kemudian masukkan: 
email: layananzoom1100@gmail.com',

            "no_wa" => $tujuan,
        ];
        //   print_r($param);
        //   echo "<br>";
        return send($param);
    }
}

// email: bpsaceh.zm
// password: zoomaceh1100

// email: kasiejarkom1100@gmail.com
// password: @Acehjkd1100

// email: layananzoom1100@gmail.com
// password: Zoom1100