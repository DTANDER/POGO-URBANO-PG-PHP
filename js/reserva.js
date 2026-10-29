
/* ============================================================
   PONER FECHA MÍNIMA = HOY
   ============================================================ */

const fecha =
    document.getElementById("fecha");


const hoy =
    new Date();


const año =
    hoy.getFullYear();


const mes =
    String(
        hoy.getMonth() + 1
    ).padStart(2, "0");


const dia =
    String(
        hoy.getDate()
    ).padStart(2, "0");


fecha.min =
    `${año}-${mes}-${dia}`;


/* ============================================================
   VALIDAR CANTIDAD DE PERSONAS
   ============================================================ */

document
    .getElementById("reserva")
    .addEventListener(
        "submit",
        function(event) {

            const personas =
                parseInt(
                    document
                        .getElementById("personas")
                        .value
                );


            if (personas <= 0) {

                event.preventDefault();

                alert(
                    "La cantidad de personas debe ser mayor a 0."
                );

            }

        }
    );

