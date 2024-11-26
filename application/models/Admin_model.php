<?php

// extends class Model
class Admin_model extends CI_Model
{

    public function get_username($username)
    {
        $admin = $this->db->select('* ')->from("zoom_admin")
            ->where('username', $username)
            ->get()->row_array();
        if (!empty($admin)) {
            return $admin;
        } else {
            return null;
        }
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
