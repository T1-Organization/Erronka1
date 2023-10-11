CREATE DATABASE erronka1;

USE erronka1;

CREATE TABLE alumnos (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  apellido VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL,
  edad INT(3),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cursos (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50),
  familia VARCHAR(50)
);

CREATE TABLE usuarios (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_alumno INT(11) UNSIGNED,
  usuario VARCHAR(50) NOT NULL,
  contraseña VARCHAR(100) NOT NULL,
  administrador BOOLEAN
);

CREATE TABLE inscripcion (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT(11) UNSIGNED,
  id_curso INT(11) UNSIGNED
);

ALTER TABLE usuarios
ADD CONSTRAINT fk_usuarios_alumnos FOREIGN KEY (id_alumno) REFERENCES alumnos(id);

ALTER TABLE inscripcion
ADD CONSTRAINT fk_inscripcion_usuarios FOREIGN KEY (id_usuario) REFERENCES usuarios(id);

ALTER TABLE inscripcion
ADD CONSTRAINT fk_inscripcion_cursos FOREIGN KEY (id_curso) REFERENCES cursos(id);

/*ALTER TABLE usuarios
DROP FOREIGN KEY fk_usuarios_alumnos;

ALTER TABLE usuarios
ADD CONSTRAINT fk_usuarios_alumnos
FOREIGN KEY (id_alumno)
REFERENCES alumnos (id)
ON DELETE CASCADE;*/
