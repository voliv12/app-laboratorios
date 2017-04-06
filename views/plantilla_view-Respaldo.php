<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $titulo; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href= "<?php echo $this->config->item('base_url'); ?>">

    <script type='text/javascript' src='js/jquery-1.8.2.js'></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">


    <script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/jquery.ui.draggable.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/DataTables-1.8.1/media/js/jquery.js"></script>
        <script type="text/javascript" src="js/DataTables-1.8.1/media/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/DataTables-1.8.1/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/DataTables-1.8.1/media/js/jquery.dataTables.editable.js"></script>
        <script type="text/javascript" src="js/jquery.jeditable.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/Highcharts-2.1.8/js/modules/exporting.js"></script>

        <link rel="stylesheet" href="js/DataTables-1.8.1/media/css/demo_table.css" type="text/css">
        <link rel="stylesheet" href="js/DataTables-1.8.1/media/css/demo_table_jui.css" type="text/css">
        <link rel="stylesheet" href="js/DataTables-1.8.1/media/css/demo_page.css" type="text/css">
        <link rel="stylesheet" href="js/themes/smoothness/jquery-ui-1.8.16.custom.css" type="text/css">
        <link rel="stylesheet" href="js/themes/base/jquery.ui.base.css" type="text/css">

        <script type="text/javascript" src="js/vanadium.js"></script>

        <link href="/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">

</head>

 <body>

      <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Inventario de Materiales y Reactivos - Instituto de Ciencias de la Salud</a>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php
                                            $this->load->helper('text');
                                            $count = count(explode(" ", $this->session->userdata('nombre')));
                                            //echo word_limiter($this->session->userdata('nombre'), $count - 1, " ");
                                            echo $this->session->userdata('nombre');
                                            ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">

              <li class="disabled"><a><?php echo $this->session->userdata('perfil'); ?></a></li>
              <li class="divider"></li>
              <li><a href="salir">Cerrar sesión</a></li>
            </ul>
          </div>

        </div>
      </div>
    </div>

<!--#######################################################-->

<div class="container">

      <div class="masthead">
          <h3 class="muted"> &nbsp; </h3>
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container" align="center">
                <a class="btn btn-default" href="catalogos/materiales/control" role="button">Materiales</a>
                <a class="btn btn-default" href="catalogos/reactivos/control" role="button">Reactivos</a>
                <a class="btn btn-default" href="catalogos/equipos/control" role="button">Equipos</a>


               <div class="btn-group">
                <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">Catálogos <span class="caret"></span></button>
                <ul class="dropdown-menu" align="left">
                   <li><a href="catalogos/usuarios/control">Usuarios</a></li>
                    <li><a href="catalogos/proveedores/control">Proveedores</a></li>
                </ul>
              </div>
              <!--div class="btn-group">
                <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">Control equipos <span class="caret"></span></button>
                <ul class="dropdown-menu" align="left">
                   <li class="dropdown-submenu">
                       <a tabindex="-1" href="equipos/destilador/control">Control</a>
                        <ul class="dropdown-menu" align="left">
                            <li><a href="equipos/destilador/control">Destilador </a></li>
                            <li><a href="equipos/banco/control">Banco de Celulas </a></li>
                            <li><a href="equipos/incubadora/control">Incubadora </a></li>
                        </ul>
                   </li>
                   <li><a href="equipos/mantenimiento/control">Mantenimiento </a></li>
                   <li><a href="equipos/reservacion/control">Reservación </a></li>
                </ul>
              </div>
              <div class="btn-group">
                <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">Bitácoras <span class="caret"></span></button>
                <ul class="dropdown-menu" align="left">
                   <li><a href="bitacoras/ctrl_equipos/control">Equipo</a></li>
                   <li><a href="bitacoras/ctrl_aseo/control">Aseo</a></li>
                </ul>
              </div-->
              <div class="btn-group">
                <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">Inventario <span class="caret"></span></button>
                <ul class="dropdown-menu" align="left">
                   <li><a href="inventario/inventario_material/control">Materiales</a></li>
                   <li><a href="inventario/inventario_reactivo/control">Reactivos</a></li>
                </ul>
              </div>
              <div class="btn-group">
               <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">Utilería <span class="caret"></span></button>
                <ul class="dropdown-menu" align="left">
                   <li><a href="utileria/respaldos/generar_respaldo">Realizar respaldo de la Base de Datos</a></li>

                </ul>
              </div>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>
     </div> <!-- /container -->

     <div class="container-fluid">
             <?php echo $contenido; ?>
     </div>
      <hr>

      <div class="footer">
        <p>&copy; Instituo de Ciencias de la Salud 2013</p>
      </div>
  </body>
</html>
