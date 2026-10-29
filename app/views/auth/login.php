<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INICIO DE SESIÓN | PG</title>

    <link rel="icon" type="image/png" href="MEDIA/img/logo_site.png">
    <link rel="stylesheet" href="CSS/inicio.css">
</head>

<body>

    <header class="encabezado">
        <div class="logo">
            <img
                src="MEDIA/img/logo_alternativo_negro.png"
                alt="Logo Pogo Urbano"
                width="200"
            >
        </div>
    </header>

    <div class="contenedor">

        <section class="formulario">

            <h2>INICIAR SESIÓN</h2>

            <?php if (!empty($mensaje)): ?>
                <p id="msg" style="color:red;">
                    <?php echo htmlspecialchars($mensaje); ?>
                </p>
            <?php endif; ?>

            <form method="POST" action="index.php?page=login">

                <label for="correo">Correo electrónico</label>

                <input
                    type="email"
                    id="correo"
                    name="correo"
                    required
                >

                <label for="pass">Contraseña</label>

                <input
                    type="password"
                    id="pass"
                    name="pass"
                    required
                >

                <button type="button" id="registroBtn">
                    REGISTRARSE
                </button>

                <button type="submit">
                    INGRESAR
                </button>

            </form>

            <p class="volver-inicio">
                <a href="index.php">
                    ← Volver al Inicio
                </a>
            </p>

        </section>

    </div>

    <script>

        // =====================================
        // BOTÓN REGISTRO
        // =====================================

        document
            .getElementById("registroBtn")
            .addEventListener("click", function () {

                window.location.href = "index.php?page=registrarse";

            });

    </script>

</body>

</html>