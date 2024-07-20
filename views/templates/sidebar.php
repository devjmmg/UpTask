<aside class="sidebar">

    <div class="contenedor-sidebar">
        <h2>UpTask</h2>
        <div class="cerrar-menu">
            <img id="cerrar-menu" src="/build/img/close.svg" alt="close-mobile">
        </div>
    </div>

    <nav class="sidebar-nav">

        <a class="<?php echo $title === "Proyectos" ? "activo" : "" ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo $title === "Crear proyecto" ? "activo" : "" ?>" href="/create_project">Crear proyecto</a>
        <a class="<?php echo $title === "Perfil" ? "activo" : "" ?>" href="/profile">Perfil</a>

    </nav>

    <div class="close-sesion">
        <a href="/logout" >Cerrar sesión</a>
    </div>

</aside>