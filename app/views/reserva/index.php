<div class="contenedor">


    <!-- ======================================================
         RESERVACIÓN
         ====================================================== -->

    <section class="reservacion">

        <h2>
            RESERVACIONES
        </h2>


        <!-- ==================================================
             RESERVA EXITOSA
             ================================================== -->

        <?php if ($reservaExitosa): ?>

            <p class="mensaje-exito">

                ¡Reserva realizada con éxito!

                Gracias por elegir Pogo Urbano.

            </p>

        <?php endif; ?>


        <!-- ==================================================
             ERRORES
             ================================================== -->

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



        <!-- ==================================================
             FORMULARIO
             ================================================== -->

        <form
            id="reserva"
            method="POST"
            action="index.php?page=reserva"
        >


            <!-- NOMBRE -->

            <label for="nombre">
                NOMBRE
            </label>


            <input
                type="text"
                id="nombre"
                value="<?php
                    echo htmlspecialchars(
                        $nombreUsuario
                    );
                ?>"
                readonly
            >



            <!-- CANTIDAD PERSONAS -->

            <label for="personas">
                CANTIDAD DE PERSONAS
            </label>


            <input
                type="number"
                id="personas"
                name="personas"
                min="1"
                max="100"
                required
            >



            <!-- TELÉFONO -->

            <label for="telefono">
                TELÉFONO DE CONTACTO
            </label>


            <input
                type="tel"
                id="telefono"
                value="<?php
                    echo htmlspecialchars(
                        $telefonoUsuario
                    );
                ?>"
                readonly
            >



            <!-- FECHA -->

            <label for="fecha">
                FECHA
            </label>


            <input
                type="date"
                id="fecha"
                name="fecha"
                required
            >



            <!-- HORA -->

            <label for="hora">
                HORA
            </label>


            <input
                type="time"
                id="hora"
                name="hora"
                min="12:00"
                max="23:00"
                required
            >



            <!-- MESA -->

            <label for="mesa">
                MESA
            </label>


            <select
                id="mesa"
                name="mesa"
                required
            >

                <option value="">
                    Seleccione una mesa...
                </option>


                <option value="1">
                    Mesa 1
                </option>


                <option value="2">
                    Mesa 2
                </option>


                <option value="3">
                    Mesa 3
                </option>


                <option value="4">
                    Mesa 4
                </option>


                <option value="5">
                    Mesa 5
                </option>


                <option value="6">
                    Mesa 6
                </option>


                <option value="7">
                    Mesa 7
                </option>


                <option value="8">
                    Mesa 8
                </option>


                <option value="9">
                    Mesa 9
                </option>


                <option value="10">
                    Mesa 10
                </option>

            </select>



            <!-- BOTÓN -->

            <button
                type="submit"
            >

                FINALIZAR RESERVA

            </button>


        </form>

    </section>



    <!-- ======================================================
         INFORMACIÓN
         ====================================================== -->

    <section class="informacion">

        <h3>
            Después de las 30 personas
            se hace un descuento del 10%
        </h3>


        <h3>
            Amor, sazón y sabor bacano
            en cada bocado.
        </h3>


        <p>

            Selecciona una fecha,
            una hora y una mesa disponible.

        </p>

    </section>


</div>
