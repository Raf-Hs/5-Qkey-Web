<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<obj>
	<resultado><?= $resultado == 1 ? "VERDADERO" : "FALSO" ?></resultado>
    <mensaje><?= $mensaje ?></mensaje>
<?php
if ( $promociones != NULL ) :
?>
	<promociones>
<?php
	foreach ( $promociones as $row ) :
?>
		<promocion>
    <?php
        foreach($row as $campo => $valor) :
    ?>
        <<?= $campo ?>><?= $valor ?></<?= $campo ?>>
    <?php
        endforeach;
    ?>

		</promocion>
	<?php
	endforeach;
	?>
	</promociones>
<?php
endif;
?>
</obj>
