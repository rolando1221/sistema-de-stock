<?php
include("../includes/function.php");
$con = conectar();

$idcliente = $_POST['idcliente'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$dni = $_POST['dni'];
$direccion = $_POST['direccion'];
$correo = $_POST['correo']; // Asegúrate de tener este campo en tu formulario HTML
$saldo = $_POST['saldo']; // Asegúrate de tener este campo en tu formulario HTML

$sql = "UPDATE clientes 
        SET nombre='$nombre', apellido='$apellido', direccion='$direccion', correo='$correo', telefono='$telefono', dni='$dni', saldo='$saldo' 
        WHERE idcliente='$idcliente'";
$query = mysqli_query($con, $sql);

if ($query) {
    header("Location: clientes.php");
} else {
    // Manejar el caso de error si es necesario
    echo "Error al actualizar el cliente: " . mysqli_error($con);
}
?>
