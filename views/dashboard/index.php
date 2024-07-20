<?php include_once __DIR__ . "/header_dashboard.php"; ?>

<?php if(count($proyectos) === 0): ?>

<p class="no-proyectos">Aún no hay proyectos. <a href="/create_project">Comienza creando uno</a> </p>

<?php else: ?>

<ul class="listado-proyectos">

    <?php foreach($proyectos as $proyecto): ?>

    <li class="proyecto">
        <a href="/project?id=<?php echo($proyecto->url);?>">
            <?php echo $proyecto->proyecto ?>
        </a>
    </li>

    <?php endforeach; ?>

</ul>

<?php endif; ?>

<?php include_once __DIR__ . "/footer_dashboard.php"; ?>