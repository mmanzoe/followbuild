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
   
    <script src="../../js/jquery-3.0.0.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../lib/bootstrap/js/bootstrap.js"></script>
    <script src="../../lib/numeric/numeric.js"></script>
    <script src="../../lib/alertify/js/alertify.js"></script>
    <script src="../../js/main.js"></script>
    <script src="js/funciones.js"></script>

    
    <link href="../../lib/bootstrap-table-master/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="../../lib/bootstrap-table-master/dist/tableExport.min.js"></script>
    <script src="../../lib/bootstrap-table-master/dist/bootstrap-table.min.js"></script>
    <script src="../../lib/bootstrap-table-master/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="../../lib/bootstrap-table-master/dist/bootstrap-table-locale-all.min.js"></script>
    
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
                    <h1>ORDENES DE COMPRA</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">ORDEN DE COMPRA</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-3 offset-9">
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_add_inspeccion"><span class="fa fa-plus"></span> Nuevo</button>
                </div>
            </div>
            <div class="row mt-4 resultados">


            </div>
            
        </div>
        

    </div> <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->     
 
</body>



<!--Modal para agregar orden de compra-->
<div class="modal fade" id="modal_add_inspeccion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Orden de Compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="agregar">  
      <div class="modal-body"> 
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" data-toggle="tab" href="#nav-ordencompra" role="tab" aria-selected="true" id="tab-ordencompra">Orden Compra</a>
            <a class="nav-item nav-link mp" data-toggle="tab" href=".nav-detalle_producto" role="tab" aria-selected="false">Detalle Producto</a>
          </div>
        </nav> 
        <div class="tab-content mt-5" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-ordencompra" role="tabpanel">
            <div class="row">
              <div class="col-3 offset-1">
                <label>Moneda</label>
              </div>
              <div class="col-4">
                <div class="input-group">
                    <select class="form-control form-control-sm" id="moneda"></select>
                </div>
              </div>
            </div>
            <div class="row group-cambio-moneda" hidden>
              <div class="col-3 offset-1">
                <label>Tipo Cambio</label>
              </div>
              <div class="col-4">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="cambio_moneda" value="1">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Proveedor:</label>
              </div>
              <div class="col-4">
                <div class="input-group">
                  <input type="text" class="form-control form-control-sm" id="proveedor" disabled required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-sm modal-buscar-proveedor" type="button" data-toggle="modal" data-target="#modal-buscar-proveedor"><span class="fa fa-search"></span></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Nombre Proveedor:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="nombre_proveedor" disabled>
              </div>
            </div>
            <div class="row dias-credito">
              <div class="col-3 offset-1">
                <label>Dias Credito:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="dias_credito" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Forma Pago:</label>
              </div>
              <div class="col-4">
                <select class="form-control form-control-sm" id="forma_pago">
                  <option value="EFECTIVO">EFECTIVO</option>
                  <option value="CHEQUE">CHEQUE</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Tipo Solicitud:</label>
              </div>
              <div class="col-4">
                <select class="form-control form-control-sm" id="tipo_solicitud">
                  <option value="MATERIAL">MATERIAL</option>
                  <option value="SERVICIO">SERVICIO</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Proyecto:</label>
              </div>
              <div class="col-4">
                <select class="form-control form-control-sm" id="proyecto" required></select>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Tipo gasto:</label>
              </div>
              <div class="col-4">
                <select class="form-control form-control-sm" id="tipo_gasto" required></select>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Observaciones:</label>
              </div>
              <div class="col-4">
                <textarea class="form-control form-control-sm" id="observaciones" maxlength="150"></textarea>
              </div>
            </div>     
          </div>
          <div class="tab-pane fade mp nav-detalle_producto" id="nav-detalle_producto" role="tabpanel"> 
            <div class="row">
              <div class="col-3 offset-1">
                <label>Material:</label>
              </div>
              <div class="col-4">
                <div class="input-group">
                  <input type="text" class="form-control form-control-sm" id="codigo_material" disabled>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-sm modal-buscar-mp" type="button" data-toggle="modal" data-target="#modal-buscar-mp"><span class="fa fa-search"></span></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Descripcion:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="descripcion" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Medida:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="medida_material" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Precio:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="precio_material" disabled>
              </div>
            </div>               
            <div class="row">
              <div class="col-3 offset-1">
                <label>Cantidad:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="cantidad_material">
              </div>
            </div>    
          </div>  
          
        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-sm btn-success" value="Agregar">
      </div>
      </form>
    </div>
  </div>
</div>

<!--Despliega listado de proveedores-->
<div class="modal fade" id="modal-buscar-proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Buscar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-8">
            <div class="form-group">
              <label>Ingrese nombre de proveedor</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control form-control-sm" id="busca_nombre_proveedor">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary btn-sm busca-proveedor" type="button"><span class="fa fa-search"></span></button>
                </div>
              </div>
            </div>  
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 resultadoproveedor">
          
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!--Modal para listar materia prima / materia empaque-->
<div class="modal fade" id="modal-buscar-mp" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Buscar Materia Prima</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-8">
            <div class="form-group">
              <label>Ingrese nombre Material</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control form-control-sm" id="nombre_material">
                <div class="input-group-append">
                  <button class="btn btn-sm btn-outline-secondary busca-material" type="button"><span class="fa fa-search"></span></button>
                </div>
              </div>
            </div>  
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 resultadomaterial">
          
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!--Visualiza especificacion de materia prima-->
<div class="modal modal-especificaciones" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Especificaciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <embed id="muestra_pdf" src="pdf/politica_ventas.pdf" width="100%" height="550">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



</html>