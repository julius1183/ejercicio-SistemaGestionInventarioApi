<?php

require_once '../config/Database.php';
require_once '../controllers/PersonaController.php';

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$controller = new PersonaController((new Database())->conectar());

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $personas = $controller->obtenerPersona();
        echo json_encode($personas);
        break;
    
    case 'POST':
        // Leer datos JSON o Form-data
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            $data = $_POST;
        }

        if (isset($data['name']) && isset($data['age']) && isset($data['email'])) {
            $controller->crearPersona($data['name'], $data['age'], $data['email']);
            http_response_code(201); // Created
            echo json_encode(["message" => "Persona creada exitosamente."]);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["message" => "Datos incompletos."]);
        }
        break;

    case 'OPTIONS':
        // Manejo de peticiones preflight de CORS
        http_response_code(200);
        break;

    default:
        // Si no es GET ni POST, devolvemos un error limpio en lugar de intentar usar $personas
        http_response_code(405); // Method Not Allowed
        echo json_encode(["message" => "Método no permitido"]);
        break;
}