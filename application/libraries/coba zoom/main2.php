<?php
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++=
require_once 'vendor/autoload.php';
require_once 'function.php';
require_once 'config.php';
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++=
if (!isset($_GET['code'])) {
    //++++++++++++++++++++++++++++++++++++++++++++++
    //Starting Of The ALL The Things
    //++++++++++++++++++++++++++++++++++++++++++++++
    $url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=" . $accountid;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
        'grant_type'    => 'client_credentials',    # https://www.oauth.com/oauth2-servers/access-tokens/client-credentials/        
        // 'scope'         => $scope,
    )));

    $headers[] = "Authorization: Basic " . base64_encode($clientid . ":" . $secret);
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = curl_exec($ch);
    $auth = json_decode($data, true); // token will be with in this json

    var_dump($auth);
} else {
    //++++++++++++++++++++++++++++++++++++++++++++++
    //Get The Access Token//
    //++++++++++++++++++++++++++++++++++++++++++++++
    $get_token = get_access_token($_GET['code']);
    //++++++++++++++++++++++++++++++++++++++++++++++
    //Create The Meeting//
    //++++++++++++++++++++++++++++++++++++++++++++++
    $get_new_meeting_details = create_a_zoom_meeting([
        'topic'         => 'Let Learn Zoom API Intigration In PHP',
        'type'          => 2,
        'start_time'    => date('Y-m-dTh:i:00') . 'Z',
        'password'      => mt_rand(),
        // 'token'         => $get_token['access_token'], 
        'token'         => 'QRCF7X5hS9G3mCQCk-9ksA',
        // 'refresh_token' => $get_token['refresh_token'],
    ]);
    if ($get_new_meeting_details['msg'] == 'success') {
        echo $get_new_meeting_details['response']['uuid'];
    } else {
        echo "OPPS!! Error";
    }
}
