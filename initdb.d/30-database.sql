\connect bdrol;
CREATE TYPE raza_enum AS ENUM (
    'Humano',
    'Elfo',
    'Enano',
    'Mediano',
    'Orco',
    'Gnomo',
    'Semielfo',
    'Semiorco',
    'Tiflin',
    'Dracónido'
);
CREATE TYPE tipo_hechizo AS ENUM (
    'Truco',
    'Conjuración',
    'Adivinación',
    'Encantamiento',
    'Ilusión',
    'Evocación',
    'Transmutación',
    'Nigromancia',
    'Abjuración',
    'Conjuración de Hechizos'
);
CREATE TYPE clase_enum AS ENUM (
    'Bárbaro',
    'Guerrero',
    'Paladín',
    'Explorador',
    'Bardo',
    'Clérigo',
    'Druida',
    'Monje',
    'Pícaro',
    'Brujo',
    'Hechicero',
    'Mago'
);
CREATE TYPE transfondo_enum AS ENUM (
    'Acólito',
    'Criminal',
    'Erudito',
    'Héroe del Pueblo',
    'Noble',
    'Forastero',
    'Soldado',
    'Artista',
    'Marinero',
    'Charlatán',
    'Huérfano',
    'Artesano del Gremio',
    'Ermitaño',
    'Nómada'
);
CREATE TYPE alineamiento_enum AS ENUM (
    'Legal Bueno',
    'Neutral Bueno',
    'Caótico Bueno',
    'Legal Neutral',
    'Neutral Verdadero',
    'Caótico Neutral',
    'Legal Malvado',
    'Neutral Malvado',
    'Caótico Malvado'
);
CREATE TYPE tipo_dano AS ENUM (
    'Cortante',
    'Perforante',
    'Contundente',
    'Fuego',
    'Frío',
    'Ácido',
    'Eléctrico',
    'Veneno',
    'Psíquico',
    'Radiante',
    'Necrótico'
);
CREATE TYPE tipo_armadura AS ENUM (
    'Ligera',
    'Media',
    'Pesada'
);
CREATE TYPE parte_enum AS ENUM('Cabeza', 'Pechera', 'Piernas');
CREATE TYPE tipo_equipo_enum AS ENUM('Cabeza', 'Pechera', 'Piernas', 'Arma', 'Arma Secundaria', 'Escudo');
CREATE TABLE usuarios (
    id_usuario SERIAL PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE personajes (
    id_personaje SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    clase clase_enum,
    raza raza_enum,
    nivel INT DEFAULT 1,
    experiencia INT DEFAULT 0,
    fuerza INT DEFAULT 10,
    destreza INT DEFAULT 10,
    constitucion INT DEFAULT 10,
    inteligencia INT DEFAULT 10,
    sabiduria INT DEFAULT 10,
    peso_total DECIMAL(5, 2) DEFAULT 0,
    capacidad DECIMAL(5, 2),
    carisma INT DEFAULT 10,
    oro INT DEFAULT 0,
    historia_personaje TEXT,
    alineamiento alineamiento_enum,
    HP INT DEFAULT 10,
    velocidad INT DEFAULT 30,
    iniciativa INT DEFAULT 0,
    transfondo transfondo_enum,
    idiomas text,
    personalidad text,
    ideales text,
    lazos text,
    defectos text
);
CREATE TABLE habilidades_personaje (
    id_personaje INT PRIMARY KEY REFERENCES personajes(id_personaje) ON DELETE CASCADE,
    atletismo INT DEFAULT 0,
    acrobacias INT DEFAULT 0,
    juego_de_manos INT DEFAULT 0,
    sigilo INT DEFAULT 0,
    arcano INT DEFAULT 0,
    historia INT DEFAULT 0,
    investigacion INT DEFAULT 0,
    naturaleza INT DEFAULT 0,
    religion INT DEFAULT 0,
    perspicacia INT DEFAULT 0,
    medicina INT DEFAULT 0,
    percepcion INT DEFAULT 0,
    supervivencia INT DEFAULT 0,
    trato_con_animales INT DEFAULT 0,
    engaño INT DEFAULT 0,
    interpretacion INT DEFAULT 0,
    intimidacion INT DEFAULT 0,
    persuasión INT DEFAULT 0
);
CREATE TABLE usuarios_personajes (
    id_personaje INT REFERENCES personajes(id_personaje) ON DELETE CASCADE,
    id_usuario INT REFERENCES usuarios(id_usuario),
    PRIMARY KEY (id_personaje, id_usuario)
);
CREATE TABLE inventario (
    id_inventario SERIAL PRIMARY KEY,
    id_personaje INT UNIQUE NOT NULL,
    FOREIGN KEY (id_personaje) REFERENCES personajes(id_personaje) ON DELETE CASCADE
);
CREATE TABLE armadura (
    id_armadura SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    parte parte_enum NOT NULL,
    peso DECIMAL(5, 2) NOT NULL,
    defensa INT NOT NULL,
    tipo tipo_armadura NOT NULL,
    descripcion TEXT
);
CREATE TABLE arma (
    id_arma SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    peso DECIMAL(5, 2) NOT NULL,
    dano VARCHAR(6) NOT NULL,
    tipo_dano tipo_dano NOT NULL,
    descripcion TEXT
);
CREATE TABLE escudo (
    id_escudo SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    peso DECIMAL(5, 2) NOT NULL,
    defensa INT NOT NULL,
    descripcion TEXT
);
CREATE TABLE objeto_normal (
    id_objeto_normal SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    peso DECIMAL(5, 2) NOT NULL,
    descripcion TEXT
);
CREATE TABLE inventario_armadura (
    id_inventario INT,
    id_armadura INT,
    cantidad INT DEFAULT 1,
    PRIMARY KEY (id_inventario, id_armadura),
    FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario),
    FOREIGN KEY (id_armadura) REFERENCES armadura(id_armadura)
);
CREATE TABLE inventario_arma (
    id_inventario INT,
    id_arma INT,
    cantidad INT DEFAULT 1,
    PRIMARY KEY (id_inventario, id_arma),
    FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario),
    FOREIGN KEY (id_arma) REFERENCES arma(id_arma)
);
CREATE TABLE inventario_escudo (
    id_inventario INT,
    id_escudo INT,
    cantidad INT DEFAULT 1,
    PRIMARY KEY (id_inventario, id_escudo),
    FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario),
    FOREIGN KEY (id_escudo) REFERENCES escudo(id_escudo)
);
CREATE TABLE inventario_objeto_normal (
    id_inventario INT,
    id_objeto_normal INT,
    cantidad INT DEFAULT 1,
    PRIMARY KEY (id_inventario, id_objeto_normal),
    FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario),
    FOREIGN KEY (id_objeto_normal) REFERENCES objeto_normal(id_objeto_normal)
);
CREATE TABLE equipo (
    id_personaje INT,
    id_armadura INT NULL,
    id_arma INT NULL,
    id_escudo INT NULL,
    tipo_equipo tipo_equipo_enum,
    PRIMARY KEY (id_personaje, tipo_equipo),
    FOREIGN KEY (id_personaje) REFERENCES personajes(id_personaje) ON DELETE CASCADE,
    FOREIGN KEY (id_armadura) REFERENCES armadura(id_armadura),
    FOREIGN KEY (id_arma) REFERENCES arma(id_arma),
    FOREIGN KEY (id_escudo) REFERENCES escudo(id_escudo)
);
CREATE TABLE hechizos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    nivel INT NOT NULL CHECK (nivel >= 0 AND nivel <= 9) DEFAULT 0,
    tipo tipo_hechizo NOT NULL,
    descripcion TEXT,
    daño VARCHAR(50),
    distancia VARCHAR(50),
    tiempo_carga VARCHAR(50),
    duracion VARCHAR(50),
    componentes VARCHAR(100)
);
CREATE TABLE clases_hechizos (
    id SERIAL PRIMARY KEY,
    clase clase_enum NOT NULL,
    hechizo_id INT NOT NULL REFERENCES hechizos(id) ON DELETE CASCADE,
     nivel_aprendido INT NOT NULL CHECK (nivel_aprendido >= 0 AND nivel_aprendido <= 20)
);
CREATE TABLE RanurasPorClaseYNivel (
    clase clase_enum,
    nivel INT,
    nivel_hechizo INT,
    cantidad_ranuras INT,
    PRIMARY KEY (clase, nivel, nivel_hechizo)
);
CREATE TABLE hechizos_personajes (
    id_personaje INT,
    id_hechizo INT,
    PRIMARY KEY (id_personaje, id_hechizo),
    FOREIGN KEY (id_personaje) REFERENCES personajes(id_personaje) ON DELETE CASCADE,
    FOREIGN KEY (id_hechizo) REFERENCES hechizos(id)
);
CREATE TABLE RanurasBrujos (
    nivel INT,
    cantidad_ranuras INT,
    nivel_maximo_hechizo INT,
    arcanum boolean
);