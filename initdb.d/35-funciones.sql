\connect bdrol;

create view ficha as 
select * from personajes inner join habilidades_personaje using (id_personaje);

create view info_hechizos as
select hechizos.*, hechizos_personajes.id_personaje from hechizos inner join hechizos_personajes on (hechizos.id=hechizos_personajes.id_hechizo);

CREATE VIEW vista_defensa_total AS
SELECT
    e.id_personaje,
    COALESCE(SUM(a.defensa), 0) AS defensa_armadura,
    COALESCE(SUM(es.defensa), 0) AS defensa_escudo,
    COALESCE(SUM(a.defensa), 0) + COALESCE(SUM(es.defensa), 0) AS defensa_total
FROM
    equipo e
LEFT JOIN armadura a ON e.id_armadura = a.id_armadura
LEFT JOIN escudo es ON e.id_escudo = es.id_escudo
GROUP BY
    e.id_personaje;


CREATE VIEW vista_inventario_personaje AS
SELECT
    p.id_personaje,
    p.nombre AS nombre_personaje,
    COALESCE(a.nombre, 'N/A') AS nombre_armadura,
    COALESCE(i_a.cantidad, 0) AS cantidad_armadura,
    COALESCE(a.peso, 0) * COALESCE(i_a.cantidad, 0) AS peso_total_armadura,
    COALESCE(ar.nombre, 'N/A') AS nombre_arma,
    COALESCE(i_ar.cantidad, 0) AS cantidad_arma,
    COALESCE(ar.peso, 0) * COALESCE(i_ar.cantidad, 0) AS peso_total_arma,
    COALESCE(e.nombre, 'N/A') AS nombre_escudo,
    COALESCE(i_e.cantidad, 0) AS cantidad_escudo,
    COALESCE(e.peso, 0) * COALESCE(i_e.cantidad, 0) AS peso_total_escudo,
    COALESCE(o.nombre, 'N/A') AS nombre_objeto_normal,
    COALESCE(i_o.cantidad, 0) AS cantidad_objeto_normal,
    COALESCE(o.peso, 0) * COALESCE(i_o.cantidad, 0) AS peso_total_objeto_normal
FROM
    personajes p
LEFT JOIN inventario i ON i.id_personaje = p.id_personaje
LEFT JOIN inventario_armadura i_a ON i_a.id_inventario = i.id_inventario
LEFT JOIN armadura a ON a.id_armadura = i_a.id_armadura
LEFT JOIN inventario_arma i_ar ON i_ar.id_inventario = i.id_inventario
LEFT JOIN arma ar ON ar.id_arma = i_ar.id_arma
LEFT JOIN inventario_escudo i_e ON i_e.id_inventario = i.id_inventario
LEFT JOIN escudo e ON e.id_escudo = i_e.id_escudo
LEFT JOIN inventario_objeto_normal i_o ON i_o.id_inventario = i.id_inventario
LEFT JOIN objeto_normal o ON o.id_objeto_normal = i_o.id_objeto_normal;

CREATE VIEW vista_suma_peso_personaje AS
SELECT
    id_personaje,
    nombre_personaje,
    COALESCE(SUM(peso_total_armadura), 0) AS suma_peso_armaduras,
    COALESCE(SUM(peso_total_arma), 0) AS suma_peso_armas,
    COALESCE(SUM(peso_total_escudo), 0) AS suma_peso_escudos,
    COALESCE(SUM(peso_total_objeto_normal), 0) AS suma_peso_objetos_normales,
    COALESCE(SUM(peso_total_armadura), 0) +
    COALESCE(SUM(peso_total_arma), 0) +
    COALESCE(SUM(peso_total_escudo), 0) +
    COALESCE(SUM(peso_total_objeto_normal), 0) AS suma_peso_total
FROM
    vista_inventario_personaje
GROUP BY
    id_personaje, nombre_personaje;

