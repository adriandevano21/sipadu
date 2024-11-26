<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/api_watzap.php';
class Surat extends CI_Controller
{
	private $token_ = "_{ptZD^ei_u=ZFyV9Y|j_v1VOYXLPB|7}gTBl^hEP4vx}hpk-ichsan";
	private $DEVICE_ID = "iphone";
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged_in')) {
		} else {
			redirect('login');
		}
		$this->load->model('surat_model');
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

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;


		$data['surat'] = $this->surat_model->get_all_bulan($bulan, $tahun);

		$data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();
		$data['klasifikasi'] = $this->master_model->get_all('klasifikasi');
		$data['pegawai'] = $this->pegawai_model->get_all_ketua_tim();
		$data['judul'] = 'Surat';
		$this->load->vars($data);
		$this->template->load('template/template', 'surat/list');
	}

	function kirim_sekre()
	{
		$id_surat = $this->input->post('id_surat');
		$username3 = 'nelvi';
// 		$username3 = 'cutfatin-pppk'; // saat ini kirim ke fatin atau sekre gunadi.subagia
        // $username3 = 'gunadi.subagia'; // saat ini kirim ke fatin atau sekre 
		$catatan2 = $this->input->post('catatan2');
		$params = array(
			'username3' => $username3,
			'catatan2' => $catatan2,
			'update2' => date('Y-m-d H:i:s'),
		);

		$this->master_model->update('surat', 'id_surat', $id_surat, $params);
		$this->kirim_notif_sekre($id_surat);

		$this->session->set_flashdata('sukses', "Data berhasil dikirimkan");
		$this->load->library('user_agent');
		redirect($this->agent->referrer());
	}
	function kirim_draft_surat()
	{
		$id_surat = $this->input->post('id_surat');
		$username2 = $this->input->post('username2');
		$catatan1 = $this->input->post('catatan1');
		$link = $this->input->post('link');
		$params = array(
			'username2' => $username2,
			'link' => $link,
			'catatan1' => $catatan1,
			'update1' => date('Y-m-d H:i:s'),
		);

		$this->master_model->update('surat', 'id_surat', $id_surat, $params);
		$this->kirim_notif($id_surat);

		$this->session->set_flashdata('sukses', "Data berhasil dikirimkan");
		$this->load->library('user_agent');
		redirect($this->agent->referrer());
	}

	// format RB: B-001/RB/BPS/1100/04/2021
	// format umum: B.001/BPS/11560/4/2021

	public function tambah_surat()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('perihal', 'perihal', 'required');
		if ($this->form_validation->run()) {

			// 			$kategori= $this->input->post('kategori');
			$sifat = $this->input->post('sifat');
			$unit_kerja = $this->input->post('unit_kerja');
			$tanggal = $this->input->post('tanggal');
			$tanggal = date('Y-m-d', strtotime($tanggal));
			$perihal = $this->input->post('perihal');
			$tujuan = $this->input->post('tujuan');
			$klasifikasi = $this->input->post('klasifikasi');
			$klasifikasi = explode(",", $klasifikasi);
			$kode = $klasifikasi[0];
			$id_klasifikasi = $klasifikasi[1];

			$params = array(
				'unit_kerja' => $unit_kerja,
				'tanggal' => $tanggal,
				// 'tanggal' => date('Y-m-d'),
				'perihal' => $perihal,
				'tujuan' => $tujuan,
				'sifat' => $sifat,
				'kode'  => $klasifikasi[0],
				'id_klasifikasi'  => $klasifikasi[1],
			);

			$surat = $this->surat_biasa($params);
			$surat['tujuan'] = $tujuan;
			$id_surat = $this->surat_model->add($surat);
			// $this->kirim_notif($id_surat);

			$this->session->set_flashdata('sukses', "Data berhasil ditambahkan");
			$this->session->set_flashdata('no_surat_baru', $surat['no_surat']);
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
		} else {
			$data['surat'] = $this->surat_model->get_all();
			$data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();

			$this->session->set_flashdata('gagal', "Gagal membuat no surat");
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
		}

		$data = null;
		$data['judul'] = 'Surat';
		$this->load->vars($data);
		$this->template->load('template/template', 'surat/list');
	}
	public function edit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('perihal', 'perihal', 'required');
		if ($this->form_validation->run()) {
			$id_surat = $this->input->post('id_surat');
			$surat = $this->master_model->get_id('surat', 'id_surat', $id_surat);
			$sifat = $this->input->post('sifat');
			$no = $this->input->post('no');
			$unit_kerja = $this->input->post('unit_kerja');
			$perihal = $this->input->post('perihal');
			$tujuan = $this->input->post('tujuan');
			$klasifikasi = $this->input->post('klasifikasi');
			$klasifikasi = explode(",", $klasifikasi);
			$kode = $klasifikasi[0];
			$id_klasifikasi = $klasifikasi[1];
			$no_surat = $sifat . $no . '/' . $unit_kerja . '/' . $kode . '/' . $surat['bulan'] . '/' . $surat['tahun'];

			$params = array(
				'unit_kerja' => $unit_kerja,
				'perihal' => $perihal,
				'tujuan' => $tujuan,
				'awalan' => $sifat,
				'kode'  => $klasifikasi[0],
				'id_klasifikasi'  => $klasifikasi[1],
				'no_surat' => $no_surat,
			);
			$this->master_model->update('surat', 'id_surat', $id_surat, $params);

			$this->session->set_flashdata('sukses', "Data berhasil diupdate");
			$this->session->set_flashdata('no_surat_baru', $no_surat);
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
		} else {
			$data['surat'] = $this->surat_model->get_all();
			$data['unit_kerja'] = $this->db->select('*')->from('master_unit_kerja')->where('aktif', 1)->get()->result_array();

			$this->session->set_flashdata('gagal', "Gagal membuat no surat");
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
		}

		$data = null;
		$data['judul'] = 'Surat';
		$this->load->vars($data);
		$this->template->load('template/template', 'surat/list');
	}


	public function surat_biasa_lama($params)
	{
		// format : B-001/11000/FF.000/04/2021 

		$surat_sebelum = $this->db->select('*')->from('surat')->where('tanggal <=', $params['tanggal'])->where('tahun', date('Y'))->like('unit_kerja', substr($params['unit_kerja'], 0, 4))->order_by('no', 'desc')->get()->row_array(); //ambil surat terakhir sebelum/sama dengan tanggal tersebut

		$no_surat_sebelum_sama = $this->db->select('*')->from('surat')->like('unit_kerja', substr($params['unit_kerja'], 0, 4))->where('tahun', date('Y'))->where('no', $surat_sebelum['no'])->order_by('id_surat', 'desc')->get()->row_array(); //ambil surat terakhir setelah tanggal tersebut

		$surat_sesudah = $this->db->select('*')->from('surat')->like('unit_kerja', substr($params['unit_kerja'], 0, 4))->where('no', $surat_sebelum['no'] + 1)->where('tahun', date('Y'))->order_by('id_surat', 'desc')->get()->row_array(); //ambil surat terakhir setelah tanggal tersebut

		if (!empty($surat_sesudah)) { // untuk sisip surat
			$no_sebelum = $surat_sebelum['no'];
			$no_baru = $no_sebelum;
			if (empty($no_surat_sebelum_sama['sub_no'])) {
				//ascii A = 65
				$sub_no = 65;
			} else {
				$sub_no = $no_surat_sebelum_sama['sub_no'] + 1;
			}
			$bulan = date('m', strtotime($params['tanggal']));
			$tahun = date('Y', strtotime($params['tanggal']));

			$awalan = $params['sifat'];
			// 			$no_surat= $awalan.sprintf("%03d",$no_baru).chr($sub_no)."/"."BPS"."/".$unit_kerja."/".sprintf("%02d",$bulan)."/".$tahun;
			$no_surat = $awalan . sprintf("%03d", $no_baru) . chr($sub_no) . "/" . $params['unit_kerja'] . "/" . $params['kode'] . "/" . sprintf("%02d", $bulan) . "/" . $tahun;
			$surat = array(
				'bulan' => $bulan,
				'tahun' => $tahun,
				'no' => $no_baru,
				'unit_kerja' => $params['unit_kerja'],
				// 'kategori' => $params['kategori'],
				'no_surat' => $no_surat,
				'sub_no' => $sub_no,
				'perihal' => $params['perihal'],
				'awalan' => $awalan,
				'bps' => "BPS",
				'username' => $this->session->userdata('username'),
				'tanggal' => $params['tanggal'],
				'kode' => $params['kode'],
				'id_klasifikasi' => $params['id_klasifikasi'],
			);
			return $surat;
		} else {
			$no_sebelum = $surat_sebelum['no'];
			$no_baru = $no_sebelum + 1;

			$bulan = date('m', strtotime($params['tanggal']));
			$tahun = date('Y', strtotime($params['tanggal']));

			$awalan = $params['sifat'];
			// 			$no_surat= $awalan.sprintf("%03d",$no_baru)."/"."BPS"."/".$unit_kerja."/".sprintf("%02d",$bulan)."/".$tahun;
			$no_surat = $awalan . sprintf("%03d", $no_baru) . "/" . $params['unit_kerja'] . "/" . $params['kode'] . "/" . sprintf("%02d", $bulan) . "/" . $tahun;
			$surat = array(
				'bulan' => $bulan,
				'tahun' => $tahun,
				'no' => $no_baru,
				'unit_kerja' => $params['unit_kerja'],
				// 'kategori' => $params['kategori'],
				'no_surat' => $no_surat,
				// 'sub_no' => $sub_no,
				'perihal' => $params['perihal'],
				'awalan' => $awalan,
				'bps' => "BPS",
				'username' => $this->session->userdata('username'),
				'tanggal' => $params['tanggal'],
				'kode' => $params['kode'],
				'id_klasifikasi' => $params['id_klasifikasi'],
			);
			return $surat;
		}
	}
	public function surat_biasa($params)
	{
		// format : B-001/11000/FF.000/04/2021 

		$surat_sebelum = $this->db->select('*')->from('surat')->where('tanggal <=', $params['tanggal'])->where('tahun', date('Y'))->like('unit_kerja', substr($params['unit_kerja'], 0, 4))->order_by('no', 'desc')->get()->row_array(); //ambil surat terakhir sebelum/sama dengan tanggal tersebut

		$no_surat_sebelum_sama = $this->db->select('*')->from('surat')->like('unit_kerja', substr($params['unit_kerja'], 0, 4))->where('tahun', date('Y'))->where('no', $surat_sebelum['no'])->order_by('id_surat', 'desc')->get()->row_array(); //ambil surat terakhir setelah tanggal tersebut

		$surat_sesudah = $this->db->select('*')->from('surat')->like('unit_kerja', substr($params['unit_kerja'], 0, 4))->where('no', $surat_sebelum['no'] + 1)->where('tahun', date('Y'))->order_by('id_surat', 'desc')->get()->row_array(); //ambil surat terakhir setelah tanggal tersebut

		if (!empty($surat_sesudah)) { // untuk sisip surat
			$no_sebelum = $surat_sebelum['no'];
			$no_baru = $no_sebelum;
			if (empty($no_surat_sebelum_sama['sub_no'])) {
				//ascii A = 65
				$sub_no = 65;
			} else {
				$sub_no = $no_surat_sebelum_sama['sub_no'] + 1;
			}
			$bulan = date('m', strtotime($params['tanggal']));
			$tahun = date('Y', strtotime($params['tanggal']));

			$awalan = $params['sifat'];
			// 			$no_surat= $awalan.sprintf("%03d",$no_baru).chr($sub_no)."/"."BPS"."/".$unit_kerja."/".sprintf("%02d",$bulan)."/".$tahun;
			$no_surat = $awalan . $no_baru . chr($sub_no) . "/" . $params['unit_kerja'] . "/" . $params['kode'] . "/" . $tahun;
			$surat = array(
				'bulan' => $bulan,
				'tahun' => $tahun,
				'no' => $no_baru,
				'unit_kerja' => $params['unit_kerja'],
				// 'kategori' => $params['kategori'],
				'no_surat' => $no_surat,
				'sub_no' => $sub_no,
				'perihal' => $params['perihal'],
				'awalan' => $awalan,
				'bps' => "BPS",
				'username' => $this->session->userdata('username'),
				'tanggal' => $params['tanggal'],
				'kode' => $params['kode'],
				'id_klasifikasi' => $params['id_klasifikasi'],
			);
			return $surat;
		} else {
			$no_sebelum = $surat_sebelum['no'];
			$no_baru = $no_sebelum + 1;

			$bulan = date('m', strtotime($params['tanggal']));
			$tahun = date('Y', strtotime($params['tanggal']));

			$awalan = $params['sifat'];
			// 			$no_surat= $awalan.sprintf("%03d",$no_baru)."/"."BPS"."/".$unit_kerja."/".sprintf("%02d",$bulan)."/".$tahun;
			$no_surat = $awalan . $no_baru . "/" . $params['unit_kerja'] . "/" . $params['kode'] . "/" . $tahun;
			$surat = array(
				'bulan' => $bulan,
				'tahun' => $tahun,
				'no' => $no_baru,
				'unit_kerja' => $params['unit_kerja'],
				// 'kategori' => $params['kategori'],
				'no_surat' => $no_surat,
				// 'sub_no' => $sub_no,
				'perihal' => $params['perihal'],
				'awalan' => $awalan,
				'bps' => "BPS",
				'username' => $this->session->userdata('username'),
				'tanggal' => $params['tanggal'],
				'kode' => $params['kode'],
				'id_klasifikasi' => $params['id_klasifikasi'],
			);
			return $surat;
		}
	}

	public function Upload3333()
	{

		$this->load->library('upload');

		$config['upload_path'] = './upload_file/surat/'; //path folder
		$config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size'] = '100000'; //maksimum besar file 2M

		$this->upload->initialize($config);

		// $files = $_FILES['template'];
		// $this->upload->do_upload('template');

		if ($this->upload->do_upload('file_surat')) {
			$gbr[] = $this->upload->data();
			$nama_file = $gbr['0']['file_name'];
			$file_path = $gbr['0']['full_path'];
			// print_r($gbr);
		} else {
			echo 'gagal upload file';
			echo  $this->upload->display_errors('<p>', '</p>');
			$this->session->set_flashdata('gagal', "Gagal Upload Surat: " . $this->upload->display_errors('<p>', '</p>'));
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
			//return false;
		}

		// Panggil API untuk mengunggah file
		$api_url = 'http://sipadu.bpsaceh.com/api/uploadFile';
		$post_data = array(
			'file' => new CURLFile($file_path),
			'folder' => 'surat'
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response, true);

		// Tampilkan respon dari API
		// echo $response;
		if ($response['status']) {
			$id_surat = $this->input->post('id_surat');
			$params = array(
				'file_surat' => $nama_file,
				'username_upload' => $this->session->userdata('username'),
				'tanggal_upload' => date('Y-m-d H:i:s'),
			);
			$update = $this->surat_model->update($id_surat, $params);

			$this->kirim_notif_upload($id_surat);
		} else {
			$this->session->set_flashdata('gagal', "Gagal Upload Surat");
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
		}

		if ($update['error']) { //jika gagal
			$this->session->set_flashdata('gagal', "Gagal Upload Surat");
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
		} else {
			$this->session->set_flashdata('sukses', "Berhasil Upload Surat");
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
		}
	}
	public function Upload()
	{

		$this->load->library('upload');

		$config['upload_path'] = './upload_file/surat/'; //path folder
		$config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size'] = '100000'; //maksimum besar file 2M

		$this->upload->initialize($config);

		// $files = $_FILES['template'];
		// $this->upload->do_upload('template');

		if ($this->upload->do_upload('file_surat')) {
			$gbr[] = $this->upload->data();
			$nama_file = $gbr['0']['file_name'];
			$file_path = $gbr['0']['full_path'];
			// print_r($gbr);
			
			$id_surat = $this->input->post('id_surat');
			$params = array(
				'file_surat' => $nama_file,
				'username_upload' => $this->session->userdata('username'),
				'tanggal_upload' => date('Y-m-d H:i:s'),
			);
			$update = $this->surat_model->update($id_surat, $params);

			$this->kirim_notif_upload($id_surat);
			redirect('surat');
		} else {
			echo 'gagal upload file';
			echo  $this->upload->display_errors('<p>', '</p>');
			$this->session->set_flashdata('gagal', "Gagal Upload Surat: " . $this->upload->display_errors('<p>', '</p>'));
			$this->load->library('user_agent');
			redirect($this->agent->referrer());
			//return false;
		}

	}

	public function download($id_surat, $file_surat)
	{

		//load the download helper
		// 		$this->load->helper('download');
		$params = array(
			'id_surat' => $id_surat,
			'username' => $this->session->userdata('username')
		);
		$this->surat_model->add_download($params);
		$file_name = $file_surat;

		header("Content-Type:  application/pdf ");
		force_download("upload_file/surat/" . $file_surat, NULL);

	}
	public function download3333($id_surat, $file_surat)
	{

		//load the download helper
		// 		$this->load->helper('download');
		$params = array(
			'id_surat' => $id_surat,
			'username' => $this->session->userdata('username')
		);
		$this->surat_model->add_download($params);
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

	public function download_klasifikasi()
	{
		$file_surat = "Klasifikasi_Arsip.xlsx";
		//load the download helper
		$this->load->helper('download');


		header("Content-Type:  application/pdf ");
		force_download("upload_file/" . $file_surat, NULL);
	}

	public function kirim_notif_upload($id_surat)
	{

		$surat = $this->surat_model->get_id($id_surat);
		$pemberi_disposisi = $surat['nama_pegawai'];
		$link = base_url('download/surat_keluar/') . $surat['file_surat'];
		$catatan = $surat['catatan1'];
		$param = [
			"pesan" => "*Draft Pemberitahuan Surat*

Yth. $surat[nama_pegawai] 
Dengan ini kami sampaikan bahwa surat yang saudara/i ajukan telah di tanda tangan dengan detail berikut:

No Surat : $surat[no_surat]
Tanggal Surat : $surat[tanggal]
Tujuan : $surat[tujuan]
Perihal : $surat[perihal]
Link : $link

Demikian untuk ditindaklanjuti, atas perhatian dan kerjasamanya diucapkan terima kasih
",
			"no_wa" => $surat["no_wa"],
		];

// 		$this->send($param);
        return send($param);
	}


	public function kirim_notif($id_surat)
	{

		$surat = $this->surat_model->get_id($id_surat);
		$pemberi_disposisi = $surat['nama_pegawai'];
		$link = $surat['link'];
		$catatan = $surat['catatan1'];
		$param = [
			"pesan" => "*Draft Pemberitahuan Surat*

Yth. $surat[nama_pegawai2] 
Dengan ini kami sampaikan bahwa saudara/i mendapatkan draft surat dari $pemberi_disposisi untuk diverifikasi dengan detail sebagai berikut.

No Surat : $surat[no_surat]
Tanggal Surat : $surat[tanggal]
Tujuan : $surat[tujuan]
Perihal : $surat[perihal]
Catatan  : $catatan
Link Draft Surat : $link

Demikian untuk ditindaklanjuti, atas perhatian dan kerjasamanya diucapkan terima kasih
",
			"no_wa" => $surat["no_wa2"],
		];

// 		$this->send($param);
        return send($param);
	}

	public function kirim_notif_sekre($id_surat)
	{
		$surat = $this->surat_model->get_id($id_surat);
		$nama_tujuan = $surat['nama_pegawai3'];
		$no_tujuan = $surat['no_wa3'];
		$pemberi_disposisi = $surat['nama_pegawai2'];
		$catatan = $surat['catatan2'];
		$link = $surat['link'];

		$param = [
			"pesan" => "*Draft Pemberitahuan Surat*

Yth. $nama_tujuan
Dengan ini kami sampaikan bahwa saudara/i mendapatkan draft surat dari $pemberi_disposisi untuk buatkan e-ttd dengan detail sebagai berikut.

No Surat : $surat[no_surat]
Tanggal Surat : $surat[tanggal]
Tujuan : $surat[tujuan]
Perihal : $surat[perihal]
Catatan  : $catatan
Link Surat : $link

Demikian untuk ditindaklanjuti, atas perhatian dan kerjasamanya diucapkan terima kasih
",
			"no_wa" => $no_tujuan,
		];

// 		$this->send($param);
return send($param);
	}

	public function send3333($params)
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
                return $insert_params;
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
}
