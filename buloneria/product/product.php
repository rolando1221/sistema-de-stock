<?php
// Include the functions file
include("../includes/function.php");

// Establish a database connection using the function from functions.php
$con = conectar();

// SQL query to retrieve all products
$sql = "SELECT * FROM producto";
$query = ejecutarConsulta($con, $sql);

// Check if the query was successful
if (!$query) {
    die("Error in the query: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tu Página</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/pi.css">
    
</head>
<body>
<div class="buttons-container">
    <div class="buttons-container">
        <a href="../index.php" class="btn">Inicio</a>
        <a href="productos.php" class="btn">Ventas</a>
        <a href="" class="btn">Ayuda</a>
        <a id="openAddProductModalBtn" class="btn">Nuevo registro</a>
    </div>
    <div class="filter-container">
    <label for="categoryFilter">Filtrar por Categoría:</label>
    <select id="categoryFilter">
        <option value="">Todas</option>
        <option value="tornillo">Tornillo</option>
        <option value="herramientas">Herramientas</option>
        <option value="ferreteria">Ferretería</option>
        <option value="pinturas">Pinturas</option>
        <option value="construccion">Construcción</option>
        <option value="seguridad">Seguridad</option>
    </select>

    <label for="sizeFilter">Filtrar por Medida:</label>
    <input type="text" id="sizeFilter" placeholder="Ingrese medida">

    <label for="bearingFilter">Filtrar por Rodamiento:</label>
    <input type="text" id="bearingFilter" placeholder="Ingrese rodamiento">
</div>
    <div class="container">
        <main>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Buscar por descripción">
            </div>
            <section class="product-list">
                <table class="table">
                    <thead class="table-success table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Fecha</th>
                            <th>Categoría</th>
                            <th>Longitud</th>
                            <th>Peso</th>
                            <th>Descripción 1</th>
                            <th>Descripción 2</th>
                            <th>Modificar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['codigo'] ?></td>
                                <td><?php echo $row['producto'] ?></td>
                                <td><?php echo $row['marca'] ?></td>
                                <td><?php echo $row['precio'] ?></td>
                                <td><?php echo $row['stock'] ?></td>
                                <td><?php echo $row['fecha_compra'] ?></td>
                                <td><?php echo $row['categoria'] ?></td>
                                <td><?php echo $row['longitud'] ?></td>
                                <td><?php echo $row['peso'] ?></td>
                                <td><?php echo $row['descrip1'] ?></td>
                                <td><?php echo $row['descrip2'] ?></td>
                                <td>
                                <button class="btn btn-info edit-btn"
    <?php foreach ($row as $key => $value): ?>
        data-<?php echo $key; ?>="<?php echo $value; ?>"
    <?php endforeach; ?>
>
    Editar
</button>

</td>
                                <td>
                                    <button><a href="delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">Eliminar</a></button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <!-- Modal for adding products -->
    <!-- Modal for adding products -->
<div class="modal" id="addProductModal">
    <div class="modal-content">
        <span class="close" id="closeAddProductModalBtn">&times;</span>
        <h2 id="addProductModalTitle">Agregar Producto</h2>
        <form id="addProductForm" action="insertar.php" method="POST">
            <div class="mb-3">
                <label for="codigo" class="form-label">Código:</label>
                <input type="text" class="form-control" id="codigo" name="codigo" required>
            </div>
            <div class="mb-3">
                <label for="producto" class="form-label">Descripción:</label>
                <input type="text" class="form-control" id="producto" name="producto" required>
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de Compra:</label>
                <input type="date" class="form-control" id="fecha" name="fecha_compra" required>
            </div>
            <div class="mb-3">
            <label for="categoria" class="form-label">Categoría:</label>
            <select class="form-select" id="categoria" name="categoria" required>
                <option value="tornillo">Tornillería: Variedades de tornillos, tuercas, arandelas, pernos, etc.</option>
                <option value="herramientas">Herramientas: Herramientas manuales, eléctricas y de otro tipo.</option>
                <option value="ferreteria">Ferretería: Productos diversos como candados, bisagras, cerraduras, etc.</option>
                <option value="pinturas">Pinturas y accesorios de pintura: Pinturas, pinceles, rodillos, etc.</option>
                <option value="construccion">Material de construcción: Productos básicos como clavos, alambres, cemento, etc.</option>
                <option value="seguridad">Seguridad: Artículos de seguridad como cascos, guantes, gafas protectoras, etc.</option>
                <!-- Agrega más opciones según sea necesario -->
            </select>
        </div>

            <div class="mb-3">
                <label for="longitud" class="form-label">Longitud:</label>
                <input type="text" class="form-control" id="longitud" name="longitud" required>
            </div>
            <div class="mb-3">
                <label for="descrip1" class="form-label">Descripción 1:</label>
                <input type="text" class="form-control" id="descrip1" name="descrip1">
            </div>
            <div class="mb-3">
                <label for="descrip2" class="form-label">Descripción 2:</label>
                <input type="text" class="form-control" id="descrip2" name="descrip2">
            </div>
            <!-- Agrega los campos restantes de acuerdo a tu estructura -->
            <button type="submit" class="btn btn-primary" id="saveAddProductBtn">Guardar</button>
        </form>
    </div>
</div>

   <!-- Modal for editing products -->
<div class="modal" id="editProductModal">
    <div class="modal-content">
        <span class="close" id="closeEditProductModalBtn">&times;</span>
        <h2 id="editProductModalTitle">Editar Producto</h2>
        <form id="editProductForm" action="update.php" method="POST">
            <input type="hidden" id="editId" name="id" value="">
            <div class="mb-3">
                <label for="editCodigo" class="form-label">Código:</label>
                <input type="text" class="form-control" id="editCodigo" name="codigo" required>
            </div>
            <div class="mb-3">
                <label for="editProducto" class="form-label">Descripción:</label>
                <input type="text" class="form-control" id="editProducto" name="producto" required>
            </div>
            <div class="mb-3">
                <label for="editMarca" class="form-label">Marca:</label>
                <input type="text" class="form-control" id="editMarca" name="marca" required>
            </div>
            <div class="mb-3">
                <label for="editPrecio" class="form-label">Precio:</label>
                <input type="number" step="0.01" class="form-control" id="editPrecio" name="precio" required>
            </div>
            <div class="mb-3">
                <label for="editStock" class="form-label">Stock:</label>
                <input type="number" class="form-control" id="editStock" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="editFecha" class="form-label">Fecha de Compra:</label>
                <input type="date" class="form-control" id="editFecha" name="fecha_compra" required>
            </div>
            <div class="mb-3">
                <label for="editCategoria" class="form-label">Categoría:</label>
                <input type="text" class="form-control" id="editCategoria" name="categoria" required>
            </div>
            <div class="mb-3">
                <label for="editLongitud" class="form-label">Longitud:</label>
                <input type="text" class="form-control" id="editLongitud" name="longitud" required>
            </div>
            <div class="mb-3">
                <label for="editPeso" class="form-label">Peso:</label>
                <input type="text" class="form-control" id="editPeso" name="peso">
            </div>
            <div class="mb-3">
                <label for="editDescrip1" class="form-label">Descripción 1:</label>
                <input type="text" class="form-control" id="editDescrip1" name="descrip1">
            </div>
            <div class="mb-3">
                <label for="editDescrip2" class="form-label">Descripción 2:</label>
                <input type="text" class="form-control" id="editDescrip2" name="descrip2">
            </div>
            <button type="submit" class="btn btn-primary" id="saveEditProductBtn">Actualizar</button>
        </form>
    </div>
</div>



<!-- JavaScript to handle modals and other functionality -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    // Obtén referencias a los elementos de filtro
const categoryFilter = document.getElementById('categoryFilter');
const sizeFilter = document.getElementById('sizeFilter');
const bearingFilter = document.getElementById('bearingFilter');

// Agrega un evento de cambio a cada elemento de filtro
categoryFilter.addEventListener('change', filterTable);
sizeFilter.addEventListener('input', filterTable);
bearingFilter.addEventListener('input', filterTable);

// Función para filtrar la tabla
function filterTable() {
    const categoryValue = categoryFilter.value.toLowerCase();
    const sizeValue = sizeFilter.value.toLowerCase();
    const bearingValue = bearingFilter.value.toLowerCase();

    // Itera sobre las filas de la tabla y muestra/oculta según los filtros
    productRows.forEach((row) => {
        const categoryColumn = row.querySelector('td:nth-child(8)').textContent.toLowerCase(); // Ajusta el índice según tu estructura
        const sizeColumn = row.querySelector('td:nth-child(9)').textContent.toLowerCase(); // Ajusta el índice según tu estructura
        const bearingColumn = row.querySelector('td:nth-child(10)').textContent.toLowerCase(); // Ajusta el índice según tu estructura

        const categoryMatch = categoryColumn.includes(categoryValue) || categoryValue === '';
        const sizeMatch = sizeColumn.includes(sizeValue) || sizeValue === '';
        const bearingMatch = bearingColumn.includes(bearingValue) || bearingValue === '';

        if (categoryMatch && sizeMatch && bearingMatch) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
}



    // Relevant DOM elements
    const openAddProductModalBtn = document.getElementById('openAddProductModalBtn');
    const closeAddProductModalBtn = document.getElementById('closeAddProductModalBtn');
    const closeEditProductModalBtn = document.getElementById('closeEditProductModalBtn');
    const addProductModal = document.getElementById('addProductModal');
    const editProductModal = document.getElementById('editProductModal');
    const addProductForm = document.getElementById('addProductForm');
    const editProductForm = document.getElementById('editProductForm');
    const productTableBody = document.getElementById('productTableBody');
    const searchInput = document.getElementById('searchInput');
    const productRows = document.querySelectorAll('#productTableBody tr');

    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();

        productRows.forEach((row) => {
            const descripcion = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            if (descripcion.includes(searchTerm)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Show the modal for adding a new product
    openAddProductModalBtn.addEventListener('click', () => {
        document.getElementById('addProductForm').reset();
        addProductModal.style.display = 'block';
    });

    // Show the modal for editing a product
    productTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('edit-btn')) {
            const id = e.target.getAttribute('data-id');
            const codigo = e.target.getAttribute('data-codigo');
            const descripcion = e.target.getAttribute('data-producto'); // Cambiado a 'data-producto'
            const marca = e.target.getAttribute('data-marca');
            const precio = e.target.getAttribute('data-precio');
            const stock = e.target.getAttribute('data-stock');
            const fecha = e.target.getAttribute('data-fecha');
            const categoria = e.target.getAttribute('data-categoria'); // Nuevo campo
            const longitud = e.target.getAttribute('data-longitud'); // Nuevo campo
            const peso = e.target.getAttribute('data-peso'); // Nuevo campo
            const descrip1 = e.target.getAttribute('data-descrip1'); // Nuevo campo
            const descrip2 = e.target.getAttribute('data-descrip2'); // Nuevo campo

            document.getElementById('editId').value = id;
            document.getElementById('editCodigo').value = codigo;
            document.getElementById('editProducto').value = descripcion;
            document.getElementById('editMarca').value = marca;
            document.getElementById('editPrecio').value = precio;
            document.getElementById('editStock').value = stock;
            document.getElementById('editFecha').value = fecha;
            document.getElementById('editCategoria').value = categoria; // Nuevo campo
            document.getElementById('editLongitud').value = longitud; // Nuevo campo
            document.getElementById('editPeso').value = peso; // Nuevo campo
            document.getElementById('editDescrip1').value = descrip1; // Nuevo campo
            document.getElementById('editDescrip2').value = descrip2; // Nuevo campo

            editProductModal.style.display = 'block';
        }
    });

    // Show the modal for deleting a product
    productTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('delete-btn')) {
            const id = e.target.getAttribute('data-id');
            const codigo = e.target.getAttribute('data-codigo');
            const descripcion = e.target.getAttribute('data-descripcion');

            if (confirm('¿Seguro que quieres eliminar este producto?')) {
                // Enviar una solicitud al archivo delete.php con los datos del producto
                // Aquí debes usar AJAX o Fetch para realizar la solicitud.
                // Ejemplo con Fetch:
                fetch('delete.php', {
                    method: 'POST',
                    body: JSON.stringify({ id, codigo, descripcion }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.status === 200) {
                        // Eliminación exitosa, puedes actualizar la página o la tabla aquí.
                        location.reload();
                    } else {
                        alert('Error al eliminar el producto.');
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud: ', error);
                });
            }
        }
    });

    // Close the modal for adding products
    closeAddProductModalBtn.addEventListener('click', () => {
        addProductModal.style.display = 'none';
    });

    // Close the modal for editing products
    closeEditProductModalBtn.addEventListener('click', () => {
        editProductModal.style.display = 'none';
    });

    // Close the modal if the user clicks outside of it
    window.addEventListener('click', (e) => {
        if (e.target === addProductModal) {
            addProductModal.style.display = 'none';
        }
        if (e.target === editProductModal) {
            editProductModal.style.display = 'none';
        }
    });
</script>
</body>
</html>
