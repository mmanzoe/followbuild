<?php
session_start();
require_once ('../../class/class.session.php');

$validaAcceso = new validasesion();
if($validaAcceso->getValidaLogin()===true){}else{header('location: ../');};

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
    <link rel="stylesheet" href="../../lib/dataTable/datatables.css">
    <link rel="stylesheet" href="../../lib/alertify/css/alertify.core.css">
    <link rel="stylesheet" href="../../lib/alertify/css/alertify.default.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    
    <script src="../../js/jquery-3.0.0.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../lib/bootstrap/js/bootstrap.js"></script>
    <script src="../../lib/dataTable/datatables.js"></script>
    <script src="../../lib/alertify/js/alertify.js"></script>
    <script src="../../js/main.js"></script>
    <script src="../../js/numeric.js"></script>
    <script src="js/funciones.js"></script>
    <script src="../../lib/csv-jquery/highlight.js"></script>
    <script src="../../lib/csv-jquery/jquery.csv.min.js"></script>
    <script src="../../lib/csv-jquery/helpers.js"></script>
    
    
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
                        <a href="#"> <i class="menu-icon fa fa-tachometer-alt"></i>Dashboard </a>
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
                        <h1>Perfil</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Perfil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <!--contenido -->

            <div class="row mt-3">
                <div class="col-12 col-sm-6">
                    <form id="actualizarPerfil">
                    <div class="card">
                        <div class="card-header"><strong class="card-title">Perfil</strong></div>
                        <div class="card-body"> 
                            <div class="form-group row" hidden>
                                <label class="col-sm-4 col-form-label">id Usuario</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="idusuario"  value="<?php echo $_SESSION['datos_logueo']['idusuario'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nombre</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="nombre"  value="<?php echo $_SESSION['datos_logueo']['nombre_usuario'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Correo</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="correo" value="<?php echo $_SESSION['datos_logueo']['correo'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Unidad</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="unidad" value="<?php echo $_SESSION['datos_logueo']['area_asignada'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Usuario</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="usuario" value="<?php echo $_SESSION['datos_logueo']['usuario'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Contraseña Actual</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control form-control-sm" id="pass_actual" maxlength="10" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Nueva Contraseña</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control form-control-sm" id="new_pass" maxlength="10" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Confirmar Contraseña</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control form-control-sm" id="conf_pass" maxlength="10" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> <i class="d-none d-sm-block">Actualizar</i></button>
                                </div>
                            </div>

                        </div> 
                    </div>
                    </form>
                </div>
                
            </div>

        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->


</body>
</html>




