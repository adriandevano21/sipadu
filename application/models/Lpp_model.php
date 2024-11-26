<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Ppl_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 *
 */

class Lpp_model extends CI_Model
{

    // ------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
    }

    // ------------------------------------------------------------------------


    // ------------------------------------------------------------------------
    function get_all_bulan($bulan, $tahun)
    {
        return $this->db->select('*, lpp.id as id_lpp, lpp.kode_satker as kode_satker')
            ->from("lpp")
            ->join('master_pegawai', 'lpp.username = master_pegawai.username')
            ->join('master_satker', 'lpp.kode_satker = master_satker.kode_satker')
            ->like('lpp.tahun', $tahun)
            ->like('lpp.bulan', $bulan)
            ->order_by("lpp.kode_satker", "ASC")
            ->get()->result_array();
    }
    function get_isi_all_bulan($bulan, $tahun, $username)
    {
        return $this->db->select('*, lpp.id as id_lpp, isi_lpp.id as id_isi_lpp')
            ->from("lpp")
            ->join('isi_lpp', 'lpp.id=isi_lpp.id_lpp')
            ->like('lpp.tahun', $tahun)
            ->like('lpp.bulan', $bulan)
            ->like('lpp.username', $username)
            ->order_by("isi_lpp.tanggal", "ASC")
            ->order_by("isi_lpp.jam_mulai", "ASC")
            ->get()->result_array();
    }

    function get_minggu_lpp($bulan, $tahun, $username)
    {
        return $this->db->distinct()->select('minggu')
            ->from("lpp")
            ->join('isi_lpp', 'lpp.id=isi_lpp.id_lpp')
            ->like('lpp.tahun', $tahun)
            ->like('lpp.bulan', $bulan)
            ->like('lpp.username', $username)
            ->order_by("isi_lpp.tanggal", "ASC")
            ->order_by("isi_lpp.jam_mulai", "ASC")
            ->get()->result_array();
    }

    public function update($id_lpp, $params)
    {
        $this->db->where('id', $id_lpp);
        $update = $this->db->update("lpp", $params);
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

    // ------------------------------------------------------------------------

    public function get_id($id)
    {
        $all = $this->db->select('lpp.id , p.nama_pegawai as pengundang, n.nama_pegawai as notulis, c.nama_pegawai as created, nama_ruangan, topik, tanggal, pukul, notulen, selesai')
            ->from("lpp")
            ->join('master_pegawai p', 'p.username=lpp.username_pengundang')
            ->join('master_pegawai n', 'n.username=lpp.username_notulis')
            ->join('master_pegawai c', 'c.username=lpp.username_created')
            ->join('master_ruang_lpp', 'lpp.id_ruang_lpp=master_ruang_lpp.id')
            ->where('lpp.id', $id)
            ->get()->row_array();

        return $all;
    }

    public function  peserta_lpp_id_lpp($id_lpp)
    {
        return $this->db->select('peserta_lpp.username, nama_pegawai, status, no_wa, peserta_lpp.id as id')
            ->from("peserta_lpp")
            ->join('master_pegawai', 'master_pegawai.username=peserta_lpp.username')
            ->where('peserta_lpp.id_lpp', $id_lpp)
            ->order_by("master_pegawai.nama_pegawai", "ASC")->get()->result_array();
    }
    public function  peserta_lpp_eksternal_id_lpp($id_lpp)
    {
        return $this->db->select('id, nama,instansi, status')
            ->from("peserta_lpp_eksternal")
            ->where('peserta_lpp_eksternal.id_lpp', $id_lpp)
            ->get()->result_array();
    }

    public function dokumentasi_lpp_id_lpp($id_lpp)
    {
        return $this->db->select('id,nama_file')
            ->from("dokumentasi_lpp")
            ->where('dokumentasi_lpp.id_lpp', $id_lpp)
            ->get()->result_array();
    }
}

/* End of file lpp_model.php */
/* Location: ./application/models/Lpp_model.php */