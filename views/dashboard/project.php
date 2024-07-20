<?php include_once __DIR__ . "/header_dashboard.php"; ?>

<div class="contenedor-sm">

    <div class="nueva-tarea">
        <button type="button" class="agregar-tarea" id="agregar-tarea">&#43; Nueva Tarea</button>
    </div>

    <div class="filtros" id="filtros">
        <div class="filtros-inputs">
        <h2>Filtros:</h2>
            <div class="campo">
                <label for="todas">Todas</label>
                <input type="radio" id="todas" name="filtro" value="" checked>
            </div>

            <div class="campo">
                <label for="pendiente">Pendiente</label>
                <input type="radio" id="pendiente" name="filtro" value="0">
            </div>

            <div class="campo">
                <label for="completa">Completa</label>
                <input type="radio" id="completa" name="filtro" value="1">
            </div>
        </div>
    </div>

    <ul class="listar-tareas" id="listar-tareas"></ul>

    <?php include_once __DIR__ . "/footer_dashboard.php"; ?>

    <?php 

$script .= "
<script src='/build/js/tareas.js'></script>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
";