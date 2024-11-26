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

class Projek_model extends CI_Model
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
        return $this->db->select('*,projek.id as id_projek')
            ->from("projek")
            ->join('master_tim', 'projek.id_tim = master_tim.id')
            ->get()->result_array();
    }
    function get_by_id($id)
    {
        return $this->db->select('*,projek.id as id_projek, projek.tahun as tahun_projek')
            ->from("projek")
            ->join('master_tim', 'projek.id_tim = master_tim.id')
            ->join('iku', 'projek.id_iku = iku.id', 'left')
            ->like('projek.id', $id)
            ->get()->row_array();
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

    public function cek_projek($id)
    {
        $cek = $this->db->get_where('aktivitas', array('id_projek' => $id))->result();

        if (empty($cek)) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file lpp_model.php */
/* Location: ./application/models/Lpp_model.php */