<?php
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++=
require_once 'vendor/autoload.php';
require_once 'function.php';
require_once 'config.php';
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++=

//++++++++++++++++++++++++++++++++++++++++++++++
//Starting Of The ALL The Things
//++++++++++++++++++++++++++++++++++++++++++++++





//++++++++++++++++++++++++++++++++++++++++++++++
//Get The Access Token//
//++++++++++++++++++++++++++++++++++++++++++++++
// $get_token = get_access_token($_GET['code']);
//++++++++++++++++++++++++++++++++++++++++++++++
//Create The Meeting//
//++++++++++++++++++++++++++++++++++++++++++++++

function get_token1()
{
    // BPS Aceh ZM
    $accountid1 = 'M8aAftWjToyvlgsNtAdTAw';
    $clientid1 = 'jYhkPZugRpdFuiESyCtA';
    $secret1 = 'jLplq8FWaa7zWzh3F1E1IKfc78noOG93';
    
    // $accountid3 = 'M8aAftWjToyvlgsNtAdTAw';
    // $clientid3 = '46Is3axxQWeEA_aGLo68RA';
    // $secret3 = '4IGTKDlXoKZahzgcSupVAmSCXWCi4whk';
    
    
    $url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=" . $accountid1;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
        'grant_type'    => 'client_credentials',    # https://www.oauth.com/oauth2-servers/access-tokens/client-credentials/        
        // 'scope'         => $scope,
    )));

    $headers[] = "Authorization: Basic " . base64_encode($clientid1 . ":" . $secret1);
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = curl_exec($ch);
    $auth = json_decode($data, true); // token will be with in this json
    return $auth;
}
function get_token2()
{
    // kasie jarkom 
    $accountid2 = 'M8aAftWjToyvlgsNtAdTAw';
    $clientid2 = 'gkpl2iqTT62eEg85Yts1Q';
    $secret2 = 'ZG2LblNtLoHWCCE50JnjCww4V6sNfXBy';
    $url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=" . $accountid2;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
        'grant_type'    => 'client_credentials',    # https://www.oauth.com/oauth2-servers/access-tokens/client-credentials/        
        // 'scope'         => $scope,
    )));

    $headers[] = "Authorization: Basic " . base64_encode($clientid2 . ":" . $secret2);
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = curl_exec($ch);
    $auth = json_decode($data, true); // token will be with in this json
    return $auth;
}
function get_token3()
{
    // Layananzoom
    
    $accountid3 = 'M8aAftWjToyvlgsNtAdTAw';
    $clientid3 = '46Is3axxQWeEA_aGLo68RA';
    $secret3 = '4IGTKDlXoKZahzgcSupVAmSCXWCi4whk';
    
    
    $url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=" . $accountid3;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
        'grant_type'    => 'client_credentials',    # https://www.oauth.com/oauth2-servers/access-tokens/client-credentials/        
        // 'scope'         => $scope,
    )));

    $headers[] = "Authorization: Basic " . base64_encode($clientid3 . ":" . $secret3);
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $data = curl_exec($ch);
    $auth = json_decode($data, true); // token will be with in this json
    return $auth;
}

function createMeeting($data = array())
{
    if ($data["id_akun_zoom"] == 1) {
        $auth = get_token1();
    } else if($data["id_akun_zoom"] == 2){
        $auth = get_token2();
    } else if($data["id_akun_zoom"] == 3){
        $auth = get_token3();
    }
    // print_r($auth);

    $get_new_meeting_details = create_a_zoom_meeting([
        'topic'         => $data['topic'],
        'type'          => $data['type'],
        'start_time'    => $data['start_date'],
        'password'      => $data['password'],
        'duration'      => $data['duration'],
        'token'         => $auth['access_token'],
        // 'refresh_token' => $get_token['refresh_token'],
    ]);
    
    // print_r($get_new_meeting_details);
    if ($get_new_meeting_details['msg'] == 'success') {
        return ($get_new_meeting_details['response']);
    } else {
        return  "OPPS!! Error";
    }
}

function deleteMeeting($data = array())
{

    if ($data["id_akun_zoom"] == 1) {
        $auth = get_token1();
    } else if($data["id_akun_zoom"] == 2){
        $auth = get_token2();
    } else if($data["id_akun_zoom"] == 3){
        $auth = get_token3();
    }

    $delete_meeting_details = delete_a_zoom_meeting([

        'id_zoom'      => $data['id_zoom'],
        'token'         => $auth['access_token'],
    ]);
    if ($delete_meeting_details['msg'] == 'success') {
        return ($delete_meeting_details['response']);
    } else {
        return  "OPPS!! Error";
    }
}
