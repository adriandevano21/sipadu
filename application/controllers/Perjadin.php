<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Perjadin extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_in')) {
    } else {
      redirect('login');
    }
    $this->load->model('rincian_gaji_model');
    $this->load->model('perjadin_model');
    $this->load->model('master_model');
    $this->load->model('ppk_model');
     $this->load->model('pegawai_model');
  }

  public function lihat()
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
    $data['perjadin'] = $this->perjadin_model->get_all_bulan($bulan, $tahun);


    $data['bulan'] = $bulan;
    $data['tahun'] = $tahun;
    $data['judul'] = 'Perjadin';
    $this->load->vars($data);
    $this->template->load('template/template', 'perjadin/lihat');
  }
  
//20241014
  public function lihat2()
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
    $data['perjadin'] = $this->perjadin_model->get_all_bulan2($bulan, $tahun);


    $data['bulan'] = $bulan;
    $data['tahun'] = $tahun;
    $data['judul'] = 'Perjadin';
    $this->load->vars($data);
    $this->template->load('template/template', 'perjadin/lihat');
  }
//20241014

  public function pdf($id_perjadin)
  {
    $this->load->library('pdfgenerator');
    $data['detail_perjadin'] = $this->perjadin_model->get_id($id_perjadin);
    $data['rombongans'] = $this->perjadin_model->get_nama_rombongan($data['detail_perjadin']['tanggal_pergi'],$data['detail_perjadin']['tanggal_pulang'],$data['detail_perjadin']['komponen'],$data['detail_perjadin']['kegiatan']);
    $data['jumlah_rombongans'] = count($data['rombongans']);
    $data['tanggal'] = $this->rangeTanggalIndonesia($data['detail_perjadin']['tanggal_pergi'], $data['detail_perjadin']['tanggal_pulang']);
    $data['dokumentasi_perjadin'] = $this->perjadin_model->dokumentasi_perjadin_id_perjadin($id_perjadin);
    $this->load->vars($data);

    // $this->template->load('template/template', 'perjadin/pdf');
    $html = $this->load->view('perjadin/pdf2', $data, true);
    $this->pdfgenerator->generate($html, "Laporan Perjadin " . $data['detail_perjadin']['nama_pegawai']);
  }
  
  public function pdf2($id_perjadin)
  {
    $this->load->library('pdfgenerator');
    $data['detail_perjadin'] = $this->perjadin_model->get_id($id_perjadin);
    $data['rombongans'] = $this->perjadin_model->get_nama_rombongan($data['detail_perjadin']['tanggal_pergi'],$data['detail_perjadin']['tanggal_pulang'],$data['detail_perjadin']['komponen'],$data['detail_perjadin']['kegiatan']);
    $data['jumlah_rombongans'] = count($data['rombongans']);
    $data['tanggal'] = $this->rangeTanggalIndonesia($data['detail_perjadin']['tanggal_pergi'], $data['detail_perjadin']['tanggal_pulang']);
    $data['dokumentasi_perjadin'] = $this->perjadin_model->dokumentasi_perjadin_id_perjadin($id_perjadin);
    $this->load->vars($data);

    // $this->template->load('template/template', 'perjadin/pdf');
    $html = $this->load->view('perjadin/pdf2', $data, true);
    $this->pdfgenerator->generate($html, "Laporan Perjadin " . $data['detail_perjadin']['nama_pegawai']);
  }

  public function detail($id_perjadin)
  {

    $data['detail_perjadin'] = $this->perjadin_model->get_id($id_perjadin);
    $data['tanggal'] = $this->rangeTanggalIndonesia($data['detail_perjadin']['tanggal_pergi'], $data['detail_perjadin']['tanggal_pulang']);
    $data['dokumentasi_perjadin'] = $this->perjadin_model->dokumentasi_perjadin_id_perjadin($id_perjadin);
    $data['judul'] = 'Perjadin';
    $this->load->vars($data);
    $this->template->load('template/template', 'perjadin/detail');
  }

  public function tambah() // fungsi ini digunakan untuk menambahkan aktivitas
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('kode_tujuan', 'kode_tujuan', 'required');
    
    // print_r($this->input->post('username_peserta2'));
    if ($this->form_validation->run()) {
        
      $username =  (!empty($this->input->post('username'))) ? $this->input->post('username') : $this->session->userdata('username')  ;    
      $tanggal_pergi = date("Y-m-d", strtotime($this->input->post('tanggal_pergi')));
      $tanggal_pulang = date("Y-m-d", strtotime($this->input->post('tanggal_pulang')));
      $date1 = date_create($tanggal_pergi);
      $date2 = date_create($tanggal_pulang);
      $kode_tujuan = $this->input->post('kode_tujuan');
      $no_st = $this->input->post('no_st');
      $komponen = $this->input->post('komponen');
      $program = $this->input->post('program');
      $kegiatan = $this->input->post('kegiatan');
      $status = "diajukan"; // status 0 baru
      $judul = $this->input->post('judul');
      $diff = date_diff($date1, $date2);
      $durasi = $diff->format("%a"); // pulang-pergi, satuan hari
      $deskripsi = $this->input->post('deskripsi');
      $id_jenis_anggaran = $this->input->post('id_jenis_anggaran');
    
      $params = array(
        'username'            => $username,
        'tanggal_pergi'       => $tanggal_pergi,
        'tanggal_pulang'      => $tanggal_pulang,
        'kode_tujuan'         => $kode_tujuan,
        'status'              => $status,
        'no_st'              => $no_st,
        'judul'               => $judul,
        'program'               => $program,
        'kegiatan'               => $kegiatan,
        'komponen'               => $komponen,
        'durasi'              => $durasi + 1,
        'deskripsi'           => $deskripsi,
        'id_jenis_anggaran'  => $id_jenis_anggaran,
        'username_created' => $this->session->userdata('username')
      );
      $id_perjadin = $this->master_model->insert("perjadin", $params);    
        $params2 = array(
            'username'              => $username,
            'aktivitas'             => $judul,
            'status_kerja'          => "progres",
            'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
            'tanggal'               => $tanggal_pergi,
            'id_pk'                 => $id_pk,
            'id_projek'               => $id_projek,
            'pukul'                 => "08:00:00",
            'tanggal_selesai'      => $tanggal_pulang,
            'selesai'                 => "16:00:00",
        );
        $this->master_model->insert("aktivitas", $params2);
        
        $username_peserta = $this->input->post('username_peserta2');
        if(!empty($username_peserta)){
            if (isset($username_peserta)) {
                $username_peserta2 = explode(" ", $username_peserta);
            };
            foreach ($username_peserta2 as $username) {
                $params = array(
                    'username'            => $username,
                    'tanggal_pergi'       => $tanggal_pergi,
                    'tanggal_pulang'      => $tanggal_pulang,
                    'kode_tujuan'         => $kode_tujuan,
                    'status'              => $status,
                    'no_st'              => $no_st,
                    'judul'               => $judul,
                    'program'               => $program,
                    'kegiatan'               => $kegiatan,
                    'komponen'               => $komponen,
                    'durasi'              => $durasi + 1,
                    'deskripsi'           => $deskripsi,
                    'id_jenis_anggaran'  => $id_jenis_anggaran,
                    'username_created' => $this->session->userdata('username')
                    );
            $id_perjadin = $this->master_model->insert("perjadin", $params);
            $params2 = array(
                    'username'              => $username,
                    'aktivitas'             => $judul,
                    'status_kerja'          => "progres",
                    'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                    'tanggal'               => $tanggal_pergi,
                    'id_pk'                 => $id_pk,
                    'id_projek'               => $id_projek,
                    'pukul'                 => "08:00:00",
                    'tanggal_selesai'      => $tanggal_pulang,
                    'selesai'                 => "16:00:00",
                );
                $this->master_model->insert("aktivitas", $params2);
            } 
        }
        
        $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

        redirect('perjadin/lihat');
    } else {
        $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
      $data['master_satker'] = $this->master_model->get_all('master_satker');
      
      $data['judul'] = 'Perjadin';
      $this->load->vars($data);
      $this->template->load('template/template', 'perjadin/tambah_perjadin2');
    }
  }
  
