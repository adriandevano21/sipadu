<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Rapat
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 *
 */
include_once(dirname(__FILE__) . "/Qrcode_kegiatan.php");
// require_once APPPATH . 'libraries/api_watzap.php';

class Event extends Qrcode_kegiatan
{
  private $token_ = "_{ptZD^ei_u=ZFyV9Y|j_v1VOYXLPB|7}gTBl^hEP4vx}hpk-ichsan";
  private $DEVICE_ID = "iphone";

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in')) {
    } else {
      redirect('login');
    }
    $this->load->model('rincian_gaji_model');
    $this->load->model('rapat_model');
    $this->load->model('master_model');
    $this->load->model('pegawai_model');
  }

  public function list()
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
    $data['ruang_rapat'] = $this->rapat_model->get_all_ruang_rapat();
    $data['rapat'] = $this->rapat_model->get_all_bulan($bulan, $tahun);
    $data['bulan'] = $bulan;
    $data['tahun'] = $tahun;
    $data['judul'] = 'Event';
    $this->load->vars($data);
    $this->template->load('template/template', 'event/list');
  }

  public function tambah() // fungsi ini digunakan untuk menambahkan aktivitas
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('topik', 'topik', 'required');

    if ($this->form_validation->run()) {
      $dateTimeRange = $this->input->post('range');
      // Memisahkan tanggal dan waktu mulai serta tanggal dan waktu selesai
      // Memecah tanggal mulai dan selesai
      list($startDateTime, $endDateTime) = explode(" - ", $dateTimeRange);

      // Memformat tanggal dan waktu menjadi objek DateTime
      $startDateTimeObj = DateTime::createFromFormat('m/d/Y h:i a', $startDateTime);
      $endDateTimeObj = DateTime::createFromFormat('m/d/Y h:i a', $endDateTime);

      // Mendapatkan tanggal mulai dan selesai
      $startDate = $startDateTimeObj->format('Y-m-d');
      $endDate = $endDateTimeObj->format('Y-m-d');

      // Mendapatkan jam mulai dan selesai
      $startTime = $startDateTimeObj->format('H:i:s');
      $endTime = $endDateTimeObj->format('H:i:s');


      $username = $this->session->userdata('username');
      // $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
      // $pukul = $this->input->post('pukul');
      // $selesai = $this->input->post('selesai');
      $status = "0"; // status 0 -> tidak hadir
      $topik = $this->input->post('topik');
      $username_pengundang = $this->input->post('username_pengundang');
      $username_notulis = $this->input->post('username_notulis');
      $id_ruang_rapat = $this->input->post('id_ruang_rapat');
      $id_tim = $this->input->post('id_tim');
      $id_jenis_kegiatan = $this->input->post('id_jenis_kegiatan');
      $username_peserta = $this->input->post('username_peserta2');
      $nama_peserta_eksternal = $this->input->post('nama_peserta_eksternal');
      $instansi_peserta_eksternal = $this->input->post('instansi_peserta_eksternal');
      $lokasi =   (!empty($this->input->post('lokasi'))) ? $this->input->post('lokasi') : NULL;

      // Mendapatkan tanggal dan waktu dalam format yang diinginkan
      $tanggal = $startDate;
      $pukul = $startTime;
      $tanggal_selesai = $endDate;
      $selesai = $endTime;

      
      $params = array(
        'username_created'    => $username,
        'tanggal'             => $tanggal,
        'id_ruang_rapat'      => $id_ruang_rapat,
        'pukul'               => $pukul,
        'selesai'             => $selesai,
        'topik'               => $topik,
        'username_pengundang' => $username_pengundang,
        'username_notulis'    => $username_notulis,
        'id_tim'              => $id_tim,
        'id_jenis_kegiatan'   => $id_jenis_kegiatan,
        'tanggal_selesai'     => $tanggal_selesai,
        'lokasi'              => $lokasi
      );
     
    //  array_push($username_peserta, $username_pengundang, $username_notulis);

        if (isset($username_peserta)) {
        $username_peserta2 = explode(" ", $username_peserta);
        foreach ($username_peserta2 as $nilai) {
            $username_peserta5[] = $nilai;
            // echo "Nilai yang dipilih: " . $nilai . "<br>";
            }
        } else {
            echo "Tidak ada nilai yang dipilih.";
        }
        
        array_push($username_peserta5, $username_pengundang, $username_notulis);
    
        
      $id_rapat = $this->master_model->insert("rapat", $params);
      foreach ($username_peserta5 as $key => $value) {
        $data_peserta=$this->pegawai_model->get_pegawai($value);
        $peserta_rapat[$key] = array(
          'id_rapat' => $id_rapat,
          'username' => $value,
          'no_wa' => $data_peserta['no_wa'],
        );
      }
      
    //   if (isset($nama_peserta_eksternal)) {
    //     $nama_peserta_eksternal = explode(" ", $nama_peserta_eksternal);
    //     foreach ($nama_peserta_eksternal as $nilai) {
    //         $nama_peserta_eksternal[] = $nilai;
    //         // echo "Nilai yang dipilih: " . $nilai . "<br>";
    //         }
    //     } else {
    //         echo "Tidak ada nilai yang dipilih.";
    //     }
        
        // if (isset($instansi_peserta_eksternal)) {
        // $instansi_peserta_eksternal = explode(" ", $instansi_peserta_eksternal);
        // foreach ($instansi_peserta_eksternal as $nilai) {
        //     $instansi_peserta_eksternal[] = $nilai;
            
        //     }
        // } else {
        //     echo "Tidak ada nilai yang dipilih.";
        // }
        
        //   foreach ($nama_peserta_eksternal as $key => $value) {
        //     $peserta_eksternal[$key] = array(
        //       'id_rapat' => $id_rapat,
        //       'nama' => $nama_peserta_eksternal[$key],
        //       'instansi' => $instansi_peserta_eksternal[$key],
        //     );
        //   }
      
      
      $this->master_model->insert_batch("peserta_rapat", $peserta_rapat);
    //   $this->master_model->insert_batch("peserta_rapat_eksternal", $peserta_eksternal);

      $qr = $this->buat_qr($topik, $tanggal);
      if ($qr === FALSE) {
        $this->session->set_flashdata('gagal', "Data yg anda masukan gagal");
      } else {
        $data = array('qrcode' => $qr);
        $this->master_model->update('rapat', 'id', $id_rapat, $data);
        $this->tambah_aktivitas($id_rapat);
        $this->kirim_undangan($id_rapat);
        $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

        redirect('event/list');
      }
    } else {

      $data['master_ruang_rapat'] = $this->master_model->get_all('master_ruang_rapat');
      $data['master_jenis_kegiatan'] = $this->master_model->get_all('master_jenis_kegiatan');
      $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
      $data['judul'] = 'Event';
      $this->load->vars($data);
      $this->template->load('template/template', 'event/tambah_rapat');
    }
  }
  
