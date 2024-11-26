<?php
class Card_model extends CI_Model {

    public function get_all_cards() {
        return $this->db->get('cards')->result();
    }

    public function insert_card($data) {
        return $this->db->insert('cards', $data);
    }
    
    public function create($data) {
        return $this->db->insert('cards', $data);
    }

    public function update_card($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('cards', $data);
    }
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('cards', $data);
    }

    public function delete_card($id) {
        $this->db->where('id', $id);
        return $this->db->delete('cards');
    }

    public function get_card($id) {
        return $this->db->get_where('cards', array('id' => $id))->row();
    }

    public function get_changes_by_card($id) {
        return $this->db->get_where('card_changes', array('card_id' => $id))->result();
    }

    public function update_card_list($card_id, $list_id) {
        $this->db->where('id', $card_id);
        return $this->db->update('cards', array('list_id' => $list_id));
    }
    public function get_cards_by_list($list_id) {
        $this->db->where('list_id', $list_id);
        return $this->db->get('cards')->result();
    }
    public function update_list($card_id, $list_id) {
    $this->db->where('id', $card_id);
    $this->db->update('cards', ['list_id' => $list_id]);
}
}
?>