//{20241014
  public function tambah2() // fungsi ini digunakan untuk menambahkan aktivitas
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('kode_tujuan', 'kode_tujuan', 'required');
    
    // print_r($this->input->post('username_peserta2'));
    if ($this->form_validation->run()) {
        
      $username =  (!empty($this->input->post('username'))) ? $this->input->post('username') : $this->session->userdata('username')  ;    
      $tanggal_pergi = date("Y-m-d", strtotime($this->input->post('tanggal_pergi')));
      $tanggal_pulang = date("Y-m-d", strtotime($this->input->post('tanggal_pulang')));
      $date1 = date_create($tanggal_pergi);
      $date2 = date_create($tanggal_pulang);
      $kode_tujuan = $this->input->post('kode_tujuan');
      $no_st = $this->input->post('no_st');
      $komponen = $this->input->post('komponen');
      $program = $this->input->post('program');
      $kegiatan = $this->input->post('kegiatan');
      $status = "diajukan"; // status 0 baru
      $judul = $this->input->post('judul');
      $diff = date_diff($date1, $date2);
      $durasi = $diff->format("%a"); // pulang-pergi, satuan hari
      $deskripsi = $this->input->post('deskripsi');
      $id_jenis_anggaran = $this->input->post('id_jenis_anggaran');
      
    
      $params = array(
        'username'            => $username,
        'tanggal_pergi'       => $tanggal_pergi,
        'tanggal_pulang'      => $tanggal_pulang,
        'kode_tujuan'         => $kode_tujuan,
        'status'              => $status,
        'no_st'              => $no_st,
        'judul'               => $judul,
        'program'               => $program,
        'kegiatan'               => $kegiatan,
        'komponen'               => $komponen,
        'durasi'              => $durasi + 1,
        'deskripsi'           => $deskripsi,
        'id_jenis_anggaran'  => $id_jenis_anggaran,
        'username_created' => $this->session->userdata('username')
      );
      $id_perjadin = $this->master_model->insert("perjadin", $params);
      
        $tanggalinput = $tanggal_pergi;
        $pengulangans = range(1,$durasi+1);
        foreach ($pengulangans as $pengulangan) {
            $params2 = array(
                'username'              => $username,
                'aktivitas'             => $judul,
                'status_kerja'          => "progres",
                'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                'tanggal'               => $tanggalinput,
                'id_pk'                 => $id_pk,
                'id_projek'               => $id_projek,
                'pukul'                 => "08:00:00",
                'tanggal_selesai'      => $tanggalinput,
                'selesai'                 => "16:00:00",
            );
            $this->master_model->insert("aktivitas", $params2);
            $tanggalinput = date('Y-m-d', strtotime($tanggal_pergi) + 86400*$pengulangan);
        };
        
        
        $username_peserta = $this->input->post('username_peserta2');
        if(!empty($username_peserta)){
            if (isset($username_peserta)) {
                $username_peserta2 = explode(" ", $username_peserta);
            };
            foreach ($username_peserta2 as $username) {
                $params = array(
                    'username'            => $username,
                    'tanggal_pergi'       => $tanggal_pergi,
                    'tanggal_pulang'      => $tanggal_pulang,
                    'kode_tujuan'         => $kode_tujuan,
                    'status'              => $status,
                    'no_st'              => $no_st,
                    'judul'               => $judul,
                    'program'               => $program,
                    'kegiatan'               => $kegiatan,
                    'komponen'               => $komponen,
                    'durasi'              => $durasi + 1,
                    'deskripsi'           => $deskripsi,
                    'id_jenis_anggaran'  => $id_jenis_anggaran,
                    'username_created' => $this->session->userdata('username')
                    );
                $id_perjadin = $this->master_model->insert("perjadin", $params);
                
                $tanggalinput = $tanggal_pergi;
                $pengulangans = range(1,$durasi+1);
                foreach ($pengulangans as $pengulangan) {
                    $params2 = array(
                        'username'              => $username,
                        'aktivitas'             => $judul,
                        'status_kerja'          => "progres",
                        'username_pemberi_aktivitas' => $username_pemberi_aktivitas,
                        'tanggal'               => $tanggalinput,
                        'id_pk'                 => $id_pk,
                        'id_projek'               => $id_projek,
                        'pukul'                 => "08:00:00",
                        'tanggal_selesai'      => $tanggalinput,
                        'selesai'                 => "16:00:00",
                    );
                    $this->master_model->insert("aktivitas", $params2);
                    $tanggalinput = date('Y-m-d', strtotime($tanggal_pergi) + 86400*$pengulangan);
                };
                
            } 
        }
        
        $this->session->set_flashdata('sukses', "Data yg anda masukan berhasil");

        redirect('perjadin/lihat');
    } else {
        $data['master_pegawai'] = $this->pegawai_model->get_all_pegawai();
      $data['master_satker'] = $this->master_model->get_all('master_satker');
      
      $data['judul'] = 'Perjadin';
      $this->load->vars($data);
      $this->template->load('template/template', 'perjadin/tambah_perjadin2');
    }
  }