//20241028
  public function tambah2() // fungsi ini digunakan untuk menambahkan aktivitas
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('topik', 'topik', 'required');

    if ($this->form_validation->run()) {
      $dateTimeRange = $this->input->post('range');
      // Memisahkan tanggal dan waktu mulai serta tanggal dan waktu selesai
      // Memecah tanggal mulai dan selesai
      
      list($startDateTime, $endDateTime) = explode(" - ", $dateTimeRange);

      // Memformat tanggal dan waktu menjadi objek DateTime
      $startDateTimeObj = DateTime::createFromFormat('m/d/Y h:i a', $startDateTime);
      $endDateTimeObj = DateTime::createFromFormat('m/d/Y h:i a', $endDateTime);

      // Mendapatkan tanggal mulai dan selesai
      $startDate = $startDateTimeObj->format('Y-m-d');
      $endDate = $endDateTimeObj->format('Y-m-d');

      // Mendapatkan jam mulai dan selesai
      $startTime = $startDateTimeObj->format('H:i:s');
      $endTime = $endDateTimeObj->format('H:i:s');

    $lamahari = $endDateTimeObj->format('d')-$startDateTimeObj->format('d');
    print_r($lamahari);

      $username = $this->session->userdata('username');
      $status = "0"; // status 0 -> tidak hadir
      $topik = $this->input->post('topik');
      $username_pengundang = $this->input->post('username_pengundang');
      $username_notulis = $this->input->post('username_notulis');
      $id_ruang_rapat = $this->input->post('id_ruang_rapat');
      $id_tim = $this->input->post('id_tim');
      $id_jenis_kegiatan = $this->input->post('id_jenis_kegiatan');
      $username_peserta = $this->input->post('username_peserta2');
      $nama_peserta_eksternal = $this->input->post('nama_peserta_eksternal');
      $instansi_peserta_eksternal = $this->input->post('instansi_peserta_eksternal');
      $lokasi =   (!empty($this->input->post('lokasi'))) ? $this->input->post('lokasi') : NULL;

      // Mendapatkan tanggal dan waktu dalam format yang diinginkan
      $tanggal = $startDate;
      $pukul = $startTime;
      $tanggal_selesai = $endDate;
      $selesai = $endTime;

      
      $params = array(
        'username_created'    => $username,
        'tanggal'             => $tanggal,
        'id_ruang_rapat'      => $id_ruang_rapat,
        'pukul'               => $pukul,
        'selesai'             => $selesai,
        'topik'               => $topik,
        'username_pengundang' => $username_pengundang,
        'username_notulis'    => $username_notulis,
        'id_tim'              => $id_tim,
        'id_jenis_kegiatan'   => $id_jenis_kegiatan,
        'tanggal_selesai'     => $tanggal_selesai,
        'lokasi'              => $lokasi
      );
     
    //  array_push($username_peserta, $username_pengundang, $username_notulis);

        if (isset($username_peserta)) {
        $username_peserta2 = explode(" ", $username_peserta);
        foreach ($username_peserta2 as $nilai) {
            $username_peserta5[] = $nilai;
            // echo "Nilai yang dipilih: " . $nilai . "<br>";
            }
        } else {
            echo "Tidak ada nilai yang dipilih.";
        }
        
        array_push($username_peserta5, $username_pengundang, $username_notulis);
    
        
    //   $id_rapat = $this->master_model->insert("rapat", $params);
      foreach ($username_peserta5 as $key => $value) {
        $data_peserta=$this->pegawai_model->get_pegawai($value);
        $peserta_rapat[$key] = array(
          'id_rapat' => $id_rapat,
          'username' => $value,
          'no_wa' => $data_peserta['no_wa'],
        );
      }
      
    //   $this->master_model->insert_batch("peserta_rapat", $peserta_rapat);
    //   $this->master_model->insert_batch("peserta_rapat_eksternal", $peserta_eksternal);

      $qr = $this->buat_qr($topik, $tanggal);
      if ($qr === FALSE) {
        $this->session->set_flashdata('gagal', "Data yg anda masukan gagal");
      } else {
        $data = array('qrcode' => $qr);
        $this->master_model->update('rapat', 'id', $id_rapat, $data);
        $this->tambah_aktivitas($id_rapat);
        $this->kirim_undangan($id_rapat);
        $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

        redirect('event/list');
      }
    } else {

      $data['master_ruang_rapat'] = $this->master_model->get_all('master_ruang_rapat');
      $data['master_jenis_kegiatan'] = $this->master_model->get_all('master_jenis_kegiatan');
      $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
      $data['judul'] = 'Event';
      $this->load->vars($data);
      $this->template->load('template/template', 'event/tambah_rapat');
    }
  }
