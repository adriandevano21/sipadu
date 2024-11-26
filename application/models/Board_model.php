<?php
class Board_model extends CI_Model {

    // Get a single board by ID
    public function get_board($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('sipadu_boards');
        return $query->row();
    }

    // Get all boards
    public function get_all_boards() {
        $query = $this->db->get('sipadu_boards');
        return $query->result();
    }

    // Create a new board
    public function create_board($data) {
        return $this->db->insert('sipadu_boards', $data);
    }

    // Update an existing board
    public function update_board($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('sipadu_boards', $data);
    }

    // Delete a board
    public function delete_board($id) {
        $this->db->where('id', $id);
        return $this->db->delete('sipadu_boards');
    }

    // Get all lists for a specific board
    public function get_lists_by_board($board_id) {
        $this->db->where('id_board', $board_id);
        $this->db->order_by('position', 'ASC');
        $query = $this->db->get('sipadu_lists');
        return $query->result();
    }

    // Get a single list by ID
    public function get_list($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('sipadu_lists');
        return $query->row();
    }

    // Create a new list
    public function create_list($data) {
        return $this->db->insert('sipadu_lists', $data);
    }

    // Update an existing list
    public function update_list($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('sipadu_lists', $data);
    }

    // Delete a list
    public function delete_list($id) {
        $this->db->where('id', $id);
        return $this->db->delete('sipadu_lists');
    }

    // Get all cards for a specific list
    public function get_cards_by_list($list_id) {
        $this->db->where('id_list', $list_id);
        $this->db->order_by('position', 'ASC');
        $query = $this->db->get('sipadu_cards');
        return $query->result();
    }

    // Reorder cards within a list
    public function reorder_cards($list_id, $ordered_ids) {
        foreach ($ordered_ids as $position => $card_id) {
            $this->db->where('id', $card_id);
            $this->db->update('sipadu_cards', ['position' => $position + 1, 'id_list' => $list_id]);
        }
    }
}