//20241014}

  public function tolak($id_perjadin)
  {

    $params = array(
      'status'      => "ditolak",
      'ditolak_timestamp' => date("Y-m-d h:i:s"),
    );
    $this->master_model->update('perjadin', 'id', $id_perjadin, $params);
  }
  public function dashboard()
  {

    $tahun = date('Y');
    $data['perjadin'] = $this->perjadin_model->tujuan_perjadin($tahun);
    $data['judul'] = 'Perjadin';
    $this->load->vars($data);
    $this->template->load('template/template', 'perjadin/dashboard');
  }

  public function setujui($id_perjadin)
  {

    $params = array(
      'status'      => "disetujui",
      'disetujui_timestamp' => date("Y-m-d h:i:s"),
    );
    $this->master_model->update('perjadin', 'id', $id_perjadin, $params);
    $this->kirim_notif_ppk($id_perjadin);
    $this->session->set_flashdata('sukses', "Anda berhasil menyutujui perjalanan dinas");

    redirect('perjadin/lihat');
  }

  public function input_laporan($id_perjadin)
  {
    // $id_perjadin = $this->input->post('id_perjadin');
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('uraian_kegiatan', 'uraian_kegiatan', 'required');
    // $this->form_validation->set_rules('permasalahan', 'permasalahan', 'required');

    if ($this->form_validation->run()) {
    //   $permasalahan = $this->input->post('permasalahan');
      $uraian_kegiatan = $this->input->post('uraian_kegiatan');
      $solusi = $this->input->post('solusi');
      $pejabat = $this->input->post('pejabat');
      $dukungan = $this->input->post('dukungan');
      $program = $this->input->post('program');
      $komponen = $this->input->post('komponen');
      $kegiatan = $this->input->post('kegiatan');
    //   $pengesahan = $this->input->post('pengesahan');
      $caption1 = $this->input->post('caption1');
      $caption2 = $this->input->post('caption2');
      $jabatan = $this->input->post('jabatan');
      $username_pejabat = $this->input->post('username_pejabat');

      $this->load->library('upload');
      $new_name1 = 'perjadin_' . $this->session->userdata('nip') . '_' . $_FILES["upload_foto1"]['name'];
      $new_name2 = 'perjadin_' . $this->session->userdata('nip') . '_' . $_FILES["upload_foto2"]['name'];
      $config1['file_name'] = $new_name1;
      $config1['upload_path'] = './upload_file/perjadin/'; //path folder
      $config1['allowed_types'] = 'jpeg|jpg|png'; //type yang dapat diakses bisa anda sesuaikan
      $config1['max_size'] = '10000'; //maksimum besar file 300 kb

      $config2['file_name'] = $new_name2;
      $config2['upload_path'] = './upload_file/perjadin/'; //path folder
      $config2['allowed_types'] = 'jpeg|jpg|png'; //type yang dapat diakses bisa anda sesuaikan
      $config2['max_size'] = '10000'; //maksimum besar file 300 kb

      $this->upload->initialize($config1);

      if ($this->upload->do_upload('upload_foto1')) {
        $gbr[] = $this->upload->data();
        $nama_file1 = $gbr['0']['file_name'];
      }  
    
      $this->upload->initialize($config2);

      if ($this->upload->do_upload('upload_foto2')) {
        $gbr2[] = $this->upload->data();
        $nama_file2 = $gbr2['0']['file_name'];
      }  
      $params = array(
        
        'dukungan'            => $dukungan,
        'uraian_kegiatan'    => $uraian_kegiatan,
        'program'            => $program,
        'komponen'            => $komponen,
        'pejabat'            => $pejabat,
        'kegiatan'            => $kegiatan,
        'caption1'            => $caption1,
        'caption2'            => $caption2,
        'jabatan'            => $jabatan,
        'username_pejabat'            => $username_pejabat,
        // 'pengesahan'            => $pengesahan,
        'laporan_timestamp' => date("Y-m-d h:i:s"),
        'status' => "laporan selesai",
      );
      
      if(!empty($nama_file1)){
          $params['foto1'] = $nama_file1;
      }
      if(!empty($nama_file2)){
          $params['foto2'] = $nama_file2;
      }

      if (!empty($data)) {
        $this->master_model->insert_batch("dokumentasi_perjadin", $data);
      }
    
    $detail_perjadin = $this->perjadin_model->get_id($id_perjadin);
    $rombongans = $this->perjadin_model->get_nama_rombongan($detail_perjadin['tanggal_pergi'],$detail_perjadin['tanggal_pulang'],$detail_perjadin['komponen'],$detail_perjadin['kegiatan']);
    foreach ($rombongans as $datarombongans) {
      $this->master_model->update('perjadin', 'id', $datarombongans['id'], $params);
    };
    
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    //   redirect('perjadin/lihat');
      // $this->lihat($id_perjadin);
    } else {
      $data['detail_perjadin'] = $this->perjadin_model->get_id($id_perjadin);
      $data['rombongans'] = $this->perjadin_model->get_nama_rombongan($data['detail_perjadin']['tanggal_pergi'],$data['detail_perjadin']['tanggal_pulang'],$data['detail_perjadin']['komponen'],$data['detail_perjadin']['kegiatan']);
      $data['jumlah_rombongans'] = count($data['rombongans']);
      $data['dokumentasi_perjadin'] = $this->perjadin_model->dokumentasi_perjadin_id_perjadin($id_perjadin);
      $data['tanggal'] = $this->rangeTanggalIndonesia($data['detail_perjadin']['tanggal_pergi'], $data['detail_perjadin']['tanggal_pulang']);
      $data['pegawai'] = $this->pegawai_model->get_all_ketua_tim();
      $data['judul'] = 'Perjadin';
      $this->load->vars($data);
      $this->template->load('template/template', 'perjadin/input_laporan_2');
    }
  }
 
