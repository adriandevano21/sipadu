<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lists extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('List_model');
        $this->load->library('session');
    }

    public function index() {
        $data['lists'] = $this->List_model->get_all_lists();
        $this->load->view('lists/index', $data);
    }

    public function create() {
        $list_name = $this->input->post('list_name');
        $board_id = $this->input->post('board_id');
        if ($list_name && $board_id) {
            $data = array(
                'list_name' => $list_name,
                'board_id' => $board_id,
                'created_by' => $this->session->userdata('username')
            );
            $this->List_model->insert_list($data);
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'List name and board ID are required'));
        }
    }

    public function edit($id) {
        $list_name = $this->input->post('list_name');
        if ($list_name) {
            $data = array(
                'list_name' => $list_name
            );
            $this->List_model->update_list($id, $data);
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'List name is required'));
        }
    }

    public function delete($id) {
        $this->List_model->delete_list($id);
        echo json_encode(array('status' => 'success'));
    }

    public function view($id) {
        $data['list'] = $this->List_model->get_list($id);
        $data['cards'] = $this->List_model->get_cards_by_list($id);
        $this->load->view('lists/view', $data);
    }
}
?>
