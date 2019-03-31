-- Creación de tablas de la base de datos(reto)
-- --------Creación de tabla usuarios----------
-- esta tabla guarda los usuarios para controlar el acceso a la página

create table usuarios(
    id_usuario int PRIMARY KEY AUTO_INCREMENT,
    usuario_name VARCHAR(40) NOT NULL,
    contrasena VARCHAR(500),
    perfil VARCHAR(20),
    idUsuario int
);

-- Insertar datos de usuarios para pruebas
-- insert into usuarios values(null, 'admin', 'admin', 'admin', 'admin');
-- insert into usuarios values(null, 'alumno', 'alumno', 'alumno', 'alumno');
-- insert into usuarios values(null, 'profesor', 'profesor', 'profesor', 'profesor');
-- insert into usuarios values(null, 'centro', 'centro', 'centro', 'centro');
-- insert into usuarios values(null, 'empresa', 'empresa', 'empresa', 'empresa');
-- --------Creación de tabla centroseduc----------
create table centroseduc(
    id_centro int AUTO_INCREMENT PRIMARY KEY,
    centro_name VARCHAR(80) NOT NULL,
    responsable_name VARCHAR(40) NOT NULL,
    primerApell VARCHAR(50) NOT NULL,
    segundoApell VARCHAR(50),
    localidad VARCHAR(100) NOT NULL,
    num_telefono VARCHAR(9),
    email VARCHAR(40)
);
-- --------Datos prueba centro educativo----------
-- insert into centroseduc VALUES(null, 'IES Murgi', 'Joaquin', 'Morales', '', 'El ejido', '950123456', 'iesMurgi@gmail.com');
-- insert into centroseduc VALUES(null, 'IES Fuente nueva', 'El ejido', '950173456');
-- --------Creación de tabla alumnos----------
create table alumnos(
    id_alumno int AUTO_INCREMENT PRIMARY KEY,
    alumno_name VARCHAR(40) NOT NULL,
    primerApell VARCHAR(50) NOT NULL,
    segundoApell VARCHAR(50),
    fecha_nacimiento DATE,
    num_telefono VARCHAR(9),
    email VARCHAR(40),
    centroEduc int NOT NULL,
    FOREIGN KEY (centroEduc) REFERENCES centroseduc(id_centro)
);
-- --------Creación de tabla empresas----------
create table empresas(
    id_empresa int AUTO_INCREMENT PRIMARY KEY,
    empresa_name VARCHAR(40) NOT NULL,
    responsable_name VARCHAR(40) NOT NULL,
    primerApell VARCHAR(50) NOT NULL,
    segundoApell VARCHAR(50),
    localidad VARCHAR(100) NOT NULL,
    num_telefono VARCHAR(9),
    email VARCHAR(40)
);

-- demandas de Formación profesional en centros de trabajo
create table demandas(
    id_demanda int AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(80) NOT NULL,
    experiencia VARCHAR(500) NOT NULL,
    idiomas VARCHAR(300),
    descripcion VARCHAR(600) not NULL,
    fecha DATE,
    alumno int NOT NULL,
    FOREIGN KEY (alumno) REFERENCES alumnos(id_alumno)
);
-- --------Creación de tabla EstudiosFP----------
create table estudios(
    id_estudio int AUTO_INCREMENT PRIMARY KEY,
    cicloFP_name VARCHAR(100) NOT NULL,
    nivel VARCHAR(100) NOT NULL,
    demanda int NOT NULL,
    FOREIGN KEY (demanda) REFERENCES demandas(id_demanda)
);
-- ofertas de Formación profesional en centros de trabajo
create table ofertas(
    id_oferta int AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(80) NOT NULL,
    categoria VARCHAR(80) NOT NULL,
    subcategoria VARCHAR(80) NOT NULL,
    num_puestos int,
    localidad VARCHAR(100) NOT NULL,
    descripcion VARCHAR(600) not NULL,
    contratacion char(2),
    fecha DATE,
    empresa int NOT NULL,
    FOREIGN KEY (empresa) REFERENCES empresas(id_empresa)
);

-- tabla en la que se refleja acuerdo entre empresa y alumno
create table contrataciones(
    id_contratacion int PRIMARY KEY,
    alumno int NOT NULL,
    empresa int NOT NULL,
    tipo VARCHAR(40),
    FOREIGN KEY (alumno) REFERENCES alumnos(id_alumno),
    FOREIGN KEY (empresa) REFERENCES empresas(id_empresa)
);


-- triguers necesarios para creación de usuarios

CREATE TRIGGER registrarAlumno AFTER INSERT ON alumnos
FOR EACH ROW
INSERT INTO usuarios VALUES(null,concat(NEW.alumno_name,'_',NEW.primerApell),'', 'alumno', NEW.id_alumno);

CREATE TRIGGER registrarCentoEduc AFTER INSERT ON centroseduc
FOR EACH ROW
INSERT INTO usuarios VALUES(null,concat(NEW.responsable_name,'_',NEW.primerApell),'', 'centro', NEW.id_centro);

CREATE TRIGGER registrarEmpresa AFTER INSERT ON empresas
FOR EACH ROW
INSERT INTO usuarios VALUES(null,concat(NEW.responsable_name,'_',NEW.primerApell),'', 'empresa', NEW.id_empresa);