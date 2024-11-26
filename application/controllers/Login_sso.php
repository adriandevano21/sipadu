<?php
defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH  . 'libraries/sso/autoload.php';
class Login_sso extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
	}
	public function index()
	{


		session_start();

		$provider = new JKD\SSO\Client\Provider\Keycloak([
			'authServerUrl'         => 'https://sso.bps.go.id',
			'realm'                 => 'pegawai-bps',
			'clientId'              => '11100-ngezoom-f15',
			'clientSecret'          => '3ac3bfd8-a844-4e8b-b1f5-3dc620fe1bd0',
			'redirectUri'           => 'https://webapps.bps.go.id/aceh/ngezoom/'

		]);

		if (!isset($_GET['code'])) {

			// Untuk mendapatkan authorization code
			$authUrl = $provider->getAuthorizationUrl();
			$_SESSION['oauth2state'] = $provider->getState();
			header('Location: ' . $authUrl);
			exit;

			// Mengecek state yang disimpan saat ini untuk memitigasi serangan CSRF
		} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

			unset($_SESSION['oauth2state']);
			exit('Invalid state');
		} else {

			try {
				$token = $provider->getAccessToken('authorization_code', [
					'code' => $_GET['code']
				]);
			} catch (Exception $e) {
				exit('Gagal mendapatkan akses token : ' . $e->getMessage());
			}

			// Opsional: Setelah mendapatkan token, anda dapat melihat data profil pengguna
			try {

				$user = $provider->getResourceOwner($token);
				echo "Nama : " . $user->getName();
				echo "E-Mail : " . $user->getEmail();
				echo "Username : " . $user->getUsername();
				echo "NIP : " . $user->getNip();
				echo "NIP Baru : " . $user->getNipBaru();
				echo "Kode Organisasi : " . $user->getKodeOrganisasi();
				echo "Kode Provinsi : " . $user->getKodeProvinsi();
				echo "Kode Kabupaten : " . $user->getKodeKabupaten();
				echo "Alamat Kantor : " . $user->getAlamatKantor();
				echo "Provinsi : " . $user->getProvinsi();
				echo "Kabupaten : " . $user->getKabupaten();
				echo "Golongan : " . $user->getGolongan();
				echo "Jabatan : " . $user->getJabatan();
				echo "Foto : " . $user->getUrlFoto();
				echo "Eselon : " . $user->getEselon();
			} catch (Exception $e) {
				exit('Gagal Mendapatkan Data Pengguna: ' . $e->getMessage());
			}

			// Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
			echo $token->getToken();
		}


		// $this->load->vars($data);
		// $this->template->load('template/template', 'login');
		$this->load->view('login');
	}

	public function dologin()
	{

		$username 	= $this->input->post('username');
		$tahun_anggaran  = $this->input->post('tahun_anggaran');
		$password = $this->input->post('password');

		$data = $this->login_model->cek_login($username,  $password);


		if (!empty($data)) {
			$newdata = array(
				'username'  => $data['username'],
				'tahun_anggaran'     => $tahun_anggaran,
				'nama_pegawai' => $data['nama_pegawai'],
				'nip_pegawai_lama' => $data['nip_pegawai_lama'],
				'nip_pegawai' => $data['nip_pegawai'],
				'kode_satker' => $data['kode_satker'],
				'kode_bidang' => $data['kode_bidang'],
				'kode_unit_kerja' => $data['kode_unit_kerja'],
				'nama_unit_kerja' => $data['nama_unit_kerja'],
				'nama_satker' => $data['nama_satker'],
				'pangkat' => $data['pangkat'],
				'level_user' => $data['level_user'],
				'logged_in' => TRUE

			);

			$this->session->set_userdata($newdata);
			redirect('home');
		} else {

			echo "gagal";
			redirect('login');
		}
	}

	function logout() // fungsi logout
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}
