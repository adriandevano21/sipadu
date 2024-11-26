<?php

// extends class Model
class Meeting_model extends CI_Model
{
    public function get_all()
    {
        $all = $this->db->select('*, meeting.password as password_zoom,meeting.id as id_meeting ')->from("meeting")
            ->join('master_pegawai', 'master_pegawai.username=meeting.username')
            ->order_by('start_date', 'desc')
            ->get()->result_array();

        return $all;
    }

    public function belum_upload_adm()
    {
        $date = date("Y-m-d");
        $all = $this->db->select('*')->from("meeting")
            ->join('master_pegawai', 'master_pegawai.username=meeting.username')
            ->where('start_date < ', $date)
            ->where('file_adm IS  NULL', null, false)
            ->where('status ', 2)
            ->get()->result_array();

        return $all;
    }

    public function get_username($username)
    {
        $all = $this->db->select('*, meeting.password as password_zoom,meeting.id as id_meeting ')->from("meeting")
            ->join('master_pegawai', 'master_pegawai.username=meeting.username')
            ->where('meeting.username', $username)
            ->get()->result_array();

        return $all;
    }

    public function get_id($id)
    {
        $all = $this->db->select('*, meeting.password as password_zoom,meeting.id as id_meeting ')->from("meeting")
            ->join('master_pegawai', 'master_pegawai.username=meeting.username')
            ->where('id', $id)
            ->get()->row_array();

        return $all;
    }
}
