<?php

class Absensi_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all()
    {
        return $this->db->select('*')->from("absensi")->join('master_pegawai', 'master_pegawai.username=absensi.username')->like('timestamp','2023')->or_like('timestamp','2024')->get()->result_array();
    }
    function get_absensiku()
    {
        return $this->db->select('*')->from("absensi")->join('master_pegawai', 'master_pegawai.username=absensi.username')->where('absensi.username', $this->session->userdata('username'))->get()->result_array();
    }
    function get_absensiku_api($username)
    {
        $all = $this->db->select('absensi.timestamp, kegiatan')->from("absensi")
        ->join('master_pegawai', 'master_pegawai.username=absensi.username')
        ->where('absensi.username', $username)
        ->like('absensi.timestamp', date('Y'))
        ->order_by('timestamp', 'DESC')
        ->get()->result_array();

        $response['status'] = 200;
        $response['error'] = false;
        $response['PresensikuData'] = $all;
        return $response;
    }

    function update($tabel, $pk, $data_pk, $params)
    {
        $this->db->where($pk, $data_pk);
        return $this->db->update($tabel, $params);
    }

    function update_batch($data)
    {
        $this->db->update_batch('master_kl', $data, 'id_kl');
    }
    function insert_batch($data)
    {
        $this->db->insert_batch('master_kl', $data);
    }

    function insert($tabel, $params)
    {
        $this->db->insert($tabel, $params);
        // return $this->db->insert_id();
    }
    public function get_id($table, $pk, $data_pk)
    {
        return $this->db->select('*')->from($table)->where($pk, $data_pk)->get()->row_array();
    }
    public function cek_hari_ini()
    {
        return $this->db->select('*')->from("mood_pegawai")->where("tanggal", date("Y-m-d"))->where('username', $this->session->userdata('username'))->get()->row_array();
    }
} //akhir class