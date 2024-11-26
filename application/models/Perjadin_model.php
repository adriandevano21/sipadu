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

class Perjadin_model extends CI_Model
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
  
  //20241014
  function get_all_bulan2($bulan, $tahun)
  {
    return $this->db->select('*, perjadin.id as id_perjadin')
    ->from("perjadin")
    ->join('master_pegawai', "perjadin.username=master_pegawai.username")
    ->join('master_satker', "perjadin.kode_tujuan=master_satker.kode_satker")
    ->like('tanggal_pergi', $tahun . '-' . $bulan)
    ->group_by("perjadin.tanggal_pergi","perjadin.tanggal_pulang","perjadin.komponen","perjadin.program","perjadin.kegiatan")
    ->order_by("perjadin.tanggal_pergi", "DESC")->get()->result_array();
  }
  //20241014
  
  // ------------------------------------------------------------------------
  function tujuan_perjadin($tahun)
  {
    return $this->db->select('*')
    ->from("tujuan_perjadin")
    ->where('tahun', $tahun )
    ->get()->result_array();
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
     return $this->db->select('tx.nominal as nominal_taksi, h.nominal as nominal_hotel, h.sbm as sbm_hotel, h.sbm_gol4 as sbm_gol4_hotel, h.sbm_es2 as sbm_es2_hotel, t.nominal as nominal_transportasi, u.nominal as nominal_uang, 
     perjadin.*,master_satker.*, a.nama_pegawai as nama_pegawai, b.nip as nip_pejabat,b.nama_pegawai as nama_pejabat, perjadin.id as id_perjadin')
    ->from("perjadin")
    ->join('master_pegawai a', "perjadin.username=a.username",'left')
    ->join('master_satker', "perjadin.kode_tujuan=master_satker.kode_satker")
    ->join('master_pegawai b', "perjadin.username_pejabat=b.username",'left')
    ->join('rate_hotel h', "perjadin.kode_tujuan=h.kode_satker",'left')
    ->join('rate_transportasi t', "perjadin.kode_tujuan=t.kode_satker",'left')
    ->join('uang_harian u', "perjadin.kode_tujuan=u.kode_satker",'left')
    ->join('rate_taksi tx', "perjadin.kode_tujuan=tx.kode_satker",'left')
    ->where('perjadin.id', $id)
    ->get()->row_array();
    
  }
  public function get_id_bu($id)
  {
     return $this->db->select('perjadin.*,master_satker.*, a.nama_pegawai as nama_pegawai, b.nip as nip_pejabat,b.nama_pegawai as nama_pejabat, perjadin.id as id_perjadin')
    ->from("perjadin")
    ->join('master_pegawai a', "perjadin.username=a.username",'left')
    ->join('master_satker', "perjadin.kode_tujuan=master_satker.kode_satker")
    ->join('master_pegawai b', "perjadin.username_pejabat=b.username",'left')
    ->where('perjadin.id', $id)
    ->get()->row_array();
    
  }
  
  public function get_nama_rombongan($tanggal_pergi,$tanggal_pulang,$komponen,$kegiatan)
  {
     return $this->db->select('master_pegawai.nama_pegawai,perjadin.id')
                            ->from("perjadin")
                            ->join('master_pegawai', 'master_pegawai.username=perjadin.username')
                            ->where("tanggal_pergi",$tanggal_pergi)
                            ->where("tanggal_pulang",$tanggal_pulang)
                            ->where("komponen",$komponen)
                            ->where("kegiatan",$kegiatan)
                            ->order_by('perjadin.id', 'ASC')
                            ->get()
                            ->result_array();
    
  }


}

/* End of file Perjadin_model.php */
/* Location: ./application/models/Perjadin_model.php */