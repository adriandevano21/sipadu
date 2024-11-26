<?php

class Indikator_pk_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all()
    {
        return $this->db->select('*')->from("master_pegawai")->get()->result_array();
    }
    public function get_pegawai($username)
    {
        return $this->db->select('*')->from('master_pegawai')->where('username', $username)->get()->row_array();
    }
    function get_all_aktif() // semua PNS BPS Provinsi Aceh
    {
        return $this->db->select('*')->from("indikator_pk")->where('status', "1")->like('kode_satker', '1100')->get()->result_array();
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
    public function kloter($kloter)
    {
        return $this->db->select('nama_pegawai, no_wa')->from("master_pegawai")->where("kloter_wa", $kloter)->get()->result_array();
    }
} //akhir class