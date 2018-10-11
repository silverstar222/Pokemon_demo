<?php

class Pokemons_model extends CI_Model {

    public $id;
    public $name;

    public function get_pokemons() {
        $query = $this->db
            ->select('p.name as pname, t.name as tname')
            ->from('pokemons as p')
            ->join('pokemon_types as pt', 'pt.pokemon_id=p.id')
            ->join('types as t', 'pt.type_id=t.id')
            ->order_by("p.name", "asc")
            ->get();
        return $query->result();
    }

    public function get_pokemon($pokemon) {
        $query = $this->db->where('name', $pokemon)->get('pokemons');
        return $query->result();
    }

    public function insert_pokemon($pokemon) {
        $this->name = $pokemon;

        $this->db->insert('pokemons', $this);

        return $this->db->insert_id();

    }

    public function search($key) {

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

    public function search_pokemons($key) {
        $query = $this->db
            ->select('p.name as pname, t.name as tname')
            ->from('pokemons as p')
            ->join('pokemon_types as pt', 'pt.pokemon_id=p.id')
            ->join('types as t', 'pt.type_id=t.id')
            ->where("p.name LIKE '%".$key."%' OR t.name LIKE '%".$key."%'")
            ->order_by("p.name", "asc")
            ->get();
        return $query->result();
    }

    public function clear() {

        return $this->db->empty_table('pokemons');
    }

}