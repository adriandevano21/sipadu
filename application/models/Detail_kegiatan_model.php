<?php
class Detail_kegiatan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Create
    public function tambah_detail_kegiatan($data)
    {
        $this->db->insert('detail_kegiatan', $data);
        return $this->db->insert_id();
    }

    // Read
    public function semua_detail_kegiatan()
    {
        return $this->db->get('detail_kegiatan')->result_array();
    }

    // Read
    public function semua_rekap_kegiatan_pegawai()
    {
        return $this->db->get('rekap_kegiatan_pegawai')->result_array();
    }

    public function detail_detail_kegiatan($id)
    {
        return $this->db->get_where('detail_kegiatan', array('id_detail_kegiatan' => $id))->row_array();
    }

    // Update
    public function update_detail_kegiatan($id, $data)
    {
        $this->db->where('id_detail_kegiatan', $id);
        return $this->db->update('detail_kegiatan', $data);
    }

    // Delete
    public function hapus_detail_kegiatan($id)
    {
        return $this->db->delete('detail_kegiatan', array('id_detail_kegiatan' => $id));
    }

    function semua_kegiatan_detail()
    {
        $this->db->select('detail_kegiatan.id_detail_kegiatan, kegiatan.id_kegiatan, 
        kegiatan.nama_kegiatan,detail_kegiatan.tanggal_mulai, detail_kegiatan.tanggal_selesai, 
        detail_kegiatan.output, tujuan_pk.tujuan_pk, kedeputian.kedeputian,  
        GROUP_CONCAT(sipadu_master_pegawai.url_foto SEPARATOR ";") as url_foto,
        GROUP_CONCAT(sipadu_master_pegawai.nama_pegawai SEPARATOR ";") as nama_pegawai,
        GROUP_CONCAT(sipadu_master_tim.nama_tim SEPARATOR ";") as nama_tim_kolab,
        mt.nama_tim, nama_subtim');
        $this->db->from('kegiatan');
        $this->db->join('detail_kegiatan', 'kegiatan.id_kegiatan = detail_kegiatan.id_kegiatan');
        $this->db->join('kolaborasi_tim_kegiatan', 'kolaborasi_tim_kegiatan.id_detail_kegiatan = detail_kegiatan.id_detail_kegiatan');
        $this->db->join('master_tim ', 'sipadu_kolaborasi_tim_kegiatan.id_tim = master_tim.id','left');
        $this->db->join('anggota_kegiatan', 'detail_kegiatan.id_detail_kegiatan = anggota_kegiatan.id_detail_kegiatan');
        $this->db->join('anggota_subtim', 'anggota_subtim.id_anggota_subtim = anggota_kegiatan.id_anggota_subtim');
        $this->db->join('master_pegawai', 'anggota_subtim.username = master_pegawai.username');
        $this->db->join('tujuan_pk', 'detail_kegiatan.id_tujuan_pk = tujuan_pk.id_tujuan_pk');
        $this->db->join('kedeputian', 'detail_kegiatan.id_kedeputian = kedeputian.id_kedeputian');
        $this->db->join('subtim', 'kegiatan.kode_subtim = subtim.kode_subtim');
        $this->db->join('master_tim mt', 'subtim.id_tim = mt.id');
        
        $this->db->group_by('detail_kegiatan.id_detail_kegiatan');
        $query = $this->db->get();
        return $query->result_array();
    }
}
