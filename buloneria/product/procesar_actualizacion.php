<?php
  include("../includes/function.php");
$con = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $porcentaje = $_POST["porcentaje"];
    $filtro = $_POST["filtro"];


    // Actualiza los precios en la base de datos según el filtro y el porcentaje
    $query = "UPDATE producto SET precio = precio * (1 + ?) WHERE marca LIKE ? OR producto LIKE ?";
    $stmt = mysqli_prepare($con, $query);
    
    if ($stmt) {
        $porcentaje = $porcentaje / 100; // Divide el porcentaje por 100 para obtener el factor de aumento
        $filtro = "%$filtro%"; // Agrega comodines para buscar coincidencias parciales
        mysqli_stmt_bind_param($stmt, "sss", $porcentaje, $filtro, $filtro);
    
        if (mysqli_stmt_execute($stmt)) {
            echo "Los precios han sido actualizados con éxito.";
        } else {
            echo "Error al actualizar los precios: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($con);
    }
    
}
// Cierra la conexión a la base de datos
mysqli_close($con);
if($query){
    Header("Location: ../productos.php");
    
}else {
}
?>
