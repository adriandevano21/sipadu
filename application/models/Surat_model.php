<?php

// extends class Model
class Surat_model extends CI_Model
{
    public function get_skp($nip_pegawai, $tahun)
    {
        return $this->db->select('*,
            sum(a.target) as sum_target,
            sum(a.realisasi) as sum_realisasi,
            avg(a.kualitas) as avg_kualitas')
            ->from("tabel_matriks_kinerja_individu as a")
            ->join('tabel_matriks_kinerja as b ', 'a.id_matriks=b.id_matriks_kinerja', 'left')
            ->join('tabel_master_kegiatan as c', 'b.id_kegiatan=c.id_kegiatan', 'left')
            ->join('tabel_master_pekerjaan as d', 'b.id_master_pekerjaan=d.id_master_pekerjaan', 'left')
            ->join('master_pegawai as e', 'a.nip_pegawai=e.nip_pegawai', 'left')
            ->join('master_butir_fungsional as f', 'a.id_butir=f.id_butir', 'left')
            ->where('a.nip_pegawai', $nip_pegawai)
            ->where('a.tahun', $tahun)
            ->group_by('a.id_matriks')->get()->result_array();
    }

    function add($params)
    {
        $this->db->insert('surat', $params);
        return $this->db->insert_id();
    }
    public function get_all()
    {
        return $this->db->select('*')->from("surat")->join('master_pegawai', 'surat.username=master_pegawai.username')->order_by('tanggal', 'desc')->order_by('id_surat', 'desc')->get()->result_array();
    }

    function get_all_bulan($bulan, $tahun)
    {
        return $this->db->select('id_surat, no_surat, tujuan, perihal, tanggal, awalan, a.username, username2, username3, unit_kerja, no, kode, link,
        catatan1, catatan2, file_surat,
        a.nama_pegawai as nama_pegawai, a.url_foto as url_foto, a.no_wa as no_wa,
        b.nama_pegawai as nama_pegawai2, b.url_foto as url_foto2, b.no_wa as no_wa2,
        c.nama_pegawai as nama_pegawai3, c.url_foto as url_foto3, c.no_wa as no_wa3')->from("surat")
            ->join('master_pegawai a', 'surat.username=a.username', 'left')
            ->join('master_pegawai b', 'surat.username2=b.username', 'left')
            ->join('master_pegawai c', 'surat.username3=c.username', 'left')
            ->like('bulan', $bulan)
            ->like('tahun', $tahun)
            ->order_by('tanggal', 'desc')
            ->order_by('id_surat', 'desc')
            ->get()->result_array();
    }
    function get_id($id_surat)
    {
        return $this->db->select('id_surat, no_surat, tujuan, perihal, tanggal, awalan, 
        a.username, username2, unit_kerja, no, kode, link,catatan1, catatan2, file_surat,
        a.nama_pegawai as nama_pegawai, a.url_foto as url_foto, a.no_wa as no_wa,
        b.nama_pegawai as nama_pegawai2, b.url_foto as url_foto2, b.no_wa as no_wa2,
        c.nama_pegawai as nama_pegawai3, c.url_foto as url_foto3, c.no_wa as no_wa3')
            ->from("surat")
            ->join('master_pegawai a', 'surat.username=a.username', 'left')
            ->join('master_pegawai b', 'surat.username2=b.username', 'left')
            ->join('master_pegawai c', 'surat.username3=c.username', 'left')
            ->like('id_surat', $id_surat)
            ->get()->row_array();
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

    function add_download($params)
    {
        $this->db->insert('download_surat', $params);
        return $this->db->insert_id();
    }
}
