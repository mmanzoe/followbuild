<?php 
session_start();
require_once ('../../class/class.session.php');

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
<html lang="es">
<head>
    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $_SESSION['datos_logueo']['sistema'] ?></title>
    <meta name="description" content="sistema algo">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="../../img/favicon.ico">

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
    <script src="../../lib/numeric/numeric.js"></script>
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
                    <a href="../"> <i class="menu-icon fa fa-tachometer-alt"></i>Dashboard </a>
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
                        <a class="nav-link" href="../cambio_pass/"><i class="fa fa-cog"></i> Configuraci??n</a>

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
                    <h1>PAGO CLIENTES</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Ventas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        
      <div class="row">

        <div class="col-md-12">
            <div class="card table-responsive">
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
    
 
</body>


<!--MODAL PARA ASIGANAR PAGOS-->
<div class="modal modal-pago fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pago factura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="grabar">
      <div class="modal-body">
        <div class="row">
          <input type="hidden" id="idfactura">
          <div class="col-6">
            <div class="row">
              <div class="col-5">        
                <label>Tipo de pago:</label>
              </div>
              <div class="col-6"> 
                <select class="form-control form-control-sm" id="forma_pago" required>
                </select>
              </div>  
            </div>
            <div class="row">
              <div class="col-5">        
                <label>Forma de pago:</label>
              </div>
              <div class="col-6"> 
                <select class="form-control form-control-sm" id="tipo" required></select>
              </div>  
            </div>
            <div class="row">
              <div class="col-5">        
                <label>Monto:</label>
              </div>
              <div class="col-6"> 
                <input type="text" class="form-control form-control-sm" id="monto" required>
              </div>  
            </div>
            <div class="row">
              <div class="col-5">        
                <label>Doc. Valida:</label>
              </div>
              <div class="col-6"> 
                <input type="text" class="form-control form-control-sm" id="doc_valida" required>
              </div>  
            </div>
              <div class="row" hidden>
              <div class="col-5">        
                <label>Carga Retencion:</label>
              </div>
              <div class="col-6"> 
                <div class="custom-file">
                    <input type="file" class="custom-file-input form-control-sm" name="file[]" id="file">
                    <label class="custom-file-label">Seleccione</label>
                </div>
              </div>  
            </div>
          </div>
          <div class="col-6">
            <div class="row">
              <div class="col-12 text-center">
                <label class="text-center">Detalle Pago</label>
              </div>
            </div>
            <div class="row">
              <div class="col-12 detalle-pago">             
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-sm btn-success">Grabar</button>
      </div>
      </form>
    </div>
  </div>
</div>




</html>