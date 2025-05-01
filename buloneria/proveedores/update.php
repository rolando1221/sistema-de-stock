<?php

include("../includes/function.php");
$con = conectar();

$id = $_POST['id'];
$proveedor = $_POST['proveedor'];
$cuil = $_POST['cuil'];
$domicilio = $_POST['domicilio'];
$telefono = $_POST['telefono'];

$sql = "UPDATE proveedores SET proveedor='$proveedor', cuil='$cuil', domicilio='$domicilio', telefono='$telefono' WHERE id='$id'";
$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: proveedores.php");
}
?>
