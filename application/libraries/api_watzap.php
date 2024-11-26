<?php
function send($params)
{
    try {
        // $dataSending = Array();
        // $dataSending["api_key"] = "59N5INDJF6I683Z4";
        // $dataSending["number_key"] = "YVhQXKP64PPcqO5O";
        // $dataSending["phone_no"] = $params["no_wa"];
        // $dataSending["message"] = $params["pesan"];
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //   CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
        //   CURLOPT_RETURNTRANSFER => true,
        //   CURLOPT_ENCODING => '',
        //   CURLOPT_MAXREDIRS => 10,
        //   CURLOPT_TIMEOUT => 0,
        //   CURLOPT_FOLLOWLOCATION => true,
        //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //   CURLOPT_CUSTOMREQUEST => 'POST',
        //   CURLOPT_POSTFIELDS => json_encode($dataSending),
        //   CURLOPT_HTTPHEADER => array(
        //     'Content-Type: application/json'
        //   ),
        // ));
        // $response = curl_exec($curl);
        // curl_close($curl);
        
        // // echo $response;
        // $response = json_decode($response);
        
        
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