//{20241029
  public function input_laporan_2($id_perjadin)
  {
    // $id_perjadin = $this->input->post('id_perjadin');
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('uraian_kegiatan', 'uraian_kegiatan', 'required');
    // $this->form_validation->set_rules('permasalahan', 'permasalahan', 'required');

    if ($this->form_validation->run()) {
    //   $permasalahan = $this->input->post('permasalahan');
      $uraian_kegiatan = $this->input->post('uraian_kegiatan');
      $solusi = $this->input->post('solusi');
      $pejabat = $this->input->post('pejabat');
      $dukungan = $this->input->post('dukungan');
      $program = $this->input->post('program');
      $komponen = $this->input->post('komponen');
      $kegiatan = $this->input->post('kegiatan');
    //   $pengesahan = $this->input->post('pengesahan');
      $caption1 = $this->input->post('caption1');
      $caption2 = $this->input->post('caption2');
      $jabatan = $this->input->post('jabatan');
      $username_pejabat = $this->input->post('username_pejabat');

      $this->load->library('upload');
      $new_name1 = 'perjadin_' . $this->session->userdata('nip') . '_' . $_FILES["upload_foto1"]['name'];
      $new_name2 = 'perjadin_' . $this->session->userdata('nip') . '_' . $_FILES["upload_foto2"]['name'];
      $config1['file_name'] = $new_name1;
      $config1['upload_path'] = './upload_file/perjadin/'; //path folder
      $config1['allowed_types'] = 'jpeg|jpg|png'; //type yang dapat diakses bisa anda sesuaikan
      $config1['max_size'] = '10000'; //maksimum besar file 300 kb

      $config2['file_name'] = $new_name2;
      $config2['upload_path'] = './upload_file/perjadin/'; //path folder
      $config2['allowed_types'] = 'jpeg|jpg|png'; //type yang dapat diakses bisa anda sesuaikan
      $config2['max_size'] = '10000'; //maksimum besar file 300 kb

      $this->upload->initialize($config1);

      if ($this->upload->do_upload('upload_foto1')) {
        $gbr[] = $this->upload->data();
        $nama_file1 = $gbr['0']['file_name'];
      }  
    
      $this->upload->initialize($config2);

      if ($this->upload->do_upload('upload_foto2')) {
        $gbr2[] = $this->upload->data();
        $nama_file2 = $gbr2['0']['file_name'];
      }  
      $params = array(
        
        'dukungan'            => $dukungan,
        'uraian_kegiatan'    => $uraian_kegiatan,
        'program'            => $program,
        'komponen'            => $komponen,
        'pejabat'            => $pejabat,
        'kegiatan'            => $kegiatan,
        'caption1'            => $caption1,
        'caption2'            => $caption2,
        'jabatan'            => $jabatan,
        'username_pejabat'            => $username_pejabat,
        // 'pengesahan'            => $pengesahan,
        'laporan_timestamp' => date("Y-m-d h:i:s"),
        'status' => "laporan selesai",
      );
      
      if(!empty($nama_file1)){
          $params['foto1'] = $nama_file1;
      }
      if(!empty($nama_file2)){
          $params['foto2'] = $nama_file2;
      }

      if (!empty($data)) {
        $this->master_model->insert_batch("dokumentasi_perjadin", $data);
      }
    
    $detail_perjadin = $this->perjadin_model->get_id($id_perjadin);
    $rombongans = $this->perjadin_model->get_nama_rombongan($detail_perjadin['tanggal_pergi'],$detail_perjadin['tanggal_pulang'],$detail_perjadin['komponen'],$detail_perjadin['kegiatan']);
    foreach ($rombongans as $datarombongans) {
      $this->master_model->update('perjadin', 'id', $datarombongans['id'], $params);
    };
    
      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    //   redirect('perjadin/lihat');
      // $this->lihat($id_perjadin);
    } else {
      $data['detail_perjadin'] = $this->perjadin_model->get_id($id_perjadin);
      $data['rombongans'] = $this->perjadin_model->get_nama_rombongan($data['detail_perjadin']['tanggal_pergi'],$data['detail_perjadin']['tanggal_pulang'],$data['detail_perjadin']['komponen'],$data['detail_perjadin']['kegiatan']);
      $data['jumlah_rombongans'] = count($data['rombongans']);
      $data['dokumentasi_perjadin'] = $this->perjadin_model->dokumentasi_perjadin_id_perjadin($id_perjadin);
      $data['tanggal'] = $this->rangeTanggalIndonesia($data['detail_perjadin']['tanggal_pergi'], $data['detail_perjadin']['tanggal_pulang']);
      $data['pegawai'] = $this->pegawai_model->get_all_ketua_tim();
      $data['judul'] = 'Perjadin';
      $this->load->vars($data);
      $this->template->load('template/template', 'perjadin/input_laporan_2');
    }
  }
