<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Kirimwa extends CI_Controller
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
	function apiKirimWaRequest2222(array $params)
	{
		$httpStreamOptions = [
			"method" => $params["method"] ?? "GET",
			"header" => [
				"Content-Type: application/json",
				"Authorization: Bearer " . ($params["token"] ?? ""),
			],
			"timeout" => 15,
			"ignore_errors" => true,
		];

		if ($httpStreamOptions["method"] === "POST") {
			$httpStreamOptions["header"][] = sprintf(
				"Content-Length: %d",
				strlen($params["payload"] ?? "")
			);
			$httpStreamOptions["content"] = $params["payload"];
		}

		// Join the headers using CRLF
		$httpStreamOptions["header"] =
			implode("\r\n", $httpStreamOptions["header"]) . "\r\n";

		$stream = stream_context_create(["http" => $httpStreamOptions]);
		$response = file_get_contents($params["url"], false, $stream);

		// Headers response are created magically and injected into
		// variable named $http_response_header
		$httpStatus = $http_response_header[0];

		preg_match("#HTTP/[\d\.]+\s(\d{3})#i", $httpStatus, $matches);

		if (!isset($matches[1])) {
			throw new Exception("Can not fetch HTTP response header.");
		}

		$statusCode = (int) $matches[1];
		if ($statusCode >= 200 && $statusCode < 300) {
			return [
				"body" => $response,
				"statusCode" => $statusCode,
				"headers" => $http_response_header,
			];
		}

		throw new Exception($response, $statusCode);
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
		echo $result;
		return $result;
	}

	function addDevice()
	{
		try {
			$baseApiUrl = getenv("API_BASEURL")
				? getenv("API_BASEURL")
				: "https://api.kirimwa.id/v1";
			$reqParams = [
				"url" => $baseApiUrl . "/devices",
				"method" => "POST",
				"payload" => json_encode([
					// 'device_id' => "iphone-x-pro"
					"device_id" => $this->DEVICE_ID,
				]),
			];

			$response = $this->apiKirimWaRequest($reqParams);
			echo $response["body"];
			print_r($response);
		} catch (Exception $e) {
			print_r($e);
		}
	}

	public function addDevice222()
	{
		try {
			$baseApiUrl = getenv("API_BASEURL")
				? getenv("API_BASEURL")
				: "https://api.kirimwa.id/v1";
			$reqParams = [
				"token" => $this->token_,
				"url" => $baseApiUrl . "/devices",
				"method" => "POST",
				"payload" => json_encode([
					"device_id" => $this->DEVICE_ID,
				]),
			];

			$response = $this->apiKirimWaRequest($reqParams);
			echo $response["body"];
		} catch (Exception $e) {
			print_r($e);
		}
	}

	public function scanQR()
	{
		try {
			$query = http_build_query(["device_id" => $this->DEVICE_ID]);
			$baseApiUrl = getenv("API_BASEURL")
				? getenv("API_BASEURL")
				: "https://api.kirimwa.id/v1";
			$reqParams = [
				"token" => $this->token_,
				"url" => sprintf("%s/qr?%s", $baseApiUrl, $query),
			];

			$response = $this->apiKirimWaRequest($reqParams);
			echo $response["body"];
		} catch (Exception $e) {
			print_r($e);
		}
	}

	public function send($params)
	{
		try {
			$baseApiUrl = getenv("API_BASEURL")
				? getenv("API_BASEURL")
				: "https://api.kirimwa.id/v1";
			$reqParams = [
				"token" => $this->token_,
				"url" => $baseApiUrl . "/messages",
				"method" => "POST",
				"payload" => json_encode([
					"message" => $params["pesan"],
					"phone_number" => $params["no_wa"],
					"message_type" => getenv("MESSAGE_TYPE")
						? getenv("MESSAGE_TYPE")
						: "text",
					"device_id" => $this->DEVICE_ID,
				]),
			];

			$response = $this->apiKirimWaRequest($reqParams);
			$response = json_decode($response);
			$insert_params = [
				"id" => $response->id,
				"status" => $response->status,
				"message" => $response->message,
				"location" => $response->meta->location,
			];

			$this->master_model->insert("status_kirimwa", $insert_params);
		} catch (Exception $e) {
			print_r($e);
		}
	}

	public function pengingat_sipadu()
	{
		$data = $this->aktivitas_model->belum_isi();

		foreach ($data as $key => $value) {
			$param = [
				"pesan" => "*Pengingat SIPADU*

yth. $value[nama_pegawai] 
Jangan lupa ya untuk mengisi kegiatan hari ini di s.id/sipadu1100

terima kasih
",
				"no_wa" => $value["no_wa"],
			];
			//   print_r($param);
			//   echo "<br>";
			$this->send($param);
		}
	}

	

	public function pengingat_absen($kloter)
	{
		$data = $this->pegawai_model->kloter($kloter);

		foreach ($data as $key => $value) {
			$param = [
				"pesan" => "*Pengingat Presensi*

yth. $value[nama_pegawai] 
Mohon untuk tidak lupa melakukan presensi. 
Terima kasih, stay safe and stay healthy!
",
				"no_wa" => $value["no_wa"],
			];
			//   print_r($param);
			//   echo "<br>";
			$this->send($param);
		}
	}

	public function cekStatus()
	{
		try {
			$baseApiUrl = getenv("API_BASEURL")
				? getenv("API_BASEURL")
				: "https://api.kirimwa.id/v1";
			$reqParams = [
				"token" => $this->token_,
				"url" => sprintf(
					"%s/messages/%s",
					$baseApiUrl,
					"kwid-1a1cb58075e942deadaf84511a0"
				),
			];

			$response = $this->apiKirimWaRequest($reqParams);
			var_dump($response);
		} catch (Exception $e) {
			print_r($e);
		}
	}

	public function deleteDevice()
	{
		try {
			$reqParams = [
				"token" => $this->token_,
				"url" => sprintf(
					"https://api.kirimwa.id/v1/devices/%s",
					"iphone"
				),
				"method" => "DELETE",
			];

			$response = $this->apiKirimWaRequest($reqParams);
			echo $response["body"];
			print_r($response);
		} catch (Exception $e) {
			print_r($e);
		}
	}

	// public function index()
	// {

	//     // $this->load->vars($data);
	//     $this->template->load('template/template', 'absensi/absensi');
	// }
	public function absensiku()
	{
		$data["data"] = $this->absensi_model->get_absensiku();

		$this->load->vars($data);
		$this->template->load("template/template", "absensi/absensi");
	}
	public function absensi()
	{
		$data["data"] = $this->absensi_model->get_all();

		$this->load->vars($data);
		$this->template->load("template/template", "absensi/absensi");
	}
}