create view vista_equipo_peso as
select
	id_personaje,
	coalesce(SUM(armadura.peso),0)+
	coalesce(SUM(arma.peso),0)+
	coalesce(SUM(escudo.peso),0)
	
	AS peso from equipo left join arma using (id_arma) left join escudo using (id_escudo)
left join armadura using (id_armadura) group by id_personaje;

CREATE VIEW hechizos_por_personaje AS
SELECT
    p.id_personaje AS id_personaje,
    p.nombre AS nombre_personaje,
    h.nivel AS nivel_hechizo,
    COUNT(h.id) AS cantidad_hechizos
FROM
    hechizos_personajes hp
JOIN
    hechizos h ON hp.id_hechizo = h.id
JOIN
    Personajes p ON hp.id_personaje = p.id_personaje
GROUP BY
    p.id_personaje, p.nombre, h.nivel
ORDER BY
    p.id_personaje, h.nivel;


CREATE OR REPLACE FUNCTION calcular_capacidad()
RETURNS TRIGGER AS $$
BEGIN
    NEW.capacidad := NEW.fuerza * 15;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_calcular_capacidad
BEFORE INSERT OR UPDATE ON personajes
FOR EACH ROW
EXECUTE FUNCTION calcular_capacidad();

CREATE OR REPLACE FUNCTION validar_estadisticas_personaje()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.fuerza < 8 THEN
        NEW.fuerza := 8;
    ELSIF NEW.fuerza > 20 THEN
        NEW.fuerza := 20;
    END IF;

    -- Validar y ajustar destreza
    IF NEW.destreza < 8 THEN
        NEW.destreza := 8;
    ELSIF NEW.destreza > 20 THEN
        NEW.destreza := 20;
    END IF;

    -- Validar y ajustar constitución
    IF NEW.constitucion < 8 THEN
        NEW.constitucion := 8;
    ELSIF NEW.constitucion > 20 THEN
        NEW.constitucion := 20;
    END IF;

    -- Validar y ajustar inteligencia
    IF NEW.inteligencia < 8 THEN
        NEW.inteligencia := 8;
    ELSIF NEW.inteligencia > 20 THEN
        NEW.inteligencia := 20;
    END IF;

    -- Validar y ajustar sabiduría
    IF NEW.sabiduria < 8 THEN
        NEW.sabiduria := 8;
    ELSIF NEW.sabiduria > 20 THEN
        NEW.sabiduria := 20;
    END IF;

    -- Validar y ajustar carisma
    IF NEW.carisma < 8 THEN
        NEW.carisma := 8;
    ELSIF NEW.carisma > 20 THEN
        NEW.carisma := 20;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_validar_estadisticas
BEFORE INSERT OR UPDATE ON personajes
FOR EACH ROW
EXECUTE FUNCTION validar_estadisticas_personaje();


CREATE OR REPLACE FUNCTION crear_inventario()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO inventario (id_inventario,id_personaje)
    VALUES (NEW.id_personaje,NEW.id_personaje);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_crear_inventario
after INSERT ON personajes
FOR EACH ROW
EXECUTE FUNCTION crear_inventario();


CREATE OR REPLACE FUNCTION validar_peso_total(p_id_personaje INT) RETURNS BOOLEAN AS $$
DECLARE
    v_peso_total DECIMAL(10, 2);
    v_capacidad DECIMAL(10, 2);
