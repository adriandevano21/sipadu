<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
    }
    public function index()
    {
        redirect('aktivitas/home');
        // $this->load->vars($data);
        // $this->template->load('template/template', 'home');
    }
}