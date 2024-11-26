<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Origin: * ');
header('Content-Type: application/json');

require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller
{

    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
		$this->load->model('master_model');
        $this->load->model('aktivitas_model');
        $this->load->model('absensi_model');
        $this->load->model('master_model');
        $this->load->model('token_model');
        
    }

    // method index untuk menampilkan semua data student menggunakan method get
    public function index_get()
    {
        // $response = $this->pegawai_model->all_student();
        // $this->response($response);
    }
    
    public function login_post()
    {
        $response = $this->login_model->cek_login_api(
            $this->post('username'),
            $this->post('password')
            // $this->post('uuid')
        );
        //$response = $this->post('username');
        $this->response($response);
    }
    

    public function feed_post()
    {

        $response = $this->gaji_model->get_gajiTukin_terakhir(
            $this->post('nip_pegawai_lama')
        );


        //$response = $this->post('username');
        $this->response($response);
    }
    
    public function getKegiatanku_post()
    {
        if($this->input->post('bulan') == ''){
            $bulan = date('m');
        } else {
            $bulan = $this->input->post('bulan');
        }
        if($this->input->post('tahun') == ''){
            $tahun = date('Y');
        } else {
            $tahun = $this->input->post('tahun');
        }
        $response = $this->aktivitas_model->get_sendiri_bulan_api($bulan, $tahun, $this->post('username'));
        
        //$response = $this->post('username');
        $this->response($response);
        // print_r($response);
    }
    public function inputKegiatan_post()
    {
        $tanggal = date("Y-m-d", strtotime($this->post('tanggal')));
        $params = array(
            'username'              => $this->post('username'),
            'aktivitas'             => $this->post('kegiatan'),
            'status_kerja'          => 'WFO',
            'username_pemberi_aktivitas' => NULL,
            'tanggal'               => $tanggal

        );

        $all = $this->master_model->insert("aktivitas", $params);
        if (!empty($all)) {
            $response['status'] = 200;
            $response['error'] = false;
            $response['inputKegiatanData'] = $all;
            }
            else {
                $response['status'] = 500;
                $response['error'] = true;
                $response['m_error'] = 'gagal input data';
            }
        
        
        //$response = $this->post('username');
        $this->response($response);
        // print_r($response);
    }
    public function getPresensiku_post()
    {
        
        $response = $this->absensi_model->get_absensiku_api($this->post('username'));
        
        $this->response($response);
        
    }
    function sendiri($bulan = '', $tahun = '')
    {
        
        $data['rekap'] = $this->master_model->get_id("rekap_pegawai_lapor", "tanggal", date("Y-m-d"));
        $cek_mood_hari_ini = $this->mood_model->cek_hari_ini();
        if (!empty($cek_mood_hari_ini)) {
            $data['modal_mood'] = false;
        } else {
            $data['modal_mood'] = true;
        }
        // print_r($data['rekap']);
        // exit;
        
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->vars($data);
        $this->template->load('template/template', 'aktivitas/lihat_aktivitas_sendiri');
    }
    public function rekapProgresUser_post()
    {

        $response = $this->bs_model->get_rekap_progres_user(
            $this->post('username')
        );

        $this->response($response);
        
    }
    public function jadwal_post()
    {

        $response = $this->jadwal_model->get_jadwal_username(
            $this->post('username')
        );
        $this->response($response);
    }

    
    public function rekap_harian_post()
    {

        $response = $this->absen_model->get_rekap_harian(
            $this->post('username')
        );

        //$response = $this->post('username');
        $this->response($response);
        // print_r($response);
    }
    
    
    // untuk menambah student menaggunakan method post
    public function absen_post()
    {
        $response = $this->absen_model->insert_absen(
            $this->post('username'),
            $this->post('address'),
            $this->post('latitude'),
            $this->post('longitude'),
            $this->post('accuracy'),
            $this->post('catatan')
        );
        $this->response($response);
    }
    
    public function entriVBs_post()
    {
        $response = $this->bs_v_model->entri_v_bs(
            $this->post('username'),
            $this->post('bs_id'),
            $this->post('sampel_entri')
        );
        $this->response($response);
    }
    
    public function guletinBs_post()
    {
        $response = $this->bs_model->guletin_bs(
            $this->post('username'),
            $this->post('bs_id'),
            $this->post('sampel_guletin')
        );
        $this->response($response);
    }
    public function cekGuletin_post()
    {
        $response = $this->box_model->cek_guletin(
            
            $this->post('no_box')
            
        );
        $this->response($response);
    }
   
    public function scanBs_post()
    {
        $response = $this->bs_model->scan_bs(
            $this->post('username'),
            $this->post('bs_id'),
            $this->post('sampel_scan')
        );
        $this->response($response);
    }
    
    
    public function updateCorrectionBs_put()
    {
        $response = $this->bs_model->update_correction_bs(
            $this->put('username'),
            $this->put('bs_id')
        );
        $this->response($response);
    }
    
    public function updateValidationKofaxBs_put()
    {
        $response = $this->bs_model->update_validation_kopax_bs(
            $this->put('username'),
            $this->put('bs_id')
        );
        $this->response($response);
    }
    
    public function updateValidationLengkapBs_put()
    {
        $response = $this->bs_model->update_validation_lengkap_bs(
            $this->put('username'),
            $this->put('bs_id')
        );
        $this->response($response);
    }
    
     public function updateValidationKofaxVBs_put()
    {
        $response = $this->bs_v_model->update_validation_kopax_v_bs(
            $this->put('username'),
            $this->put('bs_id')
        );
        $this->response($response);
    }
    
    public function updateValidationLengkapVBs_put()
    {
        $response = $this->bs_v_model->update_validation_lengkap_v_bs(
            $this->put('username'),
            $this->put('bs_id')
        );
        $this->response($response);
    }
    
    public function updateStagingBs_put()
    {
        $response = $this->bs_model->update_staging_bs(
            $this->put('username'),
            $this->put('bs_id'),
            $this->put('sampel_staging')
        );
        $this->response($response);
    }
    
    public function cekScan_post()
    {
        $response = $this->bs_model->cek_scan_bs(
            
            $this->post('bs_id')
            
        );
        $this->response($response);
    }
    

    public function password_put()
    {
        $response = $this->pengguna_model->update_password(
            $this->put('username'),
            $this->put('password')
        );
        $this->response($response);
    }
    
    public function cekIdSls_post()
    {
        $fitur = $this->post('fitur');
        $response = $this->sls_model->get_id(
            $this->post('sls_id')
        );
        
        $this->response($response);
    }
    
    public function scanAbsen_post()
    {
        $cek_rapat = $this->master_model->get_id("rapat", "qrcode", $this->post('qrcode'));
        if (!empty($cek_rapat)) {

            $params = array(
                'status' => 1
            );
            $data_pk = array(
                'username' => $this->post('username'),
                'id_rapat' => $cek_rapat['id'],
            );

            $all = $this->master_model->update_array_biasa('peserta_rapat', $data_pk, $params);
            if (!empty($all)) {
                $response['status'] = 200;
                $response['error'] = false;
                $response['scanData'] = $all;
                $this->response($response);
                }
                else {
                    $response['status'] = 500;
                    $response['error'] = true;
                    $response['m_error'] = 'gagal input data';
                    $this->response($response);
                }
        } else {
        }

        $cek = $this->master_model->get_id("qrcode", "qrcode", $this->post('qrcode'));
        if (!empty($cek)) {
            if ($cek['aktif'] == 1) {
                $params = array(
                    'username'           => $this->post('username'),
                    'qrcode'             => $this->post('qrcode'),
                    'kegiatan' => $cek['kegiatan']
                );

                $all = $this->master_model->insert("absensi", $params);
                $response['status'] = 200;
                $response['error'] = false;
                $response['scanData'] = $all;
                $this->response($response);
            } else {
                $response['status'] = 500;
                $response['error'] = true;
                $response['m_error'] = 'QRcode tidak aktif';
                $this->response($response);
            }
        } else {
            
            $response['status'] = 500;
            $response['error'] = true;
            $response['m_error'] = 'QRcode anda tidak terdaftar';
            $this->response($response);
        }
    }
    
    public function cekIdBs_post()
    {
        $fitur = $this->post('fitur');
        $response = $this->bs_model->get_id(
            $this->post('bs_id')
        );
        
        $all = $this->db->select('*')->from("bs")->where('bs_id', $bs_id)->get()->result();
        
        if(empty($all)){
            $cek_dsbs = $this->bs_model->get_id_dsbs($this->post('bs_id'));
            if(empty($cek_bs)){
                $response['error'] = true;
                $response['m_error'] = "Box ini tidak terdaftar, <br> Hubungi pengawas";
            } else {
                $response['error'] = false;
                $response['m_error'] = null;
                $this->response($response);
            }
             
        } else 
        if(!empty($all)){
            if($fitur == "guletin"){
                $response['error'] = true;
                // $response['m_error'] = "Box ini sudah diguletin, <br> Hubungi pengawas";
                $response['m_error'] = print_r($all);
                
            } else
            if($fitur == "dokumen"){
                $response['error'] = true;
                $response['m_error'] = "Box ini sudah discan, <br> Hubungi pengawas";
                foreach ($response['scanData'] as $value) {
                    if($value->scan != "1"){
                        $response['error'] = false;
                        $response['m_error'] = null;
                    }
                }
            }
            $this->response($response);
            
        }
        
        
    }
    public function cekNoBox_post()
    {
        $fitur = $this->post('fitur');
        $response = $this->box_model->get_sls(
            $this->post('no_box')
        );
        if(!empty($response)){
            
            if($fitur == "guletin"){
                $response['error'] = true;
                $response['m_error'] = "Box ini sudah diguletin, <br> Hubungi pengawas";
                foreach ($response['scanData'] as $value) {
                    if($value->guletin != "1"){
                        $response['error'] = false;
                        $response['m_error'] = null;
                    }
                }
                
            }else
            if($fitur == "dokumen"){
               $response['error'] = true;
                $response['m_error'] = "Box ini sudah diguletin, <br> Hubungi pengawas";
                foreach ($response['scanData'] as $value) {
                    if($value->scan != "1"){
                        $response['error'] = false;
                        $response['m_error'] = null;
                    }
                }
            }else
            if($fitur == "cek wilayah"){
                $response['error'] = true;
                $response['m_error'] = "Box ini sudah diguletin, <br> Hubungi pengawas";
                foreach ($response['scanData'] as $value) {
                    if($value->cek_wilayah != "1"){
                        $response['error'] = false;
                        $response['m_error'] = null;
                    }
                }
            }if($fitur == "validasi"){
                $response['error'] = true;
                $response['m_error'] = "Box ini sudah diguletin, <br> Hubungi pengawas";
                foreach ($response['scanData'] as $value) {
                    if($value->validasi != "1"){
                        $response['error'] = false;
                        $response['m_error'] = null;
                    }
                }
            }
        }
        $this->response($response);
    }
    
    public function updateGuletin_put()
    {
        $response = $this->box_model->update_guletin(
            $this->put('username'),
            $this->put('sls_id'),
            $this->put('no_box')
        );
        $this->response($response);
    }
    public function updateScanDoc_put()
    {
        $response = $this->box_model->update_scan(
            $this->put('username'),
            $this->put('sls_id'),
            $this->put('no_box')
        );
        $this->response($response);
    }
    public function updateValidasi_put()
    {
        $response = $this->box_model->update_validasi(
            $this->put('username'),
            $this->put('sls_id'),
            $this->put('no_box')
        );
        $this->response($response);
    }
    public function updateCekWilayah_put()
    {
        $response = $this->box_model->update_cek_wilayah(
            $this->put('username'),
            $this->put('sls_id'),
            $this->put('no_box')
        );
        $this->response($response);
    }
    
    public function kabkot_get()
    {
        $response = $this->kabkot_model->get_all();
        $this->response($response);
    }
    public function identitasBs_post()
    {
        $response = $this->bs_model->get_identitas_bs(
            $this->post('bs_id'));
        $this->response($response);
    }
    public function identitasBsV_post()
    {
        $response = $this->bs_v_model->get_identitas_bs_v(
            $this->post('bs_id'));
        $this->response($response);
    }
    
    public function userScanBs_post()
    {
        $response = $this->bs_model->get_user_scan_bs(
            $this->post('bs_id'));
        $this->response($response);
    }
    
    public function userCorrectionBs_post()
    {
        $response = $this->bs_model->get_user_correction_bs(
            $this->post('bs_id'));
        $this->response($response);
    }
    
    public function userValidationKofaxBs_post()
    {
        $response = $this->bs_model->get_user_validation_kofax_bs(
            $this->post('bs_id'));
        $this->response($response);
    }
    public function userEntriBs_post()
    {
        $response = $this->bs_v_model->get_user_entri_bs(
            $this->post('bs_id'));
        $this->response($response);
    }
    
    public function userValidationKofaxVBs_post()
    {
        $response = $this->bs_v_model->get_user_validation_kofax_v_bs(
            $this->post('bs_id'));
        $this->response($response);
    }
    
    public function bsBelumCorrection_post()
    {
        $response = $this->bs_model->get_bs_belum_correction(
            $this->post('username'));
        $this->response($response);
    }
    public function bsBelumValidasi_post()
    {
        $response = $this->bs_model->get_bs_belum_validasi(
            $this->post('username'));
        $this->response($response);
    }
    public function bsBelumValidationLengkap_post()
    {
        $response = $this->bs_model->get_bs_belum_validation_lengkap(
            $this->post('username'));
        $this->response($response);
    }
    public function bsBelumValidasiV_post()
    {
        $response = $this->bs_v_model->get_bs_belum_validasi_v(
            $this->post('username'));
        $this->response($response);
    }
    public function bsBelumValidationLengkapV_post()
    {
        $response = $this->bs_v_model->get_bs_belum_validation_lengkap_v(
            $this->post('username'));
        $this->response($response);
    }
    
    
    public function boxBelumCek_get()
    {
        $response = $this->box_model->get_box_belum_cek();
        $this->response($response);
    }
    public function pushToken_post(){
        $response = $this->token_model->insert_token(
            $this->post('username'),$this->post('token'));
        $this->response($response);
    }
    
    public function rekapBox_post(){
        $response = $this->box_model->rekap_box(
            $this->post('kegiatan'),$this->post('tanggal'));
        $this->response($response);
    }
    
    public function rekapAbsen_post(){
        $response = $this->absen_model->rekap_absen(
            $this->post('username'));
        $this->response($response);
    }
    
    // ini untuk lihat peruser
    // public function progresUser_post(){
    //     $response = $this->progres_model->progres_user(
    //         $this->post('username'));
    //     $this->response($response);
    // }
    
    // ini untuk lihat secara tim
    public function progresUser_post(){
        $response = $this->progres_model->progres_tim(
            $this->post('username'));
        $this->response($response);
    }
    public function guletinUser_post(){
        $response = $this->progres_model->guletin_user(
            $this->post('username'));
        $this->response($response);
    }
    public function pilahUser_post(){
        $response = $this->progres_model->pilah_user(
            $this->post('username'));
        $this->response($response);
    }
     public function scanUser_post(){
        $response = $this->progres_model->scan_user(
            $this->post('username'));
        $this->response($response);
    }
    
     public function validasiUser_post(){
        $response = $this->progres_model->validasi_user(
            $this->post('username'));
        $this->response($response);
    }
    
    public function guletinTim_post(){
        $response = $this->progres_model->guletin_tim(
            $this->post('kode_tim'));
        $this->response($response);
    }
    public function pilahTim_post(){
        $response = $this->progres_model->pilah_tim(
            $this->post('kode_tim'));
        $this->response($response);
    }
     public function scanTim_post(){
        $response = $this->progres_model->scan_tim(
            $this->post('kode_tim'));
        $this->response($response);
    }
     public function validasiTim_post(){
        $response = $this->progres_model->validasi_tim(
            $this->post('kode_tim'));
        $this->response($response);
    }
    
    public function getListKabkot_get(){
        $response = $this->master_sls_model->get_kabkot();
        $this->response($response);
    }
    public function getListKec_post(){
        $response = $this->master_sls_model->get_kec(
            $this->post('kabkot_id'));
        $this->response($response);
    }
    public function getListDesa_post(){
        $response = $this->master_sls_model->get_desa(
            $this->post('kec_id'));
        $this->response($response);
    }
    public function getListSls_post(){
        $response = $this->master_sls_model->get_sls(
            $this->post('desa_id'));
        $this->response($response);
    }
    
    public function getListDsbs_post(){
        $response = $this->master_dsbs_model->get_dsbs(
            $this->post('desa_id'));
        $this->response($response);
    }
    
    
    public function getProgresBsUser_post(){
        $response = $this->bs_model->get_progres_bs_user(
            $this->post('username'));
        $this->response($response);
    }
}