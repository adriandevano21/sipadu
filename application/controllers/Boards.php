<?php

class Boards extends CI_Controller {

   public function view($board_id) {
    $this->load->model('Board_model');
    $this->load->model('Card_model');
    $this->load->model('Pegawai_model'); // Model untuk mengambil data user dari master_pegawai

    $data['board'] = $this->Board_model->get_board($board_id);
    $data['lists'] = $this->Board_model->get_lists_by_board($board_id);
    $data['users'] = $this->Pegawai_model->get_all_pegawai2(); // Ambil semua user

    foreach ($data['lists'] as $list) {
        $list->cards = $this->Card_model->get_cards_by_list($list->id);
    }

    $this->load->view('boards/view', $data);
}


    public function create_card() {
        $data = array(
            'id_list' => $this->input->post('listId'),
            'name' => $this->input->post('cardName'),
            'description' => $this->input->post('cardDescription'),
            'start_date' => $this->input->post('cardStartDate'),
            'end_date' => $this->input->post('cardEndDate'),
            'progress' => $this->input->post('cardProgress'),
            'assigned_to' => $this->input->post('cardAssignedTo'),
            'created_by' => $this->session->userdata('username'),
            'position' => 0 // Set default position
        );

        $this->load->model('Card_model');
        $card_id = $this->Card_model->create_card($data);

        echo json_encode(array('status' => 'success', 'card_id' => $card_id));
    }

    public function update_card() {
        $card_id = $this->input->post('cardId');

        $data = array(
            'name' => $this->input->post('cardName'),
            'description' => $this->input->post('cardDescription'),
            'start_date' => $this->input->post('cardStartDate'),
            'end_date' => $this->input->post('cardEndDate'),
            'progress' => $this->input->post('cardProgress'),
            'assigned_to' => $this->input->post('cardAssignedTo')
        );

        $this->load->model('Card_model');
        $this->Card_model->update_card($card_id, $data);

        echo json_encode(array('status' => 'success'));
    }

    public function delete_card($card_id) {
        $this->load->model('Card_model');
        $this->Card_model->delete_card($card_id);

        echo json_encode(array('status' => 'success'));
    }

    public function update_position() {
        $card_id = $this->input->post('card_id');
        $list_id = $this->input->post('list_id');
        $position = $this->input->post('position');

        $this->load->model('Card_model');
        $this->Card_model->update_card_position($card_id, $list_id, $position);

        echo json_encode(array('status' => 'success'));
    }
}
