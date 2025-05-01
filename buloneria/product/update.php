<?php

include("../includes/function.php");
$con = conectar();

$id = $_POST['id'];
$codigo = $_POST['codigo'];
$producto = $_POST['producto'];
$marca = $_POST['marca'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$fecha_compra = $_POST['fecha_compra'];
$categoria = $_POST['categoria'];
$longitud = $_POST['longitud'];
$peso = $_POST['peso'];
$descrip1 = $_POST['descrip1'];
$descrip2 = $_POST['descrip2'];

// Assuming 'id' is the correct primary key column in the 'clientes' table
$sql = "UPDATE producto SET `codigo`='$codigo', `producto`='$producto', `marca`='$marca', `precio`='$precio', 
        `stock`='$stock', `fecha_compra`='$fecha_compra', `categoria`='$categoria', `longitud`='$longitud', 
        `peso`='$peso', `descrip1`='$descrip1', `descrip2`='$descrip2' WHERE `id`='$id'";

// Print the SQL query for debugging purposes
echo "SQL Query: $sql";

$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: product.php");
} else {
    // Print the detailed error message for debugging purposes
    echo "Error: " . mysqli_error($con);
}
?>