BEGIN
    SELECT COALESCE(SUM(
        COALESCE(a.peso * ia.cantidad, 0) +
        COALESCE(ar.peso * iar.cantidad, 0) +
        COALESCE(e.peso * ie.cantidad, 0) +
        COALESCE(o.peso * ioc.cantidad, 0)
    ), 0) INTO v_peso_total
    FROM inventario i
    LEFT JOIN inventario_arma ia ON i.id_inventario = ia.id_inventario
    LEFT JOIN arma a ON ia.id_arma = a.id_arma
    LEFT JOIN inventario_armadura iar ON i.id_inventario = iar.id_inventario
    LEFT JOIN armadura ar ON iar.id_armadura = ar.id_armadura
    LEFT JOIN inventario_escudo ie ON i.id_inventario = ie.id_inventario
    LEFT JOIN escudo e ON ie.id_escudo = e.id_escudo
    LEFT JOIN inventario_objeto_normal ioc ON i.id_inventario = ioc.id_inventario
    LEFT JOIN objeto_normal o ON ioc.id_objeto_normal = o.id_objeto_normal
    WHERE i.id_personaje = p_id_personaje;

    SELECT capacidad INTO v_capacidad
    FROM personajes
    WHERE id_personaje = p_id_personaje;

    IF v_peso_total > v_capacidad THEN
        RETURN FALSE;
    ELSE
        RETURN TRUE;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION trigger_validar_peso_total_arma()
RETURNS TRIGGER AS $$
BEGIN
    IF NOT validar_peso_total(
        (SELECT i.id_personaje FROM inventario i WHERE i.id_inventario = COALESCE(NEW.id_inventario, OLD.id_inventario))
    ) THEN
        RAISE EXCEPTION 'El peso total del inventario excede la capacidad permitida para este personaje.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_validar_peso_total_arma
AFTER INSERT OR UPDATE OR DELETE ON inventario_arma
FOR EACH ROW
EXECUTE FUNCTION trigger_validar_peso_total_arma();

CREATE OR REPLACE FUNCTION trigger_validar_peso_total_armadura() RETURNS TRIGGER AS $$
BEGIN
    IF NOT validar_peso_total(
        (SELECT i.id_personaje FROM inventario i WHERE i.id_inventario = COALESCE(NEW.id_inventario, OLD.id_inventario))
    )THEN
        RAISE EXCEPTION 'El peso total del inventario excede la capacidad permitida para este personaje.';
    
    END IF;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_validar_peso_total_armadura
AFTER INSERT OR UPDATE OR DELETE ON inventario_armadura
FOR EACH ROW
EXECUTE FUNCTION trigger_validar_peso_total_armadura();

CREATE OR REPLACE FUNCTION trigger_validar_peso_total_escudo() RETURNS TRIGGER AS $$
BEGIN
    IF NOT validar_peso_total(
        (SELECT i.id_personaje FROM inventario i WHERE i.id_inventario = COALESCE(NEW.id_inventario, OLD.id_inventario))
    ) THEN
        RAISE EXCEPTION 'El peso total del inventario excede la capacidad permitida para este personaje.';
    
    END IF;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_validar_peso_total_escudo
AFTER INSERT OR UPDATE OR DELETE ON inventario_escudo
FOR EACH ROW
EXECUTE FUNCTION trigger_validar_peso_total_escudo();

CREATE OR REPLACE FUNCTION trigger_validar_peso_total_objeto_normal() RETURNS TRIGGER AS $$
BEGIN
    IF NOT validar_peso_total(
        (SELECT i.id_personaje FROM inventario i WHERE i.id_inventario = COALESCE(NEW.id_inventario, OLD.id_inventario))
    )THEN
        RAISE EXCEPTION 'El peso total del inventario excede la capacidad permitida para este personaje.';
    
    END IF;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_validar_peso_total_objeto_normal
AFTER INSERT OR UPDATE OR DELETE ON inventario_objeto_normal
FOR EACH ROW
EXECUTE FUNCTION trigger_validar_peso_total_objeto_normal();


CREATE OR REPLACE FUNCTION actualizar_peso_total_personaje() 
RETURNS TRIGGER AS $$
DECLARE
    personaje_id INT;
