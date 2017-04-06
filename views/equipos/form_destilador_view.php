<script type="text/javascript" charset="utf-8"> 
$(document).ready(function(){    
                $( "#fecha").datepicker({changeMonth: true, changeYear: true, "dateFormat": "yy-mm-dd"});
                $( "#de").datepicker({changeMonth: true, changeYear: true, "dateFormat": "yy-mm-dd"});
                $( "#hasta").datepicker({changeMonth: true, changeYear: true, "dateFormat": "yy-mm-dd"});        
});
	// increase the default animation speed to exaggerate the effect
	$.fx.speeds._default = 1000;
	$(function() {
		$( "#dialog" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "explode"
		});
		$( "#opener" ).click(function() {
			$( "#dialog" ).dialog( "open" );
			return false;
		});
	});
	
</script> 

<div class="container">
<h4>Graficar funcionamiento Destilador</h4>                  
<div id="nav_rigth">
    <a href="equipos/destilador/control" class="enlaces"><img src="imagenes/left.png" title="Regresar"/></a>
</div>




    <?php //$this->load->helper(array('form', 'url')); ?>
    <?php //echo form_open_multipart('equipos/destilador/generar_grafica'); ?>    
    <form class="form-signin" action="equipos/destilador/generar_grafica" method="POST">  
    <br />
    <label for="agua">Agua:</label>
    <select name="agua" rel="0">                   
            <option value="destilada">Destilada</option>
            <option value="enfriada">Enfriada</option>            
    </select><br />
    <label for="de">De:</label>
	<input type="text" name="de" id="de" class="required" rel="1" width="30"/>
        <br />
     <label for="hasta">Hasta:</label>
	<input type="text" name="hasta" id="hasta" class="required" rel="2" width="30"/>
        <br />
      <input type="submit" value="Graficar" />
     <?php echo form_close(); ?>
</div>





