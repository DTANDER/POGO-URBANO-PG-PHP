
/* ============================================================
   CARRITO (se guarda en el navegador)
   Cada elemento: { id, nombre, precio, cantidad }
   ============================================================ */

const CLAVE_CARRITO = "carritoPogo";
const DATOS_CARTA = document.getElementById("cartaDatos").dataset;
const LOGUEADO    = DATOS_CARTA.logueado === "1";
const URL_PEDIDO  = DATOS_CARTA.urlPedido;

const drawer        = document.getElementById("drawer");
const overlay       = document.getElementById("overlay");
const carritoLista  = document.getElementById("carritoLista");
const carritoVacio  = document.getElementById("carritoVacio");
const datosPedido   = document.getElementById("datosPedido");
const pieCarrito    = document.getElementById("pieCarrito");
const totalValor    = document.getElementById("totalValor");
const contador      = document.getElementById("carritoContador");
const btnVaciar     = document.getElementById("vaciarCarrito");
const formPedido    = document.getElementById("formPedido");
const mensajePedido = document.getElementById("mensajePedido");
const tarjetas      = document.querySelectorAll(".plato");

let carrito = leerCarrito();


function leerCarrito() {
    try {
        return JSON.parse(localStorage.getItem(CLAVE_CARRITO)) || [];
    } catch (e) {
        return [];
    }
}

function guardarCarrito() {
    try {
        localStorage.setItem(CLAVE_CARRITO, JSON.stringify(carrito));
    } catch (e) {}
}

function formatearPrecio(valor) {
    return "$" + Math.round(valor).toLocaleString("es-CO");
}


/* ============================================================
   ABRIR Y CERRAR EL PANEL
   ============================================================ */

function abrirCarrito() {
    drawer.classList.add("abierto");
    overlay.classList.add("activo");
    drawer.setAttribute("aria-hidden", "false");
    document.body.classList.add("sin-scroll");
}

function cerrarCarrito() {
    drawer.classList.remove("abierto");
    overlay.classList.remove("activo");
    drawer.setAttribute("aria-hidden", "true");
    document.body.classList.remove("sin-scroll");
}

document.getElementById("abrirCarrito").addEventListener("click", abrirCarrito);
document.getElementById("cerrarCarrito").addEventListener("click", cerrarCarrito);
overlay.addEventListener("click", cerrarCarrito);

document.addEventListener("keydown", function(evento) {
    if (evento.key === "Escape") {
        cerrarCarrito();
    }
});


/* ============================================================
   MENSAJES DENTRO DEL PANEL
   ============================================================ */

function mostrarMensaje(texto, tipo) {
    mensajePedido.textContent = texto;
    mensajePedido.className = "mensaje " + tipo;
    mensajePedido.hidden = false;
}

function ocultarMensaje() {
    mensajePedido.hidden = true;
}


/* ============================================================
   AGREGAR PRODUCTO (botón "Agregar" de la carta)
   ============================================================ */

document.querySelectorAll(".btn-agregar").forEach(function(boton) {

    boton.addEventListener("click", function() {

        const tarjeta = this.closest(".plato");

        const id     = parseInt(tarjeta.dataset.id);
        const nombre = tarjeta.dataset.nombre;
        const precio = parseFloat(tarjeta.dataset.precio);

        const existente = carrito.find(function(p) {
            return p.id === id;
        });

        if (existente) {
            existente.cantidad++;
        } else {
            carrito.push({
                id: id,
                nombre: nombre,
                precio: precio,
                cantidad: 1
            });
        }

        ocultarMensaje();
        dibujarCarrito();


        /* Confirmación en el botón */

        this.textContent = "✓ Agregado";

        setTimeout(function() {
            boton.textContent = "+ Agregar";
        }, 800);

    });

});


/* ============================================================
   BOTONES + / − / QUITAR DENTRO DEL CARRITO
   ============================================================ */

carritoLista.addEventListener("click", function(evento) {

    const boton = evento.target.closest("button[data-accion]");

    if (!boton) {
        return;
    }

    const id     = parseInt(boton.dataset.id);
    const accion = boton.dataset.accion;

    const item = carrito.find(function(p) {
        return p.id === id;
    });

    if (!item) {
        return;
    }

    if (accion === "sumar") {
        item.cantidad++;
    }

    if (accion === "restar") {
        item.cantidad--;
    }

    if (accion === "quitar" || item.cantidad <= 0) {
        carrito = carrito.filter(function(p) {
            return p.id !== id;
        });
    }

    dibujarCarrito();

});


