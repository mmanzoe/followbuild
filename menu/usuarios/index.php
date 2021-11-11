<?php
session_start();
require_once ('../../class/class.session.php');

$validaAcceso = new validasesion();

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
                <a class="navbar-brand" href="./"><img src="../../img/cintillo_logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="../../img/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="../"> <i class="menu-icon fa fa-tachometer-alt"></i>Dashboard </a>
                    </li>
                    <?php require_once '../../php/menu_dinamic.php'?>
                </ul>
            </div>
        </nav>
    </aside>
    <!-- /#left-panel -->


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
                            <!--<img class="user-avatar rounded-circle" src="../img/admin.jpg" alt="User Avatar">-->
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="../perfil/"><i class="fa fa-user"></i> Mi Perfil</a>

                            <a class="nav-link" href="../configuracion/"><i class="fa fa-cog"></i> Configuracion</a>

                            <a class="nav-link" href="../../php/logout.php"><i class="fa fa-power-off"></i> Salir</a>
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
                        <h1>Usuarios</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Configuración</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <!--contenido -->
            
            <div class="animated fadeIn mt-3">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Usuarios</strong>
                                <button class="btn btn-sm btn-success pull-right ingresoUsuario" hidden><i class="fa fa-plus"></i> Nuevo usuario</button>
                            </div>
                            <div class="card-body">
                            
                                <table id="registros" 
                                        data-show-export="true"
                                        data-export-types=['excel']
                                        data-locale="es-ES" 
                                        data-pagination="true"
                                        data-export-data-type="all"
                                        data-search="true">
                                    <thead>
                                        <tr>
                                            <th data-field="nombre">Nombre</th>
                                            <th data-field="correo">Correo</th>
                                            <th data-field="usuario">Usuario</th>
                                            <th data-field="area">Area</th>
                                            <th data-field="estado">Estado</th>
                                            <th data-field="accion">Accion</th>
                                        </tr>
                                    </thead>
                                    
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
           


        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->


</body>
</html>


<div class="modal fade" id="modalAddUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ingreso Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="grabarProveedor">
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nit</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" maxlength="15" id="nit" pattern="[A-Za-z0-9]{1,15}" title="sin guiones" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nombre</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="nombre" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Correo</label>
                    <div class="col-sm-9">
                    <input type="email" class="form-control form-control-sm" id="correo" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tipo</label>
                    <div class="col-sm-9">
                    <select class="form-control form-control-sm tipoproveedor" id="tipo" id="tipo"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Regimen</label>
                    <div class="col-sm-9">
                    <select class="form-control form-control-sm regimenproveedor" id="regimen" id="regimen"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Grupo</label>
                    <div class="col-sm-9">
                    <select class="form-control form-control-sm area_empresa" id="area_empresa"></select>
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

<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="actualizaUsuario">
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Registro</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="editId" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Usuario</label>
                    <div class="col-sm-9">
                    <input type="email" class="form-control form-control-sm" id="editUsuario" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nombre</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="editNombre">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Correo</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="editCorreo">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Area</label>
                    <div class="col-sm-9">
                    <select class="form-control form-control-sm area" id="editArea" ></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Contraseña</label>
                    <div class="col-sm-9">
                    <input type="password" class="form-control form-control-sm" id="editContrasena" maxlength="10">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Confirmar Contraseña</label>
                    <div class="col-sm-9">
                    <input type="password" class="form-control form-control-sm" id="editValidaContrasena" maxlength="10">
                    </div>
                </div>
                
            </div>


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-sm btn-success">Actualizar</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalPermiso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Permiso Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="actualizaPermiso">
      <div class="modal-body">
        <div class="row">
            
            <div class="col-12 permisos">    
       
                       
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
