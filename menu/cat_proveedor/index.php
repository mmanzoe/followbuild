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

    <link rel="shortcut icon" href="favicon.ico">

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
                    <h1>PROVEEDORES</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Catalogos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        
        <div class="container-fluid">    
            <div class="row">
              <div class="col-2 offset-10">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_add_proveedor"><span class="fa fa-plus"></span> Nuevo</button>
              </div>
            </div>
        
            
            
            <div class="animated fadeIn mt-3">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Proveedores</strong>
                            </div>
                            <div class="card-body">
                                
                                <table id="registros" class="resultados" 
                                        data-show-export="true"
                                        data-export-types=['excel']
                                        data-locale="es-ES" 
                                        data-pagination="true"
                                        data-export-data-type="all"
                                        data-search="true">
                                    <thead>
                                        <tr>
                                            <th data-field="nit">Nit</th>
                                            <th data-field="contribuyente">Contribuyente</th>
                                            <th data-field="empresa">Empresa</th>
                                            <th data-field="direccion">Direccion</th>
                                            <th data-field="credito">Credito</th>
                                            <th data-field="accion">Accion</th>
                                        </tr>
                                    </thead>
                                    
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
       
        
        
        
        
        

    
        
        
    </div> <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->    
    
 

</body>


<!--Modal para agregar proveedor-->
<div class="modal fade" id="modal_add_proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="grabar">  
      <div class="modal-body"> 
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-empresa-tab" data-toggle="tab" href="#nav-empresa" role="tab" aria-selected="true">Empresa</a>
            <a class="nav-item nav-link" id="nav-contacto-tab" data-toggle="tab" href="#nav-contacto" role="tab" aria-selected="false">Contacto</a>
          </div>
        </nav> 
        <div class="tab-content mt-5" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-empresa" role="tabpanel" >
            <div class="row">
              <div class="col-3 offset-1">
                <label>Nit.:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="nit" maxlength="15" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Tipo Contribuyente:</label>
              </div>
              <div class="col-4">
                  <select class="form-control form-control-sm" id="tipo_contribuyente"></select>
              </div>
            </div>  
            <div class="row">
              <div class="col-3 offset-1">
                <label>Nombre Proveedor:</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="nombre" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Dirección Proveedor:</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="direccion" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Tel. Proveedor:</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="tel_proveedor" maxlength="13" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Dias Credito:</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="dias_credito" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Email Proveedor:</label>
              </div>
              <div class="col-7">
                <input type="email" class="form-control form-control-sm" id="email_proveedor" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Carga RTU</label>
              </div>
              <div class="col-7">
                <input type="file" name="file[]" id="file" class="form-control form-control-sm">
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="nav-contacto" role="tabpanel" >
            <div class="row">
              <div class="col-3 offset-1">
                <label>Nombre Contacto</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="contacto">
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Tel. Contacto</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="tel_contacto" maxlength="13" value="0">
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Email Contacto</label>
              </div>
              <div class="col-7">
                <input type="email" class="form-control form-control-sm" id="email_contacto">
              </div>
            </div>
          </div>         
        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-sm btn-success" value="Grabar">
      </div>
      </form>
    </div>
  </div>
</div>

<!--Modal para editar proveedor-->
<div class="modal fade" id="modal_edit_proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="actualizar">  
      <div class="modal-body"> 
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-empresa-tab" data-toggle="tab" href="#nav-edit-empresa" role="tab" aria-selected="true">Empresa</a>
            <a class="nav-item nav-link" id="nav-contacto-tab" data-toggle="tab" href="#nav-edit-contacto" role="tab" aria-selected="false">Contacto</a>
          </div>
        </nav> 
        <div class="tab-content mt-5" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-edit-empresa" role="tabpanel" >
            <div class="row">
              <div class="col-3 offset-1">
                <label>Registro.:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="idregistro" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Nit.:</label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" id="edit_nit" maxlength="15" disabled>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Tipo Contribuyente:</label>
              </div>
              <div class="col-4">
                  <select class="form-control form-control-sm" id="edit_tipo_contribuyente"></select>
              </div>
            </div>  
            <div class="row">
              <div class="col-3 offset-1">
                <label>Nombre Proveedor:</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="edit_nombre" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Dirección Proveedor:</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="edit_direccion" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Tel. Proveedor:</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="edit_tel_proveedor" maxlength="13" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Dias Credito:</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="edit_dias_credito" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Email Proveedor:</label>
              </div>
              <div class="col-7">
                <input type="email" class="form-control form-control-sm" id="edit_email_proveedor" required>
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Carga RTU</label>
              </div>
              <div class="col-7">
                <input type="file" name="file[]" class="form-control form-control-sm" id="edit_rtu">
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="nav-edit-contacto" role="tabpanel" >
            <div class="row">
              <div class="col-3 offset-1">
                <label>Nombre Contacto</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="edit_contacto">
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Tel. Contacto</label>
              </div>
              <div class="col-7">
                <input type="text" class="form-control form-control-sm" id="edit_tel_contacto" value="0" maxlength="13">
              </div>
            </div>
            <div class="row">
              <div class="col-3 offset-1">
                <label>Email Contacto</label>
              </div>
              <div class="col-7">
                <input type="email" class="form-control form-control-sm" id="edit_email_contacto">
              </div>
            </div>
          </div>         
        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-sm btn-success" value="Actualizar">
      </div>
      </form>
    </div>
  </div>
</div>

<!--Modal muestra rtu-->
<div class="modal fade" id="modal_despliega_rtu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Despliega RTU</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="despliega_rtu"> 
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!--Modal para mostrar contacto-->
<div class="modal fade" id="modal_contacto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contacto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="actualizar_contacto">  
      <div class="modal-body"> 
        <div class="col-12 actualizar_contacto">  
        
      </div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>

</html>