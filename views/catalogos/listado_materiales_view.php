<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>

</style>
</head>

    <div>
    	<ul class="nav nav-pills" role="tablist">
            <li role="presentation"><a href="catalogos/materiales/control">Mis Materiales</a></li>
            <li role="presentation"><a href="inventario/inventario_material/entrada">Entrada de Material</a></li>
            <li role="presentation"><a href="inventario/inventario_material/salida">Salida de Material</a></li>
            <li role="presentation" class="active"><a href="catalogos/materiales/listar_materiales">Todos los Materiales</a></li>
        </ul>

		<?php echo $output; ?>
    </div>

</html>
