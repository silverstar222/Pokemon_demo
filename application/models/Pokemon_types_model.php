<?php

class Pokemon_types_model extends CI_Model {

    public $id;
    public $pokemon_id;
    public $type_id;

    public function insert_pokemon_type($pokemon_id, $type_id) {
        $this->pokemon_id = $pokemon_id;
        $this->type_id = $type_id;

        $this->db->insert('pokemon_types', $this);

        return $this->db->insert_id();

    }

    public function get_pokemon_type($pokemon_id, $type_id) {

        return $this->db->where('pokemon_id', $pokemon_id)->where('type_id', $type_id)->get('pokemon_types')->result();
    }

    public function clear() {

        return $this->db->empty_table('pokemon_types');
    }

}