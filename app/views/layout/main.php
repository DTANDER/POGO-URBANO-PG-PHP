<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($titulo ?? "Pogo Urbano"); ?></title>
  <link rel="icon" type="image/png" href="media/img/logo_site.png">

  <?php foreach (($css ?? []) as $hoja): ?>
  <link rel="stylesheet" href="<?php echo $hoja; ?>">
  <?php endforeach; ?>
</head>
<body>

  <header class="encabezado">

    <div class="logo">
      <img src="media/img/logo_2.png" alt="logo Pogo Urbano" width="200">
    </div>

    <!-- OJOS -->
    <div class="ojos-container">
      <div class="ojo"><div class="pupila"></div></div>
      <div class="ojo"><div class="pupila"></div></div>
    </div>

    <?php require __DIR__ . "/navbar.php"; ?>

  </header>

  <?php echo $contenido; ?>

  <?php foreach (($scripts ?? []) as $js): ?>
  <script src="<?php echo $js; ?>"></script>
  <?php endforeach; ?>

  <footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> Pogo Urbano. Todos los derechos reservados.</p>
  </footer>

</body>
</html>
