<?php
include("../includes/function.php");
$con = conectar();

$query = "SELECT producto, marca FROM producto WHERE stock < 5"; 
$result = mysqli_query($con, $query);

$productosBajoStock = array();

while ($row = mysqli_fetch_assoc($result)) {
    $productosBajoStock[] = $row;
}

echo json_encode($productosBajoStock);

mysqli_close($con);
?>
