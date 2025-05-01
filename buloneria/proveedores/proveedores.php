<?php 
include("../includes/function.php");
    $con=conectar();

    $sql="SELECT * FROM proveedores";
    $query=mysqli_query($con,$sql);
?>

<!DOCTYPE html>
<html lang="s">
<head>
    <title>PAGINA PROVEEDORES</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <link rel="stylesheet" href="./css/css.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Botón para abrir el modal de agregar -->
            <a id="openAddProductModalBtn" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#addProductModal">Nuevo registro</a>
            <form action="volver">
                <h1><a class="btn btn-primary" href="../index.php?" type="submit">Inicio</a></h1>
            </form>

            <div class="container">
                <table class="table">
                    <thead class="table-success table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Proveedor</th>
                            <th>CUIL</th>
                            <th>Domicilio</th>
                            <th>Telefono</th>
                            <th>Modificar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['proveedor'] ?></td>
                                <td><?php echo $row['cuil'] ?></td>
                                <td><?php echo $row['domicilio'] ?></td>
                                <td><?php echo $row['telefono'] ?></td>

                                <!-- Botón para abrir el modal de edición -->
                                <td>
                                    <button class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo $row['id']; ?>">Editar</button>
                                </td>
                                <td><a href="delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">Eliminar</a>
                                </td>
                            </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Agregar -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar productos -->
                    <form action="insertar.php" method="POST">
                        <div class="mb-3">
                            <label for="proveedor" class="form-label">Proveedor</label>
                            <input type="text" class="form-control" id="proveedor" name="proveedor" placeholder="Proveedor"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="cuil" class="form-label">CUIL</label>
                            <input type="text" class="form-control" id="cuil" name="cuil" placeholder="CUIL" required>
                        </div>
                        <div class="mb-3">
                            <label for="domicilio" class="form-label">Domicilio</label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio" placeholder="Domicilio"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        // Código PHP y HTML para generar los modales de edición
        $query = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($query)) {
    ?>
            <!-- Modal de Edición -->
            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Proveedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulario para editar productos -->
                            <form action="update.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <div class="mb-3">
                                    <label for="proveedor" class="form-label">Proveedor</label>
                                    <input type="text" class="form-control" id="proveedor" name="proveedor"
                                        placeholder="Proveedor" value="<?php echo $row['proveedor'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cuil" class="form-label">CUIL</label>
                                    <input type="text" class="form-control" id="cuil" name="cuil" placeholder="CUIL"
                                        value="<?php echo $row['cuil'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="domicilio" class="form-label">Domicilio</label>
                                    <input type="text" class="form-control" id="domicilio" name="domicilio"
                                        placeholder="Domicilio" value="<?php echo $row['domicilio'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono"
                                        placeholder="Teléfono" value="<?php echo $row['telefono'] ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php 
        }
    ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script>
        // Código JavaScript para abrir el modal de agregar
        var myModal = new bootstrap.Modal(document.getElementById('addProductModal'), {
            keyboard: false
        });

        document.getElementById('openAddProductModalBtn').addEventListener('click', function () {
            myModal.show();
        });

        // Código JavaScript para abrir los modales de edición
        <?php
            $query = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($query)) {
        ?>
                var editModal<?php echo $row['id']; ?> = new bootstrap.Modal(document.getElementById('editModal<?php echo $row['id']; ?>'), {
                    keyboard: false
                });

                document.getElementById('openEditModalBtn<?php echo $row['id']; ?>').addEventListener('click', function () {
                    editModal<?php echo $row['id']; ?>.show();
                });
        <?php 
            }
        ?>
    </script>
</body>

</html>

