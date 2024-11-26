<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Rapat_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 *
 */

class Quote_model extends CI_Model
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------
  // ------------------------------------------------------------------------
  function get_random()
  {
    $this->db->select('*');
$this->db->from('quote');
$this->db->order_by('RAND()');
$this->db->limit(1);

$query = $this->db->get();
$result = $query->row_array();
return $result ;
// Sekarang $result berisi satu baris acak dari tabel.

  }

  // ------------------------------------------------------------------------
  function get_all_bulan1111($bulan, $tahun)
  {
    return $this->db->select('*, rapat.id as id_rapat,rapat.lokasi, master_ruang_rapat.id as id_ruangan')
      ->from("rapat")
      ->join('master_ruang_rapat', 'rapat.id_ruang_rapat=master_ruang_rapat.id', 'left')
      ->join('master_pegawai', 'rapat.username_notulis=master_pegawai.username')
      ->join('master_tim', 'rapat.id_tim=master_tim.id', 'left')
      ->like('tanggal', $tahun . '-' . $bulan)
      ->order_by("rapat.tanggal", "DESC")
      ->get()->result_array();
  }
  
  function get_all_bulan($bulan, $tahun)
  {
    return $this->db->select('topik, tanggal, pukul, selesai, nama_tim, nama_ruangan, username_notulis, tanggal_selesai,nama_pegawai, username_created,  rapat.id as id_rapat,rapat.lokasi, master_ruang_rapat.id as id_ruangan, count(id_rapat) as peserta')
      ->from("rapat")
      ->join('master_ruang_rapat', 'rapat.id_ruang_rapat=master_ruang_rapat.id', 'left')
      ->join('master_pegawai', 'rapat.username_notulis=master_pegawai.username')
      ->join('master_tim', 'rapat.id_tim=master_tim.id', 'left')
      ->join('peserta_rapat', 'peserta_rapat on rapat.id = peserta_rapat.id_rapat', 'left')
      ->like('tanggal', $tahun . '-' . $bulan)
      ->group_by('id_rapat')
      ->order_by("rapat.tanggal", "DESC")
      ->get()->result_array();
  }
  // ------------------------------------------------------------------------
  function get_all_ruang_rapat()
  {
    return $this->db->select('*')
      ->from("master_ruang_rapat")
      ->get()->result_array();
  }

  // ------------------------------------------------------------------------

  public function get_id($id)
  {
    $all = $this->db->select('rapat.id, rapat.lokasi, p.nama_pegawai as pengundang, n.nama_pegawai as notulis, c.nama_pegawai as created, nama_ruangan, topik, tanggal,tanggal_selesai, pukul, notulen, selesai,undangan_rapat.nama_file as nama_file_undangan, notulen_rapat.nama_file as nama_file_notulen, berkas_rapat.nama_file as nama_file_berkas')
      ->from("rapat")
      ->join('master_pegawai p', 'p.username=rapat.username_pengundang', 'left')
      ->join('master_pegawai n', 'n.username=rapat.username_notulis', 'left')
      ->join('master_pegawai c', 'c.username=rapat.username_created', 'left')
      ->join('master_ruang_rapat', 'rapat.id_ruang_rapat=master_ruang_rapat.id', 'left')
      ->join('undangan_rapat', 'rapat.id=undangan_rapat.id_rapat', 'left')
      ->join('notulen_rapat', 'rapat.id=notulen_rapat.id_rapat', 'left')
      ->join('berkas_rapat', 'rapat.id=berkas_rapat.id_rapat', 'left')
      ->where('rapat.id', $id)
      ->order_by('undangan_rapat.id', 'DESC')
      ->order_by('notulen_rapat.id', 'DESC')
      ->order_by('berkas_rapat.id', 'DESC')
      ->get()->row_array();

    return $all;
  }

  public function  peserta_rapat_id_rapat($id_rapat)
  {
    return $this->db->select('peserta_rapat.username, nama_pegawai, status, no_wa, peserta_rapat.id as id')
      ->from("peserta_rapat")
      ->join('master_pegawai', 'master_pegawai.username=peserta_rapat.username')
      ->where('peserta_rapat.id_rapat', $id_rapat)
      ->group_by('peserta_rapat.username')
      ->order_by("master_pegawai.nama_pegawai", "ASC")->get()->result_array();
  }
  public function  peserta_rapat_eksternal_id_rapat($id_rapat)
  {
    return $this->db->select('id, nama,instansi, status')
      ->from("peserta_rapat_eksternal")
      ->where('peserta_rapat_eksternal.id_rapat', $id_rapat)
      ->get()->result_array();
  }

  public function dokumentasi_rapat_id_rapat($id_rapat)
  {
    return $this->db->select('id,nama_file')
      ->from("dokumentasi_rapat")
      ->where('dokumentasi_rapat.id_rapat', $id_rapat)
      ->get()->result_array();
  }

  public function get_available_ruangan($tanggal, $pukul_start, $pukul_end)
  {

    $query  = $this->db->query("SELECT mr.id, mr.nama_ruangan
    FROM sipadu_master_ruang_rapat mr
    WHERE mr.id NOT IN (
    SELECT r.id_ruang_rapat
    FROM sipadu_rapat r
    WHERE r.tanggal = '$tanggal'
    AND (
        (r.pukul <= '$pukul_start' AND r.selesai > '$pukul_start') OR ( r.selesai > '$pukul_end' AND r.pukul < '$pukul_end' ) OR ( r.pukul > '$pukul_start' AND r.pukul < '$pukul_end' )
    )
    )");
    
    // $this->db->select('mr.id, mr.nama_ruangan');
    // $this->db->from('master_ruang_rapat mr');
    // $this->db->where_not_in('mr.id', "select r.id_ruang_rapat from sipadu_rapat r where r.tanggal = '$tanggal' and (r.pukul <= '$pukul_start' or r.selesai >= '$pukul_start') ");


    if ($query->num_rows() > 0) {
      return $query->result_array();
    } else {
      return array();
    }
  }
}

/* End of file Rapat_model.php */
/* Location: ./application/models/Rapat_model.php */

// OR
// (r.pukul_selesai > '$pukul_start' AND r.pukul_selesai <= '$pukul_end')
// $this->db->where_not_in('mr.id', function ($subquery) use ($tanggal, $pukul_start, $pukul_end) {
//   $subquery->select('r.id_ruang_rapat');
//   $subquery->from('rapat r');
//   $subquery->where('r.tanggal', $tanggal);
//   $subquery->where("r.pukul >=", $pukul_start);
//   $subquery->where("r.pukul_selesai >=", $pukul_end);
// });