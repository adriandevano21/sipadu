<?php

class Master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all($tabel)
    {
        return $this->db->select('*')->from($tabel)->get()->result_array();
    }

    function get_all_last($tabel)
    {
        return $this->db->select('*')->from($tabel)->order_by('id', 'desc')->get()->result_array();
    }

    function update($tabel, $pk, $data_pk, $params)
    {
        $this->db->where($pk, $data_pk);
        return $this->db->update($tabel, $params);
    }
    
    function update_array_biasa($tabel, $data_pk, $params)
    {
        return $this->db->update($tabel, $params, $data_pk);
    }
    

    function update_array($tabel,  $params, $kolom_pk) // $data_pk harus array untuk kondisi where
    {
        
        return $this->db->update_batch($tabel, $params, $kolom_pk);
    }

    function delete($tabel, $pk, $data_pk)
    {
        $this->db->where($pk, $data_pk);
        return $this->db->delete($tabel);
    }

    function update_batch($data)
    {
        $this->db->update_batch('master_kl', $data, 'id_kl');
    }
    function insert_batch($tabel, $data)
    {
        $this->db->insert_batch($tabel, $data);
    }

    function insert($tabel, $params)
    {
        $this->db->insert($tabel, $params);
        return $this->db->insert_id();
    }
    public function get_id($table, $pk, $data_pk)
    {
        return $this->db->select('*')->from($table)->where($pk, $data_pk)->get()->row_array();
    }
} //akhir class