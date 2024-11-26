<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boards extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Board_model');
        $this->load->library('form_validation');
    }

    // Method untuk menampilkan halaman utama boards
    public function index() {
        $this->load->view('boards/index');
    }
    public function view1() {
        $this->load->view('boards/view2');
    }

    // Method untuk mengambil semua board
    public function get_boards() {
        $boards = $this->Board_model->get_all_boards();
        echo json_encode($boards);
    }

    // Method untuk membuat board baru
    public function create() {
        $this->form_validation->set_rules('board_name', 'Board Name', 'required');

        if ($this->form_validation->run() === FALSE) {
            $response = array('status' => 'error', 'message' => validation_errors());
        } else {
            $this->Board_model->create_board();
            $response = array('status' => 'success', 'message' => 'Board created successfully');
        }

        echo json_encode($response);
    }

    // Method untuk mengambil detail board berdasarkan ID
    public function get_board($board_id) {
        $board = $this->Board_model->get_board($board_id);
        echo json_encode($board);
    }

    // Method untuk mengupdate board
    public function edit($board_id) {
        $this->form_validation->set_rules('board_name', 'Board Name', 'required');

        if ($this->form_validation->run() === FALSE) {
            $response = array('status' => 'error', 'message' => validation_errors());
        } else {
            $this->Board_model->update_board($board_id);
            $response = array('status' => 'success', 'message' => 'Board updated successfully');
        }

        echo json_encode($response);
    }

    // Method untuk menghapus board
    public function delete($board_id) {
        if ($this->Board_model->delete_board($board_id)) {
            $response = array('status' => 'success', 'message' => 'Board deleted successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to delete board');
        }

        echo json_encode($response);
    }
    
    // Fetch lists with cards
    public function get_lists_with_cards() {
        $board_id = 1; // Assuming a static board id for simplicity
        $lists = $this->Board_model->get_lists_with_cards($board_id);
        echo json_encode($lists);
    }

    // Create a new list
    public function create_list() {
        $data = array(
            'list_name' => $this->input->post('list_name'),
            'board_id' => 1, // Static board id
            'created_by' => 1, // Static user id
            'created_at' => date('Y-m-d H:i:s')
        );
        $result = $this->Board_model->insert_list($data);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'List created successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create list']);
        }
    }

    // Get list by ID for editing
    public function get_list($id) {
        $list = $this->Board_model->get_list_by_id($id);
        echo json_encode($list);
    }

    // Edit an existing list
    public function edit_list($id) {
        $data = array(
            'list_name' => $this->input->post('list_name'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $result = $this->Board_model->update_list($id, $data);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'List updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update list']);
        }
    }

    // Delete a list
    public function delete_list($id) {
        $result = $this->Board_model->delete_list($id);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'List deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete list']);
        }
    }

    // Create a new card
    public function create_card() {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'id_list' => $this->input->post('id_list'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'progress' => $this->input->post('progress'),
            'position' => 0, // Adjust position accordingly
            'assigned_to' => 1, // Static user id
            'created_by' => 1, // Static user id
            'created_at' => date('Y-m-d H:i:s')
        );
        $result = $this->Board_model->insert_card($data);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Card created successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create card']);
        }
    }

    // Get card by ID for editing
    public function get_card($id) {
        $card = $this->Board_model->get_card_by_id($id);
        echo json_encode($card);
    }

    // Edit an existing card
    public function edit_card($id) {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'progress' => $this->input->post('progress'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $result = $this->Board_model->update_card($id, $data);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Card updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update card']);
        }
    }

    // Delete a card
    public function delete_card($id) {
        $result = $this->Board_model->delete_card($id);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Card deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete card']);
        }
    }

    // Update card's list when moved
    public function update_card_list() {
        $card_id = $this->input->post('card_id');
        $new_list_id = $this->input->post('new_list_id');
        $result = $this->Board_model->update_card_list($card_id, $new_list_id);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Card moved successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to move card']);
        }
    }
}
