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
<html>
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
                    <h1>INGRESO FACTURA COMPRA</h1>
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
        
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-3">
                </div>
                <div class="col-2 offset-10">
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_add_factura"><span class="fa fa-plus"></span> Nuevo</button>
                </div>
            </div>
            <div class="row mt-4">
              <div class="col-12 table-responsive" id="listadoEnvio">

              </div>
            </div>
            
        </div>
        

    </div> <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->     
    
 
    
<!--Modal para agregar Factura-->
<div class="modal fade" id="modal_add_factura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ingreso de Facturas de Compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="mt-4 formulario" id="agregar">  
      <div class="modal-body">   
        <div class="tab-pane fade show active" id="nav-encabezado" role="tabpanel" >
          <div class="row">
            <div class="col-3 offset-1">
              <label>Orden Compra</label>
            </div>
            <div class="col-4">
              <div class="input-group">
                <input type="text" class="form-control form-control-sm" id="orden_compra" disabled>
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary btn-sm modal-buscar-orden-compra" type="button" data-toggle="modal" data-target="#modal-buscar-orden-compra"><span class="fa fa-search"></span></button>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-3 offset-1">
              <label>Serie:</label>
            </div>
            <div class="col-4">
              <input type="text" class="form-control form-control-sm" id="serie_factura" required>
            </div>
          </div>
          <div class="row">
            <div class="col-3 offset-1">
              <label>No. Factura:</label>
            </div>
            <div class="col-4">
              <input type="text" class="form-control form-control-sm" id="no_factura" required>
            </div>
          </div>
          <div class="row">
            <div class="col-3 offset-1">
              <label>Fecha Factura:</label>
            </div>
            <div class="col-4">
              <input type="date" class="form-control form-control-sm" id="fecha_factura" required>
            </div>
          </div>
          <div class="row">
            <div class="col-3 offset-1">
              <label>Proveedor:</label>
            </div>
            <div class="col-4">
              <div class="input-group">
                <input type="text" class="form-control form-control-sm" id="proveedor" disabled>
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
          <div class="row">
            <div class="col-3 offset-1">
              <label>Tipo Contribuyente:</label>
            </div>
            <div class="col-4">
              <input type="text" class="form-control form-control-sm" id="tipo_contribuyente" disabled>
            </div>
          </div>
            <div class="row">
            <div class="col-3 offset-1">
              <label>Impuesto:</label>
            </div>
            <div class="col-4">
              <input type="text" class="form-control form-control-sm" id="impuesto" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col-3 offset-1">
              <label>Tipo Factura:</label>
            </div>
            <div class="col-4">
              <select class="form-control form-control-sm" id="tipo_fac" disabled>
                <option value="MATERIAL">MATERIAL</option>
                <option value="SERVICIO">SERVICIO</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-3 offset-1">
              <label>Imagen Factura:</label>
            </div>
            <div class="col-4">
              <input type="file" name="file[]" id="file" class="form-control form-control-sm" required multiple>
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
          <div class="row" hidden>
            <div class="col-3 offset-1">
              <label>Proyecto:</label>
            </div>
            <div class="col-4">
              <input type="text" class="form-control form-control-sm" id="proyecto" disabled>
            </div>
          </div>
          <div class="row" hidden>
            <div class="col-3 offset-1">
              <label>Gasto:</label>
            </div>
            <div class="col-4">
              <input type="text" class="form-control form-control-sm" id="tipo_gasto" disabled>
            </div>
          </div>

        </div>      
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-sm btn-info agregar" value="Detalle Factura">
      </div>
      </form>
    </div>
  </div>
</div>


