<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_projects() {
        return $this->db->select('*')->from('projects')->join('project_task_summary','project_task_summary.id_project=projects.id','left')->get()->result();
    }

    public function get_project($id) {
        return $this->db->get_where('projects', array('id' => $id))->row();
    }

    public function insert_project($data) {
        $this->db->insert('projects', $data);
        return $this->db->insert_id();
    }

    public function update_project($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('projects', $data);
    }

    public function delete_project($id) {
        return $this->db->delete('projects', array('id' => $id));
    }

    public function insert_project_history($data) {
        return $this->db->insert('project_history', $data);
    }
}