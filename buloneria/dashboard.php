<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_email']) || !isset($_SESSION['user_role'])) {
    // Si no está autenticado, redirigirlo a la página de inicio de sesión
    header("Location: index.php");
    exit(); // Salir del script
}

// Obtener el rol del usuario desde la sesión
$user_role = $_SESSION['user_role'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulonería XYZ - Dashboard</title>
    <link rel="icon" type="image/png" href="./img/logo.jpg">
    <link rel="stylesheet" href="dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>

    <header>
        <h1>Bulonería XYZ</h1>
    </header>

    <nav>
        <?php if ($user_role === 'dueño') { ?>
            <a href="./product/product.php" class="boton boton-productos"><i class="fas fa-box"></i> Productos</a>
            <a href="./proveedores/proveedores.php" class="boton boton-proveedores"><i class="fas fa-truck"></i> Proveedores</a>
            <a href="./clientes/clientes.php" class="boton boton-clientes"><i class="fas fa-users"></i> Clientes</a>
        <?php } elseif ($user_role === 'empleado') { ?>
            <a href="./product/productos.php" class="boton boton-ventas"><i class="fas fa-money-bill-alt"></i> Ventas</a>
        <?php } ?>
        <a href="./includes/cerrar_sesion.php" class="boton boton-cerrar"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
    </nav>

    <section>
        <?php
        if ($user_role === 'dueño') {
            echo "<h2>Bienvenido, dueño. Aquí tienes acceso completo al sistema.</h2>";
        } elseif ($user_role === 'empleado') {
            echo "<h2>Bienvenido, empleado. Aquí tienes acceso a la información de ventas.</h2>";
        }
        ?>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Bulonería XYZ - Todos los derechos reservados <a href="#"><i class="fab fa-facebook"></i></a> <a href="#"><i class="fab fa-twitter"></i></a></p>
    </footer>

</body>
</html>



