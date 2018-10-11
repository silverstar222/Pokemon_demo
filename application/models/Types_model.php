<?php

class Types_model extends CI_Model {

    public $id;
    public $name;

    public function insert_type($type) {
        $this->name = $type;

        $this->db->insert('types', $this);

        return $this->db->insert_id();

    }

    public function get_type($type) {

        return $this->db->where('name', $type)->get('types')->result();
    }

    public function clear() {

        return $this->db->empty_table('types');
    }

}