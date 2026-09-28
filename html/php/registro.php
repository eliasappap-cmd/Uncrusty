
<?php

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "tp_colegio"
);

if ($conexion->connect_error) {
    die("Error de conexion x.x");
}

$contraseña = trim($_POST["password"]);
$dni = trim($_POST["Dni"]);
$email = trim($_POST["email"]);
$rol  = trim($_POST["rol"]);

if ($rol != "Usuario" && $rol != "Lavandero" && $rol != "Repartidor") {
    ?>
    <script>
    alert("Debe seleccionar una opción");
    window.location = "registro.html";
    </script>
    <?php
    exit();
}


$sql = "INSERT INTO usuarios
(email,dni,rol,contraseña)
VALUES (?, ?, ?,?)";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "ssss",
    $email,
    $dni,
    $rol,
    $contraseña
);

try {

    $stmt->execute();

    header("Location: login.html");
    exit();

} catch (mysqli_sql_exception $e) {

    if ($e->getCode() == 1062) {

        echo "Ese dni ya existe";

    } else {

       
        echo "Error de MySQL: " . $e->getMessage();

    }
}

