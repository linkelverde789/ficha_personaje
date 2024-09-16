<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Personajes de D&D</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/index.css">
    <style>
        nav {
            background-color: #333;
            padding: 10px;
            width: -webkit-fill-available;
            font-size: medium;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 0;
        }

        .nav-links {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .nav-links li {
            display: inline;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #555;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: #777;
        }

div{
    display: flex;
    flex-direction: center;
    justify-content: center;
    align-items: center;
}
    </style>
</head>
<body>

<nav>
      <ul class="nav-links">
<?php
      if(isset($_SESSION['id'])){
    echo '<li><a href="home.php" class="button">Inicio</a></li>';
};
?>
        <li><a href="dice.php" class="button">Lanzar dados</a></li>
      </ul>
    </nav>

    <header>
        <h1>Administrador de Personajes de</h1>
        <div>
        <img src="https://logos-world.net/wp-content/uploads/2021/12/DnD-Logo.png" alt="logo de Dungeon and Dragons" width="300px" height="auto">
     
        </div>
        </header>

    <section id="introduccion">
        <h2>Bienvenido a tu Administrador de Personajes</h2>
        <p>Este sitio te permite crear, gestionar y llevar un registro de todos tus personajes de Dungeons & Dragons en un solo lugar. Organiza tus campañas, consulta estadísticas y accede a tus personajes desde cualquier lugar.</p>
        <p>Ya sea que seas un Dungeon Master experimentado o un jugador nuevo, aquí encontrarás todas las herramientas necesarias para tus aventuras de D&D.</p>
    </section>

    <section id="acciones">
        <h2>Comienza Ahora</h2>
        <p>Para empezar, puedes crear una cuenta o iniciar sesión si ya tienes una:</p>
        <ul>
            <li><a href="Users/login.php">Iniciar Sesión</a></li>
            <li><a href="Users/create_user.php">Crear cuenta</a></li>
        </ul>
    </section>

    <footer>
        <p>&copy; 2024 Administrador de Personajes de D&D. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
