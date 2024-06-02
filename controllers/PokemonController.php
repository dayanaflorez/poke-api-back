<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Pokemon.php';

class PokemonController {
    private $db;
    private $pokemon;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->pokemon = new Pokemon($this->db);
    }

    public function getPokemons() {
        $stmt = $this->pokemon->readAll();
        $pokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($pokemons);
    }

    public function getPokemonById($id) {
        $this->pokemon->id = $id;
        $stmt = $this->pokemon->readOne();
        $pokemon = $stmt->fetch(PDO::FETCH_ASSOC);
        if($pokemon) {
            echo json_encode($pokemon);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Pokemon not found']);
        }
    }

    public function createPokemon() {
        $data = json_decode(file_get_contents("php://input"));
        $this->pokemon->name = $data->name;
        $this->pokemon->image = $data->image;
        $this->pokemon->type = $data->type; // Ensure 'type' is provided
        $this->pokemon->moves = $data->moves; // Ensure 'moves' is provided

        if($this->pokemon->create()) {
            http_response_code(201);
            echo json_encode(['message' => 'Pokemon created']);
        } else {
            http_response_code(503);
            echo json_encode(['message' => 'Unable to create Pokemon']);
        }
    }

    public function updatePokemon($id) {
        $data = json_decode(file_get_contents("php://input"));
        $this->pokemon->id = $id;
        $this->pokemon->name = $data->name;
        $this->pokemon->image = $data->image;

        if($this->pokemon->update()) {
            echo json_encode(['message' => 'Pokemon updated']);
        } else {
            http_response_code(503);
            echo json_encode(['message' => 'Unable to update Pokemon']);
        }
    }

    public function deletePokemon($id) {
        $this->pokemon->id = $id;

        if($this->pokemon->delete()) {
            echo json_encode(['message' => 'Pokemon deleted']);
        } else {
            http_response_code(503);
            echo json_encode(['message' => 'Unable to delete Pokemon']);
        }
    }
}
?>
