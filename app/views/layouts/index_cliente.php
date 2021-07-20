<?php

use Core\Session;
?>
<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">

   <title><?= $this->siteTitle(); ?></title>
   <!-- Favicons -->
   <link href="<?= PROOT ?>img/icono.jpg" rel="icon">
   <link href="<?= PROOT ?>img/icono.jpg" rel="apple-touch-icon">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="<?= PROOT ?>adminlte/plugins/fontawesome-free/css/all.min.css">
   <!-- Ionicons -->
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="<?= PROOT ?>adminlte/dist/css/adminlte.min.css">
   <!-- Google Font: Source Sans Pro -->
   <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


   <link href="<?= PROOT ?>css/plugins/animate-css/animate.min.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/style.css" rel="stylesheet">
   <!-- <link href="<?= PROOT ?>css/alertMsg.css" rel="stylesheet"> -->
   <?= $this->content('head'); ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
   <?php date_default_timezone_set('America/Bogota'); ?>
   <div class="wrapper">
      <!-- Barra superior -->
      <nav class="main-header navbar navbar-expand navbar-dark navbar-lightblue">
         <!-- Barra para expandir y contraer panel lateral -->
         <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
         </ul>
         <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <!-- <li class="nav-item dropdown">
               <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                  <span class="badge badge-warning navbar-badge">15</span>
               </a>
               <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-item dropdown-header">15 Notificaciones</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                     <i class="nav-icon fas fa-address-book"></i> 14 Cotizaciones pendientes
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                     <i class="nav-icon fas fa-truck"></i> 1 Entrega realizada
                  </a>
               </div>
            </li> -->
            <li class="nav-item">
               <a class="nav-link" href="<?=PROOT?>users/logout" role="button" title="Cerrar Sesión">
                  <i class="fas fa-sign-out-alt"></i>
               </a>
            </li>
         </ul>
      </nav>
      <!-- Fin barra superior -->
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
         <!-- Sidebar -->
         <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
               <div class="image">
                  <?php if($this->cliente->genero=='MASCULINO'):?>
                     <img src="<?= PROOT ?>img/usuario_hombre.jpg" class="img-circle elevation-2" alt="Cliente">
                  <?php else:?>
                     <img src="<?= PROOT ?>img/usuario_mujer.jpg" class="img-circle elevation-2" alt="Cliente">
                  <?php endif;?>
               </div>
               <div class="info pt-2">
                  <a href="<?= PROOT ?>home/cliente" class="d-block"><?=$this->cliente->usuario; ?></a>
               </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2" id="menu">
               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-header" style="padding: 0 1rem .5rem;">CUENTA</li>
                  <li class="nav-item">
                     <a href="<?= PROOT ?>users/actualizarDatosCliente" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                           Actualizar datos
                        </p>
                     </a>
                  </li>
                  <li class="nav-header">PEDIDOS</li>
                  <li class="nav-item">
                     <a href="<?=PROOT?>factura/rastrearPedido" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>Rastrear pedidos</p>
                     </a>
                  </li>
                  <li class="nav-item user-panel">
                     <a href="<?=PROOT?>factura/listarFinalizadasCliente" class="nav-link">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Pedidos finalizados</p>
                     </a>
                  </li>
                  <li class="nav-item user-panel">
                     <a href="<?=PROOT?>pedidos/pedido" class="nav-link">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>Nuevo pedido</p>
                     </a>
                  </li>

                  <li class="nav-item has-treeview">
                  <li class="nav-item">
                     <a href="<?= PROOT ?>home" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                           Volver al portal
                        </p>
                     </a>
                  </li>
                  </li>

               </ul>
            </nav>
            <!-- /.sidebar-menu -->
         </div>
         <!-- /.sidebar -->
      </aside>
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1 class="m-0 text-dark">Panel de Control</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= PROOT ?>home/cliente">Cliente</a></li>
                        <li class="breadcrumb-item active">Panel de Control</li>
                     </ol>
                  </div><!-- /.col -->
               </div><!-- /.row -->
            </div><!-- /.container-fluid -->
         </div>

         <!-- Main content -->
         <section class="content">
            <div class="container-fluid">
               <?= Session::displayMsg() ?>
               <?= $this->content('body'); ?>
            </div><!-- /.container-fluid -->
         </section>
         <!-- /.content -->
      </div>
      <footer class="main-footer">
         <strong>Copyright &copy; <?= date('Y'); ?> <a href="<?= PROOT ?>home/index">El Zapatero</a></strong>
      </footer>
   </div>
   <div class="modal inmodal fade font-weight-bold" id="frmModal" tabindex="-1" role="dialog" aria-labelledby="frmModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h3 class="modal-title text-decoration"><u id="modalTitulo"></u></h3>
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body" id="bodyModal">
               ...
            </div>
         </div>
      </div>
   </div>

   <!-- jQuery -->
   <script src="<?= PROOT ?>adminlte/plugins/jquery/jquery.min.js"></script>
   <!-- jQuery UI 1.11.4 -->
   <script src="<?= PROOT ?>adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
   <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
   <script>
      $.widget.bridge('uibutton', $.ui.button)
   </script>
   <!-- Bootstrap 4 -->
   <script src="<?= PROOT ?>adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= PROOT ?>adminlte/plugins/moment/moment.min.js"></script>
   <script src="<?= PROOT ?>adminlte/plugins/daterangepicker/daterangepicker.js"></script>
   <!-- Summernote -->
   <script src="<?= PROOT ?>adminlte/plugins/summernote/summernote-bs4.min.js"></script>
   <!-- AdminLTE App -->
   <script src="<?= PROOT ?>adminlte/dist/js/adminlte.js"></script>

   <script src="<?= PROOT ?>js/plugins/sweetalert/sweetalert.min.js"></script>
   <script src="<?= PROOT ?>js/plugins/validate/jquery.validate.min.js"></script>
   <script src="<?= PROOT ?>js/alertMsg.js"></script>
   <?= $this->content('footer'); ?>
</body>

</html>