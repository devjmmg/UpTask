<div class="barra-mobile">
    <h1>UpTask</h1>

    <div class="menu-mobile">
        <img id="mobile" src="/build/img/menu.svg" alt="menu-mobile">
    </div>

</div>

<div class="barra">
    <p>Hola: <span><?php echo($_SESSION["nombre"] . " " . $_SESSION["apellido"]); ?></span></p>

    <a href="/logout" class="cerrar-sesion">Cerrar sesión</a>
</div>