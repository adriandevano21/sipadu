<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Changelog extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model jika diperlukan
        // $this->load->model('changelog_model');
    }

    public function index()
    {
        $data['title'] = 'Change Log'; // Judul halaman
        // Ambil data change log dari model jika menggunakan model
        // $data['changelogs'] = $this->changelog_model->getChangelogs();
        $data['changelogs'] = [
            ['version' => '1.0', 'changes' => 'First release'],
            ['version' => '1.1', 'changes' => 'Bug fixes and performance improvements'],
            // Tambahkan data change log sesuai kebutuhan
        ];

        $this->load->vars($data);
        $this->template->load('template/template', 'changelog_view');
    }
}
