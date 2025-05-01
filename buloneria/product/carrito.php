<?php
include("../includes/function.php");
$con = conectar();

// Definir la función para generar un número de factura único
function generarNumeroFactura() {
    
    
    return "FACT-" . date("YmdHis");
}

// Consulta para obtener los datos del historial de ventas con estado "pendiente" (no vendidos)
$sql = "SELECT * FROM ventas WHERE pagado = '0'";
$query = mysqli_query($con, $sql);

// Inicializar la variable para calcular el importe total
$importe_total = 0;

// Comprobar si se ha enviado un formulario para marcar todos los productos como "vendidos"
if (isset($_POST['marcar_todo_vendido'])) {
    // Obtener la fecha actual
    $fecha_actual = date("Y-m-d");

   
    mysqli_begin_transaction($con);

    // Asignar un número de factura único al grupo de ventas
    $numero_factura = generarNumeroFactura(); // Llamada a la función para generar un número de factura único

    // Iterar a través de los productos en el carrito
    while ($row = mysqli_fetch_array($query)) {
        $importe = $row['precio'] * $row['cantidad']; // Calcular el importe total por producto
        $importe_total += $importe; // Sumar al importe total

        // Actualizar el producto en la tabla de ventas
        $id_venta = $row['id_venta'];
        $update_sql = "UPDATE ventas SET pagado = '1', fecha_compra = '$fecha_actual', precio = '$importe', grupo_venta = '$numero_factura' WHERE id_venta = $id_venta";
        $update_query = mysqli_query($con, $update_sql);

        if (!$update_query) {
            // Revertir la transacción en caso de error
            mysqli_rollback($con);
            die("Error al marcar como vendidos: " . mysqli_error($con));
        }
    }

    
    mysqli_commit($con);

    
    header("Location: carrito.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="./hi/png.css">
</head>
<body>
    <div class="container">
        <h1>Carrito</h1>
        <table class="table">
            <thead class="table-success table-striped">
                <tr>
                    <th>ID de Venta</th>
                    <th>ID de Producto</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha de Compra</th>
                    <th>Precio Unitario</th>
                    <th>Importe Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($con, "SELECT * FROM ventas WHERE pagado = '0'");
                while ($row = mysqli_fetch_array($query)) {
                    $importe = $row['precio'] * $row['cantidad']; // Calcular el importe total por producto
                    $importe_total += $importe; // Sumar al importe total
                ?>
                <tr>
                    <td><?php echo $row['id_venta'] ?></td>
                    <td><?php echo $row['id_producto'] ?></td>
                    <td><?php echo $row['producto'] ?></td>
                    <td><?php echo $row['cantidad'] ?></td>
                    <td><?php echo $row['fecha_compra'] ?></td>
                    <td><?php echo $row['precio'] ?></td>
                    <td><?php echo $importe ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        
        <!-- Mostrar el importe total de los productos seleccionados -->
        <p>Importe Total de Productos Seleccionados: <?php echo $importe_total ?></p>

        <form method="post">
            <input type="submit" name="marcar_todo_vendido" value="Marcar todos como Vendidos">
        </form>
    </div>
</body>
</html>


