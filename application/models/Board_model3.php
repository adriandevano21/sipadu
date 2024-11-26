<?php
class Board_model extends CI_Model {

    public function get_all_boards() {
        return $this->db->get('boards')->result_array();
    }

    public function get_board($board_id) {
        return $this->db->get_where('boards', array('id' => $board_id))->row_array();
    }

    public function create_board() {
        $data = array(
            'board_name' => $this->input->post('board_name'),
            'created_by' => $this->session->userdata('username'),
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('boards', $data);
    }

    public function update_board($board_id) {
        $data = array(
            'board_name' => $this->input->post('board_name'),
        );
        $this->db->where('id', $board_id);
        return $this->db->update('boards', $data);
    }

    public function delete_board($board_id) {
        return $this->db->delete('boards', array('id' => $board_id));
    }
    
    // Get all lists with their respective cards
    public function get_lists_with_cards($board_id) {
        $this->db->select('lists.*, cards.id as card_id, cards.name as card_name, cards.description, cards.start_date, cards.end_date, cards.progress, cards.position');
        $this->db->from('lists');
        $this->db->join('cards', 'cards.id_list = lists.id', 'left');
        $this->db->where('lists.board_id', $board_id);
        $this->db->order_by('lists.id', 'asc');
        $this->db->order_by('cards.position', 'asc');
        $query = $this->db->get();

        $result = [];
        foreach ($query->result() as $row) {
            $list_id = $row->id;
            if (!isset($result[$list_id])) {
                $result[$list_id] = [
                    'id' => $list_id,
                    'list_name' => $row->list_name,
                    'cards' => []
                ];
            }
            if ($row->card_id) {
                $result[$list_id]['cards'][] = [
                    'id' => $row->card_id,
                    'name' => $row->card_name,
                    'description' => $row->description,
                    'start_date' => $row->start_date,
                    'end_date' => $row->end_date,
                    'progress' => $row->progress,
                    'position' => $row->position
                ];
            }
        }
        return array_values($result);
    }

    // Insert a new list
    public function insert_list($data) {
        return $this->db->insert('lists', $data);
    }

    // Get list by ID
    public function get_list_by_id($id) {
        return $this->db->get_where('lists', ['id' => $id])->row_array();
    }

    // Update an existing list
    public function update_list($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('lists', $data);
    }

    // Delete a list
    public function delete_list($id) {
        $this->db->where('id', $id);
        return $this->db->delete('lists');
    }

    // Insert a new card
    public function insert_card($data) {
        return $this->db->insert('cards', $data);
    }

    // Get card by ID
    public function get_card_by_id($id) {
        return $this->db->get_where('cards', ['id' => $id])->row_array();
    }

    // Update an existing card
    public function update_card($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('cards', $data);
    }

    // Delete a card
    public function delete_card($id) {
        $this->db->where('id', $id);
        return $this->db->delete('cards');
    }

    // Update card's list when moved
    public function update_card_list($card_id, $new_list_id) {
        $this->db->where('id', $card_id);
        return $this->db->update('cards', ['id_list' => $new_list_id]);
    }
}
