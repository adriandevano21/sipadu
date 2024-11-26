<?php
class Kegiatan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Create
    public function tambah_kegiatan($data)
    {
        $this->db->insert('kegiatan', $data);
        return $this->db->insert_id();
    }

    // Read
    public function semua_kegiatan()
    {
        return $this->db->select('nama_tim, nama_subtim, nama_kegiatan, id_kegiatan')
            ->from("kegiatan")
            ->join('subtim', 'kegiatan.kode_subtim = subtim.kode_subtim', 'left')
            ->join('master_tim', 'master_tim.id = subtim.id_tim', 'left')
            ->where('master_tim.aktif', '1')
            ->get()->result_array();
    }

    public function detail_kegiatan($id)
    {
        return $this->db->get_where('kegiatan', array('id_kegiatan' => $id))->row_array();
    }

    // Update
    public function update_kegiatan($id, $data)
    {
        $this->db->where('id_kegiatan', $id);
        return $this->db->update('kegiatan', $data);
    }

    // Delete
    public function hapus_kegiatan($id)
    {
        return $this->db->delete('kegiatan', array('id_kegiatan' => $id));
    }
}
