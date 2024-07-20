<?php include_once __DIR__ . "/header_dashboard.php"; ?>

<div class="contenedor-sm">

    <a class="boton" href="/change_password">Cambiar contraseña</a>

    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

    <form class="formulario" method="POST">

        <div class="campo">
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" placeholder="Ej. Juan Manuel"
                value="<?php echo s($usuario->nombre); ?>">
        </div>

        <div class="campo">
            <label for="apellidos">Apellidos: </label>
            <input type="text" name="apellidos" id="apellidos" placeholder="Ej. Martínez García"
                value="<?php echo s($usuario->apellidos); ?>">
        </div>

        <div class="campo">
            <label for="email">Correo electrónico: </label>
            <input type="email" name="email" id="email" placeholder="Ej. manuel@correo.com"
                value="<?php echo s($usuario->email); ?>">
        </div>

        <input type="submit" value="Guardar">

    </form>

</div>

<?php include_once __DIR__ . "/footer_dashboard.php"; ?>