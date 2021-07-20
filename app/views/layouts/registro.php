<?php

use Core\Session;
?>
<!DOCTYPE html>
<html>

<head>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title><?= $this->siteTitle(); ?></title>

   <link rel="shortcut icon" type="image/x-icon" href="<?= PROOT ?>img/icono.jpg">

   <link href="<?= PROOT ?>css/bootstrap/css/bootstrap.min.css" rel="stylesheet">

   <link href="<?= PROOT ?>css/plugins/animate-css/animate.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/plugins/awesome-bootstrap-checkbox/Font-Awesome/css/font-awesome.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/plugins/awesome-bootstrap-checkbox/build.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/style.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/alertMsg.css" rel="stylesheet">

</head>

<!-- <body style="background-color:#ffb07d;"> -->
<body class="section-bg">
   <?= Session::displayMsg() ?>
   <div class="container animated fadeInLeft">
      <?= $this->content('body'); ?>
      <hr style="border-top:1px solid rgba(0, 0, 0, 0.42);" />
      <div class="row">
         <div class="col-md-6 text-left">
            Copyright El Zapatero. Floridablanca - Santander.
         </div>
         <div class="col-md-6 text-right">
            <small>© <?= date('Y') ?></small>
         </div>
      </div>
   </div>

   <script src="<?= PROOT ?>js/plugins/jquery/jquery.min.js"></script>
   <script src="<?= PROOT ?>js/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= PROOT ?>js/plugins/sweetalert/sweetalert.min.js"></script>
   <script src="<?= PROOT ?>js/plugins/validate/jquery.validate.min.js"></script>
   <script src="<?= PROOT ?>js/alertMsg.js"></script>

   <?= $this->content('footer'); ?>
</body>

</html>