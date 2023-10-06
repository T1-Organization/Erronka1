<?php 
class Curso {
    private $id;
    private $nombre;
    private $familia;

    public function __construct($id, $nombre, $familia) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->familia = $familia;
    }

    // Métodos para acceder a las propiedades
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getFamilia() {
        return $this->familia;
    }

    // Métodos para modificar las propiedades, si es necesario
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setFamilia($familia) {
        $this->familia = $familia;
    }

    // Otros métodos relacionados con los cursos
}

?>