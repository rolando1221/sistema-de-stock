<?php

include("../includes/function.php");
$con=conectar();

$idcliente=$_GET['idcliente'];

$sql="DELETE FROM clientes WHERE idcliente='$idcliente'";
$query=mysqli_query($con,$sql);

    if($query){
        Header("Location: clientes.php");
    }
?>
