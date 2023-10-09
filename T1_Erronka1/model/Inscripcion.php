<?php
class Inscripcion {
    private $id;
    private $idUsuario;
    private $idCurso;

    public function __construct($id, $idUsuario, $idCurso) {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idCurso = $idCurso;
    }

    // Métodos para acceder a las propiedades
    public function getId() {
        return $this->id;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getIdCurso() {
        return $this->idCurso;
    }

    // Métodos para modificar las propiedades, si es necesario
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setIdCurso($idCurso) {
        $this->idCurso = $idCurso;
    }

    // Otros métodos relacionados con las inscripciones
    public function inscribirse($conexion) {
        echo 'A';
        try {
            echo 'B';
            $consultaSQL = "INSERT INTO inscripcion (id_usuario, id_curso) VALUES (:idUsuario, :idCurso)";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->bindParam(':idUsuario', $this->idUsuario, PDO::PARAM_INT);
            $sentencia->bindParam(':idCurso', $this->idCurso, PDO::PARAM_INT);
            $resultado = $sentencia->execute();

            return $resultado;
        } catch (PDOException $error) {
            // Manejar errores de la base de datos aquí
            return false;
        }
    }

    // Agrega otros métodos según las necesidades de tu aplicación
}
?>
