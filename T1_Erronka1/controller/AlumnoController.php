<?php 
include_once __DIR__ . '/../model/Alumno.php';

//../model/Alumno.php
class AlumnoController {

    // Método para crear un nuevo alumno
    /*public function crearAlumno($nuevoAlumno) {
   
        // Lógica para crear un nuevo alumno y guardarlo en la base de datos
        // Puedes utilizar la clase Alumno aquí para representar al nuevo alumno

        //$nuevoAlumno = new Alumno($nombre, $apellido, $email, $edad);

        // Guardar el nuevo alumno en la base de datos
        if ($nuevoAlumno->guardarEnBaseDeDatos()) {
            // Éxito: el alumno se creó y se almacenó en la base de datos
            return "Alumno creado con éxito.";
        } else {
            // Error: no se pudo guardar el alumno en la base de datos
            return "Error al crear el alumno.";
        }
    }*/
    public function agregarAlumno($alumno) {
        // Intentar guardar el alumno en la base de datos
        if ($alumno->guardarEnBaseDeDatos()) {
            echo 'Alumno agregado con éxito.';
        } else {
            echo 'Hubo un error al agregar el alumno.';
        }
    }
    /*public function agregarAlumno($nombre, $apellido, $email, $edad) {
        // Crear una instancia de la clase Alumno
        $alumno = new Alumno($nombre, $apellido, $email, $edad);
        
        // Intentar guardar el alumno en la base de datos
        if ($alumno->guardarEnBaseDeDatos()) {
            echo 'Alumno agregado con éxito.';
        } else {
            echo 'Hubo un error al agregar el alumno.';
        }
    }*/

    // Método para listar todos los alumnos
    public function listarAlumnos() {
        // Lógica para obtener la lista de alumnos desde la base de datos
        // Puedes utilizar la clase Alumno aquí para representar a cada alumno
    }

    // Método para actualizar los datos de un alumno
    public function actualizarAlumno($id, $nombre, $apellido, $email, $edad) {
        // Lógica para actualizar los datos de un alumno en la base de datos
        // Puedes utilizar la clase Alumno aquí para representar al alumno existente
    }

    public function borrarAlumno($idAlumno) {
        try {
            // Verifica si el valor de $idAlumno es correcto
            echo 'Controller.php: id usuario' . $idAlumno . '<br>';
    
            // Intenta eliminar al alumno utilizando el modelo
            if (Alumno::borrarDeBaseDeDatos($idAlumno)) {
                // Borrado exitoso, puedes redirigir o mostrar un mensaje de éxito
                // Por ejemplo, redirigir al listado de alumnos
                header('Location: ../../administrazioa.php');
                exit();
            } else {
                // Error al borrar, puedes mostrar un mensaje de error
                echo 'Error al borrar el alumno.';
            }
        } catch (PDOException $error) {
            // Captura cualquier excepción que pueda ocurrir al intentar eliminar
            error_log("Error al borrar el alumno: " . $error->getMessage());
            echo 'Error al borrar el alumno: ' . $error->getMessage();
        }
    }
    
    public function editarAlumno($id, $nombre, $apellido, $email, $edad) {
        try {
            // Crear una instancia del modelo Alumno
            $alumno = new Alumno($nombre, $apellido, $email, $edad);

            // Intentar actualizar los datos del alumno en la base de datos
            if ($alumno->actualizarEnBaseDeDatos($id, $nombre, $apellido, $email, $edad)) {
                // Actualización exitosa, puedes redirigir o mostrar un mensaje de éxito
                // Por ejemplo, redirigir al listado de alumnos
                header('Location: ../../administrazioa.php');
                exit();
            } else {
                // Error en la actualización, puedes mostrar un mensaje de error
                echo 'Error al actualizar el alumno.';
            }
        } catch (PDOException $error) {
            // Manejo de errores en caso de problemas con la base de datos
            // Registra el error en el registro de errores o muestra un mensaje de error detallado
            error_log("Error al actualizar el alumno: " . $error->getMessage());
            echo 'Error al actualizar el alumno.';
        }
    }
}


?>
