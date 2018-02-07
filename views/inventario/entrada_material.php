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
    	<!--div style="float: left; margin: 0 100px 0 0; ">
    		<h4>Entrada de Material</h3>
    	</div>
    	<div style="padding: .3em;">
    		<ul class="nav nav-pills">
				<li role="presentation"><a href="catalogos/materiales/control">Mis Materiales</a></li>
				<li role="presentation"><a href="inventario/inventario_material/salida"><i class="icon-arrow-up"></i>Salida de Material</a></li>
			</ul>
    	</div-->
    	<ul class="nav nav-pills" role="tablist">
            <li role="presentation"><a href="catalogos/materiales/control">Mis Materiales</a></li>
            <li role="presentation" class="active"><a href="inventario/inventario_material/entrada">Entrada de Material</a></li>
            <li role="presentation"><a href="inventario/inventario_material/salida">Salida de Material</a></li>
            <!--li role="presentation"><a href="catalogos/materiales/listar_materiales">Todos los Materiales</a></li-->
        </ul>

		<?php echo $output; ?>
    </div>


</html>
