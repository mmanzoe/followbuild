<?php 
session_start();
require_once ('../../class/class.session.php');

unset($_SESSION['productos']);
$validaAcceso = new validasesion();
//if($validaAcceso->getValidaLogin()===true){}else{header('location: ../');};

if(!isset( $_SESSION['datos_logueo']['estado'] )){
    if( $_SESSION['datos_logueo']['estado']!=TRUE){
        header('location: ../');
    }
    header('location: ../');
}


?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $_SESSION['datos_logueo']['sistema'] ?></title>
    <meta name="description" content="sistema algo">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="../../lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../lib/font-awesome5.7.2/css/all.css">
    <link rel="stylesheet" href="../../lib/alertify/css/alertify.core.css">
    <link rel="stylesheet" href="../../lib/alertify/css/alertify.default.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../lib/DevExtreme/css/dx.common.css">
    <link rel="stylesheet" href="../../lib/DevExtreme/css/dx.light.css">
   
    <script src="../../lib/DevExtreme/js/polyfill.min.js"></script>
    <script src="../../lib/DevExtreme/js/exceljs.min.js"></script>
    <script src="../../lib/DevExtreme/js/FileSaver.min.js"></script>
    <script src="../../js/jquery-3.0.0.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../lib/bootstrap/js/bootstrap.js"></script>
    <script src="../../lib/alertify/js/alertify.js"></script>
    <script src="../../js/main.js"></script>
    <script src="js/funciones.js"></script>
    <script src="../../lib/DevExtreme/js/dx.all.js"></script>

    
</head>
<body>

<!-- Left Panel -->

<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./">Followbuild</a>
            <a class="navbar-brand hidden" href="./">FB</a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#"> <i class="menu-icon fa fa-tachometer-alt"></i>Dashboard </a>
                </li>
                <?php require_once '../../php/menu_dinamic.php'?>
            </ul>
        </div><!-- /.navbar-collapse -->

    </nav>
</aside><!-- /#left-panel -->


<div id="right-panel" class="right-panel">

    <!-- Header-->
    <header id="header" class="header">

        <div class="header-menu">
            <div class="col-sm-7">
                <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                <div class="header-left">
                  <label><?php echo $_SESSION['datos_logueo']['sistema'] ?></label>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="user-area dropdown float-right">
                  <label><?php echo $_SESSION['datos_logueo']['nombre_usuario'] ?></label>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="fa fa-user-circle fa-2x"></span>
                    </a>

                    <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="../cambio_pass/"><i class="fa fa-cog"></i> Configuración</a>

                        <a class="nav-link" href="../../php/logout.php"><i class="fa fa-power-off"></i> Logout</a>
                    </div>
                </div>



            </div>
        </div>

    </header><!-- /header -->
    <!-- Header-->

    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>CONSULTA FACTURA COMPRA</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Compras</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">

      <div class="row">

        <div class="col-md-12">
          <div class="card table-responsive">
              <div class="card-header">
              <input type="button" class="btn btn-sm btn-success pull-right"  data-toggle="modal" data-target="#modal-parametros"value="paramentros">
              </div>
              <div class="card-body">
                  <div class="loadpanel"></div>
                  <div id="resultados"></div>
              </div>
          </div>
        </div>

      </div>
        
    </div> <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel --> 
 


<!--Modal para paramentros de busqueda-->
<div class="modal fade" id="modal-parametros" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Paramentros de busqueda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">     
          <div class="form-group row">
              <label class="col-3 col-form-label">No. Factura</label>
              <div class="col-8">
                  <input type="text" class="form-control form-control-sm" id="no_factura">
              </div>
          </div>
          <div class="form-group row">
              <label class="col-3 col-form-label">Tipo Factura</label>
              <div class="col-8">
                  <select class="form-control form-control-sm" id="tipo_fac">
                    <option value="TODO">Todo</option>
                    <option value="MATERIAL">MATERIAL</option>
                    <option value="SERVICIO">SERVICIO</option>
                  </select>
              </div>
          </div>
          <div class="form-group row">
              <label class="col-3 col-form-label">Fecha Inicio</label>
              <div class="col-8">
                  <input type="date" class="form-control form-control-sm" id="fecha_i">
              </div>
          </div>
          <div class="form-group row">
              <label class="col-3 col-form-label">Fecha Final</label>
              <div class="col-8">
                  <input type="date" class="form-control form-control-sm" id="fecha_f">
              </div>
          </div>
          <div class="form-group row">
            <label class="col-3 col-form-label">Busqueda</label>
            <div class="col-8">
                <select class="form-control form-control-sm" id="tipo_fecha">
                    <option value="1">Fecha de ingreso</option>
                    <option value="2">Fecha factura</option>
                </select>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" id="buscar"><span class="fa fa-search"></span></button>
      </div>
    </div>
  </div>
</div>
    
<!--Modal para listar registros de factura-->
<div class="modal detalle_factura" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle Factura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body muestra_detalle_factura">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

<!--Modal para mostrar la imagen de la factura-->
<div class="modal image_factura" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Factura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body muestra_factura">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <a class="btn btn-success descarga_img"><span class="fa fa-download"></span></a>
      </div>
    </div>
  </div>
</div>


<!--Modal para listar la forma en que se liquida la factura-->
<div class="modal detalle_pago_factura" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle Pago Factura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body muestra_detalle_pago_factura">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>



<!--Modal para mostrar retencion-->
<div class="modal retencion_pago_factura" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Retencion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body muestra_retencion_pago_factura">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

</body>
</html>