<script type="text/javascript">
var chart;
$(document).ready(function() {
   chart = new Highcharts.Chart({
      chart: {
         renderTo: 'container',
         defaultSeriesType: 'line',
         marginRight: 130,
         marginBottom: 25
      },
      title: {
         text: 'Incubadora',
         x: -20 //center
      },
      subtitle: {
         text: 'Registro de temperaturas',
         x: -20
      },
      xAxis: {
         labels:{rotation: -20},
         categories: [<?php echo $fecha; ?>]
      },
      yAxis: {
         title: {
            text: 'Centígrados'
         },
         plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
         }]
      },
      tooltip: {
         formatter: function() {
                   return '<b>'+ this.series.name +'</b><br/>'+
               this.x +': '+ this.y +' °C';
         }
      },
      legend: {
         layout: 'vertical',
         align: 'right',
         verticalAlign: 'top',
         x: -10,
         y: 100,
         borderWidth: 0
      },
      series: [{
         name: 'Temp. exterior',        
         data: [<?php echo $exterior; ?>]        
      }, {
         name: 'Temp. interior',
         data: [<?php echo $interior; ?>]
      }]            
   });   
    $( "#de").datepicker({changeMonth: true, changeYear: true, "dateFormat": "yy-mm-dd"});
    $( "#hasta").datepicker({changeMonth: true, changeYear: true, "dateFormat": "yy-mm-dd"});    
});
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

<a href="equipos/incubadora/control" role="button" class="btn" data-toggle="modal"><img src="imagenes/left.png" title="Regresar"  width="20" height="20"/></a>
<a href="#myModal" role="button" class="btn" data-toggle="modal"><img src="imagenes/chart.png" title="Generar gráfica"  width="20" height="20"/></a>
   

<div id="container" style="width: 100%;"></div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Graficación Incubadora</h3>
  </div>
  <div class="modal-body">        
   <form class="form-inline" action="equipos/incubadora/generar_grafica" method="POST">
          
    <input type="text" class="input-small" name="de" id="de" placeholder="De">
    <input type="text" class="input-small" name="hasta" id="hasta" placeholder="Hasta">
       
    <button type="submit" class="btn btn-primary">Gráficar</button>
   </form>       
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    
  </div>
</div>