<div class="contenedor olvidar">

    <?php include_once __DIR__ .  "/../templates/nombre-sitio.php"; ?>

    <div class="contenedor-sm">

    <?php include_once __DIR__ .  "/../templates/alertas.php"; ?>

        <p class="descripcion-pagina">¿Olvidaste tu contraseña?</p>

        <form class="formulario" action="/forget_password" method="POST">

            <div class="campo">
                <label for="email">Correo electrónico: </label>
                <input type="email" name="email" id="email" placeholder="Ej. manuel@correo.com">
            </div>

            <input type="submit" value="Enviar enlace de recuperación" class="boton">

        </form>

        <div class="acciones">
            <a href="/">¿Tienes una cuenta? Inicia sesión</a>
            <a href="/create_account">¿No tienes una cuenta? Regístrate</a>
        </div>

    </div>
    <!--.contenedor-sm-->

</div>
<!--.contenedor-->