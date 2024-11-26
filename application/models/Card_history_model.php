<?php
class Card_history_model extends CI_Model {

    public function get_history_by_card($card_id) {
        $this->db->where('card_id', $card_id);
        $query = $this->db->get('card_history');
        return $query->result();
    }

    public function insert_history($data) {
        return $this->db->insert('card_history', $data);
    }
}
?>