BEGIN
    SELECT id_personaje INTO personaje_id
    FROM inventario
    WHERE id_inventario = (
        CASE
            WHEN TG_OP = 'INSERT' THEN NEW.id_inventario
            WHEN TG_OP = 'UPDATE' THEN COALESCE(NEW.id_inventario, OLD.id_inventario)
            WHEN TG_OP = 'DELETE' THEN OLD.id_inventario
        END
    );

    UPDATE personajes
    SET peso_total = (
        COALESCE((SELECT SUM(a.peso * i_a.cantidad) 
                 FROM inventario_armadura i_a
                 JOIN armadura a ON a.id_armadura = i_a.id_armadura
                 WHERE i_a.id_inventario = (SELECT id_inventario 
                                            FROM inventario 
                                            WHERE id_personaje = personaje_id)
                ), 0) +
        COALESCE((SELECT SUM(ar.peso * i_ar.cantidad) 
                 FROM inventario_arma i_ar
                 JOIN arma ar ON ar.id_arma = i_ar.id_arma
                 WHERE i_ar.id_inventario = (SELECT id_inventario 
                                             FROM inventario 
                                             WHERE id_personaje = personaje_id)
                ), 0) +
        COALESCE((SELECT SUM(e.peso * i_e.cantidad) 
                 FROM inventario_escudo i_e
                 JOIN escudo e ON e.id_escudo = i_e.id_escudo
                 WHERE i_e.id_inventario = (SELECT id_inventario 
                                             FROM inventario 
                                             WHERE id_personaje = personaje_id)
                ), 0) +
        COALESCE((SELECT SUM(o.peso * i_o.cantidad) 
                 FROM inventario_objeto_normal i_o
                 JOIN objeto_normal o ON o.id_objeto_normal = i_o.id_objeto_normal
                 WHERE i_o.id_inventario = (SELECT id_inventario 
                                             FROM inventario 
                                             WHERE id_personaje = personaje_id)
                ), 0)
    )
    WHERE id_personaje = personaje_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER trigger_actualizar_peso_total_armadura
AFTER INSERT OR UPDATE OR DELETE ON inventario_armadura
FOR EACH ROW
EXECUTE FUNCTION actualizar_peso_total_personaje();

CREATE TRIGGER trigger_actualizar_peso_total_arma
AFTER INSERT OR UPDATE OR DELETE ON inventario_arma
FOR EACH ROW
EXECUTE FUNCTION actualizar_peso_total_personaje();

CREATE TRIGGER trigger_actualizar_peso_total_escudo
AFTER INSERT OR UPDATE OR DELETE ON inventario_escudo
FOR EACH ROW
EXECUTE FUNCTION actualizar_peso_total_personaje();

CREATE TRIGGER trigger_actualizar_peso_total_objeto_normal
AFTER INSERT OR UPDATE OR DELETE ON inventario_objeto_normal
FOR EACH ROW
EXECUTE FUNCTION actualizar_peso_total_personaje();

