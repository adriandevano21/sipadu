<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks_model extends CI_Model
{
    public function getTasks()
    {
        return $this->db->get('tasks2')->result_array();
    }

    public function getAllTasks()
    {
        // return $this->db->get('tasks')->result_array();
        
        return $this->db->select('*')->from('tasks2')->like('start_date','2024')->get()->result_array();
    }

    public function addTask($data)
    {
        $this->db->insert('tasks2', $data);
        return $this->db->insert_id(); // Mengembalikan ID dari task yang baru ditambahkan
    }

    function deleteTask($data)
    {
        $this->db->where('id', $data);
        return $this->db->delete('tasks2');
    }

    function updateTask($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tasks2', $data);
    }
}
