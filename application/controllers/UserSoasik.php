<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserSoasik extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load database library
        $this->load->database();
    }

    public function index() {
        // Ambil semua data dari tabel user_soasik
        $query = $this->db->select('id,sobat_id')->from('user_soasik')->where('password IS NULL', null, false)->limit(1000)->get();
        $users = $query->result();
        
        

        // Mulai transaksi
        $this->db->trans_start();

        // Update setiap password dengan hashing bcrypt dari sobat_id
        foreach ($users as $user) {
            $hashed_password = $this->bcrypt_hash($user->sobat_id);
            $this->db->where('id', $user->id);
            $this->db->update('user_soasik', ['password' => $hashed_password]);
        }

        // Selesaikan transaksi
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Jika transaksi gagal
            echo "Terjadi kesalahan saat mengupdate password.";
        } else {
            // Jika transaksi berhasil
            echo "Password berhasil diperbarui.";
        }
    }
    public function yuhu() {
        // Ambil semua data dari tabel user_soasik
        $query = $this->db->select('id,sobat_id')->from('user_soasik')->where('password IS NULL', null, false)->where('id >','6500')->limit(1000)->get();
        $users = $query->result();
        
        

        // Mulai transaksi
        $this->db->trans_start();

        // Update setiap password dengan hashing bcrypt dari sobat_id
        foreach ($users as $user) {
            $hashed_password = $this->bcrypt_hash($user->sobat_id);
            $this->db->where('id', $user->id);
            $this->db->update('user_soasik', ['password' => $hashed_password]);
        }

        // Selesaikan transaksi
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Jika transaksi gagal
            echo "Terjadi kesalahan saat mengupdate password.";
        } else {
            // Jika transaksi berhasil
            echo "Password berhasil diperbarui.";
        }
    }

    // Fungsi untuk hashing bcrypt
    private function bcrypt_hash($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