CREATE OR REPLACE FUNCTION manejar_equipo()
RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        CASE NEW.tipo_equipo
            WHEN 'Cabeza' THEN
                UPDATE inventario_armadura
                SET cantidad = cantidad - 1
                WHERE id_inventario = (SELECT id_inventario 
                                       FROM inventario 
                                       WHERE id_personaje = NEW.id_personaje)
                AND id_armadura = NEW.id_armadura;
            WHEN 'Pechera' THEN
                UPDATE inventario_armadura
                SET cantidad = cantidad - 1
                WHERE id_inventario = (SELECT id_inventario 
                                       FROM inventario 
                                       WHERE id_personaje = NEW.id_personaje)
                AND id_armadura = NEW.id_armadura;
            WHEN 'Piernas' THEN
                UPDATE inventario_armadura
                SET cantidad = cantidad - 1
                WHERE id_inventario = (SELECT id_inventario 
                                       FROM inventario 
                                       WHERE id_personaje = NEW.id_personaje)
                AND id_armadura = NEW.id_armadura;
            WHEN 'Arma' THEN
                UPDATE inventario_arma
                SET cantidad = cantidad - 1
                WHERE id_inventario = (SELECT id_inventario 
                                       FROM inventario 
                                       WHERE id_personaje = NEW.id_personaje)
                AND id_arma = NEW.id_arma;
            WHEN 'Arma Secundaria' THEN
                UPDATE inventario_arma
                SET cantidad = cantidad - 1
                WHERE id_inventario = (SELECT id_inventario 
                                       FROM inventario 
                                       WHERE id_personaje = NEW.id_personaje)
                AND id_arma = NEW.id_arma;
            WHEN 'Escudo' THEN
                UPDATE inventario_escudo
                SET cantidad = cantidad - 1
                WHERE id_inventario = (SELECT id_inventario 
                                       FROM inventario 
                                       WHERE id_personaje = NEW.id_personaje)
                AND id_escudo = NEW.id_escudo;
        END CASE;

        CASE NEW.tipo_equipo
            WHEN 'Cabeza', 'Pechera', 'Piernas' THEN
                DELETE FROM inventario_armadura
                WHERE id_inventario = (SELECT id_inventario 
                                       FROM inventario 
                                       WHERE id_personaje = NEW.id_personaje)
                AND id_armadura = NEW.id_armadura
                AND cantidad <= 0;
            WHEN 'Arma', 'Arma Secundaria' THEN
                DELETE FROM inventario_arma
                WHERE id_inventario = (SELECT id_inventario 
                                       FROM inventario 
                                       WHERE id_personaje = NEW.id_personaje)
                AND id_arma = NEW.id_arma
                AND cantidad <= 0;
            WHEN 'Escudo' THEN
                DELETE FROM inventario_escudo
                WHERE id_inventario = (SELECT id_inventario 
                                       FROM inventario 
                                       WHERE id_personaje = NEW.id_personaje)
                AND id_escudo = NEW.id_escudo
                AND cantidad <= 0;
        END CASE;

    ELSIF TG_OP = 'DELETE' THEN
        CASE OLD.tipo_equipo
            WHEN 'Cabeza', 'Pechera', 'Piernas' THEN
                INSERT INTO inventario_armadura (id_inventario, id_armadura, cantidad)
                VALUES ((SELECT id_inventario 
                         FROM inventario 
                         WHERE id_personaje = OLD.id_personaje),
                        OLD.id_armadura, 1)
                ON CONFLICT (id_inventario, id_armadura)
                DO UPDATE SET cantidad = inventario_armadura.cantidad + 1;
            WHEN 'Arma', 'Arma Secundaria' THEN
                INSERT INTO inventario_arma (id_inventario, id_arma, cantidad)
                VALUES ((SELECT id_inventario 
                         FROM inventario 
                         WHERE id_personaje = OLD.id_personaje),
                        OLD.id_arma, 1)
                ON CONFLICT (id_inventario, id_arma)
                DO UPDATE SET cantidad = inventario_arma.cantidad + 1;
            WHEN 'Escudo' THEN
                INSERT INTO inventario_escudo (id_inventario, id_escudo, cantidad)
                VALUES ((SELECT id_inventario 
                         FROM inventario 
                         WHERE id_personaje = OLD.id_personaje),
                        OLD.id_escudo, 1)
                ON CONFLICT (id_inventario, id_escudo)
                DO UPDATE SET cantidad = inventario_escudo.cantidad + 1;
        END CASE;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER trigger_manejar_equipo
AFTER INSERT OR DELETE ON equipo
FOR EACH ROW
EXECUTE FUNCTION manejar_equipo();

CREATE OR REPLACE FUNCTION sustituir_equipo() 
RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM equipo
    WHERE id_personaje = NEW.id_personaje
      AND tipo_equipo = NEW.tipo_equipo;
      
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_sustituir_equipo
BEFORE INSERT ON equipo
FOR EACH ROW
EXECUTE FUNCTION sustituir_equipo();

