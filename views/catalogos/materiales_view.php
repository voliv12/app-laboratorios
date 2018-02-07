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
    	   <span class="label label-success"><h4>Mis Materiales</h4></span>
    	</div>
    	<div style="padding: .3em;">
            <ul class="nav nav-pills">
				<li role="presentation"><a href="inventario/inventario_material/entrada"><i class="icon-arrow-down"></i><code>Entrada de Material</code></a></li>
				<li role="presentation"><a href="inventario/inventario_material/salida"><i class="icon-arrow-up"></i>Salida de Material</a></li>
			</ul>
    	</div-->

        <ul class="nav nav-pills" role="tablist">
            <li role="presentation" class="active"><a href="catalogos/materiales/control">Mis Materiales</a></li>
            <li role="presentation"><a href="inventario/inventario_material/entrada">Entrada de Material</a></li>
            <li role="presentation"><a href="inventario/inventario_material/salida">Salida de Material</a></li>
            <!--li role="presentation"><a href="catalogos/materiales/listar_materiales">Todos los Materiales</a></li-->
            <!--li role="presentation"><a href="utileria/avisos/envia_aviso">Todos los Materiales</a></li-->
        </ul>
        <?php
            if ($stock != NULL) {
                echo "<mark>Hay material en mínimo de stock: </mark>";
            }
            foreach ($stock as $row) {
                echo    "<code>".$row['nombre'].", en stock: <b>".$row['total_stock']."</b></code> ";
            }
        ?>
		<?php echo $output; ?>
    </div>

</html>
