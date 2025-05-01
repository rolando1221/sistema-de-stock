<?php
include("../includes/function.php");
$conn = conectar();

$idcliente = $_POST['idcliente']; // Asegúrate de tener este campo en tu formulario HTML
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$dni = $_POST['dni'];
$direccion = $_POST['direccion'];
$correo = $_POST['correo']; // Agregado el campo correo

$sql = "INSERT INTO clientes (`idcliente`, `nombre`, `apellido`, `direccion`, `correo`, `telefono`, `dni`, `saldo`)
        VALUES ('$idcliente', '$nombre', '$apellido', '$direccion', '$correo', '$telefono', '$dni', 0)"; // Cambiado el orden y agregado el campo correo
$query = mysqli_query($conn, $sql);

if ($query) {
    header("Location: clientes.php");
} else {
    // Manejar el caso de error si es necesario
    echo "Error al insertar el cliente: " . mysqli_error($conn);
}
?>

