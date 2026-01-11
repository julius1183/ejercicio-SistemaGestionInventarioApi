<?php

class Persona {
    private $id;
    private $name;
    private $age;
    private $email;

    private $conn;
    private $tabla = "personas";

  
    public function __construct($db) {
        $this->conn = $db;
    }

      // obtener todas las personas//GET
    public function obtenerPersona() {
        $query = "SELECT id, name, age, email FROM " . $this->tabla;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crearPersona() {
        $query = "INSERT INTO " . $this->tabla . " SET name=:name, age=:age, email=:email";
        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Vincular datos
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

public function setId ($id) {
    $this->id = $id;
}

public function setName ($name) {
    $this->name = $name;
}
public function setAge ($age) {
    $this->age = $age;
}
public function setEmail ($email) {
    $this->email = $email;
}

public function getId () {
    return $this->id;
}

public function getName () {
    return $this->name;
}
 public function getAge () {
    return $this->age;  
}
 public function getEmail () {
    return $this->email;  
}

}

    