//20241028

  public function edit($id_rapat) // fungsi ini digunakan untuk menambahkan aktivitas
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('topik', 'topik', 'required');

    if ($this->form_validation->run()) {
      $dateTimeRange = $this->input->post('range');
      // Memisahkan tanggal dan waktu mulai serta tanggal dan waktu selesai
      // Memecah tanggal mulai dan selesai
      list($startDateTime, $endDateTime) = explode(" - ", $dateTimeRange);

      // Memformat tanggal dan waktu menjadi objek DateTime
      $startDateTimeObj = DateTime::createFromFormat('m/d/Y h:i a', $startDateTime);
      $endDateTimeObj = DateTime::createFromFormat('m/d/Y h:i a', $endDateTime);

      // Mendapatkan tanggal mulai dan selesai
      $startDate = $startDateTimeObj->format('Y-m-d');
      $endDate = $endDateTimeObj->format('Y-m-d');

      // Mendapatkan jam mulai dan selesai
      $startTime = $startDateTimeObj->format('H:i:s');
      $endTime = $endDateTimeObj->format('H:i:s');


      $username = $this->session->userdata('username');
      // $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
      // $pukul = $this->input->post('pukul');
      // $selesai = $this->input->post('selesai');
      $status = "0"; // status 0 -> tidak hadir
      $topik = $this->input->post('topik');
      $username_pengundang = $this->input->post('username_pengundang');
      $username_notulis = $this->input->post('username_notulis');
      $id_ruang_rapat = $this->input->post('id_ruang_rapat');
      $id_tim = $this->input->post('id_tim');
      $id_jenis_kegiatan = $this->input->post('id_jenis_kegiatan');
      $username_peserta = $this->input->post('username_peserta');
      $nama_peserta_eksternal = $this->input->post('nama_peserta_eksternal');
      $instansi_peserta_eksternal = $this->input->post('instansi_peserta_eksternal');
      $lokasi =   (!empty($this->input->post('lokasi'))) ? $this->input->post('lokasi') : NULL;

      // Mendapatkan tanggal dan waktu dalam format yang diinginkan
      $tanggal = $startDate;
      $pukul = $startTime;
      $tanggal_selesai = $endDate;
      $selesai = $endTime;

      array_push($username_peserta, $username_pengundang, $username_notulis);
      $params = array(
        'username_created'    => $username,
        'tanggal'             => $tanggal,
        'id_ruang_rapat'      => $id_ruang_rapat,
        'pukul'               => $pukul,
        'selesai'             => $selesai,
        'topik'               => $topik,
        // 'username_pengundang' => $username_pengundang,
        // 'username_notulis'    => $username_notulis,
        'id_tim'              => $id_tim,
        'id_jenis_kegiatan'   => $id_jenis_kegiatan,
        'tanggal_selesai'     => $tanggal_selesai,
        'lokasi'              => $lokasi
      );

      $this->master_model->update("rapat", 'id', $id_rapat, $params);

      $qr = $this->buat_qr($topik, $tanggal);
      if ($qr === FALSE) {
        $this->session->set_flashdata('gagal', "Data yg anda masukan gagal");
      } else {
        $data = array('qrcode' => $qr);
        $this->master_model->update('rapat', 'id', $id_rapat, $data);
        $this->master_model->delete('aktivitas', 'id_rapat', $id_rapat); //hapus_akttivitas  
        $this->tambah_aktivitas($id_rapat);
        $this->kirim_undangan($id_rapat);
        $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

        redirect('event/list');
      }
    } else {
      $data['peserta_rapat_eksternal'] = $this->rapat_model->peserta_rapat_eksternal_id_rapat($id_rapat);
      $data['peserta_rapat'] = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
      $data['detail_rapat'] = $this->rapat_model->get_id($id_rapat);
      $data['master_ruang_rapat'] = $this->master_model->get_all('master_ruang_rapat');
      $data['master_jenis_kegiatan'] = $this->master_model->get_all('master_jenis_kegiatan');
      $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
      $data['judul'] = 'Event';
      $this->load->vars($data);
      $this->template->load('template/template', 'event/edit_event');
    }
  }

  public function input_notulen($id_rapat)
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('notulen', 'notulen', 'required');

    if ($this->form_validation->run()) {
      $hadir = $this->input->post('hadir'); // berisi id peserta rapat
      $notulen = $this->input->post('notulen');
      $hadir_eksternal = $this->input->post('hadir_eksternal');
      $id_peserta_eksternal = $this->input->post('id_peserta_eksternal');
      $nama_peserta_eksternal = $this->input->post('nama_peserta_eksternal');
      $instansi_peserta_eksternal = $this->input->post('instansi_peserta_eksternal');

      $config['upload_path']          = './upload_file/rapat/';
      $config['allowed_types']        = 'jpeg|jpg|png|pdf|zip|rar';
      $config['max_size']             = 10000;
      // $config['max_width']            = 2048;
      // $config['max_height']           = 1000;
      //   $config['encrypt_name'] 		= true;
      $this->load->library('upload', $config);

      $jumlah_berkas = count($_FILES['upload_foto']['name']);
      for ($i = 0; $i < $jumlah_berkas; $i++) {
        if (!empty($_FILES['upload_foto']['name'][$i])) {

          $_FILES['file']['name'] = $_FILES['upload_foto']['name'][$i];
          $_FILES['file']['type'] = $_FILES['upload_foto']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['upload_foto']['tmp_name'][$i];
          $_FILES['file']['error'] = $_FILES['upload_foto']['error'][$i];
          $_FILES['file']['size'] = $_FILES['upload_foto']['size'][$i];

          if ($this->upload->do_upload('file')) {

            $uploadData = $this->upload->data();
            $file_path = $uploadData['full_path'];
            $data[] = array(
                'nama_file' => $uploadData['file_name'],
                'id_rapat' => $id_rapat,
              );
            
          } else {
            // echo 'gagal upload file';
            // echo  $this->upload->display_errors('<p>', '</p>');
            $this->session->set_flashdata('gagal', "Gagal Upload Dokumentasi: " . $this->upload->display_errors('<p>', '</p>'));
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
          }
        }
      }
      //   print_r($_FILES['upload_undangan']['name']);
      //   print_r($_FILES['upload_notulen']['name']);
      //   print_r($_FILES['upload_berkas']['name']);
      //   exit;
      // upload undangan 
      if (!empty($_FILES['upload_undangan']['name'])) {

        $_FILES['file']['name'] = $_FILES['upload_undangan']['name'];
        $_FILES['file']['type'] = $_FILES['upload_undangan']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['upload_undangan']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['upload_undangan']['error'];
        $_FILES['file']['size'] = $_FILES['upload_undangan']['size'];

        if ($this->upload->do_upload('file')) {

          $uploadData = $this->upload->data();
          $data_undangan = array(
              'nama_file' => $uploadData['file_name'],
              'id_rapat' => $id_rapat,
            );

            $this->master_model->insert("undangan_rapat", $data_undangan);
          
          
        } else {
          // echo 'gagal upload file';
          // echo  $this->upload->display_errors('<p>', '</p>');
          $this->session->set_flashdata('gagal', "Gagal Upload Undangan: " . $this->upload->display_errors('<p>', '</p>'));
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }
      }

      // upload notulen 
      if (!empty($_FILES['upload_notulen']['name'])) {

        $_FILES['file']['name'] = $_FILES['upload_notulen']['name'];
        $_FILES['file']['type'] = $_FILES['upload_notulen']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['upload_notulen']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['upload_notulen']['error'];
        $_FILES['file']['size'] = $_FILES['upload_notulen']['size'];

        if ($this->upload->do_upload('file')) {

          $uploadData = $this->upload->data();
          $data_notulen = array(
              'nama_file' => $uploadData['file_name'],
              'id_rapat' => $id_rapat,
            );
            $this->master_model->insert("notulen_rapat", $data_notulen);
            
          
        } else {
          // echo 'gagal upload file';
          // echo  $this->upload->display_errors('<p>', '</p>');
          $this->session->set_flashdata('gagal', "Gagal Upload notulen: " . $this->upload->display_errors('<p>', '</p>'));
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }
      }

      // upload berkas 
      if (!empty($_FILES['upload_berkas']['name'])) {

        $_FILES['file']['name'] = $_FILES['upload_berkas']['name'];
        $_FILES['file']['type'] = $_FILES['upload_berkas']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['upload_berkas']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['upload_berkas']['error'];
        $_FILES['file']['size'] = $_FILES['upload_berkas']['size'];

        if ($this->upload->do_upload('file')) {

          $uploadData = $this->upload->data();
          $data_berkas = array(
              'nama_file' => $uploadData['file_name'],
              'id_rapat' => $id_rapat,
            );

            $this->master_model->insert("berkas_rapat", $data_berkas);
            
          
        } else {
          // echo 'gagal upload file';
          // echo  $this->upload->display_errors('<p>', '</p>');
          $this->session->set_flashdata('gagal', "Gagal Upload berkas: " . $this->upload->display_errors('<p>', '</p>'));
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }
      }


      $error = array('error' => $this->upload->display_errors());
      // print_r($data);
      // exit;
      if (!empty($this->upload->display_errors())) {
        $this->session->set_flashdata('gagal', $this->upload->display_errors());
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        if (!empty($data)) {

          $this->master_model->insert_batch("dokumentasi_rapat", $data);
        }
      }


      $params = array(
        'notulen'            => $notulen,
        'time_notulen' => date("Y-m-d h:i:s"),
      );
      if (!empty($hadir)) {
        foreach ($hadir as $key => $value) {
          $params_hadir[] = array(
            'id' => $value,
            'status' => 1,
          );
        }
        // print_r($params_hadir);
        // exit;
        $this->master_model->update_array("peserta_rapat",  $params_hadir, 'id');
      }

      if (!empty($hadir_eksternal)) {
        foreach ($hadir_eksternal as $key => $value) {
          $params_hadir_eksternal[] = array(
            'status' => 1,
            'id' => $value,
          );
        }
        $this->master_model->update_array("peserta_rapat_eksternal", $params_hadir_eksternal, 'id');
      }

    //   foreach ($id_peserta_eksternal as $key => $value) {
    //     $params_hadir_eksternal2[] = array(
    //       'id' => $value,
    //       'nama' => $nama_peserta_eksternal[$key],
    //       'instansi' => $instansi_peserta_eksternal[$key]
    //     );
    //   }
    //   $this->master_model->update_array("peserta_rapat_eksternal", $params_hadir_eksternal2, 'id');



      $this->master_model->update('rapat', 'id', $id_rapat, $params);
      $this->lihat($id_rapat);
    } else {
      $data['peserta_rapat_eksternal'] = $this->rapat_model->peserta_rapat_eksternal_id_rapat($id_rapat);
      $data['peserta_rapat'] = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
      $data['detail_rapat'] = $this->rapat_model->get_id($id_rapat);
      $data['dokumentasi_rapat'] = $this->rapat_model->dokumentasi_rapat_id_rapat($id_rapat);
      $data['judul'] = 'Event';
      $this->load->vars($data);
      $this->template->load('template/template', 'event/input_notulen');
    }
  }
  public function input_notulen_sebelum_bpsaceh_diblok($id_rapat)
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('notulen', 'notulen', 'required');

    if ($this->form_validation->run()) {
      $hadir = $this->input->post('hadir'); // berisi id peserta rapat
      $notulen = $this->input->post('notulen');
      $hadir_eksternal = $this->input->post('hadir_eksternal');
      $id_peserta_eksternal = $this->input->post('id_peserta_eksternal');
      $nama_peserta_eksternal = $this->input->post('nama_peserta_eksternal');
      $instansi_peserta_eksternal = $this->input->post('instansi_peserta_eksternal');

      $config['upload_path']          = './upload_file/rapat/';
      $config['allowed_types']        = 'jpeg|jpg|png|pdf|zip|rar';
      $config['max_size']             = 10000;
      // $config['max_width']            = 2048;
      // $config['max_height']           = 1000;
      //   $config['encrypt_name'] 		= true;
      $this->load->library('upload', $config);

      $jumlah_berkas = count($_FILES['upload_foto']['name']);
      for ($i = 0; $i < $jumlah_berkas; $i++) {
        if (!empty($_FILES['upload_foto']['name'][$i])) {

          $_FILES['file']['name'] = $_FILES['upload_foto']['name'][$i];
          $_FILES['file']['type'] = $_FILES['upload_foto']['type'][$i];
          $_FILES['file']['tmp_name'] = $_FILES['upload_foto']['tmp_name'][$i];
          $_FILES['file']['error'] = $_FILES['upload_foto']['error'][$i];
          $_FILES['file']['size'] = $_FILES['upload_foto']['size'][$i];

          if ($this->upload->do_upload('file')) {

            $uploadData = $this->upload->data();
            $file_path = $uploadData['full_path'];

            // Panggil API untuk mengunggah file
            $api_url = 'https://sipadu.bpsaceh.com/api/uploadFile';
            $post_data = array(
              'file' => new CURLFile($file_path),
              'folder' => 'rapat'
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
              $data[] = array(
                'nama_file' => $data_api['data']['file_name'],
                'id_rapat' => $id_rapat,
              );
            } else {
              $this->session->set_flashdata('gagal', "Gagal Upload Dokumentasi Rapat");
              $this->load->library('user_agent');
              redirect($this->agent->referrer());
            }
          } else {
            // echo 'gagal upload file';
            // echo  $this->upload->display_errors('<p>', '</p>');
            $this->session->set_flashdata('gagal', "Gagal Upload Dokumentasi: " . $this->upload->display_errors('<p>', '</p>'));
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
          }
        }
      }
      //   print_r($_FILES['upload_undangan']['name']);
      //   print_r($_FILES['upload_notulen']['name']);
      //   print_r($_FILES['upload_berkas']['name']);
      //   exit;
      // upload undangan 
      if (!empty($_FILES['upload_undangan']['name'])) {

        $_FILES['file']['name'] = $_FILES['upload_undangan']['name'];
        $_FILES['file']['type'] = $_FILES['upload_undangan']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['upload_undangan']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['upload_undangan']['error'];
        $_FILES['file']['size'] = $_FILES['upload_undangan']['size'];

        if ($this->upload->do_upload('file')) {

          $uploadData = $this->upload->data();
          $file_path = $uploadData['full_path'];

          // Panggil API untuk mengunggah file
          $api_url = 'https://sipadu.bpsaceh.com/api/uploadFile';
          $post_data = array(
            'file' => new CURLFile($file_path),
            'folder' => 'rapat'
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
            $data_undangan = array(
              'nama_file' => $data_api['data']['file_name'],
              'id_rapat' => $id_rapat,
            );

            $this->master_model->insert("undangan_rapat", $data_undangan);
          } else {
            $this->session->set_flashdata('gagal', "Gagal Upload Dokumentasi Rapat");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
          }
        } else {
          // echo 'gagal upload file';
          // echo  $this->upload->display_errors('<p>', '</p>');
          $this->session->set_flashdata('gagal', "Gagal Upload Undangan: " . $this->upload->display_errors('<p>', '</p>'));
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }
      }

      // upload notulen 
      if (!empty($_FILES['upload_notulen']['name'])) {

        $_FILES['file']['name'] = $_FILES['upload_notulen']['name'];
        $_FILES['file']['type'] = $_FILES['upload_notulen']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['upload_notulen']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['upload_notulen']['error'];
        $_FILES['file']['size'] = $_FILES['upload_notulen']['size'];

        if ($this->upload->do_upload('file')) {

          $uploadData = $this->upload->data();
          $file_path = $uploadData['full_path'];

          // Panggil API untuk mengunggah file
          $api_url = 'https://sipadu.bpsaceh.com/api/uploadFile';
          $post_data = array(
            'file' => new CURLFile($file_path),
            'folder' => 'rapat'
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
            $data_notulen = array(
              'nama_file' => $data_api['data']['file_name'],
              'id_rapat' => $id_rapat,
            );

            $this->master_model->insert("notulen_rapat", $data_notulen);
          } else {
            $this->session->set_flashdata('gagal', "Gagal Upload Dokumentasi Rapat");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
          }
        } else {
          // echo 'gagal upload file';
          // echo  $this->upload->display_errors('<p>', '</p>');
          $this->session->set_flashdata('gagal', "Gagal Upload notulen: " . $this->upload->display_errors('<p>', '</p>'));
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }
      }

      // upload berkas 
      if (!empty($_FILES['upload_berkas']['name'])) {

        $_FILES['file']['name'] = $_FILES['upload_berkas']['name'];
        $_FILES['file']['type'] = $_FILES['upload_berkas']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['upload_berkas']['tmp_name'];
        $_FILES['file']['error'] = $_FILES['upload_berkas']['error'];
        $_FILES['file']['size'] = $_FILES['upload_berkas']['size'];

        if ($this->upload->do_upload('file')) {

          $uploadData = $this->upload->data();
          $file_path = $uploadData['full_path'];

          // Panggil API untuk mengunggah file
          $api_url = 'https://sipadu.bpsaceh.com/api/uploadFile';
          $post_data = array(
            'file' => new CURLFile($file_path),
            'folder' => 'rapat'
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
            $data_berkas = array(
              'nama_file' => $data_api['data']['file_name'],
              'id_rapat' => $id_rapat,
            );

            $this->master_model->insert("berkas_rapat", $data_berkas);
          } else {
            $this->session->set_flashdata('gagal', "Gagal Upload Dokumentasi Rapat");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
          }
        } else {
          // echo 'gagal upload file';
          // echo  $this->upload->display_errors('<p>', '</p>');
          $this->session->set_flashdata('gagal', "Gagal Upload berkas: " . $this->upload->display_errors('<p>', '</p>'));
          $this->load->library('user_agent');
          redirect($this->agent->referrer());
        }
      }


      $error = array('error' => $this->upload->display_errors());
      // print_r($data);
      // exit;
      if (!empty($this->upload->display_errors())) {
        $this->session->set_flashdata('gagal', $this->upload->display_errors());
        $this->load->library('user_agent');
        redirect($this->agent->referrer());
      } else {
        if (!empty($data)) {

          $this->master_model->insert_batch("dokumentasi_rapat", $data);
        }
      }


      $params = array(
        'notulen'            => $notulen,
        'time_notulen' => date("Y-m-d h:i:s"),
      );
      if (!empty($hadir)) {
        foreach ($hadir as $key => $value) {
          $params_hadir[] = array(
            'id' => $value,
            'status' => 1,
          );
        }
        // print_r($params_hadir);
        // exit;
        $this->master_model->update_array("peserta_rapat",  $params_hadir, 'id');
      }

      if (!empty($hadir_eksternal)) {
        foreach ($hadir_eksternal as $key => $value) {
          $params_hadir_eksternal[] = array(
            'status' => 1,
            'id' => $value,
          );
        }
        $this->master_model->update_array("peserta_rapat_eksternal", $params_hadir_eksternal, 'id');
      }

      foreach ($id_peserta_eksternal as $key => $value) {
        $params_hadir_eksternal2[] = array(
          'id' => $value,
          'nama' => $nama_peserta_eksternal[$key],
          'instansi' => $instansi_peserta_eksternal[$key]
        );
      }
      $this->master_model->update_array("peserta_rapat_eksternal", $params_hadir_eksternal2, 'id');



      $this->master_model->update('rapat', 'id', $id_rapat, $params);
      $this->lihat($id_rapat);
    } else {
      $data['peserta_rapat_eksternal'] = $this->rapat_model->peserta_rapat_eksternal_id_rapat($id_rapat);
      $data['peserta_rapat'] = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
      $data['detail_rapat'] = $this->rapat_model->get_id($id_rapat);
      $data['dokumentasi_rapat'] = $this->rapat_model->dokumentasi_rapat_id_rapat($id_rapat);
      $data['judul'] = 'Event';
      $this->load->vars($data);
      $this->template->load('template/template', 'event/input_notulen');
    }
  }
  public function lihat($id_rapat)
  {
    $data['peserta_rapat_eksternal'] = $this->rapat_model->peserta_rapat_eksternal_id_rapat($id_rapat);
    $data['peserta_rapat'] = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
    $data['detail_rapat'] = $this->rapat_model->get_id($id_rapat);
    $data['dokumentasi_rapat'] = $this->rapat_model->dokumentasi_rapat_id_rapat($id_rapat);
    $data['judul'] = 'Event';
    $this->load->vars($data);
    $this->template->load('template/template', 'event/lihat');
  }

  public function kirim_undangan($id_rapat)
  {
    $penerima = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
    $rapat = $this->rapat_model->get_id($id_rapat);
    foreach ($penerima as $key => $value) {
      $mulai = substr($rapat['pukul'], 0, 5);
      $selesai = substr($rapat['selesai'], 0, 5);
      $param = [
        "pesan" => "*Pemberitahuan Event*

Yth. $value[nama_pegawai] 
Dengan ini saudara/i diundang untuk mengikuti event dengan

Topik : $rapat[topik]
Tanggal : $rapat[tanggal]
Waktu : $mulai s.d $selesai WIB
Tempat : $rapat[nama_ruangan]
Narahubung : $rapat[created]
Pemimpin rapat : $rapat[pengundang]

Demikian untuk dilaksanakan, atas perhatian dan kerjasamanya diucapkan terima kasih
",
        "no_wa" => $value["no_wa"],
        "id_rapat" => $id_rapat,
      ];
      //   print_r($param);
      //   echo "<br>";
    //   return send($param);
       $this->send($param);
    }
  }
  public function kirim_batal($id_rapat)
  {
    $penerima = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
    $rapat = $this->rapat_model->get_id($id_rapat);
    foreach ($penerima as $key => $value) {
      $mulai = substr($rapat['pukul'], 0, 5);
      $selesai = substr($rapat['selesai'], 0, 5);
      $param = [
        "pesan" => "*Pemberitahuan Batal Event*

Yth. $value[nama_pegawai] 
Dengan ini kami beritahukan bahwa event dengan

Topik : $rapat[topik]
Tanggal : $rapat[tanggal]
Waktu : $mulai s.d $selesai WIB
Tempat : $rapat[nama_ruangan]
Narahubung : $rapat[created]
Pemimpin rapat : $rapat[pengundang]

*Batal* untuk dilaksanakan, atas perhatian dan kerjasamanya diucapkan terima kasih
",
        "no_wa" => $value["no_wa"],
        "id_rapat" => $id_rapat,
      ];
      //   print_r($param);
      //   echo "<br>";
    //   return send($param);
       $this->send($param);
    }
  }
  
    public function kirim_ulang($id_rapat)
  {
    $penerima = $this->rapat_model->peserta_rapat_id_rapat_belum_wa($id_rapat);
    $rapat = $this->rapat_model->get_id($id_rapat);
    foreach ($penerima as $key => $value) {
      $mulai = substr($rapat['pukul'], 0, 5);
      $selesai = substr($rapat['selesai'], 0, 5);
      $param = [
        "pesan" => "*Pemberitahuan Event*

Yth. $value[nama_pegawai] 
Dengan ini saudara/i diundang untuk mengikuti event dengan

Topik : $rapat[topik]
Tanggal : $rapat[tanggal]
Waktu : $mulai s.d $selesai WIB
Tempat : $rapat[nama_ruangan]
Narahubung : $rapat[created]
Pemimpin rapat : $rapat[pengundang]

Demikian untuk dilaksanakan, atas perhatian dan kerjasamanya diucapkan terima kasih
",
        "no_wa" => $value["no_wa"],
        "id_rapat" => $id_rapat,
      ];
      //   print_r($param);
      //   echo "<br>";
    //   return send($param);
       $this->send($param);
    }
    $this->session->set_flashdata('sukses', "Berhasil kirim ulang notif WA");
    $this->load->library('user_agent');
    redirect($this->agent->referrer());
    
  }

  public function tambah_aktivitas($id_rapat)
  {
    $peserta = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
    $rapat = $this->rapat_model->get_id($id_rapat);

    foreach ($peserta as $key => $value) {
    if($value['username'] == "ahmadriswan"){
        $params = array(
        'aktivitas' => ($rapat['topik'] ?? null),
        'username' => $value['username'],
        'tanggal' => ($rapat['tanggal'] ?? null),
        'tanggal_selesai' => ($rapat['tanggal_selesai'] ?? null),
        'id_rapat' => $id_rapat
      );
    } else {
        $params = array(
        'aktivitas' => "Mengikuti " . ($rapat['topik'] ?? null),
        'username' => $value['username'],
        'tanggal' => ($rapat['tanggal'] ?? null),
        'tanggal_selesai' => ($rapat['tanggal_selesai'] ?? null),
        'id_rapat' => $id_rapat
      );
    }
      
      $this->db->insert('aktivitas', $params);
    }
  }
  public function send($params)
  {
    try {
    //   $dataSending = array();
    //   $dataSending["api_key"] = "59N5INDJF6I683Z4";
    //   $dataSending["number_key"] = "YVhQXKP64PPcqO5O";
    //   $dataSending["phone_no"] = $params["no_wa"];
    //   $dataSending["message"] = $params["pesan"];
    //   $curl = curl_init();
    //   curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_POSTFIELDS => json_encode($dataSending),
    //     CURLOPT_HTTPHEADER => array(
    //       'Content-Type: application/json'
    //     ),
    //   ));
    //   $response = curl_exec($curl);
    //   curl_close($curl);
    //   // echo $response;

    //   $response = json_decode($response);
      //   print_r($response);
      //   exit;
      
      // URL API yang akan diuji
        $api_url = "https://api.watzap.id/v1/send_message";
        
        // Data yang akan dikirim ke API
        $data = [
            "api_key" => "59N5INDJF6I683Z4", // Ganti dengan API Key Anda
            "number_key" => "qawHPCTE29fGEdtR", // Ganti dengan Number Key Anda
            "phone_no" => $params["no_wa"], // Ganti dengan ID grup tujuan
            "message" => $params["pesan"], // Ganti dengan pesan yang ingin dikirim
            "wait_until_send" => "1" // Opsional
        ];
        
        // Konversi data ke JSON
        $json_data = json_encode($data);
        
        // Inisialisasi cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json_data,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);
        
        // Eksekusi API
        $response = curl_exec($curl);
        $response = json_decode($response);

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
  function apiKirimWaRequest($params)
  {
    $curl = curl_init();
    $token = $this->token_;
    $method = $params["method"] ?? "GET";
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      "Authorization: Bearer $token",
      "Content-Type:application/json",
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

  public function download_file($id_surat, $file_surat)
  {

    //load the download helper
    // 		$this->load->helper('download');

    $file_name = $file_surat;

    //$this->transaksi_model->update_read($id_transaksi);

    // 		header("Content-Type:  application/pdf ");
    // 		force_download("upload_file/surat/" . $file_surat, NULL);

    $folder = 'rapat';
    
     
     $this->load->helper('download');
        // $this->load->helper(array('download'));
        force_download('./upload_file/' . $folder . '/' . $file_name, NULL);

    // if ($file_data) {
    //   // Mendapatkan ekstensi file dari nama file
    //   $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

    //   // Mengirim file ke browser
    //   header("Content-Type: application/octet-stream");
    //   header("Content-Disposition: attachment; filename=\"$file_name\"");
    //   echo $file_data;
    // } else {
    //   $this->session->set_flashdata('gagal', "Gagal mengunduh file.");
    //   $this->load->library('user_agent');
    //   redirect($this->agent->referrer());
    // }
  }
  public function hapus($id_rapat)
  {
    $this->kirim_batal($id_rapat);
    $this->master_model->delete('aktivitas', 'id_rapat', $id_rapat); //hapus_akttivitas  
    $this->master_model->delete('rapat', 'id', $id_rapat); // hapus rapat

    $this->session->set_flashdata('sukses', "Berhasil hapus event");
    $this->load->library('user_agent');
    redirect($this->agent->referrer());
  }

  public function get_available_ruangan()
  {
    if ($this->input->is_ajax_request()) {
      $dateTimeRange = $this->input->post('range');
      // Memisahkan tanggal dan waktu mulai serta tanggal dan waktu selesai
      // Memecah tanggal mulai dan selesai
      list($startDateTime, $endDateTime) = explode(" - ", $dateTimeRange);

      // Memformat tanggal dan waktu menjadi objek DateTime
      $startDateTimeObj = DateTime::createFromFormat('m/d/Y h:i a', $startDateTime);
      $endDateTimeObj = DateTime::createFromFormat('m/d/Y h:i a', $endDateTime);

      // Mendapatkan tanggal mulai dan selesai
      $startDate = $startDateTimeObj->format('Y-m-d');
      $endDate = $endDateTimeObj->format('Y-m-d');

      // Mendapatkan jam mulai dan selesai
      $startTime = $startDateTimeObj->format('H:i:s');
      $endTime = $endDateTimeObj->format('H:i:s');

      // $this->db->query("select r.id_ruang_rapat from sipadu_rapat r where r.tanggal = '$startDate' and (r.pukul <= '$startTime' or r.selesai >= '$startTime') ");
      // $data['query'] = $this->db->get();

      $available_ruangan = $this->rapat_model->get_available_ruangan($startDate, $startTime, $endTime);
      $jumlah = count($available_ruangan);
      $new_array = array('id' => '99', 'nama_ruangan' => 'Luar Kantor');
      if ($available_ruangan[$jumlah - 1]['id'] != 99) {
        //   $available_ruangan = array_push($available_ruangan, $new_array);
        $available_ruangan[] = $new_array;
      }
      $data['available_ruangan'] = $available_ruangan;
      $this->output->set_content_type('application/json')->set_output(json_encode($data['available_ruangan']));
      // $this->load->view('event/ruangan_terseedia_view', $data);
    }
  }
}


/* End of file Rapat.php */
/* Location: ./application/controllers/Rapat.php */