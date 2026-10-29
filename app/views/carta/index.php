  <!-- Datos que lee js/carta.js -->
  <div id="cartaDatos"
       data-logueado="<?php echo $logueado ? '1' : '0'; ?>"
       data-url-pedido="index.php?page=pedido_crear"
       hidden></div>

  <div class="carta">

    <?php if ($error !== ""): ?>

      <p><?php echo htmlspecialchars($error); ?></p>

    <?php elseif (empty($categorias)): ?>

      <p>No hay productos disponibles actualmente.</p>

    <?php else: ?>

      <?php foreach ($categorias as $nombreCategoria => $platillos): ?>

        <h2><?php echo htmlspecialchars($nombreCategoria); ?></h2>

        <div class="carta-grid">

          <?php foreach ($platillos as $platillo): ?>

            <?php
              $img = $imagenes[$platillo["nombre"]] ?? $imagenDefecto;
            ?>

            <article
              class="plato"
              data-id="<?php echo $platillo["id_producto"]; ?>"
              data-nombre="<?php echo htmlspecialchars($platillo["nombre"], ENT_QUOTES); ?>"
              data-precio="<?php echo floatval($platillo["precio"]); ?>"
            >

              <span class="badge-cantidad" hidden></span>

              <div class="plato-img">
                <img
                  src="<?php echo htmlspecialchars($img); ?>"
                  alt="<?php echo htmlspecialchars($platillo["nombre"]); ?>"
                  onerror="this.onerror=null; this.src='<?php echo $imagenDefecto; ?>';"
                >
              </div>

              <div class="plato-info">
                <h3 class="plato-nombre"><?php echo htmlspecialchars($platillo["nombre"]); ?></h3>
                <span class="plato-precio"><?php echo formatearPrecio($platillo["precio"]); ?></span>
              </div>

              <button type="button" class="btn-agregar">
                + Agregar
              </button>

            </article>

          <?php endforeach; ?>

        </div>

      <?php endforeach; ?>

    <?php endif; ?>

  </div>


  <!-- ========================================================
       BOTÓN FLOTANTE DEL CARRITO
       ======================================================== -->

  <button type="button" class="carrito-flotante" id="abrirCarrito">
    🛒 Ver carrito
    <span id="carritoContador">0</span>
  </button>


  <!-- ========================================================
       PANEL DEL CARRITO (DERECHA)
       ======================================================== -->

  <div class="overlay" id="overlay"></div>

  <aside class="drawer" id="drawer" aria-hidden="true">

    <div class="drawer-header">
      <h2>Tu Carrito</h2>

      <button
        type="button"
        class="drawer-cerrar"
        id="cerrarCarrito"
        aria-label="Cerrar carrito"
      >✕</button>
    </div>


    <form id="formPedido" class="drawer-form">

      <div class="drawer-cuerpo">

        <!-- Mensaje de éxito o error -->
        <div class="mensaje" id="mensajePedido" hidden></div>

        <!-- Carrito vacío -->
        <p class="carrito-vacio" id="carritoVacio">
          Tu carrito está vacío.<br>
          Agrega productos desde la carta.
        </p>

        <!-- Lista de productos -->
        <ul class="carrito-lista" id="carritoLista"></ul>

        <button type="button" class="btn-vaciar" id="vaciarCarrito" hidden>
          🗑 Vaciar carrito
        </button>


        <!-- Datos de entrega -->
        <div id="datosPedido" hidden>

          <h3 class="drawer-subtitulo">Datos de entrega</h3>

          <?php if ($logueado): ?>

            <label for="pedidoNombre">Nombre</label>
            <input
              type="text"
              id="pedidoNombre"
              value="<?php echo htmlspecialchars($nombreUsuario); ?>"
              readonly
            >

            <label for="pedidoTelefono">Teléfono</label>
            <input
              type="tel"
              id="pedidoTelefono"
              value="<?php echo htmlspecialchars($telefonoUsuario); ?>"
              readonly
            >

            <label for="direccion">Dirección</label>
            <input
              type="text"
              id="direccion"
              placeholder="Ingrese su dirección"
              required
            >

            <label for="pago">Medio de pago</label>
            <select id="pago" required>
              <option value="">Seleccione...</option>
              <option value="Efectivo">Efectivo</option>
              <option value="Tarjeta">Tarjeta</option>
              <option value="Nequi">Nequi</option>
              <option value="Daviplata">Daviplata</option>
              <option value="Bancolombia">Bancolombia</option>
            </select>

          <?php else: ?>

            <p class="aviso-login">
              Para finalizar tu pedido debes iniciar sesión.
              Tu carrito se guardará mientras tanto.
            </p>

          <?php endif; ?>

        </div>

      </div>


      <!-- Total + botón -->
      <div class="drawer-pie" id="pieCarrito" hidden>

        <div class="carrito-total">
          <span>Total</span>
          <span id="totalValor">$0</span>
        </div>

        <?php if ($logueado): ?>

          <button type="submit" class="btn-finalizar" id="btnFinalizar">
            FINALIZAR PEDIDO
          </button>

        <?php else: ?>

          <a href="index.php?page=login" class="btn-finalizar">
            INICIAR SESIÓN PARA PEDIR
          </a>

        <?php endif; ?>

      </div>

    </form>

  </aside>
