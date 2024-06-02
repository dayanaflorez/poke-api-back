<?php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Trainer.php';
require_once __DIR__ . '/../models/Pokemon.php';

class TrainerController {
    private $db;
    private $trainer;
    private $pokemon;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->trainer = new Trainer($this->db);
        $this->pokemon = new Pokemon($this->db);
    }

    public function getTrainers() {
        $stmt = $this->trainer->readAll();
        $trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($trainers);
    }

    public function getTrainerById($id) {
        $this->trainer->id = $id;
        $stmt = $this->trainer->readOne();
        $trainer = $stmt->fetch(PDO::FETCH_ASSOC);
        if($trainer) {
            echo json_encode($trainer);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Trainer not found']);
        }
    }

    public function createTrainer() {
        $data = json_decode(file_get_contents("php://input"));
        $this->trainer->name = $data->name;
        $this->trainer->age = $data->age;
        $this->trainer->region = $data->region;

        if($this->trainer->create()) {
            http_response_code(201);
            echo json_encode(['message' => 'Trainer created']);
        } else {
            http_response_code(503);
            echo json_encode(['message' => 'Unable to create trainer']);
        }
    }

    public function updateTrainer($id) {
        $data = json_decode(file_get_contents("php://input"));
        $this->trainer->id = $id;
        $this->trainer->name = $data->name;
        $this->trainer->age = $data->age;
        $this->trainer->region = $data->region;

        if($this->trainer->update()) {
            echo json_encode(['message' => 'Trainer updated']);
        } else {
            http_response_code(503);
            echo json_encode(['message' => 'Unable to update trainer']);
        }
    }

    public function deleteTrainer($id) {
        $this->trainer->id = $id;

        if($this->trainer->delete()) {
            echo json_encode(['message' => 'Trainer deleted']);
        } else {
            http_response_code(503);
            echo json_encode(['message' => 'Unable to delete trainer']);
        }
    }

    public function assignPokemonToTrainer($idTrainer) {
        $this->trainer->id = $idTrainer;
        $stmt = $this->trainer->readOne();
        $trainer = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$trainer) {
            http_response_code(404);
            echo json_encode(['message' => 'Trainer not found']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"));
        $this->pokemon->name = $data->name;
        $this->pokemon->image = $data->image;
        $this->pokemon->type = $data->type;
        $this->pokemon->moves = $data->moves;

        if($this->pokemon->create()) {
            $pokemonId = $this->db->lastInsertId();
            $query = "INSERT INTO trainer_pokemons (trainer_id, pokemon_id) VALUES (:trainer_id, :pokemon_id)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':trainer_id', $idTrainer);
            $stmt->bindParam(':pokemon_id', $pokemonId);

            if($stmt->execute()) {
                http_response_code(201);
                echo json_encode(['message' => 'Pokemon assigned to trainer']);
            } else {
                http_response_code(503);
                echo json_encode(['message' => 'Unable to assign pokemon to trainer']);
            }
        } else {
            http_response_code(503);
            echo json_encode(['message' => 'Unable to create Pokemon']);
        }
    }

    public function getPokemonsByTrainer($idTrainer) {
        $type = isset($_GET['type']) ? $_GET['type'] : null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : null;
        $recordsPerPage = isset($_GET['recordsPerPage']) ? (int)$_GET['recordsPerPage'] : null;

        $stmt = $this->pokemon->readByTrainer($idTrainer, $type, $page, $recordsPerPage);
        $pokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($pokemons);
    }

    // New function to filter Pokémon by type for a specific trainer
    public function getPokemonsByTypeAndTrainer($idTrainer) {
        $type = isset($_GET['type']) ? $_GET['type'] : null;

        if (!$type) {
            http_response_code(400);
            echo json_encode(['message' => 'Type parameter is missing']);
            return;
        }

        $stmt = $this->pokemon->getPokemonsByTypeAndTrainer($idTrainer, $type);
        $pokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($pokemons) {
            echo json_encode($pokemons);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Pokemons of specified type not found for this trainer']);
        }
    }

    public function deletePokemonFromTrainer($idTrainer, $idPokemon) {
        $query = "DELETE FROM trainer_pokemons WHERE trainer_id = :trainer_id AND pokemon_id = :pokemon_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':trainer_id', $idTrainer);
        $stmt->bindParam(':pokemon_id', $idPokemon);

        if($stmt->execute()) {
            echo json_encode(['message' => 'Pokemon deleted from trainer']);
        } else {
            http_response_code(503);
            echo json_encode(['message' => 'Unable to delete pokemon from trainer']);
        }
    }
}
?>
