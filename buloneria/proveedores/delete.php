<?php

include("../includes/function.php");
$con=conectar();

$id=$_GET['id'];

$sql="DELETE FROM proveedores WHERE id='$id'";
$query=mysqli_query($con,$sql);

    if($query){
        Header("Location: proveedores.php");
    }
?>
