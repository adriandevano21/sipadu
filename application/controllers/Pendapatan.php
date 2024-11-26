<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pendapatan extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
        $this->load->model('rincian_gaji_model');
        $this->load->model('rincian_tukin_model');
        $this->load->model('master_model');
    }
    public function index()
    {

        if ($this->session->userdata('level_user') == 1) {
            $data['gaji'] = $this->rincian_gaji_model->get_all();
            $data['tukin'] = $this->rincian_tukin_model->get_all();
        } else {
            $data['gaji'] = $this->rincian_gaji_model->get_gajiku();
            $data['tukin'] = $this->rincian_tukin_model->get_tukinku();
        }

        $data['judul'] = 'Pendapatan';
        $this->load->vars($data);
        $this->template->load('template/template', 'pendapatan/list');
    }
    public function absensiku()
    {
        $data['data'] = $this->absensi_model->get_absensiku();
        $data['judul'] = 'Pendapatan';
        $this->load->vars($data);
        $this->template->load('template/template', 'absensi/absensi');
    }
    public function absensi()
    {
        $data['data'] = $this->absensi_model->get_all();
        $data['judul'] = 'Pendapatan';
        $this->load->vars($data);
        $this->template->load('template/template', 'absensi/absensi');
    }
    public function upload_gaji()
    {

        $this->load->library('upload');
        $new_name = 'gaji_' . $this->session->userdata('nip') . '_' . $_FILES["template"]['name'];
        $config['file_name'] = $new_name;
        $config['upload_path'] = './upload_file/gajitukin/'; //path folder
        $config['allowed_types'] = 'xlsx'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '50000'; //maksimum besar file 2M

        $this->upload->initialize($config);

        // $files = $_FILES['template'];
        // $this->upload->do_upload('template');

        if ($this->upload->do_upload('template')) {
            $gbr[] = $this->upload->data();
            $nama_file = $gbr['0']['file_name'];
            // print_r($gbr);
        } else {
            echo 'gagal upload file';
            echo  $this->upload->display_errors('<p>', '</p>');
            //return false;
        }

        $inputFileName = "upload_file/gajitukin/" . $nama_file;

        /**  Identify the type of $inputFileName  **/
        // $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

        // /**  Create a new Reader of the type that has been identified  **/
        // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

        // /**  Load $inputFileName to a Spreadsheet Object  **/
        // $spreadsheet = $reader->load($inputFileName);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($inputFileName);

        /**  Convert Spreadsheet Object to an Array for ease of use  **/
        $data = $spreadsheet->getActiveSheet()->toArray();
        // print_r($data);
        unset($data[0]);
        foreach ($data as $key => $value) {
            if (is_null($value['0'])) {
                break;
            }
            $params = array(
                "tahun" => $value["0"],
                "bulan" => $value["1"],
                "nip_lama" => $value["2"],
                "nama" => $value["3"],
                "no_rek" => $value["4"],
                "nilai_bruto" => $value["5"],
                "pot_zakat" => $value["6"],
                "pot_sim_suk_kosikas" => $value["7"],
                "pot_korpri" => $value["8"],
                "pot_simpanan_wajib" => $value["9"],
                "pot_pinjaman_kosikas" => $value["10"],
                "pot_arisan_dw" => $value["11"],
                "pot_sembako" => $value["12"],
                "pot_tabungan_dw" => $value["13"],
                "pot_bank" => $value["14"],
                // "pot_iu_tu" => $value["15"],
                "pot_rumah_dinas" => $value["15"],
                "nilai_bruto_min_pot_tanpa_bank" => $value["16"],
                "nilai_bruto_min_pot_dengan_bank" => $value["17"],
                "nilai_netto_1" => $value["18"],
                // "tambah_uang_dw" => $value["20"],
                // "nilai_netto_2" => $value["21"],
            );

            try {
                $this->rincian_gaji_model->insert("rincian_gaji", $params);
            } catch (Exception $error) {
                echo 'ERROR:' . $error->getMessage();
            }
        }

        redirect('pendapatan');
        // $data_duplikat = $this->kegiatan_model->cek_duplikat();
        // $this->db->query('TRUNCATE TABLE dummy_tabel_master_kegiatan');
        // if (empty($data_duplikat)) {
        //     $this->session->set_flashdata('sukses', "Data berhasil ditambahkan");
        //     $this->load->library('user_agent');
        //     // redirect($this->agent->referrer());
        //     redirect('kegiatan');
        // } else {
        //     // $this->download_error_upload($data_duplikat);
        // }
    }
    public function upload_tukin()
    {

        $this->load->library('upload');
        $new_name = 'tukin_' . $this->session->userdata('nip') . '_' . $_FILES["template"]['name'];
        $config['file_name'] = $new_name;
        $config['upload_path'] = './upload_file/gajitukin/'; //path folder
        $config['allowed_types'] = 'xlsx'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '50000'; //maksimum besar file 2M

        $this->upload->initialize($config);

        // $files = $_FILES['template'];
        // $this->upload->do_upload('template');

        if ($this->upload->do_upload('template')) {
            $gbr[] = $this->upload->data();
            $nama_file = $gbr['0']['file_name'];
            // print_r($gbr);
        } else {
            echo 'gagal upload file';
            echo  $this->upload->display_errors('<p>', '</p>');
            //return false;
        }

        $inputFileName = "upload_file/gajitukin/" . $nama_file;

        /**  Identify the type of $inputFileName  **/
        // $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

        // /**  Create a new Reader of the type that has been identified  **/
        // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

        // /**  Load $inputFileName to a Spreadsheet Object  **/
        // $spreadsheet = $reader->load($inputFileName);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($inputFileName);

        /**  Convert Spreadsheet Object to an Array for ease of use  **/
        $data = $spreadsheet->getActiveSheet()->toArray();
        // print_r($data);
        unset($data[0]);
        foreach ($data as $key => $value) {
            if (is_null($value['0'])) {
                break;
            }
            $params = array(
                "tahun" => $value["0"],
                "bulan" => $value["1"],
                "nip_lama" => $value["2"],
                "nama" => $value["3"],
                "no_rek" => $value["4"],
                "nilai_bruto" => $value["5"],
                "pot_zakat" => $value["6"],
                "pot_korpri" => $value["7"],
                "pot_paguyuban" => $value["8"],
                "pot_kosikas" => $value["9"],
                "pot_kurban" => $value["10"],
                "pot_bank" => $value["11"],
                "pot_sosial" => $value["12"],
                "pot_total" => $value["13"],
                "nilai_netto" => $value["14"],

            );

            try {
                $this->rincian_tukin_model->insert("rincian_tukin", $params);
            } catch (Exception $error) {
                redirect('pendapatan');
                echo 'ERROR:' . $error->getMessage();
                $ee = $this->db->error();
                print_r($ee);
            }
        }

        redirect('pendapatan');
        // $data_duplikat = $this->kegiatan_model->cek_duplikat();
        // $this->db->query('TRUNCATE TABLE dummy_tabel_master_kegiatan');
        // if (empty($data_duplikat)) {
        //     $this->session->set_flashdata('sukses', "Data berhasil ditambahkan");
        //     $this->load->library('user_agent');
        //     // redirect($this->agent->referrer());
        //     redirect('kegiatan');
        // } else {
        //     // $this->download_error_upload($data_duplikat);
        // }
    }

    public function download_error_upload($data_duplikat)
    {
        $spreadsheet2 = new Spreadsheet();

        // $spreadsheet->getDefaultStyle()
        //     ->getFont()
        //     ->setName('Segoe UI')
        //     ->setSize(11);


        $sheet = $spreadsheet2->getActiveSheet();
        $sheet->setCellValue('A1', 'id_pok');
        $sheet->setCellValue('B1', 'POK');
        $sheet->setCellValue('C1', 'IKU');
        $sheet->setCellValue('D1', 'nama_kegiatan');
        $sheet->setCellValue('E1', 'jenis_kegiatan');
        $sheet->setCellValue('F1', 'status');

        foreach ($data_duplikat as $key => $value) {
            $sheet->setCellValue('A' . ($key + 2), $value['id_pok']);
            $sheet->setCellValue('B' . ($key + 2), $value['pok']);
            $sheet->setCellValue('C' . ($key + 2), $value['iku']);
            $sheet->setCellValue('D' . ($key + 2), $value['nama_kegiatan']);
            $sheet->setCellValue('E' . ($key + 2), $value['jenis_kegiatan']);
            $sheet->setCellValue('F' . ($key + 2), 'Duplikat');
        }

        $styleGaris = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    // 'color' => ['argb' => 'FFFF0000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:F' . (count($data_duplikat) + 1))->applyFromArray($styleGaris);

        $writer = new Xlsx($spreadsheet2);

        $filename = "error upload master kegiatan";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
