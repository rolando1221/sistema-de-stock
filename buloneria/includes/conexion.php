<?php
function conectar()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "comercio";

    $con = mysqli_connect($host, $user, $pass);

    if (!$con) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    mysqli_select_db($con, $bd);

    return $con;
}
?>
