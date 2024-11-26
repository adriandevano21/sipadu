<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'cards';
    }

    // Get all cards in a list
    public function get_cards_by_list($id_list) {
    $this->db->where('id_list', $id_list);
    $this->db->order_by('position', 'ASC');
    $query = $this->db->get($this->table);
    return $query->result_array() ?: array(); // Pastikan selalu return array
    }

    // Get a single card by ID
    public function get_card($id_card) {
        $this->db->where('id', $id_card);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // Create a new card
    public function create_card($data) {
        $this->db->select_max('position');
        $this->db->where('id_list', $data['id_list']);
        $max_position = $this->db->get($this->table)->row()->position;

        $data['position'] = $max_position + 1;

        return $this->db->insert($this->table, $data);
    }

    // Update a card
    public function update_card($id_card, $data) {
        $this->db->where('id', $id_card);
        return $this->db->update($this->table, $data);
    }

    // Delete a card
    public function delete_card($id_card) {
        $this->db->where('id', $id_card);
        return $this->db->delete($this->table);
    }

    // Update the list and position of a card after drag-and-drop
    public function update_card_list($id_card, $new_list_id) {
        $this->db->select_max('position');
        $this->db->where('id_list', $new_list_id);
        $max_position = $this->db->get($this->table)->row()->position;

        $data = array(
            'id_list' => $new_list_id,
            'position' => $max_position + 1
        );

        $this->db->where('id', $id_card);
        return $this->db->update($this->table, $data);
    }

    // Reorder cards within the same list
    public function reorder_cards($id_list, $positions) {
        foreach ($positions as $position => $id_card) {
            $data = array('position' => $position);
            $this->db->where('id', $id_card);
            $this->db->where('id_list', $id_list);
            $this->db->update($this->table, $data);
        }
    }
}
