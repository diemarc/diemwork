<h3>Total: <?php echo $total; ?></h3>
<ul class="pager">
    <?php if ($param_ofset > 0) { ?>
        <li>
            <a href="<?php echo $btn_anterior; ?>">Anterior</a>
        </li>
    <?php } ?> 
    <?php if ($siguiente <= $total) { ?>
        <li>
            <a href="<?php echo $btn_siguiente; ?>">Siguiente</a>
        </li>
    <?php } ?>
</ul>
