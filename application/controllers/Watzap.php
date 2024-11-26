<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Watzap extends CI_Controller
{
	private $token_ = "_{ptZD^ei_u=ZFyV9Y|j_v1VOYXLPB|7}gTBl^hEP4vx}hpk-ichsan";
	private $DEVICE_ID = "iphone";

	public function __construct()
	{
		parent::__construct();
		// if ($this->session->userdata('logged_in')) {
		// } else {
		//     redirect('login');
		// }
		$this->load->model("aktivitas_model");
		$this->load->model("master_model");
		$this->load->model("pegawai_model");
	}
	
	public function cek(){
	    $dataSending = Array();
        $dataSending["api_key"] = "59N5INDJF6I683Z4";
        $dataSending["number_key"] = "qawHPCTE29fGEdtR";
        $dataSending["phone_no"] = "6282285993357";
        $dataSending["message"] = "YOUR-MESSAGE";
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
        print_r($response);
        curl_close($curl);
        
	}
	
	public function pengingat_sipadu2()
	{
		$data = $this->aktivitas_model->belum_isi();

		foreach ($data as $key => $value) {
			$param = [
"pesan" => 
"*Pengingat SIPADU*

yth. $value[nama_pegawai] 
Jangan lupa ya untuk mengisi kegiatan hari ini di s.id/sipadu1100

terima kasih.
",
				"no_wa" => $value["no_wa"],
				"ket" => "pengingat sipadu",
			];
			//   print_r($param);
			//   echo "<br>";
			$this->kirim($param);
		}
	}
	
	public function pengingat_absen($kloter)
	{
// 		$data = $this->pegawai_model->get_all_pegawai();
        $data = $this->pegawai_model->kloter($kloter);

		foreach ($data as $key => $value) {
			$param = [
				"pesan" => "*Pengingat Presensi*

yth. $value[nama_pegawai] 
Mohon untuk tidak lupa melakukan presensi. 
Terima kasih, stay safe and stay healthy!
",
				"no_wa" => $value["no_wa"],
				"ket" => "pengingat absen",
			];
			//   print_r($param);
			//   echo "<br>";
			$this->kirim($param);
		}
	}
	
	public function kirim($params){
	    try {
	    $dataSending = Array();
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
			$insert_params = [
				
				"status" => $response->status,
				"message" => $response->message,
				"worker_by" => $response->worker_by,
				"ack" => $response->ack,
				'ket' => $params['ket'],
				'no_wa'=> $params['no_wa']
				
			];
		$this->master_model->insert("status_watzap", $insert_params);
	    } catch (Exception $e) {
			print_r($e);
		}	
	}
	
	
	


	
}