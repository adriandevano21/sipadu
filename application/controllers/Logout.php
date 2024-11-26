<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        
    }
    function index() // fungsi logout
	{
	    $this->session->sess_destroy();
	    if($this->session->userdata('logout') == 0){
	        redirect('login');
	    }
	    
	        $this->load->helper('cookie');
    		delete_cookie("AUTH_SESSION_ID", "sso.bps.go.id", "/auth/realms/pegawai-bps/");
    		delete_cookie("KEYCLOAK_IDENTITY", "sso.bps.go.id", "/auth/realms/pegawai-bps/");
    		delete_cookie("KEYCLOAK_SESSION", "sso.bps.go.id", "/auth/realms/pegawai-bps/");
    		// 		redirect('login');
    		redirect($this->session->userdata('logout'));
	    
		
		
	}
}