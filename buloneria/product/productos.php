<?php
session_start();
include("../includes/function.php");
$con = conectar();

$esDuenoAutenticado = isset($_SESSION['rol']) && $_SESSION['rol'] === 'dueno';
$urlVolver = $esDuenoAutenticado ? 'product.php' : 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregarAlCarrito'])) {
    $productoId = $_POST['productoId'];
    $cantidad = $_POST['cantidad'];

    $query = "SELECT * FROM producto WHERE id = $productoId AND stock >= $cantidad";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $importe = $cantidad * $row['precio'];

        $insertQuery = "INSERT INTO ventas (id_producto, producto, cantidad, fecha_compra, precio, importe) 
        VALUES ('$productoId', '{$row['producto']}', '$cantidad', NOW(), '{$row['precio']}', '$importe')";
        mysqli_query($con, $insertQuery);

        $newStock = $row['stock'] - $cantidad;
        $updateQuery = "UPDATE producto SET stock = $newStock WHERE id = $productoId";
        mysqli_query($con, $updateQuery);

        header("Location: productos.php");
        exit;
    }
}

$query = "SELECT * FROM producto WHERE stock > 0";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="./ventas/css.css">
</head>
<body>
    <button><a href="<?php echo $urlVolver; ?>" class="nav">Volver</a></button>
    <button><a href="carrito.php" class="nav">Carrito</a></button>
    <button><a href="vendido.php" class="nav-link">Historial</a></button>
    <button id="mostrarModalStockBajo" onclick="mostrarModalStockBajo()">Ver Productos con Bajo Stock</button>

    <div id="modalStockBajo" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModalStockBajo()">&times;</span>
            <h2>Productos con Bajo Stock</h2>
            <ul id="productosBajoStock"></ul>
        </div>
    </div>

    <h1>Listado de Productos</h1>
    <h1>Actualizar Precios</h1>
    <form>
        <label for="buscador">Buscar:</label>
        <input type="text" id="buscador" name="busquedor" placeholder="Escribe tu búsqueda..." />
        <button type="submit">Buscar</button>
    </form>

    <button id="mostrarFormulario" onclick="mostrarModalAumento()">Aumentar</button>

    <div id="formularioContainer" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModalAumento()">&times;</span>
            <h2>Subir Precios por Porcentaje</h2>
            <form method="post" action="./config/procesar_actualizacion.php">
                <div class="input-group">
                    <label for="porcentaje">Porcentaje de Aumento:</label>
                    <input type="text" name="porcentaje" id="porcentaje" required>
                </div>
                <div class="input-group">
                    <label for="filtro">Filtrar por Marca o Producto:</label>
                    <input type="text" name="filtro" id="filtro">
                </div>
                <button type="submit">Actualizar Precios</button>
            </form>
        </div>
    </div>

    <div class="product-grid">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="product">
                    <h2><?php echo $row['producto']; ?></h2>
                    <p>Marca: <?php echo $row['marca']; ?></p>
                    <p>Precio: $<?php echo $row['precio']; ?></p>
                    <p>Stock Disponible: <?php echo $row['stock']; ?></p>
                    <button onclick="abrirModal(<?php echo $row['id']; ?>)">Seleccionar</button>
                </div>

                <div id="modal-<?php echo $row['id']; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="cerrarModal(<?php echo $row['id']; ?>)">&times;</span>
                        <h3><?php echo $row['producto']; ?></h3>
                        <p>Marca: <?php echo $row['marca']; ?></p>
                        <p>Precio: $<?php echo $row['precio']; ?></p>
                        <form method="post" action="">
                            <input type="hidden" name="productoId" value="<?php echo $row['id']; ?>">
                            <label for="cantidad-<?php echo $row['id']; ?>">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad-<?php echo $row['id']; ?>" min="1" max="<?php echo $row['stock']; ?>">
                            <button class="btn -btn primary" type="submit" name="agregarAlCarrito">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p>No hay productos disponibles.</p>';
        }

        mysqli_close($con);
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

     <script>
        function abrirModal(productoId) {
            var modal = document.getElementById('modal-' + productoId);
            modal.style.display = "block";
        }

        function cerrarModal(productoId) {
            var modal = document.getElementById('modal-' + productoId);
            modal.style.display = "none";
        }

        function agregarAlCarrito(productoId) {
            var cantidadInput = document.getElementById('cantidad-' + productoId);
            var cantidad = cantidadInput.value;

            cerrarModal(productoId);
        }

        function mostrarModalAumento() {
            var modal = document.getElementById("formularioContainer");
            modal.style.display = "block";
        }

        function cerrarModalAumento() {
            var modal = document.getElementById("formularioContainer");
            modal.style.display = "none";
        }

        function buscarProductos() {
            var input = document.getElementById("buscador");
            var filtro = input.value.toLowerCase();

            var productos = document.querySelectorAll(".product");

            productos.forEach(function(producto) {
                var nombre = producto.querySelector("h2").textContent.toLowerCase();
                var marca = producto.querySelector("p:nth-of-type(1)").textContent.toLowerCase();
                var precio = producto.querySelector("p:nth-of-type(3)").textContent.toLowerCase();

                if (nombre.indexOf(filtro) > -1 || marca.indexOf(filtro) > -1 || precio.indexOf(filtro) > -1) {
                    producto.style.display = "";
                } else {
                    producto.style.display = "none";
                }
            });
        }

        var buscador = document.getElementById("buscador");
        buscador.addEventListener("input", buscarProductos);

        function mostrarModalStockBajo() {
            var modal = document.getElementById("modalStockBajo");
            modal.style.display = "block";
            $.ajax({
                url: "obtener_productos_bajo_stock.php",
                dataType: "json",
                success: function(data) {
                    var listaProductosBajoStock = document.getElementById("productosBajoStock");
                    listaProductosBajoStock.innerHTML = "";

                    data.forEach(function(producto) {
                        var liProducto = document.createElement("li");
                        liProducto.innerHTML = producto.producto + " (Marca: " + producto.marca + ")";
                        listaProductosBajoStock.appendChild(liProducto);
                    });
                },
                error: function() {
                    console.log("Error al obtener los productos con bajo stock");
                }
            });
        }

        function cerrarModalStockBajo() {
            var modal = document.getElementById("modalStockBajo");
            modal.style.display = "none";
        }
    </script>
</body>
</html>



