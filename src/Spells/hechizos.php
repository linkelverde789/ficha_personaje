<?php
session_start();
include 'gestor_hechizos.php';
if (!isset($_SESSION['Personaje_ID'])) {
    header('Location: ../home.php');
}
include '../security.php';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprender Hechizos</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/spells.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        select,
        p,
        table {
            font-family: 'UnifrakturMaguntia';
        }
        body {
            padding-top: 0;
            padding: 0 10% 0 10%;
        }
        nav {
            background-color: #333;
            padding: 20px;
            font-size: medium;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            padding-top: 0;
            margin: auto;
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
    </style>
    <script>
        window.onload = function () {
            var error = "<?php echo addslashes($error); ?>";
            if (error) {
                alert(error);
            }
        };
    </script>
</head>
<body>
    <nav>
        <ul class="nav-links">
            <li><a href="../home.php" class="button">Inicio</a></li>
            <li><a href="../Inventory/inventario.php" class="button">Gestionar inventario</a></li>
            <li><a href="../Character/updateCharacter.php" class="button">Actualizar personaje</a></li>
            <li><a href="../CharacterSheet/ficha.php" class="button">Ficha</a></li>
            <li><a href="../dice.php" class="button">Lanzar dados</a></li>
        </ul>
    </nav>
    <div class="jose">
        <h1>Aprender Hechizos</h1>
        <form class="form" action="learnSpell.php" method="post">
            <?php
            lista();
            ?>
        </form>
        <section>
            <h1>Ranuras de Hechizos</h1>
            <?php getSpellsSlots(); ?>
        </section>
        <section>
            <h1>Tus Hechizos</h1>
            <?php getLearnedSpells(); ?>
        </section>
        <script src="../javascript/obtenerDescripcion.js"></script>
        <script src="../javascript/checkObject.js"></script>
    </div>
</body>
</html>