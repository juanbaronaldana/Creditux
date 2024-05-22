<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="solicitarCredito.css">
  <title>Creditux</title>
</head>
<body>

  <img src="img/letras blancas sin fondo.png" alt="Logo" class="logo">

  <div class="container">
    <div class="form-container">
      <h2>Simulador de Crédito</h2>
      <form id="creditForm" action="" method="post">
        <label for="nombre">Nombre Completo:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" required>

        <label for="cedula">Número de Cédula:</label>
        <input type="text" id="cedula" name="cedula" value="<?php echo isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : ''; ?>" required>

        <label for="monto">Monto del Crédito:</label>
        <input type="number" id="monto" name="monto" value="<?php echo isset($_POST['monto']) ? htmlspecialchars($_POST['monto']) : ''; ?>" required>

        <label for="cuotas">Número de Cuotas:</label>
        <input type="number" id="cuotas" name="cuotas" value="<?php echo isset($_POST['cuotas']) ? htmlspecialchars($_POST['cuotas']) : ''; ?>" required>

        <label for="interes">Porcentaje de Interés (máximo 10%):</label>
        <input type="number" id="interes" name="interes" max="10" value="<?php echo isset($_POST['interes']) ? htmlspecialchars($_POST['interes']) : ''; ?>" required>

        <label for="frecuencia">Frecuencia de Pago:</label>
        <select id="frecuencia" name="frecuencia" required>
          <option value="quincenal" <?php echo (isset($_POST['frecuencia']) && $_POST['frecuencia'] == 'quincenal') ? 'selected' : ''; ?>>Quincenal</option>
          <option value="mensual" <?php echo (isset($_POST['frecuencia']) && $_POST['frecuencia'] == 'mensual') ? 'selected' : ''; ?>>Mensual</option>
          <option value="trimestral" <?php echo (isset($_POST['frecuencia']) && $_POST['frecuencia'] == 'trimestral') ? 'selected' : ''; ?>>Trimestral</option>
          <option value="cuatrimestral" <?php echo (isset($_POST['frecuencia']) && $_POST['frecuencia'] == 'cuatrimestral') ? 'selected' : ''; ?>>Cuatrimestral</option>
          <option value="semestral" <?php echo (isset($_POST['frecuencia']) && $_POST['frecuencia'] == 'semestral') ? 'selected' : ''; ?>>Semestral</option>
          <option value="anual" <?php echo (isset($_POST['frecuencia']) && $_POST['frecuencia'] == 'anual') ? 'selected' : ''; ?>>Anual</option>
        </select>

        <button type="submit">Simular Crédito</button>
        <button type="button" onclick="window.location.href='bienvenido.html'">Salir del Simulador</button>
      </form>
    </div>
    <div class="result-container" id="resultado">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $nombre = $_POST['nombre'];
          $correo = $_POST['correo'];
          $cedula = $_POST['cedula'];
          $monto = $_POST['monto'];
          $cuotas = $_POST['cuotas'];
          $interes = $_POST['interes'];
          $frecuencia = $_POST['frecuencia'];

          // Conversión del porcentaje de interés
          $interes = $interes / 100;

          // Determinación del interés y número de pagos según la frecuencia
          switch ($frecuencia) {
              case 'quincenal':
                  $r = $interes / 24; // Interés quincenal
                  $n = $cuotas * 2; // Número de pagos quincenales
                  break;
              case 'mensual':
                  $r = $interes / 12; // Interés mensual
                  $n = $cuotas; // Número de pagos mensuales
                  break;
              case 'trimestral':
                  $r = $interes / 4; // Interés trimestral
                  $n = ceil($cuotas / 3); // Número de pagos trimestrales
                  break;
              case 'cuatrimestral':
                  $r = $interes / 3; // Interés cuatrimestral
                  $n = ceil($cuotas / 4); // Número de pagos cuatrimestrales
                  break;
              case 'semestral':
                  $r = $interes / 2; // Interés semestral
                  $n = ceil($cuotas / 6); // Número de pagos semestrales
                  break;
              case 'anual':
                  $r = $interes; // Interés anual
                  $n = ceil($cuotas / 12); // Número de pagos anuales
                  break;
              default:
                  $r = $interes / 12; // Por defecto, mensual
                  $n = $cuotas;
                  break;
          }

          // Fórmula de la cuota fija: C = P * r * (1 + r)^n / [(1 + r)^n - 1]
          $cuota = $monto * $r * pow((1 + $r), $n) / (pow((1 + $r), $n) - 1);

          echo "<h2>Resultados de la Simulación</h2>";
          echo "<p>Nombre: $nombre</p>";
          echo "<p>Correo Electrónico: $correo</p>";
          echo "<p>Número de Cédula: $cedula</p>";
          echo "<p>Monto del Crédito: $monto</p>";
          echo "<p>Número de Cuotas: $cuotas</p>";
          echo "<p>Porcentaje de Interés: " . ($interes * 100) . "%</p>";
          echo "<p>Frecuencia de Pago: $frecuencia</p>";
          echo "<p>Cuota Fija: " . number_format($cuota, 2) . "</p>";
      }
      ?>
    </div>
  </div>
  
</body>
</html>
