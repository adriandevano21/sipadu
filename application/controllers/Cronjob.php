<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Controller Cronjob
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Cronjob extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model("master_model");
    $this->load->model('aktivitas_model');
  }

  public function update_aktif_qr()
  {
    
    $this->master_model->update('qrcode', 'tanggal <', date("Y:m:d"),  array('aktif' => 0 ) );
  }
//   public function pengingat_sipadu($kloter)
// 	{
// 		$data = $this->aktivitas_model->belum_isi($kloter);

// 		foreach ($data as $key => $value) {
// 			$param = [
// 				"pesan" => "*Pengingat SIPADU*

// yth. $value[nama_pegawai] 
// Jangan lupa ya untuk mengisi kegiatan hari ini di s.id/sipadu1100

// terima kasih
// ",
// 				"no_wa" => $value["no_wa"],
// 			];
// 			//   print_r($param);
// 			//   echo "<br>";
// 			$this->send($param);
// 		}
// 	}
	
	
    public function kirim_peringatan()
    {
        $query = $this->db->query("select nama_pegawai from sipadu_master_pegawai where username not in (select username from sipadu_aktivitas where tanggal = curdate()) and kode_satker = 1100 and status_pegawai = 'PNS' ORDER BY nama_pegawai ASC");
        $datas = $query->result_array();
        if(empty($datas)){
            $param = [
				"pesan" => "*[Pengingat SIPADU]*
                
Terima kasih Bapak/Ibu/Rekan-rekan, semuanya telah mengisi kegiatan hari ini. 
Alhamdulillah. 
😊
                ",
				"no_wa" => "6282272623336-1423444905@g.us",
			];
        } else {
            $list_nama = "";
        foreach ($datas as $data) {
            $list_nama .= "\n" . $data['nama_pegawai'];
        }
        $param = [
				"pesan" => "*[Pengingat SIPADU]*
                
Terima kasih Bapak/Ibu/Rekan-rekan yang telah mengisi kegiatan harian. 😊
                
Nama-nama berikut kami persilahkan untuk mengisi kegiatan hari ini :
$list_nama 
                
terima kasih 😊
                ",
				"no_wa" => "6282272623336-1423444905@g.us",
			];
        };
            // print_r($param);
			//echo "<br>";
			$this->send($param);
    }
    
    public function kirim_peringatan22()
    {
        $query = $this->db->query("select nama_pegawai from sipadu_master_pegawai where username not in (select username from sipadu_aktivitas where tanggal = curdate()) and kode_satker = 1100 and status_pegawai = 'PNS' ORDER BY nama_pegawai ASC");
        $datas = $query->result_array();
        if(empty($datas)){
            $param = [
				"pesan" => "*[Pengingat SIPADU]*
                
Terima kasih Bapak/Ibu/Rekan-rekan, semuanya telah mengisi kegiatan hari ini. 
Alhamdulillah. 
😊
                ",
				"no_wa" => "6282285993357",
			];
        } else {
            $list_nama = "";
        foreach ($datas as $data) {
            $list_nama .= "\n" . $data['nama_pegawai'];
        }
        $param = [
				"pesan" => "*[Pengingat SIPADU]*
                
Terima kasih Bapak/Ibu/Rekan-rekan yang telah mengisi kegiatan harian. 😊
                
Nama-nama berikut kami persilahkan untuk mengisi kegiatan harian :
$list_nama 
                
terima kasih
                ",
				"no_wa" => "6282285993357",
				// "no_wa" => "6281377234407",
			];
        };
        
            // print_r($param);
			//echo "<br>";
			$this->send22($param);
    }
	
	public function send($params)
    {
    try {
        // URL API yang akan diuji
        $api_url = "https://api.watzap.id/v1/send_message_group";
        
        // Data yang akan dikirim ke API
        $data = [
            "api_key" => "59N5INDJF6I683Z4", // Ganti dengan API Key Anda
            "number_key" => "qawHPCTE29fGEdtR", // Ganti dengan Number Key Anda
            "group_id" => $params["no_wa"], // Ganti dengan ID grup tujuan
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
        
        
    //   $dataSending = array();
    //   $dataSending["api_key"] = "59N5INDJF6I683Z4";
    //   $dataSending["number_key"] = "YVhQXKP64PPcqO5O";
    //   $dataSending["group_id"] = $params["no_wa"];
    //   $dataSending["message"] = $params["pesan"];
    //   $dataSending["wait_until_send"] = "1"; //This is an optional parameter, if you use this parameter the response will appear 
    //   $curl = curl_init();
    //   curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://api.watzap.id/v1/send_message_group',
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
      curl_close($curl);
      // echo $response;

      $response = json_decode($response);
      //   print_r($response);
      //   exit;

      $insert_params = [

        "status" => $response->status,
        "message" => $response->message,
        "worker_by" => $response->worker_by,
        "ack" => $response->ack,
        "no_wa" => $params['no_wa'],
        "ket" => "Pengingat SIPADU"

      ];
      $this->master_model->insert("status_watzap", $insert_params);
    } catch (Exception $e) {
        
    }
  }
  
  public function send22($params)
  {
      
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
    
    // Periksa error cURL
    if (curl_errno($curl)) {
        echo "cURL Error: " . curl_error($curl);
    } else {
        // Tampilkan respons dari API
        echo "API Response: " . $response;
    }
    
    // Tutup cURL
    curl_close($curl);  
    
    
    // try {
    //   $dataSending = array();
    //   $dataSending["api_key"] = "59N5INDJF6I683Z4";
    //   $dataSending["number_key"] = "qawHPCTE29fGEdtR";
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
    //   print_r(curl_exec($curl));
    //   $response = curl_exec($curl);
    //   curl_close($curl);
    //   // echo $response;
      
      $insert_params = [

        "status" => $response->status,
        "message" => $response->message,
        "worker_by" => $response->worker_by,
        "ack" => $response->ack,
        "no_wa" => $params['no_wa'],
        "ket" => "Testing CronJob"

      ];
      $this->master_model->insert("status_watzap", $insert_params);
    // } catch (Exception $e) {
    //   print_r($e);
    // }
  }

}


/* End of file Cronjob.php */
/* Location: ./application/controllers/Cronjob.php */