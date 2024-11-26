<?php

// extends class Model
class Anggota_subtim_model extends CI_Model
{

    public function get_all()
    {
        return $this->db->select('nama_pegawai,master_pegawai.username,nama_subtim, id_anggota_subtim')
            ->from("anggota_subtim")
            ->join('subtim', 'subtim.kode_subtim=anggota_subtim.kode_subtim', 'left')
            ->join('master_pegawai', 'anggota_subtim.username=master_pegawai.username', 'left')
            ->get()->result_array();
    }

    public function get_aktif()
    {
        $admin = $this->db->select('* ')->from("zoom_admin")
            ->join('master_pegawai', 'master_pegawai.username=zoom_admin.username')
            ->where('aktif', 1)
            ->get()->result_array();
        if (!empty($admin)) {
            return $admin;
        } else {
            return null;
        }
    }
}
