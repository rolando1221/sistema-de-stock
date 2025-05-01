<?php
include("../includes/function.php");
$con = conectar();

// Consulta para obtener los datos del historial de ventas con estado "pagado"
$sql = "SELECT grupo_venta, DATE_FORMAT(fecha_compra, '%H:%i') AS hora_formato, 
               SUM(precio * cantidad) AS importe_total
        FROM ventas 
        WHERE pagado = '1' 
        GROUP BY grupo_venta, hora_formato";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas</title>
    <link rel="stylesheet" href="./hi/pn.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
</head>
<body>
    <div>
        <a href="productos.php?" class="btn btn-primary">volver</a>
    </div>
    <div class="container">
        <h1>Historial de Ventas</h1>
        
        <?php
        while ($row = mysqli_fetch_array($query)) {
            $hora_formato = $row['hora_formato'];
            $grupo_venta = $row['grupo_venta'];
            $importe_total = $row['importe_total'];
        ?>
        
        <h2>Hora: <?php echo $hora_formato; ?></h2>
        <h3>Grupo de Venta: <?php echo $grupo_venta; ?></h3>
        <p>Importe Total: <?php echo $importe_total; ?></p>
        
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
                // Obtén las ventas específicas de ese grupo
                $ventas_query = mysqli_query($con, "SELECT * FROM ventas WHERE pagado = '1' AND grupo_venta = '$grupo_venta'");
                while ($venta = mysqli_fetch_array($ventas_query)) {
                    ?>
                    <tr>
                        <td><?php echo $venta['id_venta'] ?></td>
                        <td><?php echo $venta['id_producto'] ?></td>
                        <td><?php echo $venta['producto'] ?></td>
                        <td><?php echo $venta['cantidad'] ?></td>
                        <td><?php echo $venta['fecha_compra'] ?></td>
                        <td><?php echo $venta['precio'] ?></td>
                        <td><?php echo $venta['precio'] * $venta['cantidad'] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        
        <?php
        }
        ?>
    </div>
</body>
</html>
