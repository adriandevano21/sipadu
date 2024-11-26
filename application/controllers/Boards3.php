<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boards extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Board_model');
        $this->load->model('List_model');
        $this->load->model('Card_model');
        $this->load->library('session');
    }

    public function index() {
        $data['boards'] = $this->Board_model->get_all_boards();
        $this->load->view('boards/index', $data);
    }

    public function create() {
        $board_name = $this->input->post('board_name');
        if ($board_name) {
            $data = array(
                'board_name' => $board_name,
                'created_by' => $this->session->userdata('username')
            );
            $this->Board_model->insert_board($data);
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Board name is required'));
        }
    }

    public function edit($id) {
        $board_name = $this->input->post('board_name');
        if ($board_name) {
            $data = array(
                'board_name' => $board_name
            );
            $this->Board_model->update_board($id, $data);
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Board name is required'));
        }
    }

    public function delete($id) {
        $this->Board_model->delete_board($id);
        echo json_encode(array('status' => 'success'));
    }

    public function view($id) {
        $data['board'] = $this->Board_model->get_board($id); // Assuming you have a method to get board details
        $data['lists'] = $this->List_model->get_lists_by_board($id);

        foreach ($data['lists'] as &$list) {
            $list->cards = $this->Card_model->get_cards_by_list($list->id);
        }

        $this->load->view('boards/view', $data);
    }
    
    public function update_card_list() {
    $card_id = $this->input->post('card_id');
    $list_id = $this->input->post('list_id');

    $this->Card_model->update_list($card_id, $list_id);
    echo json_encode(['status' => 'success']);
}
}
?>
