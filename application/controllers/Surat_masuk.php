<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_masuk extends CI_Controller
{
    private $token_ = "_{ptZD^ei_u=ZFyV9Y|j_v1VOYXLPB|7}gTBl^hEP4vx}hpk-ichsan";
    private $DEVICE_ID = "iphone";


    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
        $this->load->model('surat_masuk_model');
        $this->load->model('master_model');
        $this->load->model('pegawai_model');
        $this->load->model('tim_model');
    }
    public function list()
    {
        $data['pegawai'] = $this->pegawai_model->get_all_pegawai();
        $data['tim'] = $this->tim_model->get_all_aktif();
        $data['surat_masuk'] = $this->surat_masuk_model->get_all();
        // $data['disposisi'] = $this->surat_masuk_model->get_all_disposisi();

        $this->load->vars($data);
        $this->template->load('template/template', 'surat_masuk/list');
    }
    public function detail($id_surat_masuk)
    {
        // $data['pegawai'] = $this->pegawai_model->get_all_pegawai();
        $data['detail'] = $this->surat_masuk_model->get_detail($id_surat_masuk);
        // print_r($data);
        // exit;

        $this->load->vars($data);
        $this->template->load('template/template', 'surat_masuk/detail');
    }
    public function tambah()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perihal', 'perihal', 'required');
        if ($this->form_validation->run()) {
            $no_surat = $this->input->post('no_surat');
            $sifat_surat = $this->input->post('sifat_surat');
            $tanggal_surat = $this->input->post('tanggal');
            $tanggal_surat = date('Y-m-d', strtotime($tanggal_surat));
            $perihal = $this->input->post('perihal');
            $tujuan = $this->input->post('tujuan');
            $ringkasan = $this->input->post('ringkasan');
            $pengirim = $this->input->post('pengirim');

            $this->load->library('upload');

            $config['upload_path'] = './upload_file/surat_masuk/'; //path folder
            $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
            $config['max_size'] = '100000'; //maksimum besar file 2M
            $new_name = $this->sanitize_filename($_FILES["file_surat"]['name']);
            $config['file_name'] = $new_name;

            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_surat')) {
                $gbr[] = $this->upload->data();
                $nama_file = $gbr['0']['file_name'];
            } else {
                echo 'gagal upload file';
                echo  $this->upload->display_errors('<p>', '</p>');
                $this->session->set_flashdata('gagal', "Gagal Upload Surat: " . $this->upload->display_errors('<p>', '</p>'));
                $this->load->library('user_agent');
                redirect($this->agent->referrer());
            }
            $ketua_tim = $this->tim_model->get_ketua_tim($tujuan);

            $params = array(
                'no_surat' => $no_surat,
                'sifat_surat' => $sifat_surat,
                'tanggal_surat' => $tanggal_surat,
                'perihal' => $perihal,
                'tujuan' => $tujuan,
                'pengirim' => $pengirim,
                'ringkasan' => $ringkasan,
                'status' => 1, // open
                'username_created' => $this->session->userdata('username'),
                'file_surat' => $nama_file,
                'username1' => $ketua_tim['username'],
            );

            $id_surat_masuk = $this->master_model->insert('surat_masuk', $params);
            $this->kirim_notif($id_surat_masuk);

            $this->session->set_flashdata('sukses', "Data berhasil ditambahkan");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('gagal', "Gagal membuat no surat");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }
    public function edit()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('perihal', 'perihal', 'required');
        if ($this->form_validation->run()) {
            $no_surat = $this->input->post('no_surat');
            $sifat_surat = $this->input->post('sifat_surat');
            $tanggal_surat = $this->input->post('tanggal');
            $tanggal_surat = date('Y-m-d', strtotime($tanggal_surat));
            $perihal = $this->input->post('perihal');
            $tujuan = $this->input->post('tujuan');
            $ringkasan = $this->input->post('ringkasan');

            $this->load->library('upload');

            $config['upload_path'] = './upload_file/surat_masuk/'; //path folder
            $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
            $config['max_size'] = '100000'; //maksimum besar file 2M
            $new_name = $this->sanitize_filename($_FILES["file_surat"]['name']);
            $config['file_name'] = $new_name;

            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_surat')) {
                $gbr[] = $this->upload->data();

                $nama_file = $gbr['0']['file_name'];
            } else {
                echo 'gagal upload file';
                echo  $this->upload->display_errors('<p>', '</p>');
                $this->session->set_flashdata('gagal', "Gagal Upload Surat: " . $this->upload->display_errors('<p>', '</p>'));
                $this->load->library('user_agent');
                redirect($this->agent->referrer());
            }
            $ketua_tim = $this->tim_model->get_ketua_tim($tujuan);

            $params = array(
                'no_surat' => $no_surat,
                'sifat_surat' => $sifat_surat,
                'tanggal_surat' => $tanggal_surat,
                'perihal' => $perihal,
                'tujuan' => $tujuan,
                'ringkasan' => $ringkasan,
                'status' => 1, // open
                'username_created' => $this->session->userdata('username'),
                'file_surat' => $nama_file,
                'username1' => $ketua_tim['username'],
            );

            $this->master_model->insert('surat_masuk', $params);

            $this->session->set_flashdata('sukses', "Data berhasil ditambahkan");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('gagal', "Gagal membuat no surat");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }
    public function download($file_surat)
    {

        //load the download helper
        $this->load->helper('download');
        // $params = array(
        //     'id_surat' => $id_surat,
        //     'username' => $this->session->userdata('username')
        // );
        // $this->surat_model->add_download($params);
        //$this->transaksi_model->update_read($id_transaksi);

        header("Content-Type:  application/pdf ");
        force_download("upload_file/surat_masuk/" . $file_surat, NULL);
    }
    public function disposisi()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('catatan', 'catatan', 'required');
        $this->form_validation->set_rules('username', 'username', 'required');
        if ($this->form_validation->run()) {
            $id_surat_masuk = $this->input->post('id_surat_masuk');
            $username = $this->input->post('username');
            $catatan = $this->input->post('catatan');
            $username_pemberi_disposisi = $this->session->userdata('username');
            // $cek_disposisi = $this->surat_masuk_model->cek_disposisi($id_surat_masuk);
            // $cek_username_disposisi = $this->surat_masuk_model->cek_username_disposisi($id_surat_masuk, $username_pemberi_disposisi);
            $kolom =  $this->surat_masuk_model->cek_kolom_username($id_surat_masuk, $username_pemberi_disposisi);
            
            $kolomCatatan = 'catatan' . $kolom;
            $kolomUpdated = 'updated' . $kolom;
            $kolomUsername = 'username' . ($kolom + 1);
            $params_update = array(
                $kolomCatatan => $catatan,
                $kolomUpdated => date("Y-m-d H:i:s"),
                $kolomUsername => $username
            );

            $this->master_model->update('surat_masuk', 'id', $id_surat_masuk, $params_update);
            $this->kirim_notif_disposisi($id_surat_masuk);
            $this->session->set_flashdata('sukses', "Data berhasil ditambahkan");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('gagal', "Gagal membuat no surat");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }
    public function selesai()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('catatan', 'catatan', 'required');
        if ($this->form_validation->run()) {
            $id_surat_masuk = $this->input->post('id_surat_masuk');
            $catatan = $this->input->post('catatan');
            $username_pemberi_disposisi = $this->session->userdata('username');
            // $cek_disposisi = $this->surat_masuk_model->cek_disposisi($id_surat_masuk);
            // $cek_username_disposisi = $this->surat_masuk_model->cek_username_disposisi($id_surat_masuk, $username_pemberi_disposisi);
            $kolom =  $this->surat_masuk_model->cek_kolom_username($id_surat_masuk, $username_pemberi_disposisi);
            print_r($id_surat_masuk);
            $kolomCatatan = 'catatan' . $kolom;
            $kolomUpdated = 'updated' . $kolom;
            $kolomUsername = 'username' . ($kolom + 1);
            $params_update = array(
                $kolomCatatan => $catatan,
                $kolomUpdated => date("Y-m-d H:i:s"),
                'status' => 5
            );

            $this->master_model->update('surat_masuk', 'id', $id_surat_masuk, $params_update);

            $this->session->set_flashdata('sukses', "Disposisi berhasil diselesaikan");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('gagal', "Gagal membuat no surat");
            $this->load->library('user_agent');
            redirect($this->agent->referrer());
        }

        $this->load->library('user_agent');
        redirect($this->agent->referrer());
    }

    public function kirim_notif($id_surat_masuk)
    {

        $surat_masuk = $this->surat_masuk_model->get_id($id_surat_masuk);
        $link = base_url() . '/download/surat_masuk/' . $surat_masuk['file_surat'];
        $param = [
            "pesan" => "*DRAFT Pemberitahuan Surat Masuk*

Yth. $surat_masuk[nama_pegawai1] 
Dengan ini kami sampaikan bahwa saudara/i mendapatkan surat dengan detail sebagai berikut.

No Surat : $surat_masuk[no_surat]
Tanggal Surat : $surat_masuk[tanggal_surat]
Pengirim : $surat_masuk[pengirim]
Perihal : $surat_masuk[perihal]
Ringkasan : $surat_masuk[ringkasan]
Link Surat : $link

Demikian untuk ditindaklanjuti, atas perhatian dan kerjasamanya diucapkan terima kasih
",
            "no_wa" => $surat_masuk["no_wa1"],
        ];

        $this->send($param);
    }

    public function kirim_notif_disposisi($id_surat_masuk)
    {
        $surat_masuk = $this->surat_masuk_model->get_id($id_surat_masuk);
        $link = base_url() . '/download/surat_masuk/' . $surat_masuk['file_surat'];
        if (empty($surat_masuk['nama_pegawai3'])) {
            $nama_tujuan = $surat_masuk['nama_pegawai2'];
            $no_tujuan = $surat_masuk['no_wa2'];
            $pemberi_disposisi = $surat_masuk['nama_pegawai1'];
            $catatan = $surat_masuk['catatan1'];
        }
        if (!empty($surat_masuk['nama_pegawai3'])) {
            $nama_tujuan = $surat_masuk['nama_pegawai3'];
            $no_tujuan = $surat_masuk['no_wa3'];
            $pemberi_disposisi = $surat_masuk['nama_pegawai2'];
            $catatan = $surat_masuk['catatan2'];
        }

        $param = [
            "pesan" => "*DRAFT Pemberitahuan Disposisi Surat*

Yth. $nama_tujuan
Dengan ini kami sampaikan bahwa saudara/i mendapatkan disposisi surat dari $pemberi_disposisi dengan detail sebagai berikut.

No Surat : $surat_masuk[no_surat]
Tanggal Surat : $surat_masuk[tanggal_surat]
Pengirim : $surat_masuk[pengirim]
Perihal : $surat_masuk[perihal]
Ringkasan : $surat_masuk[ringkasan]
Catatan Disposisi : $catatan
Link Surat : $link

Demikian untuk ditindaklanjuti, atas perhatian dan kerjasamanya diucapkan terima kasih
",
            "no_wa" => $no_tujuan,
        ];

        $this->send($param);
    }

    public function send($params)
    {
        try {
            $dataSending = array();
            $dataSending["api_key"] = "59N5INDJF6I683Z4";
            $dataSending["number_key"] = "YVhQXKP64PPcqO5O";
            $dataSending["phone_no"] = $params["no_wa"];
            $dataSending["message"] = $params["pesan"];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
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
            // echo $response;

            $response = json_decode($response);
            //   print_r($response);
            //   exit;

            if (!empty($response->worker_by)) {
                $insert_params = [

                    "status" => $response->status,
                    "message" => $response->message,
                    "worker_by" => $response->worker_by,
                    "ack" => $response->ack,
                    "no_wa" => $params['no_wa'],
                    "ket" => "notif surat masuk"

                ];
                $this->master_model->insert("status_watzap", $insert_params);
            } else {
                $this->session->set_flashdata('gagal', "Data yg anda masukan berhasil tetapi tidak berhasil kirim notif WA, silahkan hubungi admin $response->message");
                redirect('event/list');
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    function apiKirimWaRequest($params)
    {
        $curl = curl_init();
        $token = $this->token_;
        $method = $params["method"] ?? "GET";
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token",
            "Content-Type:application/json",
        ]);

        curl_setopt($curl, CURLOPT_URL, $params["url"]);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params["payload"]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        // 		echo $result;
        return $result;
    }

    function sanitize_filename($filename)
    {
        // Hapus karakter yang tidak diinginkan dari nama file
        $filename = preg_replace("/[^a-zA-Z0-9-_.]/", "", $filename);

        // Ganti spasi dengan karakter underscore
        $filename = str_replace(" ", "_", $filename);

        // Hilangkan karakter underscore ganda
        $filename = preg_replace("/[_]+/", "_", $filename);

        return $filename;
    }
}