<!--Despliega listado de ordenes de compra-->
<div class="modal fade" id="modal-buscar-orden-compra" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Buscar Orden Compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-8">
            <div class="form-group">
              <label>Ingrese nombre proveedor </label>
              <div class="input-group mb-3">
                <input type="text" class="form-control form-control-sm" id="busca_nombre_proveedor_orden">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary busca-ordencompra btn-sm" type="button"><span class="fa fa-search"></span></button>
                </div>
              </div>
            </div>  
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 resultadoordencompra">
          
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!--Despliega formulario material-->
<div class="modal fade" id="modal-form-mpep" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Material</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form id="inserta-registro-mpep">    
      <div class="modal-body">
          
          <div class="row">
              <div class="col-4 offset-1">
                <label>Material:</label>
              </div>
              <div class="col-6">
                <div class="input-group mb-3">
                  <input type="text" class="form-control form-control-sm" id="materia_prima" disabled>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-sm modal-buscar-mp" type="button" data-toggle="modal" data-target="#modal-buscar-mp"><span class="fa fa-search"></span></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4 offset-1">
                <label>Descripcion:</label>
              </div>
              <div class="col-6">
                <input type="text" class="form-control form-control-sm" id="descripcion" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-4 offset-1">
                <label>No. Lote:</label>
              </div>
              <div class="col-6">
                <input type="text" class="form-control form-control-sm" id="no_lote">
              </div>
            </div>
            <div class="row">
              <div class="col-4 offset-1">
                <label>Fecha Vencimiento:</label>
              </div>
              <div class="col-6">
                <input type="date" class="form-control form-control-sm" id="fecha_vence">
              </div>
            </div>
            <div class="row">
              <div class="col-4 offset-1">
                <label>Cantidad:</label>
              </div>
              <div class="col-6">
                <input type="text" class="form-control form-control-sm" id="cantidad">
              </div>
            </div>
            <div class="row">
              <div class="col-4 offset-1">
                <label>Medida:</label>
              </div>
              <div class="col-6">
                <select class="form-control form-control-sm" id="medida"></select>
              </div>
            </div>
            <div class="row">
              <div class="col-4 offset-1">
                <label>Valor Unitario:</label>
              </div>
              <div class="col-6">
                <input type="text" class="form-control form-control-sm" id="valor">
              </div>
            </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-sm btn-success btn-sm">Agregar</button>
      </div>
    </form>  
    </div>
  </div>
</div>

<!--Despliega formulario servicio-->
<div class="modal fade" id="modal-form-servicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="inserta-registro-servicio">  
      <div class="modal-body">
           <div class="row">
              <div class="col-4 offset-1">
                <label>Descripcion:</label>
              </div>
              <div class="col-6">
                  <input type="text" class="form-control form-control-sm" id="des_sr" required>
              </div>
           </div>
           <div class="row">
              <div class="col-4 offset-1">
                <label>valor:</label>
              </div>
              <div class="col-6">
                <input type="text" class="form-control form-control-sm" id="valor_sr" required>
              </div>
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-sm btn-success btn-sm">Agregar</button>
      </div>
      </form>    
    </div>
  </div>
</div>

<!--Despliega formulario suministro-->
<div class="modal fade" id="modal-form-suministro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Suministro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="inserta-registro-suministro">  
      <div class="modal-body">
            <div class="row">
              <div class="col-4 offset-1">
                <label>Descripcion:</label>
              </div>
              <div class="col-6">
                <input type="text" class="form-control form-control-sm" id="des_sm">
              </div>
            </div>
            <div class="row">
              <div class="col-4 offset-1">
                <label>Cantidad:</label>
              </div>
              <div class="col-6">
                <input type="text" class="form-control form-control-sm" id="cant_sm">
              </div>
            </div>
            <div class="row">
              <div class="col-4 offset-1">
                <label>Valor:</label>
              </div>
              <div class="col-6">
                <input type="text" class="form-control form-control-sm" id="valor_sm">
              </div>
            </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-sm btn-success btn-sm">Agregar</button>
      </div>
      </form>    
    </div>
  </div>
</div>

<!--Despliega formulario activo fijo-->
<div class="modal fade" id="modal-form-suministro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Activo Fijo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="inserta-registro-activofijo">  
      <div class="modal-body">
            <div class="row">
              <div class="col-3 offset-1">
                <label>Descripcion:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="des_af">
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>valor:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="valor_af">
              </div>
            </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-sm btn-success btn-sm">Agregar</button>
      </div>
      </form>    
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
              <label>Ingrese nombre material</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control form-control-sm" id="nombre_mpep">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary busca-mpep btn-sm" type="button"><span class="fa fa-search"></span></button>
                </div>
              </div>
            </div>  
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 resultadompep">
          
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>