CREATE OR REPLACE FUNCTION calcular_velocidad() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.raza = 'Humano' OR NEW.raza = 'Elfo' OR NEW.raza = 'Dracónido' OR
       NEW.raza = 'Semielfo' OR NEW.raza = 'Tiflin' THEN
        NEW.velocidad := 30;
    ELSIF NEW.raza = 'Enano' OR NEW.raza = 'Gnomo' OR NEW.raza = 'Mediano' OR
          NEW.raza = 'Orco' OR NEW.raza = 'Semiorco' THEN
        NEW.velocidad := 25;
    ELSE
        NEW.velocidad := 30;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
CREATE TRIGGER trigger_calcular_velocidad
BEFORE INSERT ON personajes
FOR EACH ROW
EXECUTE FUNCTION calcular_velocidad();

CREATE OR REPLACE FUNCTION calcular_habilidades() RETURNS TRIGGER AS $$
DECLARE
    fuerza_mod INT := (NEW.fuerza - 10) / 2;
    destreza_mod INT := (NEW.destreza - 10) / 2;
    inteligencia_mod INT := (NEW.inteligencia - 10) / 2;
    sabiduria_mod INT := (NEW.sabiduria - 10) / 2;
    carisma_mod INT := (NEW.carisma - 10) / 2;
    bonificador_competencia INT := CASE
        WHEN NEW.nivel <= 4 THEN 2
        WHEN NEW.nivel <= 8 THEN 3
        WHEN NEW.nivel <= 12 THEN 4
        ELSE 5
    END;
    v_atletismo INT;
    v_acrobacias INT;
    v_juego_de_manos INT;
    v_sigilo INT;
    v_arcano INT;
    v_historia INT;
    v_investigacion INT;
    v_naturaleza INT;
    v_religion INT;
    v_perspicacia INT;
    v_medicina INT;
    v_percepcion INT;
    v_supervivencia INT;
    v_trato_con_animales INT;
    v_engano INT;
    v_interpretacion INT;
    v_intimidacion INT;
    v_persuasion INT;
