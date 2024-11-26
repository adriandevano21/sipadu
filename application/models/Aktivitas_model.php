<?php

class Aktivitas_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all()
    {
        return $this->db->select('*, aktivitas.id as id_aktivitas')->from("aktivitas")->join('master_pegawai', "aktivitas.username=master_pegawai.username")->order_by("aktivitas.id", "DESC")->get()->result_array();
    }
    function get_sendiri()
    {
        return $this->db->select('*, aktivitas.id as id_aktivitas')->from("aktivitas")->join('master_pegawai', "aktivitas.username=master_pegawai.username")->where('master_pegawai.username', $this->session->userdata('username'))->order_by("aktivitas.id", "DESC")->get()->result_array();
    }
    function get_perorang($username)
    {
        return $this->db->select('*, aktivitas.id as id_aktivitas')
        ->from("aktivitas")
        ->join('master_pegawai', "aktivitas.username=master_pegawai.username")
        ->where('master_pegawai.username', $username) 
        ->group_start() 
        ->like('aktivitas.tanggal', date('Y-m'))  
        ->or_like('aktivitas.tanggal', date('Y-m', strtotime('-1 month')))
        ->group_end()
        ->order_by("aktivitas.tanggal", "DESC")->get()->result_array();
    }
    function get_sendiri_bulan($bulan, $tahun)
    {
        return $this->db->select('*, aktivitas.id as id_aktivitas')->from("aktivitas")
            ->join('master_pegawai', "aktivitas.username=master_pegawai.username")
            // ->join('indikator_pk', "aktivitas.id_indikator_pk=indikator_pk.id", 'left')
            ->join('pk', "aktivitas.id_pk=pk.id", 'left')
            ->like('tanggal', $tahun . '-' . $bulan)
            ->where('master_pegawai.username', $this->session->userdata('username'))->order_by("aktivitas.tanggal", "DESC")->get()->result_array();
    }
    function get_sendiri_bulan_api($bulan, $tahun, $username)
    {
        $all = $this->db->select('*, aktivitas.id as id_aktivitas')->from("aktivitas")
            ->join('master_pegawai', "aktivitas.username=master_pegawai.username")
            ->like('tanggal', $tahun . '-' . $bulan)
            ->where('master_pegawai.username', $username)
            ->order_by("aktivitas.tanggal", "DESC")->get()->result_array();

        $response['status'] = 200;
        $response['error'] = false;
        $response['KegiatankuData'] = $all;
        return $response;
    }
    function get_all_bulan($bulan, $tahun)
    {
        return $this->db->select('*, aktivitas.id as id_aktivitas')->from("aktivitas")
            ->join('master_pegawai', "aktivitas.username=master_pegawai.username")
            ->like('tanggal', $tahun . '-' . $bulan)
            ->order_by("aktivitas.tanggal", "DESC")->get()->result_array();
    }
    function get_all_bulan_pegawai($username, $bulan, $tahun)
    {
        if (empty($username)) {
            return $this->db->select('*, aktivitas.id as id_aktivitas')->from("aktivitas")
                ->join('master_pegawai', "aktivitas.username=master_pegawai.username")
                ->like('tanggal', $tahun . '-' . $bulan)
                ->order_by("aktivitas.tanggal", "DESC")->get()->result_array();
        } else {
            return $this->db->select('*, aktivitas.id as id_aktivitas')->from("aktivitas")
                ->join('master_pegawai', "aktivitas.username=master_pegawai.username")
                ->where('aktivitas.username', $username)
                ->like('tanggal', $tahun . '-' . $bulan)
                ->order_by("aktivitas.tanggal", "DESC")->get()->result_array();
        }
    }
    function get_all_pegawai($username)
    {

        return $this->db->select('*, aktivitas.id as id_aktivitas')->from("aktivitas")
            ->join('master_pegawai', "aktivitas.username=master_pegawai.username")
            ->where('aktivitas.username', $username)
            ->where('tanggal >', "2023-07-30")
            ->order_by("aktivitas.tanggal", "DESC")->get()->result_array();
    }

    function update($tabel, $pk, $data_pk, $params)
    {
        $this->db->where($pk, $data_pk);
        return $this->db->update($tabel, $params);
    }

    function update_batch($data)
    {
        $this->db->update_batch('master_kl', $data, 'id_kl');
    }
    function insert_batch($data)
    {
        $this->db->insert_batch('master_kl', $data);
    }

    function insert($tabel, $params)
    {
        $this->db->insert($tabel, $params);
        // return $this->db->insert_id();
    }
    public function get_id($table, $pk, $data_pk)
    {
        return $this->db->select('*')->from($table)->where($pk, $data_pk)->get()->row_array();
    }

    public function belum_isi($kloter_wa)
    {
        $query = $this->db->query("select nama_pegawai, no_wa from sipadu_master_pegawai where username not in (select username from sipadu_aktivitas where tanggal = curdate()) and kloter_wa = $kloter_wa and kode_satker = 1100 and status_pegawai = 'PNS'") ;
        return $query->result_array();
    }

    public function getAktivitasByDateAndUsername($bulan, $tahun, $usernames)
    {
        $usernamesStr = implode("', '", $usernames);

        $sql = "
            SELECT
                nama_pegawai,
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-01' THEN aktivitas END SEPARATOR ';') AS 'tanggal_1',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-02' THEN aktivitas END SEPARATOR ';') AS 'tanggal_2',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-03' THEN aktivitas END SEPARATOR ';') AS 'tanggal_3',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-04' THEN aktivitas END SEPARATOR ';') AS 'tanggal_4',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-05' THEN aktivitas END SEPARATOR ';') AS 'tanggal_5',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-06' THEN aktivitas END SEPARATOR ';') AS 'tanggal_6',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-07' THEN aktivitas END SEPARATOR ';') AS 'tanggal_7',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-08' THEN aktivitas END SEPARATOR ';') AS 'tanggal_8',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-09' THEN aktivitas END SEPARATOR ';') AS 'tanggal_9',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-10' THEN aktivitas END SEPARATOR ';') AS 'tanggal_10',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-11' THEN aktivitas END SEPARATOR ';') AS 'tanggal_11',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-12' THEN aktivitas END SEPARATOR ';') AS 'tanggal_12',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-13' THEN aktivitas END SEPARATOR ';') AS 'tanggal_13',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-14' THEN aktivitas END SEPARATOR ';') AS 'tanggal_14',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-15' THEN aktivitas END SEPARATOR ';') AS 'tanggal_15',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-16' THEN aktivitas END SEPARATOR ';') AS 'tanggal_16',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-17' THEN aktivitas END SEPARATOR ';') AS 'tanggal_17',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-18' THEN aktivitas END SEPARATOR ';') AS 'tanggal_18',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-19' THEN aktivitas END SEPARATOR ';') AS 'tanggal_19',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-20' THEN aktivitas END SEPARATOR ';') AS 'tanggal_20',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-21' THEN aktivitas END SEPARATOR ';') AS 'tanggal_21',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-22' THEN aktivitas END SEPARATOR ';') AS 'tanggal_22',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-23' THEN aktivitas END SEPARATOR ';') AS 'tanggal_23',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-24' THEN aktivitas END SEPARATOR ';') AS 'tanggal_24',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-25' THEN aktivitas END SEPARATOR ';') AS 'tanggal_25',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-26' THEN aktivitas END SEPARATOR ';') AS 'tanggal_26',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-27' THEN aktivitas END SEPARATOR ';') AS 'tanggal_27',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-28' THEN aktivitas END SEPARATOR ';') AS 'tanggal_28',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-29' THEN aktivitas END SEPARATOR ';') AS 'tanggal_29',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-30' THEN aktivitas END SEPARATOR ';') AS 'tanggal_30',
                GROUP_CONCAT(CASE WHEN tanggal = '{$tahun}-{$bulan}-31' THEN aktivitas END SEPARATOR ';') AS 'tanggal_31'
                
            FROM
                sipadu_aktivitas
                JOIN sipadu_master_pegawai ON sipadu_aktivitas.username = sipadu_master_pegawai.username
            WHERE
                sipadu_aktivitas.username IN ('{$usernamesStr}')
            GROUP BY
                sipadu_master_pegawai.username;
        ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
} //akhir class