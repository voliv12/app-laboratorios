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
            <li role="presentation"><a href="catalogos/reactivos/control">Mis Reactivos</a></li>
            <li role="presentation"><a href="inventario/inventario_reactivo/entrada">Entrada de Reactivo</a></li>
            <li role="presentation"><a href="inventario/inventario_reactivo/salida">Salida de Reactivo</a></li>
            <!--li role="presentation" class="active"><a href="catalogos/reactivos/listar_reactivos">Todos los Reactivos</a></li-->
        </ul>

		<?php echo $output; ?>
    </div>

</html>
