<?php include_once __DIR__ . "/header_dashboard.php"; ?>

<div class="contenedor-sm">

    <a class="boton" href="/profile">Regresar</a>

    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

    <form class="formulario" method="POST">

        <div class="campo">
            <label for="current_password">Contraseña actual: </label>
            <input type="password" name="current_password" id="current_password" placeholder="Escriba su contraseña actual">
        </div>

        <div class="campo">
            <label for="new_password">Nueva contraseña: </label>
            <input type="password" name="new_password" id="new_password" placeholder="Escriba su contraseña">
        </div>

        <div class="campo">
            <label for="confirmar">Confirmar contraseña: </label>
            <input type="password" name="confirmar" id="confirmar" placeholder="Confirma su contraseña">
        </div>

        <input type="submit" value="Guardar">

    </form>

</div>

<?php include_once __DIR__ . "/footer_dashboard.php"; ?>