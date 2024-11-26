<?php

// extends class Model
class Zoom_Meeting_model extends CI_Model
{
    public function get_all()
    {
        $all = $this->db->select('*, zoom_meeting.password as password_zoom,zoom_meeting.id as id_zoom_meeting ')->from("zoom_meeting")
            ->join('master_pegawai', 'master_pegawai.username=zoom_meeting.username')
            ->like('start_date', date("Y"))
            // ->like('start_date', 2023)
            ->order_by('start_date', 'desc')
            ->get()->result_array();

        return $all;
    }

    public function belum_upload_adm()
    {
        $date = date("Y-m-d");
        $all = $this->db->select('*')->from("zoom_meeting")
            ->join('master_pegawai', 'master_pegawai.username=zoom_meeting.username')
            ->where('start_date < ', $date)
            ->where('file_adm IS  NULL', null, false)
            ->where('status ', 2)
            ->get()->result_array();

        return $all;
    }

    public function get_username($username)
    {
        $all = $this->db->select('*, zoom_meeting.password as password_zoom,zoom_meeting.id as id_zoom_meeting ')->from("zoom_meeting")
            ->join('master_pegawai', 'master_pegawai.username=zoom_meeting.username')
            ->where('zoom_meeting.username', $username)
            ->get()->result_array();

        return $all;
    }

    public function get_id($id)
    {
        $all = $this->db->select('*, zoom_meeting.password as password_zoom,zoom_meeting.id as id_zoom_meeting ')->from("zoom_meeting")
            ->join('master_pegawai', 'master_pegawai.username=zoom_meeting.username')
            ->where('id', $id)
            ->get()->row_array();

        return $all;
    }
    
    public function cek_ketersediaan_akunxxxx($start_date, $end_date) {
      
        $akun_tersedia = NULL;

        // Cek ketersediaan akun 1
        $query_akun1 = $this->db->where('id_akun_zoom', 1)
                                ->where('DATE(start_date)', date('Y-m-d', strtotime($start_date)))
                                ->group_start()
                                ->where("('$start_date'  BETWEEN start_date AND end_date)")
                                ->or_where("('$end_date'  BETWEEN start_date AND end_date)")
                                ->or_where("(start_date > '$start_date' AND end_date < '$end_date')")
                                ->group_end()->get('zoom_meeting');

        // Jika akun 1 sudah digunakan, coba akun 2
        if ($query_akun1->num_rows() > 0) {
            $query_akun2 = $this->db->where('id_akun_zoom', 2)
                                ->where('DATE(start_date)', date('Y-m-d', strtotime($start_date)))
                                ->group_start()
                                ->where("('$start_date'  BETWEEN start_date AND end_date)")
                                ->or_where("('$end_date'  BETWEEN start_date AND end_date)")
                                ->or_where("(start_date > '$start_date' AND end_date < '$end_date')")
                                ->group_end()->get('zoom_meeting');

            // Jika akun 2 tersedia, set akun tersedia menjadi akun 2
            if ($query_akun2->num_rows() == 0) {
                $akun_tersedia = '2';
            } else if($query_akun2->num_rows() > 0){
                $query_akun3 = $this->db->where('id_akun_zoom', 3)
                                ->where('DATE(start_date)', date('Y-m-d', strtotime($start_date)))
                                ->group_start()
                                ->where("('$start_date'  BETWEEN start_date AND end_date)")
                                ->or_where("('$end_date'  BETWEEN start_date AND end_date)")
                                ->or_where("(start_date > '$start_date' AND end_date < '$end_date')")
                                ->group_end()->get('zoom_meeting');
            } else if($query_akun3->num_rows() == 0){
                $akun_tersedia = '3';
            }
        } else {
            $akun_tersedia = '1';
        }
        return $akun_tersedia;
    }
    
    public function cek_ketersediaan_akun($start_date, $end_date) {
    $akun_tersedia = NULL;

    // Cek ketersediaan akun 1
    $query_akun1 = $this->db->where('id_akun_zoom', 1)
                            ->where('DATE(start_date)', date('Y-m-d', strtotime($start_date)))
                            ->group_start()
                            ->where("('$start_date' BETWEEN start_date AND end_date)", NULL, FALSE)
                            ->or_where("('$end_date' BETWEEN start_date AND end_date)", NULL, FALSE)
                            ->or_where("(start_date > '$start_date' AND end_date < '$end_date')", NULL, FALSE)
                            ->group_end()
                            ->get('zoom_meeting');

    // Jika akun 1 sudah digunakan, coba akun 2
    if ($query_akun1->num_rows() > 0) {
        $akun_tersedia = '2';
        // Cek ketersediaan akun 2
        $query_akun2 = $this->db->where('id_akun_zoom', 2)
                                ->where('DATE(start_date)', date('Y-m-d', strtotime($start_date)))
                                ->group_start()
                                ->where("('$start_date' BETWEEN start_date AND end_date)", NULL, FALSE)
                                ->or_where("('$end_date' BETWEEN start_date AND end_date)", NULL, FALSE)
                                ->or_where("(start_date > '$start_date' AND end_date < '$end_date')", NULL, FALSE)
                                ->group_end()
                                ->get('zoom_meeting');

        // Jika akun 2 tersedia, set akun tersedia menjadi akun 2
        if ($query_akun2->num_rows() > 0) {
            $akun_tersedia = '3';
            // Cek ketersediaan akun 3
            $query_akun3 = $this->db->where('id_akun_zoom', 3)
                                    ->where('DATE(start_date)', date('Y-m-d', strtotime($start_date)))
                                    ->group_start()
                                    ->where("('$start_date' BETWEEN start_date AND end_date)", NULL, FALSE)
                                    ->or_where("('$end_date' BETWEEN start_date AND end_date)", NULL, FALSE)
                                    ->or_where("(start_date > '$start_date' AND end_date < '$end_date')", NULL, FALSE)
                                    ->group_end()
                                    ->get('zoom_meeting');

            // Jika akun 3 tersedia, set akun tersedia menjadi akun 3
            if ($query_akun3->num_rows() > 0) {
                $akun_tersedia = NULL;
            }
        }
    } else {
        $akun_tersedia = '1';
    }
    return $akun_tersedia;
}

    
}
