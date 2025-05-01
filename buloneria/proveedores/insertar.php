<?php
include("../includes/function.php");
$conn = conectar();

$proveedor = $_POST['proveedor'];
$id = $_POST['id'];
$cuil = $_POST['cuil']; // Añadida la variable cuil
$domicilio = $_POST['domicilio']; // Añadida la variable domicilio
$telefono = $_POST['telefono'];

$sql = "INSERT INTO proveedores (`proveedor`, `id`, `cuil`, `domicilio`, `telefono`)
        VALUES('$proveedor', '$id', '$cuil', '$domicilio', '$telefono')";
$query = mysqli_query($conn, $sql);

if ($query) {
    Header("Location: proveedores.php");
} else {
    // Manejo de error si es necesario
    echo "Error: " . mysqli_error($conn);
}
?>

