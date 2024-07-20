<div class="contenedor crear">

    <?php include_once __DIR__ .  "/../templates/nombre-sitio.php";?>

    <div class="contenedor-sm">

        <p class="descripcion-pagina">Crear cuenta nueva</p>

        <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

        <form class="formulario" action="/create_account" method="POST">

            <div class="campo">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" placeholder="Ej. Juan Manuel" value="<?php echo s($usuario->nombre); ?>">
            </div>

            <div class="campo">
                <label for="apellidos">Apellidos: </label>
                <input type="text" name="apellidos" id="apellidos" placeholder="Ej. Martínez García" value="<?php echo s($usuario->apellidos); ?>">
            </div>

            <div class="campo">
                <label for="email">Correo electrónico: </label>
                <input type="email" name="email" id="email" placeholder="Ej. manuel@correo.com" value="<?php echo s($usuario->email); ?>">
            </div>

            <div class="campo">
                <label for="password">Contraseña: </label>
                <input type="password" name="password" id="password" placeholder="Escriba su contraseña">
            </div>

            <div class="campo">
                <label for="confirmar">Confirmar contraseña: </label>
                <input type="password" name="confirmar" id="confirmar" placeholder="Confirma su contraseña">
            </div>

            <input type="submit" value="Crear cuenta nueva" class="boton">

        </form>

        <div class="acciones">
            <a href="/">¿Tienes una cuenta? Inicia sesión</a>
            <a href="/forget_password">¿Olvidaste tu contraseña?</a>
        </div>

    </div>
    <!--.contenedor-sm-->

</div>
<!--.contenedor-->