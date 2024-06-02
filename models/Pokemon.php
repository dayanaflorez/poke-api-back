<?php
class Pokemon {
    private $conn;
    private $table_name = "pokemons";

    public $id;
    public $name;
    public $image;
    public $type;
    public $moves;

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

    public function readByTrainer($trainer_id, $type = null, $page = null, $recordsPerPage = null) {
        $query = "SELECT p.* FROM " . $this->table_name . " p
                  JOIN trainer_pokemons tp ON p.id = tp.pokemon_id
                  WHERE tp.trainer_id = :trainer_id";

        if ($type) {
            $query .= " AND p.type = :type";
        }

        if ($page !== null && $recordsPerPage !== null) {
            $offset = ($page - 1) * $recordsPerPage;
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':trainer_id', $trainer_id);

        if ($type) {
            $stmt->bindParam(':type', $type);
        }

        if ($page !== null && $recordsPerPage !== null) {
            $stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, image=:image, type=:type, moves=:moves";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":moves", $this->moves);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, image=:image, type=:type, moves=:moves WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":moves", $this->moves);
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

    public function getPokemonsByTypeAndTrainer($trainerId, $type) {
        $query = "SELECT p.* FROM pokemons p 
                  INNER JOIN trainer_pokemons tp ON p.id = tp.pokemon_id 
                  WHERE tp.trainer_id = ? AND p.type = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $trainerId);
        $stmt->bindParam(2, $type);
        $stmt->execute();
        return $stmt;
    }
}
?>
