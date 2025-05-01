<?php

include("../includes/function.php");
$con=conectar();

$id=$_GET['id'];

$sql="DELETE FROM producto WHERE id='$id'";
$query=mysqli_query($con,$sql);

    if($query){
        Header("Location: product.php");
    }
?>
