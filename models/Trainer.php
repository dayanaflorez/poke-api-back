<?php
class Trainer {
    private $conn;
    private $table_name = "trainers";

    public $id;
    public $name;
    public $age;
    public $region;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, age=:age, region=:region";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":region", $this->region);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, age=:age, region=:region WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":region", $this->region);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function assignPokemon($pokemon_id) {
        $query = "INSERT INTO trainer_pokemon (trainer_id, pokemon_id) VALUES (:trainer_id, :pokemon_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":trainer_id", $this->id);
        $stmt->bindParam(":pokemon_id", $pokemon_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function removePokemon($pokemon_id) {
        $query = "DELETE FROM trainer_pokemon WHERE trainer_id = :trainer_id AND pokemon_id = :pokemon_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":trainer_id", $this->id);
        $stmt->bindParam(":pokemon_id", $pokemon_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getPokemons($trainerId) {
        $query = "SELECT p.* FROM pokemons p INNER JOIN trainer_pokemon tp ON p.id = tp.pokemon_id WHERE tp.trainer_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $trainerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isPokemonAssigned($trainerId, $pokemonId) {
        $query = "SELECT * FROM trainer_pokemon WHERE trainer_id = ? AND pokemon_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $trainerId);
        $stmt->bindParam(2, $pokemonId);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>
