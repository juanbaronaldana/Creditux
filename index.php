<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Login - Creditux</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "creditux";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                echo '<script>alert("Inicio de sesión exitoso. ¡Bienvenido a Creditux!"); window.location.href = "bienvenido.html";</script>';
            } else {
                echo '<script>alert("Contraseña incorrecta."); window.location.href = "index.php";</script>';
            }
        } else {
            echo '<script>alert("No existe una cuenta con este email."); window.location.href = "index.php";</script>';
        }

        $stmt->close();
        $conn->close();
    }
    ?>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="index.php" method="post">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input class="boton" type="submit" value="Iniciar Sesión">
        </form>
        <br>
        <h3>si no tienes cuenta por favor registrate</h3>
        <button onclick="window.location.href='register.php'">Registrarse</button>
    </div>
</body>
</html>
