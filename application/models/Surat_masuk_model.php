<?php

// extends class Model
class Surat_masuk_model extends CI_Model
{

    function add($params)
    {
        $this->db->insert('surat', $params);
        return $this->db->insert_id();
    }
    public function get_all_copy()
    {
        return $this->db->select('*, surat_masuk.id as id_surat_masuk, nama_tim')->from("surat_masuk")
            ->join('master_pegawai', 'surat_masuk.username_created=master_pegawai.username')
            ->join('master_tim', 'surat_masuk.tujuan=master_tim.id')
            ->order_by('tanggal_surat', 'desc')
            ->order_by('surat_masuk.id', 'desc')
            ->get()->result_array();
    }

    public function get_all()
    {
        return $this->db->select('surat_masuk.id, no_surat, tanggal_surat, pengirim, perihal, 
        ringkasan,tujuan,file_surat, created_at, status, 
        sifat_surat, surat_masuk.id as id_surat_masuk, nama_tim, 
        username1, username2, username3, 
        a.nama_pegawai as nama_pegawai1, a.url_foto as url_foto1, 
        b.nama_pegawai as nama_pegawai2, b.url_foto as url_foto2,
        c.nama_pegawai as nama_pegawai3,  c.url_foto as url_foto3,
        catatan1, catatan2, catatan3')
            ->from("surat_masuk")
            ->join('master_pegawai', 'surat_masuk.username_created=master_pegawai.username', 'left')
            ->join('master_pegawai a', 'surat_masuk.username1=a.username', 'left')
            ->join('master_pegawai b', 'surat_masuk.username2=b.username', 'left')
            ->join('master_pegawai c', 'surat_masuk.username3=c.username', 'left')
            ->join('master_tim', 'surat_masuk.tujuan=master_tim.id')
            ->order_by('tanggal_surat', 'desc')
            ->order_by('surat_masuk.id', 'desc')
            ->get()->result_array();
    }
    public function get_all_disposisi()
    {
        return $this->db->select('*, surat_masuk.id as id_surat_masuk')->from("surat_masuk")
            ->join('disposisi_surat_masuk', 'surat_masuk.id=disposisi_surat_masuk.id_surat_masuk')
            ->join('master_pegawai', 'disposisi_surat_masuk.username=master_pegawai.username')
            ->order_by('tanggal_surat', 'desc')
            ->order_by('surat_masuk.id', 'desc')
            ->order_by('disposisi_surat_masuk.id', 'asc')
            ->get()->result_array();
    }

    public function get_id($id_surat_masuk)
    {
        return $this->db->select('surat_masuk.id, no_surat, tanggal_surat, pengirim, perihal, 
        ringkasan,tujuan,file_surat, created_at, status, 
        sifat_surat, surat_masuk.id as id_surat_masuk, nama_tim, 
        username1, username2, username3, 
        a.nama_pegawai as nama_pegawai1, a.url_foto as url_foto1, a.no_wa as no_wa1,
        b.nama_pegawai as nama_pegawai2, b.url_foto as url_foto2, b.no_wa as no_wa2,
        c.nama_pegawai as nama_pegawai3,  c.url_foto as url_foto3, c.no_wa as no_wa3,
        catatan1, catatan2, catatan3')
            ->from("surat_masuk")
            ->join('master_pegawai', 'surat_masuk.username_created=master_pegawai.username', 'left')
            ->join('master_pegawai a', 'surat_masuk.username1=a.username', 'left')
            ->join('master_pegawai b', 'surat_masuk.username2=b.username', 'left')
            ->join('master_pegawai c', 'surat_masuk.username3=c.username', 'left')
            ->join('master_tim', 'surat_masuk.tujuan=master_tim.id')
            ->where('surat_masuk.id', $id_surat_masuk)
            ->get()->row_array();
    }

    public function get_detail($id_surat_masuk)
    {
        return $this->db->select('*, surat_masuk.id as id_surat_masuk')
            ->from("surat_masuk")
            ->join('disposisi_surat_masuk', 'surat_masuk.id=disposisi_surat_masuk.id_surat_masuk', 'left')
            ->join('master_pegawai', 'disposisi_surat_masuk.username=master_pegawai.username')
            ->where('surat_masuk.id', $id_surat_masuk)
            ->order_by('tanggal_surat', 'desc')
            ->order_by('disposisi_surat_masuk.id', 'asc')
            ->get()->result_array();
    }

    function cek_disposisi($id_surat_masuk) // dapatkan row terakhir
    {
        return $this->db->select('*')->from("disposisi_surat_masuk")
            ->where('id_surat_masuk', $id_surat_masuk)
            ->order_by('id', 'desc')
            ->get()->row_array();
    }

    function cek_username_disposisi($id_surat_masuk, $username) // dapatkan row terakhir
    {
        return $this->db->select('*')->from("disposisi_surat_masuk")
            ->where('username', $username)
            ->where('id_surat_masuk', $id_surat_masuk)
            ->order_by('id', 'desc')
            ->get()->row_array();
    }

    function cek_kolom_username($id_surat_masuk, $username) // dapatkan row terakhir
    {
        $username1 = $this->db->select('no_surat')->from("surat_masuk")
            ->where('username1', $username)
            ->where('id', $id_surat_masuk)
            ->get()->row_array();
        $username2 = $this->db->select('no_surat')->from("surat_masuk")
            ->where('username2', $username)
            ->where('id', $id_surat_masuk)
            ->get()->row_array();
        $username3 = $this->db->select('no_surat')->from("surat_masuk")
            ->where('username3', $username)
            ->where('id', $id_surat_masuk)
            ->get()->row_array();


        if (!empty($username1)) {
            return '1';
        }
        if (!empty($username2)) {
            return '2';
        }
        if (!empty($username3)) {
            return '3';
        }
    }

    function get_all_bulan($bulan, $tahun)
    {
        return $this->db->select('*')->from("surat_masuk")
            ->join('master_pegawai', 'surat_masuk.username=master_pegawai.username')
            ->like('bulan', $bulan)
            ->like('tahun', $tahun)
            ->order_by('tanggal', 'desc')
            ->order_by('id', 'desc')
            ->get()->result_array();
    }

    public function update($id_surat, $params)
    {
        $this->db->where('id_surat', $id_surat);
        $update = $this->db->update("surat", $params);
        if ($update) {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Data person diubah.';
            return $response;
        } else {
            $response['status'] = 502;
            $response['error'] = true;
            $response['message'] = 'Data person gagal diubah.';
            return $response;
        }
    }

    public function update_disposisi($id_surat, $username, $params)
    {
        $this->db->where('id_surat_masuk', $id_surat);
        $this->db->where('username', $username);
        $update = $this->db->update("disposisi_surat_masuk", $params);
    }

    function add_download($params)
    {
        $this->db->insert('download_surat', $params);
        return $this->db->insert_id();
    }
}
