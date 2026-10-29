<nav class="menu">
    <ul>

        <li><a href="index.php?page=inicio">Inicio</a></li>

        <li><a href="index.php?page=reserva">Reservas</a></li>

        <li><a href="index.php?page=contacto">Contáctanos</a></li>

        <li><a href="index.php?page=somos">Quiénes somos</a></li>

        <li><a href="index.php?page=carta">Nuestra Carta</a></li>

        <?php if ((int) ($_SESSION['rol'] ?? 0) === Usuario::ROL_ADMIN): ?>
        <li><a href="index.php?page=admin">Panel admin</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['id_usuario'])): ?>

        <li class="perfil">

            <button type="button" id="perfilBoton">
                Perfil ▾
            </button>

            <div class="perfil-ventana" id="perfilVentana">

                <h3>Mi perfil</h3>

                <p>
                    <strong>Nombre:</strong><br>
                    <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'No disponible'); ?>
                </p>

                <hr>

                <a href="index.php?page=logout" class="cerrar-sesion">
                    Cerrar sesión
                </a>

            </div>

        </li>

        <?php else: ?>

        <li><a href="index.php?page=login">Iniciar sesión</a></li>

        <?php endif; ?>

    </ul>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const boton = document.getElementById("perfilBoton");
    const ventana = document.getElementById("perfilVentana");

    if (boton && ventana) {
        boton.addEventListener("click", function () {
            ventana.style.display =
                ventana.style.display === "block" ? "none" : "block";
        });
    }

});

// Si el navegador muestra la página guardada al darle "atrás",
// la recargamos para que refleje el estado real de la sesión.
window.addEventListener("pageshow", function (evento) {
    if (evento.persisted) {
        window.location.reload();
    }
});
</script>
