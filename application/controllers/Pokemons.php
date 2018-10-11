<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pokemons extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.htmlA
     */
    public function index() {
        $this->load->model('pokemons_model', 'pokemons');
        $ps = $this->pokemons->get_pokemons();

        if (empty($ps)) {
            $this->load->view('pokemeons/insert');
        } else {
            $data['pokemons'] = $this->format_pokemons($ps);
            $this->load->view('pokemeons/search', $data);
        }
    }

    public function search() {
        $this->load->model('pokemons_model', 'pokemons');
        $ps = $this->pokemons->search_pokemons(trim($_POST['key']));
        $pokemons = (empty($ps)) ? [] : $this->format_pokemons($ps);

        echo json_encode($pokemons);
        exit;
    }

    public function insert() {
        sleep(2);
        $response['status'] = 'error';

        $str = file_get_contents(base_url().'assets/pokemon.json');
        $pokemons = json_decode($str, true);
        $this->load->model('pokemons_model', 'pokemons');
        $this->load->model('types_model', 'types');
        $this->load->model('pokemon_types_model', 'pt');
        foreach ($pokemons as $pokemon) {
            $p = $this->pokemons->get_pokemon($pokemon['name']);
            if (empty($p)) {
                $pokemon_id = $this->pokemons->insert_pokemon($pokemon['name']);

                foreach ($pokemon['types'] as $type) {
                    $t = $this->types->get_type($type);

                    if (empty($t)) {
                        $type_id = $this->types->insert_type($type);
                    } else {
                        $type_id = $t[0]->id;
                    }

                    $pt = $this->pt->get_pokemon_type($pokemon_id, $type_id);

                    if (empty($pt)) {
                        $this->pt->insert_pokemon_type($pokemon_id, $type_id);
                        $response['status'] = 'done';
                    }
                }
            }
        }


        echo json_encode($response);
        exit;
    }

    public function clear() {
        $response['status'] = 'done';

        $this->load->model('pokemons_model', 'pokemons');
        $this->load->model('types_model', 'types');
        $this->load->model('pokemon_types_model', 'pt');

        $this->pokemons->clear();
        $this->types->clear();
        $this->pt->clear();

        echo json_encode($response);
        exit;
    }

    private function format_pokemons($pokemons) {
        $final_pokemons = [];

        foreach($pokemons as $pokemon){
            $final_pokemons[$pokemon->pname]['name'] = ucfirst($pokemon->pname);
            $final_pokemons[$pokemon->pname]['types'][] = ucfirst($pokemon->tname);
        }

        return array_values($final_pokemons);
    }
}
