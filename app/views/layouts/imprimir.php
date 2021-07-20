<?php
use Core\Session;
use App\Models\Users;
use App\Controllers;
use App\Models\Modulos;
use App\Controllers\PermisosController;
use App\Controllers\RolesController;
?>
<!DOCTYPE html>
<html>
<head>      
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" type="image/x-icon" href="<?=PROOT?>img/icono_ec2s.ico">
   <link href="<?=PROOT?>css/bootstrap.min.css" rel="stylesheet">
   <link href="<?=PROOT?>font-awesome/css/font-awesome.css" rel="stylesheet">
   <link href="<?=PROOT?>css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
   <link href="<?=PROOT?>css/plugins/iCheck/custom.css" rel="stylesheet">
   <link href="<?=PROOT?>css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
   <link href="<?=PROOT?>css/animate.css" rel="stylesheet">
   <link href="<?=PROOT?>css/style.css" rel="stylesheet">
   <link href="<?=PROOT?>css/custom.css" rel="stylesheet">
   <?= $this->content('head'); ?>
  
</head>
<body class="fixed-nav md-skin">
   <div id="wrapper">
      <div id="page-wrapper" class="gray-bg">
         <div class="wrapper wrapper-content animated fadeInDown">
            <?= Session::displayMsg() ?>
            <?= $this->content('body'); ?> 
            <div id="contenido">
            </div>
         </div>
      </div>
   </div>	   

   <!-- Mainly scripts -->
      <script src="<?=PROOT?>js/jQuery-3.3.1.min.js"></script>
      <script src="<?=PROOT?>js/popper.min.js"></script>
      <script src="<?=PROOT?>js/bootstrap.min.js"></script>
      <script src="<?=PROOT?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
      <script src="<?=PROOT?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
      <script src="<?=PROOT?>js/plugins/sweetalert/sweetalert.min.js"></script>
      <script src="<?=PROOT?>js/plugins/validate/jquery.validate.min.js"></script>

      <!-- Custom and plugin javascript -->
      <script src="<?=PROOT?>js/inspinia.js"></script>
      <script src="<?=PROOT?>js/plugins/pace/pace.min.js"></script>
      <script src="<?=PROOT?>js/plugins/iCheck/icheck.min.js"></script>


      <script src="<?=PROOT?>js/alertMsg.js"></script>
      <script src="<?=PROOT?>js/custom.js"></script>

      <?= $this->content('footer'); ?>
  </body>
  </html>