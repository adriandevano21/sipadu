<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_biasa extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		if(isset($_GET['code'])){
		        
		    redirect('login');    
		    } elseif($this->session->userdata('logged_in')) {
		    redirect('home');
		    }
		
		if ($this->session->userdata('logged_in')) {
		    
		    redirect('home');
		    
        } 
		$this->load->model('login_model');
	}
	public function index()
	{

		// $this->load->vars($data);
		// $this->template->load('template/template', 'login');
		$this->load->view('login');
	}

	public function dologin()
	{

		$username 	= $this->input->post('username');
		// $tahun_anggaran  = $this->input->post('tahun_anggaran');
		$password = $this->input->post('password');

		$data = $this->login_model->cek_login($username,  $password);


		if (!empty($data)) {
		$newdata = array(
				'username'  => $data['username'],
				// 'username'  => $data['nip_pegawai_lama'],
				// 'tahun_anggaran'     => $tahun_anggaran,
				// 'tahun_anggaran'     => date(Y),
				'nama_pegawai' => $data['nama_pegawai'],
				'nip_lama' => $data['nip_lama'],
				'nip' => $data['nip'],
				'kode_satker' => $data['kode_satker'],
		// 		'kode_bidang' => $data['kode_bidang'],
				// 'kode_unit_kerja' => $data['kode_unit_kerja'],
				// 'nama_unit_kerja' => $data['nama_unit_kerja'],
		// 		'nama_satker' => $data['nama_satker'],
				// 'pangkat' => $data['pangkat'],
				'level_user' => $data['level_user'],
				'admin_lpp' => $data['admin_lpp'],
				'admin_kerja_sama' => $data['admin_kerja_sama'],
				'admin_sk' => $data['admin_sk'],
				'admin_zoom' => $data['admin_zoom'],
				'logged_in' => TRUE,
				// 'foto' => $user->getUrlFoto(),
				// 'id_pegawai' => $data['id_pegawai'],
				// 'admin' => $data['admin_zoom'], // 1 adalah aktif
				'logout' => 0,

			);

			$this->session->set_userdata($newdata);
			redirect("home");
		} else {

			echo "gagal";
			redirect('login_biasa');
		}
	}

	function logout() // fungsi logout
	{
		$this->session->sess_destroy();
		redirect('login_biasa');
	}
}
