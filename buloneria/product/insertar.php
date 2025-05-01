<?php
include("../includes/function.php");
$conn = conectar();

$codigo = $_POST['codigo'];
$id = $_POST['id']; // Cambié $_GET a $_POST para obtener el 'id' desde el formulario
$producto = $_POST['producto'];
$marca = $_POST['marca'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$fecha_compra = $_POST['fecha_compra'];
$categoria = $_POST['categoria'];
$longitud = $_POST['longitud'];
$descrip1 = $_POST['descrip1'];
$descrip2 = $_POST['descrip2'];

$sql = "INSERT INTO producto (`codigo`, `id`, `producto`, `marca`, `precio`, `stock`, `fecha_compra`, `categoria`, `longitud`, `descrip1`, `descrip2`)
VALUES ('$codigo', '$id', '$producto', '$marca', '$precio', '$stock', '$fecha_compra', '$categoria', '$longitud', '$descrip1', '$descrip2')";
$query = mysqli_query($conn, $sql);

if ($query) {
    Header("Location: product.php");
} else {
    // Manejo de errores si es necesario
}
?>
