<?php
session_start();

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$bd = "comercio";

$conn = mysqli_connect($host, $user, $pass, $bd);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Procesar el inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consulta para obtener los datos del usuario
    $sql = "SELECT nombre, correo_electronico, rol FROM usuarios WHERE correo_electronico = '$correo' AND contrasena = '$contrasena'";
    $result = mysqli_query($conn, $sql);

    // Verificar si se encontró un usuario
    if (mysqli_num_rows($result) > 0) {
        // Obtener los datos del usuario
        $row = mysqli_fetch_assoc($result);

        // Establecer las variables de sesión
        $_SESSION['user_name'] = $row['nombre'];
        $_SESSION['user_email'] = $row['correo_electronico'];
        $_SESSION['user_role'] = $row['rol'];

        // Redirigir al dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        $mensaje_error = "Inicio de sesión fallido. Verifica tus credenciales.";
    }
}

// Cerrar la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if (isset($mensaje_error)) { ?>
        <p style="color: red;"><?php echo $mensaje_error; ?></p>
    <?php } ?>
    <form action="" method="post">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required><br>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br>
        
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
