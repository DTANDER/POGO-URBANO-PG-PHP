<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración | POGO URBANO</title>
  <link rel="icon" type="image/png" href="media/img/logo_site.png">
  <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="media/img/logo_2.png" alt="logo Pogo Urbano" width="200">
    </div>
    <h1>Panel de Administración</h1>
    <nav>
      <ul>
        <li><a href="index.php?page=admin_pedidos">Gestionar Pedidos</a></li>
        <li><a href="index.php?page=admin_reservas">Gestionar Reservas</a></li>
        <li><a href="index.php?page=admin_usuarios">Gestión de Usuarios</a></li>
        <li><a href="index.php?page=admin_reportes">Reportes</a></li>
        <li><a href="index.php?page=logout">Cerrar Sesión</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <p>Bienvenido, <?php echo htmlspecialchars($nombreAdmin); ?>. Aquí puedes gestionar pedidos, reservas, usuarios y ver reportes.</p>
  </main>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> Pogo Urbano. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
