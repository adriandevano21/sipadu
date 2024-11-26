<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebhookReceiver extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the necessary model here if needed
        $this->load->model('master_model');
    }

    public function index() {
        // Get the raw POST data
        $raw_data = $this->input->raw_input_stream;
        $decoded_data = json_decode($raw_data, true);

        // Check if the incoming data is as expected
        if (isset($decoded_data['type']) && $decoded_data['type'] === 'incoming_chat') {
            $data = $decoded_data['data'];

            // Extract data
            $chat_id = $data['chat_id'];
            $message_id = $data['message_id'];
            $name = $data['name'];
            $profile_picture = $data['profile_picture'];
            $timestamp = $data['timestamp'];
            $message_body = $data['message_body'];
            $message_ack = $data['message_ack'];
            $has_media = $data['has_media'];
            $media_mime = $data['media_mime'];
            $media_name = $data['media_name'];
            $location_attached = $data['location_attached'];
            $is_forwarding = $data['is_forwading'];
            $is_from_me = $data['is_from_me'];

            // Process the data (e.g., save to database)
            // Example: Save data to the database using a model
           
            $this->master_model->insert('pesanwa',[
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'name' => $name,
                'profile_picture' => $profile_picture,
                'timestamp' => $timestamp,
                'message_body' => $message_body,
                'message_ack' => $message_ack,
                'has_media' => $has_media,
                'media_mime' => $media_mime,
                'media_name' => $media_name,
                'is_forwarding' => $is_forwarding,
                'is_from_me' => $is_from_me
            ]);
           

            // Return a success response
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'Data received and processed']));
        } else {
            // Return an error response if data is not as expected
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid data']));
        }
    }
    
    function set(){
        $dataSending = Array();
        $dataSending["api_key"] = "59N5INDJF6I683Z4";
        $dataSending["number_key"] = "W4VNFb2ffPlQihxt";
        $dataSending["endpoint_url"] = "https://webapps.bps.go.id/aceh/sipadu/WebhookReceiver";
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.watzap.id/v1/set_webhook',
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
        echo $response;
    }
    
    function get(){
        $dataSending = Array();
        $dataSending["api_key"] = "59N5INDJF6I683Z4";
        $dataSending["number_key"] = "W4VNFb2ffPlQihxt";
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://webhook.site/f9f004ab-3509-42cf-a81e-c03c9bea2e8c',
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
        echo $response;
    }
}
