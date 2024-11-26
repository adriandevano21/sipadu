<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Perjadin_model_model
 *
 * This Model for ...
 * 
 *
 */

class Ppk_model extends CI_Model
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
    return $this->db->select('*, perjadin.id as id_perjadin')
    ->from("perjadin")
    ->join('master_pegawai', "perjadin.username=master_pegawai.username")
    ->join('master_satker', "perjadin.kode_tujuan=master_satker.kode_satker")
    ->like('tanggal_pergi', $tahun . '-' . $bulan)
    ->order_by("perjadin.tanggal_pergi", "DESC")->get()->result_array();
  }

  // ------------------------------------------------------------------------
  
  public function dokumentasi_perjadin_id_perjadin($id_perjadin)
  {
    return $this->db->select('id,nama_file, caption')
    ->from("dokumentasi_perjadin")
    ->where('dokumentasi_perjadin.id_perjadin', $id_perjadin)
    ->get()->result_array();
  }
  
  public function get_id($id)
  {
     return $this->db->select('*')
    ->from("ppk")
    ->join('master_pegawai', "ppk.username=master_pegawai.username")
    ->where('ppk.id', $id)
    ->get()->row_array();
    
  }
  
  public function get_id_jenis_anggaran($id)
  {
     return $this->db->select('nama_pegawai, no_wa')
    ->from("ppk")
    ->join('master_pegawai', "ppk.username=master_pegawai.username")
    ->where('ppk.id_jenis_anggaran', $id)
    ->get()->row_array();
    
  }

}

/* End of file Perjadin_model.php */
/* Location: ./application/models/Perjadin_model.php */