<div class="contenedor login">

    <?php include_once __DIR__ .  "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">

        <p class="descripcion-pagina">Iniciar Sesión</p>

        <?php include_once __DIR__ .  "/../templates/alertas.php"; ?>

        <form class="formulario" action="/" method="POST">

            <div class="campo">
                <label for="email">Correo electrónico: </label>
                <input type="email" name="email" id="email" placeholder="Ej. correo@corre.com"
                    value="<?php echo s($usuario->email); ?>">
            </div>

            <div class="campo">
                <label for="password">Contraseña: </label>
                <input type="password" name="password" id="password" placeholder="Escriba su contraseña">
            </div>

            <input type="submit" value="Iniciar Sesión" class="boton">

        </form>

        <div class="acciones">
            <a href="/create_account">¿No tienes una cuenta? Regístrate</a>
            <a href="/forget_password">¿Olvidaste tu contraseña?</a>
        </div>

    </div>
    <!--.contenedor-sm-->

</div>
<!--.contenedor-->