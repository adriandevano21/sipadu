<?php

// extends class Model
class Login_model extends CI_Model
{
    public function cek_login($username, $password)
    {
        $all = $this->db->select('*')->from("master_pegawai")
            // ->join('master_unit_kerja', 'master_pegawai.kode_unit_kerja=master_unit_kerja.kode_unit_kerja')
            // ->join('master_satker', 'master_pegawai.kode_satker=master_satker.kode_satker')
            // ->join('master_pangkat','master_pegawai.pangkat=master_pangkat.gol_pangkat')
            ->where('username', $username)->get()->row_array();
        if (password_verify($password, $all['password'])) {
            return $all;
        } else {
            return null;
        }
    }
    
    public function cek_login_api($username, $password)
    {
        $all = $this->db->select('*')->from("master_pegawai")
            ->where('username', $username)->get()->row_array();
        if (password_verify($password, $all['password'])) {
            if(!empty($all)){
                
                    $response['status'] = 200;
                    $response['error'] = false;
                    $response['userData'] = $all;
                    return $response;
                
                
            }else {
                    $response['status'] = 404;
                    $response['error'] = true;
                    $response['m_error'] = 'username dan password salah';
                    $response['userData'] = null;
                    return $response;
            }
            } else {
                    $response['status'] = 404;
                    $response['error'] = true;
                    $response['m_error'] = 'username dan password salah';
                    $response['userData'] = null;
                    return $response;
            }
    }
    
    
    public function cek_username($username)
    {
        $all = $this->db->select('*')->from("master_pegawai")
            ->where('username', $username)->get()->row_array();

        return $all;
    }
}