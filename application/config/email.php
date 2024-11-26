<?php if (!defined('BASEPATH')) exit('Direct Access Not Allowed');


$config['protocol'] = 'smtp';
$config['smtp_host'] = "ssl://smtp.gmail.com";
$config['smtp_port'] = 465;
// $config['smtp_port'] = 587;
$config['smtp_user'] = "layanan.it1100@gmail.com";
$config['smtp_pass'] = "11Aceh00";
$config['charset'] = "utf-8";
$config['mailtype'] = "html";
$config['newline'] = "\r\n";
$config['smtp_timeout'] = 300;
$config['useragent']    = 'PHPMailer';
$config['smtp_auto_tls']    = true;
$config['smtp_debug']       = 0;
$config['smtp_conn_options'] = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
// end of file config_page.php 
// Location config/config_page.php 
