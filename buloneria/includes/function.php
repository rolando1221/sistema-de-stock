<?php
function conectar()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "comercio";

    $con = mysqli_connect($host, $user, $pass);

    if (!$con) {
        die("Error en la conexión: " . mysqli_connect_error());
    }

    mysqli_select_db($con, $bd);

    return $con;
}

function ejecutarConsulta($con, $sql)
{
    $query = mysqli_query($con, $sql);

    if (!$query) {
        die("Error en la consulta: " . mysqli_error($con));
    }

    return $query;
}

function iniciarSesion($correo, $contrasena)
{
    $conexion = conectar();

    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM usuarios WHERE correo_electronico = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Inicio de sesión exitoso
            // Almacenar información de sesión si es necesario
            return true;
        } else {
            return false; // Contraseña incorrecta
        }
    } else {
        return false; // Usuario no encontrado
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}
?>

