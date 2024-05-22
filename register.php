<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <title>Registro Creditux</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";     
        $dbname = "creditux";            

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $nombre = $_POST['nombre'];
        $numero = $_POST['numero'];
        $email = $_POST['email'];
        $cedula = $_POST['cedula'];
        $password = $_POST['password'];
        $confirmarPassword = $_POST['confirmar-password'];

        if ($password !== $confirmarPassword) {
            echo '<script>alert("Las contraseñas no coinciden."); window.location.href = "register.php";</script>';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre, numero, email, cedula, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nombre, $numero, $email, $cedula, $hashedPassword);

            if ($stmt->execute() === TRUE) {
                echo '<script>alert("Registro exitoso. ¡Bienvenido a Creditux!"); window.location.href = "login.html";</script>';
            } else {
                echo "Error al registrar: " . $stmt->error;
            }

            $stmt->close();
        }

        $conn->close();
    }
    ?>
    <div class="container">
        <form action="register.php" method="post" class="registro-form">
            <h2>Registro Creditux</h2>

            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="numero">Número de Teléfono:</label>
            <input type="tel" id="numero" name="numero" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="cedula">Número de Cédula:</label>
            <input type="text" id="cedula" name="cedula" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmar-password">Confirmar Contraseña:</label>
            <input type="password" id="confirmar-password" name="confirmar-password" required>

            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>
