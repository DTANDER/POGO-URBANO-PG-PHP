<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registrarse | Pogo Urbano</title>

    <link
        rel="stylesheet"
        href="CSS/registrarse.css"
    >

    <link
        rel="icon"
        type="image/png"
        href="media/img/logo_site.png"
    >

</head>


<body>


<div class="contenedor">


    <div class="caja-registro">


        <img
            src="media/img/logo_2.png"
            alt="Logo Pogo Urbano"
            class="logo"
        >


        <h2>
            Crear Cuenta
        </h2>


        <!-- =====================================================
             MENSAJE DE ÉXITO
             ===================================================== -->

        <?php if ($registroExitoso): ?>

            <p class="mensaje-exito">

                ¡Registro exitoso!
                Ya puedes iniciar sesión.

            </p>

        <?php endif; ?>


        <!-- =====================================================
             MENSAJES DE ERROR
             ===================================================== -->

        <?php if (!empty($errores)): ?>

            <div class="mensaje-error">

                <?php foreach ($errores as $error): ?>

                    <p>

                        <?php
                        echo htmlspecialchars($error);
                        ?>

                    </p>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <!-- =====================================================
             FORMULARIO
             ===================================================== -->

        <form
            id="registroForm"
            method="POST"
            action="index.php?page=registrarse"
        >


            <!-- NOMBRE -->

            <label for="nombre">
                Nombre Completo
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Ingrese su nombre"
                value="<?php
                    echo htmlspecialchars(
                        $valores["nombre"] ?? ""
                    );
                ?>"
                required
            >


            <!-- CORREO -->

            <label for="correo">
                Correo Electrónico
            </label>

            <input
                type="email"
                id="correo"
                name="correo"
                placeholder="Ingrese su correo"
                value="<?php
                    echo htmlspecialchars(
                        $valores["correo"] ?? ""
                    );
                ?>"
                required
            >


            <!-- TELÉFONO -->

            <label for="telefono">
                Teléfono
            </label>

            <input
                type="tel"
                id="telefono"
                name="telefono"
                placeholder="Ingrese su teléfono"
                value="<?php
                    echo htmlspecialchars(
                        $valores["telefono"] ?? ""
                    );
                ?>"
                required
            >


            <!-- CONTRASEÑA -->

            <label for="password">
                Contraseña
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Ingrese una contraseña"
                required
            >


            <!-- CONFIRMAR CONTRASEÑA -->

            <label for="confirmar">
                Confirmar Contraseña
            </label>

            <input
                type="password"
                id="confirmar"
                name="confirmar"
                placeholder="Confirme la contraseña"
                required
            >


            <!-- BOTÓN -->

            <button type="submit">

                REGISTRARSE

            </button>


        </form>


        <!-- =====================================================
             VOLVER AL LOGIN
             ===================================================== -->

        <p class="volver">

            ¿Ya tienes una cuenta?

            <a href="index.php?page=login">
                Iniciar sesión
            </a>

        </p>


    </div>

</div>


<script>

/* ============================================================
   VALIDACIÓN DE CONTRASEÑAS
   ============================================================ */

document
    .getElementById("registroForm")
    .addEventListener(
        "submit",
        function(event) {

            const password =
                document.getElementById(
                    "password"
                ).value;


            const confirmar =
                document.getElementById(
                    "confirmar"
                ).value;


            if (password !== confirmar) {

                event.preventDefault();

                alert(
                    "Las contraseñas no coinciden."
                );

            }

        }
    );


/* ============================================================
   SOLO NÚMEROS EN TELÉFONO
   ============================================================ */

document
    .getElementById("telefono")
    .addEventListener(
        "input",
        function() {

            this.value =
                this.value.replace(
                    /[^0-9]/g,
                    ""
                );

        }
    );

</script>


</body>

</html>