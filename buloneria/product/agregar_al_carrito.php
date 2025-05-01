<?php
include("../includes/function.php");

// Comprueba si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregarAlCarrito'])) {
    $productoId = $_POST['productoId'];
    $cantidad = $_POST['cantidad'];

    // Realiza la inserción en la tabla de ventas
    $con = conectar();
    $sql = "INSERT INTO ventas (id_producto, producto, cantidad, fecha_compra, precio, estado, importe) VALUES (?, ?, ?, NOW(), ?, 'pendiente', ?)";
    $stmt = mysqli_prepare($con, $sql);
    
    // Asegúrate de que los valores se pasen de manera segura y adecuada
    $producto = ""; // Inserta el nombre del producto
    $precio = 0;    // Inserta el precio del producto
    $importe = $cantidad * $precio;

    mysqli_stmt_bind_param($stmt, "issdi", $productoId, $producto, $cantidad, $precio, $importe);
    
    if (mysqli_stmt_execute($stmt)) {
        // La inserción se realizó con éxito
        echo "Producto agregado al carrito con éxito.";
    } else {
        // Error en la inserción
        echo "Hubo un error al agregar el producto al carrito.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    // Si no se envió el formulario correctamente
    echo "No se recibieron datos para agregar al carrito.";
}
?>
