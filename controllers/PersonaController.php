<?php

require_once '../models/Persona.php';
require_once '../config/Database.php';

//require, include, include_once//
class PersonaController {
    private $db;
    private $personaModel;

    public function __construct($database) {
        $this->db = $database;
        $this->personaModel = new Persona($this->db);
    }

  // Método para obtener todas las personas // GET
public function obtenerPersona()
{
    $stmt = $this->personaModel->obtenerPersona();
    $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $personas;//array associativo personas
}


// Método para crear una nueva persona
public function crearPersona($name, $age, $email)
{
    $this->personaModel->setName($name);
    $this->personaModel->setAge($age);
    $this->personaModel->setEmail($email);

    if ($this->personaModel->crearPersona()) {
        return true;
    }

    return false;

}
}