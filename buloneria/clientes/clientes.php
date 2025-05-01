<?php 
   include("../includes/function.php");
    $con = conectar();

    $sql = "SELECT * FROM clientes";
    $query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="s">
<head>
    <title>PAGINA CLIENTES</title>
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
        <a id="openAddClientModalBtn" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#addClientModal">Nuevo registro</a>
        <form action="volver">
            <h1><a class="btn btn-primary" href="../index.php?" type="submit">Inicio</a></h1>
        </form>

        <div class="container">
            <table class="table">
                <thead class="table-success table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>DNI</th>
                        <th>Saldo</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        while ($row = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $row['idcliente'] ?></td>
                            <td><?php echo $row['nombre'] ?></td>
                            <td><?php echo $row['apellido'] ?></td>
                            <td><?php echo $row['direccion'] ?></td>
                            <td><?php echo $row['correo'] ?></td>
                            <td><?php echo $row['telefono'] ?></td>
                            <td><?php echo $row['dni'] ?></td>
                            <td><?php echo $row['saldo'] ?></td>

                            <!-- Botón para abrir el modal de edición -->
                            <td>
                                <button class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#editClientModal<?php echo $row['idcliente']; ?>">Editar</button>
                            </td>
                            <td><a href="delete.php?idcliente=<?php echo $row['idcliente'] ?>"
                                    class="btn btn-danger">Eliminar</a></td>
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
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
    <!-- Formulario para agregar clientes -->
    <form action="insertar.php" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" required>
        </div>
        <!-- Agrega el campo de correo en el formulario -->
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
        </div>
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI" required>
        </div>
        <div class="mb-3">
            <label for="saldo" class="form-label">Saldo</label>
            <input type="text" class="form-control" id="saldo" name="saldo" placeholder="Saldo" required>
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
    <div class="modal fade" id="editClientModal<?php echo $row['idcliente']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para editar clientes -->
                    <form action="update.php" method="POST">
                        <input type="hidden" name="idcliente" value="<?php echo $row['idcliente']; ?>">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $row['nombre']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo $row['apellido']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" value="<?php echo $row['direccion']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" value="<?php echo $row['correo']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="<?php echo $row['telefono']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI" value="<?php echo $row['dni']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="saldo" class="form-label">Saldo</label>
                            <input type="text" class="form-control" id="saldo" name="saldo" placeholder="Saldo" value="<?php echo $row['saldo']; ?>" required>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

<script>
    // JavaScript code to open the add modal
    var addClientModal = new bootstrap.Modal(document.getElementById('addClientModal'), {
        keyboard: false
    });

    document.getElementById('openAddClientModalBtn').addEventListener('click', function () {
        addClientModal.show();
    });

    // JavaScript code to open edit modals
    <?php
        $query = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($query)) {
    ?>
    var editClientModal<?php echo $row['idcliente']; ?> = new bootstrap.Modal(document.getElementById('editClientModal<?php echo $row['idcliente']; ?>'), {
        keyboard: false
    });

    document.getElementById('openEditClientModalBtn<?php echo $row['idcliente']; ?>').addEventListener('click', function () {
        editClientModal<?php echo $row['idcliente']; ?>.show();
    });
    <?php 
        }
    ?>
</script>
</body>
</html>