BEGIN
    v_atletismo := fuerza_mod + CASE
        WHEN NEW.transfondo IN ('Soldado', 'Forastero', 'Marinero') OR NEW.clase IN ('Guerrero', 'Bárbaro') THEN bonificador_competencia
        ELSE 0
    END;

    v_acrobacias := destreza_mod + CASE
        WHEN NEW.transfondo IN ('Forastero', 'Marinero', 'Artista') OR NEW.clase IN ('Pícaro', 'Monje') THEN bonificador_competencia
        ELSE 0
    END;

    v_juego_de_manos := destreza_mod + CASE
        WHEN NEW.transfondo IN ('Criminal', 'Charlatán') OR NEW.clase IN ('Pícaro') THEN bonificador_competencia
        ELSE 0
    END;

    v_sigilo := destreza_mod + CASE
        WHEN NEW.transfondo IN ('Criminal', 'Charlatán') OR NEW.clase IN ('Pícaro') THEN bonificador_competencia
        ELSE 0
    END;

    v_arcano := inteligencia_mod + CASE
        WHEN NEW.transfondo IN ('Erudito', 'Ermitaño') OR NEW.clase IN ('Mago', 'Hechicero') THEN bonificador_competencia
        ELSE 0
    END;

    v_historia := inteligencia_mod + CASE
        WHEN NEW.transfondo IN ('Erudito', 'Noble') OR NEW.clase IN ('Bardo', 'Mago') THEN bonificador_competencia
        ELSE 0
    END;

    v_investigacion := inteligencia_mod + CASE
        WHEN NEW.transfondo IN ('Erudito', 'Ermitaño') OR NEW.clase IN ('Mago', 'Bardo') THEN bonificador_competencia
        ELSE 0
    END;

    v_naturaleza := inteligencia_mod + CASE
        WHEN NEW.transfondo IN ('Ermitaño', 'Forastero') OR NEW.clase IN ('Druida') THEN bonificador_competencia
        ELSE 0
    END;

    v_religion := inteligencia_mod + CASE
        WHEN NEW.transfondo IN ('Erudito', 'Ermitaño') OR NEW.clase IN ('Clérigo') THEN bonificador_competencia
        ELSE 0
    END;

    v_perspicacia := sabiduria_mod + CASE
        WHEN NEW.transfondo IN ('Ermitaño', 'Forastero', 'Soldado') OR NEW.clase IN ('Druida', 'Clérigo') THEN bonificador_competencia
        ELSE 0
    END;

    v_medicina := sabiduria_mod + CASE
        WHEN NEW.transfondo IN ('Ermitaño', 'Forastero') OR NEW.clase IN ('Clérigo', 'Druida') THEN bonificador_competencia
        ELSE 0
    END;

    v_percepcion := sabiduria_mod + CASE
        WHEN NEW.transfondo IN ('Forastero', 'Soldado') OR NEW.clase IN ('Explorador', 'Pícaro') THEN bonificador_competencia
        ELSE 0
    END;

    v_supervivencia := sabiduria_mod + CASE
        WHEN NEW.transfondo IN ('Forastero', 'Marinero') OR NEW.clase IN ('Explorador') THEN bonificador_competencia
        ELSE 0
    END;

    v_trato_con_animales := sabiduria_mod + CASE
        WHEN NEW.transfondo IN ('Forastero', 'Marinero') OR NEW.clase IN ('Explorador') THEN bonificador_competencia
        ELSE 0
    END;

    v_engano := carisma_mod + CASE
        WHEN NEW.transfondo IN ('Criminal', 'Charlatán', 'Artista') OR NEW.clase IN ('Bardo') THEN bonificador_competencia
        ELSE 0
    END;

    v_interpretacion := carisma_mod + CASE
        WHEN NEW.transfondo IN ('Artista', 'Charlatán') OR NEW.clase IN ('Bardo') THEN bonificador_competencia
        ELSE 0
    END;

    v_intimidacion := carisma_mod + CASE
        WHEN NEW.transfondo IN ('Soldado', 'Criminal') OR NEW.clase IN ('Guerrero', 'Bárbaro') THEN bonificador_competencia
        ELSE 0
    END;

    v_persuasion := carisma_mod + CASE
        WHEN NEW.transfondo IN ('Noble', 'Charlatán') OR NEW.clase IN ('Bardo') THEN bonificador_competencia
        ELSE 0
    END;

    IF EXISTS (SELECT 1 FROM habilidades_personaje WHERE id_personaje = NEW.id_personaje) THEN
        UPDATE habilidades_personaje
        SET 
            atletismo = v_atletismo,
            acrobacias = v_acrobacias,
            juego_de_manos = v_juego_de_manos,
            sigilo = v_sigilo,
            arcano = v_arcano,
            historia = v_historia,
            investigacion = v_investigacion,
            naturaleza = v_naturaleza,
            religion = v_religion,
            perspicacia = v_perspicacia,
            medicina = v_medicina,
            percepcion = v_percepcion,
            supervivencia = v_supervivencia,
            trato_con_animales = v_trato_con_animales,
            engaño = v_engano,
            interpretacion = v_interpretacion,
            intimidacion = v_intimidacion,
            persuasión = v_persuasion
        WHERE id_personaje = NEW.id_personaje;
    ELSE
        INSERT INTO habilidades_personaje (
            id_personaje, atletismo, acrobacias, juego_de_manos, sigilo,
            arcano, historia, investigacion, naturaleza, religion, perspicacia,
            medicina, percepcion, supervivencia, trato_con_animales, engaño,
            interpretacion, intimidacion, persuasión
        )
        VALUES (
            NEW.id_personaje, v_atletismo, v_acrobacias, v_juego_de_manos, v_sigilo,
            v_arcano, v_historia, v_investigacion, v_naturaleza, v_religion, v_perspicacia,
            v_medicina, v_percepcion, v_supervivencia, v_trato_con_animales, v_engano,
            v_interpretacion, v_intimidacion, v_persuasion
        );
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_calcular_habilidades
after INSERT OR UPDATE ON personajes
FOR EACH ROW
EXECUTE FUNCTION calcular_habilidades();

