<?php
session_start();

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
    <title>Sistema Algo</title>
    <meta name="description" content="sistema algo">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="favicon.ico">

    <link rel="shortcut icon" href="../img/favicon.ico">

    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../lib/font-awesome5.7.2/css/all.css">
    
    <link rel="stylesheet" href="../css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    
    
    <script src="../js/jquery-3.0.0.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.js"></script>
    <script src="../js/main.js"></script>

    <link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table-locale-all.min.js"></script>
    
</head>

<body>


    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img src="../img/cintillo_logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="../img/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="#"> <i class="menu-icon fa fa-tachometer-alt"></i>Dashboard </a>
                    </li>
                    <?php require_once '../php/menu_dinamic.php'?>
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
                            <a class="nav-link" href="perfil/"><i class="fa fa-user"></i> Mi Perfil</a>

                            <a class="nav-link" href="configuracion/"><i class="fa fa-cog"></i> Configuracion</a>

                            <a class="nav-link" href="../php/logout.php"><i class="fa fa-power-off"></i> Salir</a>
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
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
        
            <!--contenido -->

            <div class="animated fadeIn mt-3">
                <div class="row">
                    
                </div>
            </div>


        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

<script>
    var $table = $('#table')

    $(function() {
        var data = [
            {
                'id': 0,
                'name': 'Item 0',
                'price': '$0'
            },
            {
                'id': 1,
                'name': 'Item 1',
                'price': '$1'
            },
            {
                'id': 2,
                'name': 'Item 2',
                'price': '$2'
            },
            {
                'id': 3,
                'name': 'Item 3',
                'price': '$3'
            },
            {
                'id': 4,
                'name': 'Item 4',
                'price': '$4'
            },
            {
                'id': 5,
                'name': 'Item 5',
                'price': '$5'
            },
            {
                'id': 2,
                'name': 'Item 2',
                'price': '$2'
            },
            {
                'id': 3,
                'name': 'Item 3',
                'price': '$3'
            },
            {
                'id': 4,
                'name': 'Item 4',
                'price': '$4'
            },
            {
                'id': 5,
                'name': 'Item 5',
                'price': '$5'
            },
            {
                'id': 2,
                'name': 'Item 2',
                'price': '$2'
            },
            {
                'id': 3,
                'name': 'Item 3',
                'price': '$3'
            },
            {
                'id': 4,
                'name': 'Item 4',
                'price': '$4'
            },
            {
                'id': 5,
                'name': 'Item 5',
                'price': '$5'
            }
        ]
        
        $table.bootstrapTable({data: data})

    })

</script>

</body>






</html>

