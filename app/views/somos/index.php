<main class="pagina">

        <section class="parte1">

            <h1 class="titulo">
                SOMOS EL POGO
            </h1>

            <div class="texto1">

                <h2>El Pogo Urbano Restaurant</h2>

                <p>
                    Nace con la idea de transformar la experiencia gastronómica,
                    uniendo la calidad de la cocina con la facilidad del mundo digital.
                </p>

                <p>
                    Nuestro objetivo es que cada cliente disfrute no solo de un buen plato,
                    sino también de un acceso rápido, moderno y atractivo a nuestros servicios en línea.
                </p>

                <p>
                    El proyecto fue creado por
                    <strong>Charawi, Diezki, Chomby, Yaqui y Yexiz</strong>,
                    quienes impulsaron esta iniciativa con la visión de aportar innovación
                    al sector gastronómico en Medellín y proyectarlo hacia todo el país.
                </p>

                <p>
                    <strong>El Pogo</strong> fue hecho con el fin de facilitar los pedidos
                    en línea, brindar una atención cercana y generar un espacio virtual
                    llamativo que fidelice a nuestros clientes.
                </p>

                <p>
                    Creemos en la unión de la gastronomía y la tecnología como motor
                    de crecimiento y modernización de la industria culinaria.
                </p>

            </div>

        </section>


        <!-- BIOGRAFÍAS -->
        <section class="parte2">

            <h2 class="titulo2">
                BIOGRAFÍAS DE LOS QUE ARMARON EL POGO
            </h2>

            <div class="equipo">

                <?php foreach ($equipo as $miembro): ?>

                    <article class="tarjeta-miembro">

                        <h2 class="tituloC">
                            <?php echo htmlspecialchars($miembro['apodo']); ?>
                        </h2>

                        <h3>
                            <?php echo htmlspecialchars($miembro['nombre']); ?>
                        </h3>

                        <p class="textoC">
                            <?php echo htmlspecialchars($miembro['descripcion']); ?>
                        </p>

                    </article>

                <?php endforeach; ?>

            </div>

        </section>

    </main>
