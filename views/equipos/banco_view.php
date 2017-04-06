<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<script type="text/javascript">
    $(document).ready(function() {
         $( "#de").datepicker({changeMonth: true, changeYear: true, "dateFormat": "yy-mm-dd"});
         $( "#hasta").datepicker({changeMonth: true, changeYear: true, "dateFormat": "yy-mm-dd"});    
    });
</script>

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
 <h4>Control Banco de Células</h4>
 
 <a href="#myModal" role="button" class="btn" data-toggle="modal"><img src="imagenes/chart.png" title="Generar gráfica"  width="20" height="20"/></a>
 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Graficación Banco de Células</h3>
  </div>
  <div class="modal-body">        
   <form class="form-inline" action="equipos/banco/generar_grafica" method="POST">
     
    <input type="text" class="input-small" name="de"  id="de" placeholder="De">
    <input type="text" class="input-small" name="hasta" id="hasta" placeholder="Hasta">
       
    <button type="submit" class="btn btn-primary">Gráficar</button>
   </form>       
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    
  </div>
</div>
 
    <?php echo $output; ?>

</html>


