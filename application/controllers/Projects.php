<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
        } else {
            redirect('login');
        }
        $this->load->model('Project_model');
        $this->load->library('session');
    }

    public function index() {
        $data['judul'] = 'Project';
        $this->load->vars($data);
        $this->template->load('template/template', 'project/projects_view');
    }

    public function get_projects() {
        $projects = $this->Project_model->get_all_projects();
        echo json_encode($projects);
    }

    public function add_project() {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $project_id = $this->Project_model->insert_project($data);

        if ($project_id) {
            $history_data = array(
                'project_id' => $project_id,
                'name' => $data['name'],
                'description' => $data['description'],
                'created_by' => $data['created_by'],
                'created_at' => $data['created_at'],
                'action' => 'Project created'
            );
            $this->Project_model->insert_project_history($history_data);

            echo json_encode(array('status' => 'success', 'message' => 'Project added successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to add project'));
        }
    }

    public function update_project() {
        $id = $this->input->post('id');
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description')
        );

        $result = $this->Project_model->update_project($id, $data);

        if ($result) {
            $history_data = array(
                'project_id' => $id,
                'name' => $data['name'],
                'description' => $data['description'],
                'created_by' => $this->session->userdata('username'),
                'created_at' => date('Y-m-d H:i:s'),
                'action' => 'Project updated'
            );
            $this->Project_model->insert_project_history($history_data);

            echo json_encode(array('status' => 'success', 'message' => 'Project updated successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update project'));
        }
    }

    public function delete_project() {
        $id = $this->input->post('id');
        $project = $this->Project_model->get_project($id);

        $result = $this->Project_model->delete_project($id);

        if ($result) {
            $history_data = array(
                'project_id' => $id,
                'name' => $project->name,
                'description' => $project->description,
                'created_by' => $this->session->userdata('username'),
                'created_at' => date('Y-m-d H:i:s'),
                'action' => 'Project deleted'
            );
            $this->Project_model->insert_project_history($history_data);

            echo json_encode(array('status' => 'success', 'message' => 'Project deleted successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to delete project'));
        }
    }
}