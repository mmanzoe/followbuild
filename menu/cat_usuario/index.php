<?php 
session_start(); 

if(isset($_SESSION['login'])){
	if($_SESSION['login'] != 'true'){
		header('location: ../../');
	}
}else{
	header('location: ../../');
}



?>
<!doctype html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>..:SENKE:..</title>
<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../../css/style.css" rel="stylesheet" type="text/css">
<link href="../../css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="../../css/rwd-tables.css" rel="stylesheet" type="text/css">
<link href="../../css/alertify.default.css" rel="stylesheet" type="text/css">
<link href="../../css/alertify.core.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../js/jquery.js"></script>
<script language="javascript" src="../../js/popper.min.js"></script>
<script language="javascript" src="../../js/bootstrap.min.js"></script>
<script language="javascript" src="../../js/alertify.js"></script>
<script language="javascript" src="../../js/main.js" type="text/javascript"></script>
<script language="javascript" src="js/funciones.js?v=<?php date('Y-m-d') ?>"></script>


</head>
<body>
 

<!-- Left Panel -->

<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./">ALPROMA S.A.</a>
            <a class="navbar-brand hidden" href="./">A</a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <?php include('../php/menu_administracion.php') ?>
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
                    <button class="search-trigger" hidden><i class="fa fa-search"></i></button>
                    <div class="form-inline" hidden>
                        <form class="search-form">
                            <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                            <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                        </form>
                    </div>

                    <div class="dropdown for-notification" hidden>
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="count bg-danger">5</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="notification">
                            <p class="red">You have 3 Notification</p>
                            <a class="dropdown-item media bg-flat-color-1" href="#">
                            <i class="fa fa-check"></i>
                            <p>Server #1 overloaded.</p>
                        </a>
                            <a class="dropdown-item media bg-flat-color-4" href="#">
                            <i class="fa fa-info"></i>
                            <p>Server #2 overloaded.</p>
                        </a>
                            <a class="dropdown-item media bg-flat-color-5" href="#">
                            <i class="fa fa-warning"></i>
                            <p>Server #3 overloaded.</p>
                        </a>
                        </div>
                    </div>

                    <div class="dropdown for-message" hidden>
                        <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="message"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-envelope-o"></i>
                            <span class="count bg-primary">9</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="message">
                            <p class="red">You have 4 Mails</p>
                            <a class="dropdown-item media bg-flat-color-1" href="#">
                            <span class="photo media-left fa fa-user"></span>
                            <span class="message media-body">
                                <span class="name float-left">Jonathan Smith</span>
                                <span class="time float-right">Just now</span>
                                    <p>Hello, this is an example msg</p>
                            </span>
                        </a>
                            <a class="dropdown-item media bg-flat-color-4" href="#">
                             <span class="photo media-left fa fa-user"></span>
                            <span class="message media-body">
                                <span class="name float-left">Jack Sanders</span>
                                <span class="time float-right">5 minutes ago</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </span>
                        </a>
                            <a class="dropdown-item media bg-flat-color-5" href="#">
                             <span class="photo media-left fa fa-user"></span>
                            <span class="message media-body">
                                <span class="name float-left">Cheryl Wheeler</span>
                                <span class="time float-right">10 minutes ago</span>
                                    <p>Hello, this is an example msg</p>
                            </span>
                        </a>
                            <a class="dropdown-item media bg-flat-color-3" href="#">
                             <span class="photo media-left fa fa-user"></span>
                            <span class="message media-body">
                                <span class="name float-left">Rachel Santos</span>
                                <span class="time float-right">15 minutes ago</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </span>
                        </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="user-area dropdown float-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <p><?php echo $_SESSION['nombre'] ?></p>
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
                    <h1>CREACIÓN USUARIOS</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Crear</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        
        <div class="container-fluid">
            <div class="row">
              <div class="col-3">
                <div class="input-group mb-3">
                  <input type="text" class="form-control form-control-sm" id="nombre_busca" placeholder="Buscar por nombre">
                  <div class="input-group-append">
                    <button class="btn btn-success btn-sm" type="button" id="buscar_usuario"><span class="fa fa-search"></span></button>
                  </div>
                </div>
              </div>
              <div class="col-3 offset-6">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-usuario"><span class="fa fa-plus"></span> Nuevo</button>
              </div>
            </div>
            <div class="row mt-4 resultados table-responsive">


            </div>
        </div>
        

    </div> <!-- .content -->
</div><!-- /#right-panel -->

<!-- Right Panel -->    
    
 

<!--INGRESO DE USUARIOS-->
<div class="modal fade" id="modal-usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Creacion de Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="grabar">
      <div class="modal-body">
        <div class="row">
          <div class="col-4 offset-1">
            <label>Nombre:</label>
          </div>
          <div class="col-6">
            <input type="text" class="form-control form-control-sm" id="nombre" maxlength="50" required>
          </div>
        </div>
        <div class="row">
          <div class="col-4 offset-1">
            <label>Correo:</label>
          </div>
          <div class="col-6">
            <input type="text" class="form-control form-control-sm" id="correo" maxlength="100" required>
          </div>
        </div>
        <div class="row">
          <div class="col-4 offset-1">
            <label>usuario:</label>
          </div>
          <div class="col-5">
            <input type="text" class="form-control form-control-sm" id="usuario" maxlength="10" required>
          </div>
        </div>
        <div class="row">
          <div class="col-4 offset-1">
            <label>Contraseña:</label>
          </div>
          <div class="col-6">
            <input type="password" class="form-control form-control-sm" id="password" maxlength="10" required>
          </div>
        </div>
        <div class="row">
          <div class="col-4 offset-1">
            <label>Confirmar Contraseña:</label>
          </div>
          <div class="col-6">
            <input type="password" class="form-control form-control-sm" id="passwordc" maxlength="10" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="bubmit" class="btn btn-primary">Grabar</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!--PERMISOS DE USUARIOS-->
<div class="modal fade" id="modal-permiso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Creacion de Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="">
      <div class="modal-body">
        <div class="row">
          <div class="col-2 offset-1">
            <label>Permiso:</label>
          </div>
          <div class="col-7">
            <input type="hidden" id="idregistro">
            <div class="input-group mb-3">
              <div class="input-group">
                <select class="custom-select form-control-sm"  id="permisos"></select>
                <div class="input-group-append">
                  <button class="btn btn-success btn-sm" type="button" id="grabapermiso">Agregar</button>
                </div>
              </div> 
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 listapermisos">
          
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>




</body>

</html>