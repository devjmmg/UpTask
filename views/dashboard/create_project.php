<?php include_once __DIR__ . "/header_dashboard.php"; ?>

<div class="contenedor-sm">

    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

    <form class="formulario" action="/create_project" method="POST">

        <?php include_once __DIR__ . "/formulario_proyecto.php" ?>

        <input type="submit" value="Guardar" class="boton">

    </form>

</div>

<?php include_once __DIR__ . "/footer_dashboard.php"; ?>