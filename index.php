<?php

// Primero cargar la clase Cliente
require_once "Cliente.php";

// Después iniciar la sesión
session_start();

// Inicializar clientes si no existen
if (!isset($_SESSION['clientes'])) {
    $_SESSION['clientes'] = [];
}

// Procesar operaciones
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $accion = $_POST['accion'];

    // REGISTRAR
    if ($accion == "crear") {

        $id = empty($_SESSION['clientes'])
            ? 1
            : max(array_keys($_SESSION['clientes'])) + 1;

        $cliente = new Cliente(
            $id,
            $_POST['nombre'],
            $_POST['apellido'],
            $_POST['correo'],
            $_POST['telefono']
        );

        $_SESSION['clientes'][$id] = $cliente;
    }

    // ACTUALIZAR
    if ($accion == "actualizar") {

        $id = $_POST['id'];

        if (isset($_SESSION['clientes'][$id])) {
            $_SESSION['clientes'][$id]->nombre = $_POST['nombre'];
            $_SESSION['clientes'][$id]->apellido = $_POST['apellido'];
            $_SESSION['clientes'][$id]->correo = $_POST['correo'];
            $_SESSION['clientes'][$id]->telefono = $_POST['telefono'];
        }
    }

    // ELIMINAR
    if ($accion == "eliminar") {

        $id = $_POST['id'];

        unset($_SESSION['clientes'][$id]);
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>REGISTRO CLIENTES</title>

    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            padding: 25px;
        }

        .contenedor {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        input {
            padding: 9px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 9px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            margin: 2px;
        }

        .registrar { background: green; }
        .actualizar { background: blue; }
        .eliminar { background: red; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #17365d;
            color: white;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>SISTEMA DE GESTIÓN DE CLIENTES</h1>

    <h2>Registrar nuevo cliente</h2>

    <form method="POST">

        <input type="hidden" name="accion" value="crear">

        <input type="text" name="nombre"
               placeholder="Nombre" required>

        <input type="text" name="apellido"
               placeholder="Apellido" required>

        <input type="email" name="correo"
               placeholder="Correo" required>

        <input type="text" name="telefono"
               placeholder="Teléfono" required>

        <button class="registrar" type="submit">
            Registrar cliente
        </button>

    </form>

    <h2>Lista de clientes</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($_SESSION['clientes'] as $cliente): ?>

        <tr>

            <td><?php echo $cliente->id; ?></td>

            <td>
                <input form="editar<?php echo $cliente->id; ?>"
                       name="nombre"
                       value="<?php echo htmlspecialchars($cliente->nombre); ?>"
                       required>
            </td>

            <td>
                <input form="editar<?php echo $cliente->id; ?>"
                       name="apellido"
                       value="<?php echo htmlspecialchars($cliente->apellido); ?>"
                       required>
            </td>

            <td>
                <input form="editar<?php echo $cliente->id; ?>"
                       type="email"
                       name="correo"
                       value="<?php echo htmlspecialchars($cliente->correo); ?>"
                       required>
            </td>

            <td>
                <input form="editar<?php echo $cliente->id; ?>"
                       name="telefono"
                       value="<?php echo htmlspecialchars($cliente->telefono); ?>"
                       required>
            </td>

            <td>

                <form method="POST"
                      id="editar<?php echo $cliente->id; ?>">

                    <input type="hidden" name="id"
                           value="<?php echo $cliente->id; ?>">

                    <button type="submit"
                            name="accion"
                            value="actualizar"
                            class="actualizar">
                        Actualizar
                    </button>

                </form>

                <form method="POST">

                    <input type="hidden" name="id"
                           value="<?php echo $cliente->id; ?>">

                    <button type="submit"
                            name="accion"
                            value="eliminar"
                            class="eliminar"
                            onclick="return confirm('¿Desea eliminar este cliente?')">
                        Eliminar
                    </button>

                </form>

            </td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
