<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model sk_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 *
 */

class Sk_model extends CI_Model
{

    // ------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
    }

    // ------------------------------------------------------------------------


    // ------------------------------------------------------------------------
    function get_all()
    {
        return $this->db->select('*, sk.id as id_sk')
            ->from("sk")
            ->order_by("sk.tanggal", "DESC")
            ->get()->result_array();
    }

    // ------------------------------------------------------------------------

    public function get_id($id)
    {
        $all = $this->db->select('sk.id , p.nama_pegawai as pengundang, n.nama_pegawai as notulis, c.nama_pegawai as created, nama_ruangan, topik, tanggal, pukul, notulen, selesai')
            ->from("sk")
            ->join('master_pegawai p', 'p.username=sk.username_pengundang')
            ->join('master_pegawai n', 'n.username=sk.username_notulis')
            ->join('master_pegawai c', 'c.username=sk.username_created')
            ->join('master_ruang_sk', 'sk.id_ruang_sk=master_ruang_sk.id')
            ->where('sk.id', $id)
            ->get()->row_array();

        return $all;
    }

    public function  peserta_sk_id_sk($id_sk)
    {
        return $this->db->select('peserta_sk.username, nama_pegawai, status, no_wa, peserta_sk.id as id')
            ->from("peserta_sk")
            ->join('master_pegawai', 'master_pegawai.username=peserta_sk.username')
            ->where('peserta_sk.id_sk', $id_sk)
            ->order_by("master_pegawai.nama_pegawai", "ASC")->get()->result_array();
    }
    public function  peserta_sk_eksternal_id_sk($id_sk)
    {
        return $this->db->select('id, nama,instansi, status')
            ->from("peserta_sk_eksternal")
            ->where('peserta_sk_eksternal.id_sk', $id_sk)
            ->get()->result_array();
    }

    public function dokumentasi_sk_id_sk($id_sk)
    {
        return $this->db->select('id,nama_file')
            ->from("dokumentasi_sk")
            ->where('dokumentasi_sk.id_sk', $id_sk)
            ->get()->result_array();
    }
}

/* End of file sk_model.php */
/* Location: ./application/models/sk_model.php */