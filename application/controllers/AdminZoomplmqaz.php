<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/coba zoom/api_zoom.php';
require_once APPPATH . 'libraries/api_watzap.php';

class adminZoomplmqaz extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('admin_model');
        $this->load->model('master_model');
        $this->load->model('zoom_meeting_model');
    }

    public function index()
    {
        // $this->load->vars($data);
        $this->template->load('template/template', 'home');
    }
    public function list()
    {
        $data['zoom'] = $this->meeting_model->get_all();
        $this->load->vars($data);
        $this->template->load('template/template', 'zoom/list');
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

            if ($arr['id_akun_zoom'] == 1) {
                $result = createMeeting($arr);
            } else {
                $result = createMeeting2($arr);
            }
            print_r($result);

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

                print_r($result);
            }
            $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");
            // redirect('zoom/list');
            // $this->load->view('sukses');
        }
    }

    public function verifikasiViaWa($username, $id)
    {
        $admin = $this->admin_model->get_username($username);

        if (!empty($admin)) {

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

                if ($arr['id_akun_zoom'] == 1) {
                    $result = createMeeting($arr);
                } else {
                    $result = createMeeting($arr);
                }
                
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
                
                    $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");
                    // redirect('zoom/list');
                    $this->load->view('sukses');
                } else {
                    print_r($result);
                }
                
            }
        } else {
            echo "gagal";
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

    public function kirim_via_wa($nama, $tujuan, $tanggal, $waktu, $link_zoom, $meeting_id, $password, $topik)
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
email: bpsaceh.zm
password: zoomaceh1100',

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
email: bpsaceh.zm
password: zoomaceh1100',

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
email: kasiejarkom1100@gmail.com
password: @Acehjkd1100',

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
email: layananzoom1100@gmail.com
password: Zoom1100',

            "no_wa" => $tujuan,
        ];
        //   print_r($param);
        //   echo "<br>";
        return send($param);
    }
}