CREATE OR REPLACE FUNCTION calcular_iniciativa() RETURNS TRIGGER AS $$
BEGIN
    DECLARE
        modificador_destreza INT := (NEW.destreza - 10) / 2;
    BEGIN
        NEW.iniciativa := modificador_destreza;
        RETURN NEW;
    END;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_calcular_iniciativa
BEFORE INSERT OR UPDATE ON personajes
FOR EACH ROW
EXECUTE FUNCTION calcular_iniciativa();



CREATE OR REPLACE FUNCTION validar_insercion_hechizo()
RETURNS TRIGGER AS $$
DECLARE
    nivel_personaje INT;
    nivel_hechizo_variable INT;
    ranuras_disponibles INT;
    hechizos_aprendidos_nivel INT;
    clase_trigger clase_enum;
    hechizo_arcanum BOOLEAN;
BEGIN

    SELECT nivel INTO nivel_personaje
    FROM Personajes
    WHERE id_personaje = NEW.id_personaje;


    SELECT nivel INTO nivel_hechizo_variable
    FROM hechizos
    WHERE id = NEW.id_hechizo;


        SELECT clase INTO clase_trigger 
    FROM personajes 
    WHERE id_personaje = NEW.id_personaje;

    IF clase_trigger = 'Brujo' THEN
    if nivel_hechizo_variable >= 6 THEN
    IF EXISTS (
                SELECT 1
                FROM hechizos_personajes HP
                JOIN hechizos H ON HP.id_hechizo = H.id
                WHERE HP.id_personaje = NEW.id_personaje
                  AND H.nivel >= 6
            ) THEN
                RAISE EXCEPTION 'El personaje ya ha aprendido un hechizo Arcanum.';
            END IF;
        END IF;

    SELECT cantidad_ranuras
        INTO ranuras_disponibles
        FROM RanurasBrujos
        WHERE nivel = nivel_personaje
          AND arcanum IS FALSE;

        SELECT COUNT(*)
        INTO hechizos_aprendidos_nivel
        FROM hechizos_personajes HP
        JOIN hechizos H ON HP.id_hechizo = H.id
        WHERE HP.id_personaje = NEW.id_personaje
        and HP.id_hechizo not in (
            select id 
            from hechizos_personajes inner join hechizos on (hechizos_personajes.id_hechizo=hechizos.id)
            where nivel > 5);

        
        IF hechizos_aprendidos_nivel >= ranuras_disponibles THEN
            RAISE EXCEPTION 'El personaje ya ha aprendido el número máximo de hechizos para este nivel.';
        END IF;

    ELSE
        IF NOT EXISTS (
            SELECT 1
            FROM clases_hechizos
            WHERE clase = clase_trigger
              AND hechizo_id = NEW.id_hechizo
              AND nivel_aprendido <= nivel_personaje
        ) THEN
            RAISE EXCEPTION 'El hechizo no puede ser aprendido por el personaje en su nivel actual.';
        END IF;

        SELECT cantidad_ranuras
        INTO ranuras_disponibles
        FROM RanurasPorClaseYNivel
        WHERE clase = clase_trigger
          AND nivel = nivel_personaje
          AND nivel_hechizo = nivel_hechizo_variable;

        SELECT COUNT(*)
        INTO hechizos_aprendidos_nivel
        FROM hechizos_personajes HP
        JOIN hechizos H ON HP.id_hechizo = H.id
        WHERE HP.id_personaje = NEW.id_personaje
          AND H.nivel = nivel_hechizo_variable;

        IF hechizos_aprendidos_nivel >= ranuras_disponibles THEN
            RAISE EXCEPTION 'El personaje ya ha aprendido el número máximo de hechizos permitidos para su nivel actual de hechizo.';
        END IF;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_validar_insercion_hechizo
BEFORE INSERT ON hechizos_personajes
FOR EACH ROW
EXECUTE FUNCTION validar_insercion_hechizo();
