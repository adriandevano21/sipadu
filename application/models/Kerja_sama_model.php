<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model kerja_sama_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 *
 */

class Kerja_sama_model extends CI_Model
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
        return $this->db->select('*, kerja_sama.id as id_kerja_sama')
            ->from("kerja_sama")
            ->order_by("kerja_sama.tanggal", "DESC")
            ->get()->result_array();
    }

    // ------------------------------------------------------------------------

    public function get_id($id)
    {
        $all = $this->db->select('kerja_sama.id , p.nama_pegawai as pengundang, n.nama_pegawai as notulis, c.nama_pegawai as created, nama_ruangan, topik, tanggal, pukul, notulen, selesai')
            ->from("kerja_sama")
            ->join('master_pegawai p', 'p.username=kerja_sama.username_pengundang')
            ->join('master_pegawai n', 'n.username=kerja_sama.username_notulis')
            ->join('master_pegawai c', 'c.username=kerja_sama.username_created')
            ->join('master_ruang_kerja_sama', 'kerja_sama.id_ruang_kerja_sama=master_ruang_kerja_sama.id')
            ->where('kerja_sama.id', $id)
            ->get()->row_array();

        return $all;
    }

    public function  peserta_kerja_sama_id_kerja_sama($id_kerja_sama)
    {
        return $this->db->select('peserta_kerja_sama.username, nama_pegawai, status, no_wa, peserta_kerja_sama.id as id')
            ->from("peserta_kerja_sama")
            ->join('master_pegawai', 'master_pegawai.username=peserta_kerja_sama.username')
            ->where('peserta_kerja_sama.id_kerja_sama', $id_kerja_sama)
            ->order_by("master_pegawai.nama_pegawai", "ASC")->get()->result_array();
    }
    public function  peserta_kerja_sama_eksternal_id_kerja_sama($id_kerja_sama)
    {
        return $this->db->select('id, nama,instansi, status')
            ->from("peserta_kerja_sama_eksternal")
            ->where('peserta_kerja_sama_eksternal.id_kerja_sama', $id_kerja_sama)
            ->get()->result_array();
    }

    public function dokumentasi_kerja_sama_id_kerja_sama($id_kerja_sama)
    {
        return $this->db->select('id,nama_file')
            ->from("dokumentasi_kerja_sama")
            ->where('dokumentasi_kerja_sama.id_kerja_sama', $id_kerja_sama)
            ->get()->result_array();
    }
}

/* End of file kerja_sama_model.php */
/* Location: ./application/models/kerja_sama_model.php */