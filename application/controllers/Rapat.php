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
class Rapat extends Qrcode_kegiatan
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

    $this->load->vars($data);
    $this->template->load('template/template', 'rapat/list');
  }

  public function tambah() // fungsi ini digunakan untuk menambahkan aktivitas
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('pukul', 'pukul', 'required');

    if ($this->form_validation->run()) {

      $username = $this->session->userdata('username');
      $tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
      $pukul = $this->input->post('pukul');
      $selesai = $this->input->post('selesai');
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
      array_push($username_peserta, $username_pengundang, $username_notulis);
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
        'id_jenis_kegiatan'   => $id_jenis_kegiatan
      );

      $id_rapat = $this->master_model->insert("rapat", $params);
      foreach ($username_peserta as $key => $value) {
        $username_peserta[$key] = array(
          'id_rapat' => $id_rapat,
          'username' => $value,
        );
      }
      foreach ($nama_peserta_eksternal as $key => $value) {
        $peserta_eksternal[$key] = array(
          'id_rapat' => $id_rapat,
          'nama' => $nama_peserta_eksternal[$key],
          'instansi' => $instansi_peserta_eksternal[$key],
        );
      }

      $this->master_model->insert_batch("peserta_rapat", $username_peserta);
      $this->master_model->insert_batch("peserta_rapat_eksternal", $peserta_eksternal);

      $qr = $this->buat_qr($topik, $tanggal);
      if ($qr === FALSE) {
        $this->session->set_flashdata('gagal', "Data yg anda masukan gagal");
      } else {
        $data = array('qrcode' => $qr);
        $this->master_model->update('rapat', 'id', $id_rapat, $data);
        $this->tambah_aktivitas($id_rapat);
        $this->kirim_undangan($id_rapat);
        $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

        redirect('rapat/list');
      }
    } else {

      $data['master_ruang_rapat'] = $this->master_model->get_all('master_ruang_rapat');
      $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
      $this->load->vars($data);
      $this->template->load('template/template', 'rapat/tambah_rapat');
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

            // Panggil API untuk mengunggah file
            $api_url = 'http://sipadu.bpsaceh.com/api/uploadFile';
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
          $api_url = 'http://sipadu.bpsaceh.com/api/uploadFile';
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
          $api_url = 'http://sipadu.bpsaceh.com/api/uploadFile';
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
          $api_url = 'http://sipadu.bpsaceh.com/api/uploadFile';
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
      $this->load->vars($data);
      $this->template->load('template/template', 'rapat/input_notulen');
    }
  }
  public function lihat($id_rapat)
  {
    $data['peserta_rapat_eksternal'] = $this->rapat_model->peserta_rapat_eksternal_id_rapat($id_rapat);
    $data['peserta_rapat'] = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
    $data['detail_rapat'] = $this->rapat_model->get_id($id_rapat);
    $data['dokumentasi_rapat'] = $this->rapat_model->dokumentasi_rapat_id_rapat($id_rapat);

    $this->load->vars($data);
    $this->template->load('template/template', 'rapat/lihat');
  }
  public function hapus($id_rapat)
  {
    $this->master_model->delete('aktivitas', 'id_rapat', $id_rapat); //hapus_akttivitas  
    $this->master_model->delete('rapat', 'id_rapat', $id_rapat); // hapus rapat

    $this->session->set_flashdata('sukses', "Berhasil hapus event");
    $this->load->library('user_agent');
    redirect($this->agent->referrer());
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
Narahubung : $rapat[notulis]

Demikian untuk dilaksanakan, atas perhatian dan kerjasamanya diucapkan terima kasih
",
        "no_wa" => $value["no_wa"],
      ];
      //   print_r($param);
      //   echo "<br>";
      $this->send($param);
    }
  }

  public function tambah_aktivitas($id_rapat)
  {
    $peserta = $this->rapat_model->peserta_rapat_id_rapat($id_rapat);
    $rapat = $this->rapat_model->get_id($id_rapat);
    foreach ($peserta as $key => $value) {
      $params = array(
        'aktivitas' => "Mengikuti " . ($rapat['topik'] ?? null),
        'username' => $value['username'],
        'tanggal' => ($rapat['tanggal'] ?? null),
        'id_rapat' => $id_rapat
      );
      $this->db->insert('aktivitas', $params);
    }
  }


  public function send($params)
  {
    try {
      $dataSending = array();
      $dataSending["api_key"] = "59N5INDJF6I683Z4";
      $dataSending["number_key"] = "YVhQXKP64PPcqO5O";
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
      $insert_params = [

        "status" => $response->status,
        "message" => $response->message,
        "worker_by" => $response->worker_by,
        "ack" => $response->ack,
        "no_wa" => $params['no_wa'],
        "ket" => "undangan rapat"

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


/* End of file Rapat.php */
/* Location: ./application/controllers/Rapat.php */