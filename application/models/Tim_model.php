<?php

class Tim_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_all_aktif()
    {
        return $this->db->select('nama_tim, id')
            ->from("master_tim")
            ->where('aktif', '1')
            ->get()->result_array();
    }
    public function get_ketua_tim($id_tim)
    {
        return $this->db->select('username, id_tim')
            ->from("ketua_tim")
            ->where('id_tim', $id_tim)
            ->get()->row_array();
    }
    public function get_all_subtim()
    {
        return $this->db->select('nama_tim, id_tim, id_subtim, nama_subtim, kode_subtim')
            ->from("master_tim")
            ->join('subtim', 'master_tim.id = subtim.id_tim')
            ->where('master_tim.aktif', '1')
            ->get()->result_array();
    }
} //akhir class