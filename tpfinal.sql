-- Crear la base de datos "consultorio"
CREATE DATABASE consultorio;

-- Usar la base de datos "tpfinal"
USE tpfinal;

-- Agregar la tabla "usuarios"
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usu VARCHAR(255),
    correo_usu VARCHAR(255),
    clave_usu VARCHAR(300),
    permiso_usu VARCHAR(15)
);

-- Agregar la tabla "especialidad"
CREATE TABLE especialidad (
  id_esp INT AUTO_INCREMENT PRIMARY KEY,
  especialidad VARCHAR(255)
);

-- Agregar la tabla "medicos"
CREATE TABLE medicos (
  id_med INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(2500),
  matricula VARCHAR(15),
  id_especialidad INT,
);

-- Agregar la tabla "paciente"
CREATE TABLE paciente (
  id_pac INT AUTO_INCREMENT PRIMARY KEY,
  documento INT(10),
  telefono VARCHAR(20),
  id_usu INT,
);

-- Agregar la tabla "turnos"
CREATE TABLE turnos (
  id_tur INT AUTO_INCREMENT PRIMARY KEY,
  id_med INT,
  id_pac INT,
  fecha DATE,
  hora TIME,
  tiempo INT(10),
);
