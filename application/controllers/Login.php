<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH  . 'libraries/sso/autoload.php';
class Login extends CI_Controller
{


	public function __construct()
	{
		
		parent::__construct();
        if ($this->session->userdata('logged_in')) {
            redirect('home');
        } else {
            // redirect('login');
        }

		$this->load->model('login_model');
		$this->load->model('master_model');
	}
	// 	public function index22()
	// 	{

	// 		// $this->load->vars($data);
	// 		// $this->template->load('template/template', 'login');
	// 		$this->load->view('login');
	// 	}
	public function index()
	{
	   // if (!isset($_GET['code'])) {
	   //     $this->load->view('login');
	   // } else {
	   //     $this->sso();
	   // }
	    $this->sso();
	}
	    public function sso()
	{


// 		session_start();

		$provider = new JKD\SSO\Client\Provider\Keycloak([
			'authServerUrl'         => 'https://sso.bps.go.id',
			'realm'                 => 'pegawai-bps',
			'clientId'              => '11100-sipadu-e0s',
			'clientSecret'          => 'b0816b01-b59b-4914-8903-6c2cf58d421d',
			'redirectUri'           => 'https://webapps.bps.go.id/aceh/sipadu/'


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

				// echo "Nama : " . $user->getName();
				// echo "E-Mail : " . $user->getEmail();
				// echo "Username : " . $user->getUsername();
				// echo "NIP : " . $user->getNip();
				// echo "NIP Baru : " . $user->getNipBaru();
				// echo "Kode Organisasi : " . $user->getKodeOrganisasi();
				// echo "Kode Provinsi : " . $user->getKodeProvinsi();
				// echo "Kode Kabupaten : " . $user->getKodeKabupaten();
				// echo "Alamat Kantor : " . $user->getAlamatKantor();
				// echo "Provinsi : " . $user->getProvinsi();
				// echo "Kabupaten : " . $user->getKabupaten();
				// echo "Golongan : " . $user->getGolongan();
				// echo "Jabatan : " . $user->getJabatan();
				// echo "Foto : " . $user->getUrlFoto();
				// echo "Eselon : " . $user->getEselon();

				// print_r($user);
				// echo "Kode Provinsi : " . $user->getKodeProvinsi();
				// echo "Kode Kabupaten : " . $user->getKodeKabupaten();
				// exit();

				$data = $this->login_model->cek_username($user->getUsername());
				// print_r($data);
				// exit();
				$url_logout = $provider->getLogoutUrl();

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
						'foto' => $user->getUrlFoto(),
						// 'id_pegawai' => $data['id_pegawai'],
						// 'admin' => $data['admin_zoom'], // 1 adalah aktif
						'logout' => $url_logout,

					);
					
                    $params = array('url_foto' => $user->getUrlFoto(), );
					$this->session->set_userdata($newdata);
					$this->master_model->update('master_pegawai', 'username', $data['username'], $params);

					redirect('home');
				} else {

					echo "gagal";
					exit;
					// 	redirect('login');
				}
			} catch (Exception $e) {
				exit('Gagal Mendapatkan Data Pengguna: ' . $e->getMessage());
			}

			// Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
			echo $token->getToken();
		}


		// $this->load->vars($data);
		// $this->template->load('template/template', 'login');
		// 		$this->load->view('login');
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
				// 'tahun_anggaran'     => $tahun_anggaran,
				'nama_pegawai' => $data['nama_pegawai'],
				'nip_pegawai_lama' => $data['nip_pegawai_lama'],
				'email' => $data['email'],
				'nip_pegawai' => $data['nip_pegawai'],
				'kode_satker' => $data['kode_satker'],
				'kode_bidang' => $data['kode_bidang'],
				'kode_unit_kerja' => $data['kode_unit_kerja'],
				'nama_unit_kerja' => $data['nama_unit_kerja'],
				'nama_satker' => $data['nama_satker'],
				'pangkat' => $data['pangkat'],
				'level_user' => $data['level_user'],
				'logged_in' => TRUE,
				'kode_jabatan_fungsional' => $data['kode_jabatan_fungsional'],
				'admin' => $data['admin_zoom'], // 1 adalah aktif
			);

			$this->session->set_userdata($newdata);
			redirect('zoom');
		} else {

			echo "gagal";
			redirect('login');
		}
	}

	function logout() // fungsi logout
	{
	    $this->session->sess_destroy();
	    
	        $this->load->helper('cookie');
    		delete_cookie("AUTH_SESSION_ID", "sso.bps.go.id", "/auth/realms/pegawai-bps/");
    		delete_cookie("KEYCLOAK_IDENTITY", "sso.bps.go.id", "/auth/realms/pegawai-bps/");
    		delete_cookie("KEYCLOAK_SESSION", "sso.bps.go.id", "/auth/realms/pegawai-bps/");
    		// 		redirect('login');
    		redirect($this->session->userdata('logout'));
	    
		
		
	}
}