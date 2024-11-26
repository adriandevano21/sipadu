<?php
class List_model extends CI_Model {


    public function insert_list($data) {
        return $this->db->insert('lists', $data);
    }

    // public function get_list($id) {
    //     $this->db->where('id', $id);
    //     $query = $this->db->get('lists');
    //     return $query->row();
    // }

    public function update_list($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('lists', $data);
    }

    public function delete_list($id) {
        $this->db->where('id', $id);
        return $this->db->delete('lists');
    }
    

    public function get_cards_by_list($id) {
        return $this->db->get_where('cards', array('list_id' => $id))->result();
    }
    
    public function get_lists_by_board($board_id) {
        $this->db->where('board_id', $board_id);
        return $this->db->get('lists')->result();
    }

    public function get_list($id) {
        return $this->db->get_where('lists', array('id' => $id))->row();
    }
    
    
}
?>
