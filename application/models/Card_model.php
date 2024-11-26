<?php 

class Card_model extends CI_Model {

public function get_cards_by_list($list_id) {
$this->db->where('id_list', $list_id);
$this->db->order_by('position', 'ASC');
$query = $this->db->get('cards');
return $query->result();
}

public function create_card($data) {
$this->db->insert('cards', $data);
return $this->db->insert_id();
}

public function update_card($card_id, $data) {
$this->db->where('id', $card_id);
return $this->db->update('cards', $data);
}

public function delete_card($card_id) {
$this->db->where('id', $card_id);
return $this->db->delete('cards');
}

public function update_card_position($card_id, $list_id, $position) {
$this->db->where('id', $card_id);
$this->db->update('cards', array('id_list' => $list_id, 'position' => $position));
}

public function get_card($card_id) {
$this->db->where('id', $card_id);
$query = $this->db->get('cards');
return $query->row();
}
}