<div class="contenedor restablecer">

    <?php include_once __DIR__ .  "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">

        <?php include_once __DIR__ .  "/../templates/alertas.php"; ?>

        <?php if($mostrar): ?>

        <p class="descripcion-pagina">Restablecer mi contraseña</p>

        <form class="formulario" method="POST">

            <div class="campo">
                <label for="password">Contraseña: </label>
                <input type="password" name="password" id="password" placeholder="Escriba su contraseña">
            </div>

            <div class="campo">
                <label for="confirmar">Confirmar contraseña: </label>
                <input type="password" name="confirmar" id="confirmar" placeholder="Confirma su contraseña">
            </div>

            <input type="submit" value="Restablecer password" class="boton">

        </form>

        <?php endif; ?>

        <div class="acciones">
            <a href="/">¿Tienes una cuenta? Inicia sesión</a>
            <a href="/create_account">¿No tienes una cuenta? Regístrate</a>
        </div>

    </div>
    <!--.contenedor-sm-->

</div>
<!--.contenedor-->