/* ============================================================
   VACIAR CARRITO
   ============================================================ */

btnVaciar.addEventListener("click", function() {

    if (confirm("¿Quieres quitar todos los productos del carrito?")) {
        carrito = [];
        dibujarCarrito();
    }

});


/* ============================================================
   DIBUJAR EL CARRITO
   ============================================================ */

function dibujarCarrito() {

    carritoLista.innerHTML = "";

    let total = 0;
    let unidades = 0;


    carrito.forEach(function(item) {

        const subtotal = item.precio * item.cantidad;

        total += subtotal;
        unidades += item.cantidad;


        const li = document.createElement("li");
        li.className = "carrito-item";


        const nombre = document.createElement("span");
        nombre.className = "carrito-nombre";
        nombre.textContent = item.nombre;


        const controles = document.createElement("div");
        controles.className = "carrito-controles";

        controles.appendChild(crearBoton("−", "restar", item.id));

        const cantidad = document.createElement("span");
        cantidad.className = "carrito-cantidad";
        cantidad.textContent = item.cantidad;
        controles.appendChild(cantidad);

        controles.appendChild(crearBoton("+", "sumar", item.id));


        const precio = document.createElement("span");
        precio.className = "carrito-subtotal";
        precio.textContent = formatearPrecio(subtotal);


        const quitar = crearBoton("✕", "quitar", item.id);
        quitar.className = "btn-quitar";
        quitar.title = "Quitar del carrito";


        li.appendChild(nombre);
        li.appendChild(controles);
        li.appendChild(precio);
        li.appendChild(quitar);

        carritoLista.appendChild(li);

    });


    const hayProductos = carrito.length > 0;

    carritoVacio.hidden  = hayProductos;
    datosPedido.hidden   = !hayProductos;
    pieCarrito.hidden    = !hayProductos;
    btnVaciar.hidden     = !hayProductos;

    totalValor.textContent = formatearPrecio(total);
    contador.textContent   = unidades;


    guardarCarrito();
    actualizarTarjetas();

}


function crearBoton(texto, accion, id) {

    const boton = document.createElement("button");

    boton.type = "button";
    boton.className = "btn-cantidad";
    boton.textContent = texto;
    boton.dataset.accion = accion;
    boton.dataset.id = id;

    return boton;
}


/* ============================================================
   CANTIDAD SOBRE CADA TARJETA DE LA CARTA
   ============================================================ */

function actualizarTarjetas() {

    tarjetas.forEach(function(tarjeta) {

        const id = parseInt(tarjeta.dataset.id);
        const badge = tarjeta.querySelector(".badge-cantidad");

        const item = carrito.find(function(p) {
            return p.id === id;
        });

        if (item) {
            badge.textContent = "x" + item.cantidad;
            badge.hidden = false;
            tarjeta.classList.add("en-pedido");
        } else {
            badge.hidden = true;
            tarjeta.classList.remove("en-pedido");
        }

    });

}


/* ============================================================
   FINALIZAR PEDIDO
   ============================================================ */

formPedido.addEventListener("submit", async function(evento) {

    evento.preventDefault();

    if (!LOGUEADO) {
        return;
    }

    if (carrito.length === 0) {
        mostrarMensaje("Tu carrito está vacío.", "error");
        return;
    }

    const boton = document.getElementById("btnFinalizar");

    boton.disabled = true;
    boton.textContent = "Enviando...";

    try {

        const respuesta = await fetch(URL_PEDIDO, {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({
                direccion: document.getElementById("direccion").value,
                pago: document.getElementById("pago").value,
                productos: carrito.map(function(item) {
                    return {
                        id: item.id,
                        cantidad: item.cantidad
                    };
                })
            })

        });

        const datos = await respuesta.json();

        if (datos.ok) {

            carrito = [];
            formPedido.reset();
            dibujarCarrito();

            mostrarMensaje(datos.mensaje, "exito");

        } else {

            mostrarMensaje(datos.mensaje, "error");

        }

    } catch (error) {

        mostrarMensaje(
            "No se pudo conectar con el servidor. Intenta de nuevo.",
            "error"
        );

    }

    boton.disabled = false;
    boton.textContent = "FINALIZAR PEDIDO";

});


/* Dibujar el carrito guardado al abrir la página */

dibujarCarrito();

