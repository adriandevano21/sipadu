<?php
class Cards extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Card_model');
        $this->load->model('List_model');
        $this->load->model('Master_pegawai_model');  // Memuat model untuk pengguna
    }

    public function create() {
        $data = [
            'name' => $this->input->post('card_name'),
            'description' => $this->input->post('card_description'),
            'list_id' => $this->input->post('list_id'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'progress' => $this->input->post('progress'),
            'assigned_to' => $this->input->post('assigned_to'),
            'created_by' => $this->session->userdata('username')
        ];

        $this->Card_model->create($data);
        echo json_encode(['status' => 'success']);
    }

    public function edit($id) {
        $data = [
            'name' => $this->input->post('card_name'),
            'description' => $this->input->post('card_description'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'progress' => $this->input->post('progress'),
            'assigned_to' => $this->input->post('assigned_to')
        ];

        $this->Card_model->update($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function delete($id) {
        $this->Card_model->delete($id);
        echo json_encode(['status' => 'success']);
    }

    public function update_card_list() {
        $card_id = $this->input->post('card_id');
        $list_id = $this->input->post('list_id');

        $this->Card_model->update_list($card_id, $list_id);
        echo json_encode(['status' => 'success']);
    }
}
?>
