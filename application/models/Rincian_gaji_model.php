<?php

class Rincian_gaji_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all()
    {
        return $this->db->select('*')->from("rincian_gaji")->join('master_pegawai', 'master_pegawai.nip_lama=rincian_gaji.nip_lama')->get()->result_array();
    }
    function get_gajiku()
    {
        return $this->db->select('*')->from("rincian_gaji")->join('master_pegawai', 'master_pegawai.nip_lama=rincian_gaji.nip_lama')->where('rincian_gaji.nip_lama', $this->session->userdata('nip_lama'))->get()->result_array();
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
        return $this->db->select('*')->from("mood_pegawai")->where("tanggal", date("Y-m-d"))->where('nip_lama', $this->session->userdata('nip_lama'))->get()->row_array();
    }
} //akhir class