//20241029}
  
  public function input_laporan222($id_perjadin)
  {
    // $id_perjadin = $this->input->post('id_perjadin');
    // $caption1 = $this->input->post('caption1');
    // $caption2 = $this->input->post('caption2');
    $this->load->library('form_validation');
    $this->form_validation->set_rules('uraian_kegiatan', 'uraian_kegiatan', 'required');
    // $this->form_validation->set_rules('permasalahan', 'permasalahan', 'required');

    if ($this->form_validation->run()) {
    //   $permasalahan = $this->input->post('permasalahan');
      $uraian_kegiatan = $this->input->post('uraian_kegiatan');
      $solusi = $this->input->post('solusi');
      $pejabat = $this->input->post('pejabat');
      $dukungan = $this->input->post('dukungan');
      $program = $this->input->post('program');
      $komponen = $this->input->post('komponen');
      $pengesahan = $this->input->post('pengesahan');
      $params = array(
        // 'permasalahan'      => $permasalahan,
        // 'solusi'            => $solusi,
        'pejabat'            => $pejabat,
        'dukungan'            => $dukungan,
        'uraian_kegiatan'    => $uraian_kegiatan,
        'program'            => $program,
        'komponen'            => $komponen,
        'pengesahan'            => $pengesahan,
        'laporan_timestamp' => date("Y-m-d h:i:s"),
        'status' => "laporan selesai",
      );

      $this->master_model->update('perjadin', 'id', $id_perjadin, $params);

      $this->load->library('upload');
      $new_name1 = 'perjadin_' . $this->session->userdata('nip') . '_' . $_FILES["upload_foto1"]['name'];
      $new_name2 = 'perjadin_' . $this->session->userdata('nip') . '_' . $_FILES["upload_foto2"]['name'];
      $config1['file_name'] = $new_name1;
      $config1['upload_path'] = './upload_file/perjadin/'; //path folder
      $config1['allowed_types'] = 'jpeg|jpg|png'; //type yang dapat diakses bisa anda sesuaikan
      $config1['max_size'] = '10000'; //maksimum besar file 300 kb

      $config2['file_name'] = $new_name2;
      $config2['upload_path'] = './upload_file/perjadin/'; //path folder
      $config2['allowed_types'] = 'jpeg|jpg|png'; //type yang dapat diakses bisa anda sesuaikan
      $config2['max_size'] = '10000'; //maksimum besar file 300 kb

      $this->upload->initialize($config1);

      // $files = $_FILES['template'];
      // $this->upload->do_upload('template');

      //   echo $new_name1;

      if ($this->upload->do_upload('upload_foto1')) {
        $gbr[] = $this->upload->data();
        $nama_file = $gbr['0']['file_name'];
        // print_r($gbr);
        $data[] = array(
          'nama_file' =>  $nama_file,
          'id_perjadin' => $id_perjadin,
          'caption' => $caption1
        );
      }  
    //   else {
    //     echo 'gagal upload file';
    //     echo  $this->upload->display_errors('<p>', '</p>');
    //     //return false;
    //   }

      $this->upload->initialize($config2);

      if ($this->upload->do_upload('upload_foto2')) {
        $gbr2[] = $this->upload->data();
        $nama_file2 = $gbr2['0']['file_name'];
        // print_r($gbr);
        $data[] = array(
          'nama_file' =>  $nama_file2,
          'id_perjadin' => $id_perjadin,
          'caption' => $caption2
        );
      }  
    //   else {
    //     // echo  $this->upload->display_errors();
    //     echo 'gagal upload file';
    //     echo  $this->upload->display_errors('<p>', '</p>');
    //     //return false;
    //   }

      if (!empty($data)) {
        $this->master_model->insert_batch("dokumentasi_perjadin", $data);
      }


      $this->load->library('user_agent');
      redirect($this->agent->referrer());
    //   redirect('perjadin/lihat');
      // $this->lihat($id_perjadin);
    } else {
      $data['detail_perjadin'] = $this->perjadin_model->get_id($id_perjadin);
      $data['dokumentasi_perjadin'] = $this->perjadin_model->dokumentasi_perjadin_id_perjadin($id_perjadin);
      $data['tanggal'] = $this->rangeTanggalIndonesia($data['detail_perjadin']['tanggal_pergi'], $data['detail_perjadin']['tanggal_pulang']);
      $data['judul'] = 'Perjadin';
      $this->load->vars($data);
      $this->template->load('template/template', 'perjadin/input_laporan');
    }
  }

  public function kirim_notif_ppk($id_perjadin)
  {

    $detail_perjadin = $this->perjadin_model->get_id($id_perjadin);
    $ppk = $this->ppk_model->get_id_jenis_anggaran($detail_perjadin['id_jenis_anggaran']);

    $param = [
      "pesan" => "*Notifikasi Perjadin*
				
Kepala BPS Provinsi Aceh telah menyutujui perjalanan dinas dengan rincian sebagai berikut:

Nama : $detail_perjadin[nama_pegawai]
Tujuan/Tugas : $detail_perjadin[judul]
Waktu Pelaksanaan : $detail_perjadin[tanggal_pergi]
Durasi : $detail_perjadin[durasi] Hari
Tempat Tujuan : $detail_perjadin[nama_satker]

Demikian,atas perhatian dan kerjasamanya diucapkan terima kasih
",
      "no_wa" => "$ppk[no_wa]",
    ];
    //   print_r($param);
    //   echo "<br>";
    $this->send($param);
  }

  public function kirim_undangan($id_perjadin)
  {
    $detail_perjadin = $this->perjadin_model->get_id($id_perjadin);

    $param = [
      "pesan" => "*Notifikasi Perjadin*
				
Saudara/i $detail_perjadin[nama_pegawai] telah mengajukan perjalanan dinas dengan rincian sebagai berikut:

Tujuan/Tugas : $detail_perjadin[judul]
Waktu Pelaksanaan : $detail_perjadin[tanggal_pergi]
Durasi : $detail_perjadin[durasi] Hari
Tempat Tujuan : $detail_perjadin[nama_satker]

Demikian untuk ditindaklanjutin di link s.id/sipadu1100, atas perhatian dan kerjasamanya diucapkan terima kasih
",
      "no_wa" => "6281288766444", // kirim ke pa riswan
    ];
    //   print_r($param);
    //   echo "<br>";
    $this->send($param);
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

      ];
      $this->master_model->insert("status_watzap", $insert_params);
    } catch (Exception $e) {
      print_r($e);
    }
  }
  
  public function hapus($id_perjadin)
  {
    
    $this->master_model->delete('perjadin', 'id', $id_perjadin); // hapus rapat

    $this->session->set_flashdata('sukses', "Berhasil hapus perjadin");
    $this->load->library('user_agent');
    redirect($this->agent->referrer());
  }
  
  
  function rangeTanggalIndonesia($tanggalAwal, $tanggalAkhir)
  {
    // Array nama bulan dalam bahasa Indonesia
    $namaBulan = array(
      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    // Memecah tanggal awal menjadi komponen (tahun, bulan, hari)
    $komponenTanggalAwal = explode('-', $tanggalAwal);
    $tahunAwal = $komponenTanggalAwal[0];
    $bulanAwal = $komponenTanggalAwal[1];
    $hariAwal = $komponenTanggalAwal[2];

    // Memecah tanggal akhir menjadi komponen (tahun, bulan, hari)
    $komponenTanggalAkhir = explode('-', $tanggalAkhir);
    $tahunAkhir = $komponenTanggalAkhir[0];
    $bulanAkhir = $komponenTanggalAkhir[1];
    $hariAkhir = $komponenTanggalAkhir[2];

    // Mengubah format bulan menjadi nama bulan dalam bahasa Indonesia
    $bulanAwalIndonesia = $namaBulan[(int)$bulanAwal - 1];

    // Mengecek apakah tanggal awal dan tanggal akhir sama
    if ($tanggalAwal === $tanggalAkhir) {
      // Jika tanggal sama, hanya menampilkan satu tanggal
      $rentangTanggalIndonesia = $hariAwal . ' ' . $bulanAwalIndonesia . ' ' . $tahunAwal;
    } else {
      // Jika tanggal berbeda, menampilkan rentang tanggal
      $bulanAkhirIndonesia = $namaBulan[(int)$bulanAkhir - 1];
      if($bulanAkhirIndonesia === $bulanAwalIndonesia ){
          $rentangTanggalIndonesia = $hariAwal . ' - ' . $hariAkhir . ' ' . $bulanAkhirIndonesia . ' ' . $tahunAkhir;
      } else {
          $rentangTanggalIndonesia = $hariAwal . ' ' . $bulanAwalIndonesia . ' - ' . $hariAkhir . ' ' . $bulanAkhirIndonesia . ' ' . $tahunAkhir;
      }
      
    }

    return $rentangTanggalIndonesia;
  }
  
}


/* End of file Perjadin.php */
/* Location: ./application/controllers/Perjadin.php */