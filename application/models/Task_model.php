<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model {

    public function get_projects() {
        return $this->db->get('projects')->result();
    }

    public function get_tasks($project_id) {
        $this->db->select('tasks.*, statuses.name as status_name, master_pegawai.nama_pegawai');
        $this->db->from('tasks');
        $this->db->join('statuses', 'tasks.status_id = statuses.id');
        $this->db->join('master_pegawai', 'tasks.employee_id = master_pegawai.username', 'left');
        $this->db->where('tasks.project_id', $project_id);
        return $this->db->get()->result();
    }

    public function add_task($data) {
        $this->db->insert('tasks', $data);
        $task_id = $this->db->insert_id();
        
        // Add to history
        $data['task_id'] = $task_id;
        $data['action'] = 'Create';
        $this->db->insert('task_history', $data);
        
        return $task_id;
    }

    public function update_task($id, $data) {
        $this->db->where('id', $id);
        $result = $this->db->update('tasks', $data);
        
        if ($result) {
            // Add to history
            $task = $this->db->get_where('tasks', ['id' => $id])->row_array();
            $task['id'] = NULL;
            $task['task_id'] = $id;
            $task['action'] = 'Update'; 
            $task['created_by'] = $this->session->userdata('username');
            $this->db->insert('task_history', $task);
        }
        
        return $result;
    }

    public function delete_task($id) {
        // Add to history before deleting
        $task = $this->db->get_where('tasks', ['id' => $id])->row_array();
        $task['id'] = NULL;
        $task['task_id'] = $id;
        $task['action'] = 'Delete';
        $this->db->insert('task_history', $task);
        
        $this->db->where('id', $id);
        return $this->db->delete('tasks');
    }

    public function get_employees() {
        return $this->db->get('master_pegawai')->result();
    }

    public function get_task($id) {
        $this->db->select('tasks.*,projects.name as project_name ,statuses.name as status_name, master_pegawai.nama_pegawai, master_pegawai.no_wa');
        $this->db->from('tasks');
        $this->db->join('statuses', 'tasks.status_id = statuses.id');
        $this->db->join('master_pegawai', 'tasks.employee_id = master_pegawai.username', 'left');
        $this->db->join('projects', 'tasks.project_id = projects.id', 'left');
        $this->db->where('tasks.id', $id);
        return $this->db->get()->row();
    }
}