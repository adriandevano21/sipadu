<?php
class Cards extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Card_model');
        $this->load->model('List_model');
        $this->load->model('Pegawai_model');  // Memuat model untuk pengguna
    }
    
    public function view($id) {
        $data['board'] = $this->Board_model->get_board($id); // Assuming you have a method to get board details
        $data['lists'] = $this->List_model->get_lists_by_board($id);

        foreach ($data['lists'] as &$list) {
            $list->cards = $this->Card_model->get_cards_by_list($list->id);
        }

        $this->load->view('boards/view', $data);
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
    public function get_cards_by_list($list_id) {
        $this->db->where('list_id', $list_id);
        return $this->db->get('sipadu_cards')->result();
    }
}
?>
