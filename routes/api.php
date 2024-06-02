<?php
require_once __DIR__ . '/../controllers/PokemonController.php';
require_once __DIR__ . '/../controllers/TrainerController.php';

$pokemonController = new PokemonController();
$trainerController = new TrainerController();

$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$endpoint = $requestUri[1] ?? '';
$id = $requestUri[2] ?? null;
$subEndpoint = $requestUri[3] ?? null;
$subId = $requestUri[4] ?? null;

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($endpoint === 'pokemons') {
            if ($id) {
                $pokemonController->getPokemonById($id);
            } else {
                $pokemonController->getPokemons();
            }
        } elseif ($endpoint === 'trainers') {
            if ($id && $subEndpoint === 'pokemons') {
                $type = isset($_GET['type']) ? $_GET['type'] : null;
                if ($type) {
                    $trainerController->getPokemonsByTypeAndTrainer($id, $type);
                } else {
                    $trainerController->getPokemonsByTrainer($id);
                }
            } elseif ($id) {
                $trainerController->getTrainerById($id);
            } else {
                $trainerController->getTrainers();
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint not found']);
        }
        break;
    case 'POST':
        if ($endpoint === 'pokemons') {
            $pokemonController->createPokemon();
        } elseif ($endpoint === 'trainers') {
            if ($id && $subEndpoint === 'pokemons') {
                $trainerController->assignPokemonToTrainer($id);
            } else {
                $trainerController->createTrainer();
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint not found']);
        }
        break;
    case 'PUT':
        if ($endpoint === 'pokemons' && $id) {
            $pokemonController->updatePokemon($id);
        } elseif ($endpoint === 'trainers' && $id) {
            $trainerController->updateTrainer($id);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint not found or ID is missing']);
        }
        break;
    case 'DELETE':
        if ($endpoint === 'pokemons' && $id) {
            $pokemonController->deletePokemon($id);
        } elseif ($endpoint === 'trainers' && $id) {
            if ($subEndpoint === 'pokemons' && $subId) {
                $trainerController->deletePokemonFromTrainer($id, $subId);
            } else {
                $trainerController->deleteTrainer($id);
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint not found or ID is missing']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
?>
