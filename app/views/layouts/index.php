<?php
use Core\Session;
?>
<!DOCTYPE html>
<html>

<head>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title><?= $this->siteTitle(); ?></title>

   <!-- Favicons -->
   <link href="<?= PROOT ?>img/icono.jpg" rel="icon">
   <link href="<?= PROOT ?>img/icono.jpg" rel="apple-touch-icon">
   <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

   <link href="<?= PROOT ?>css/bootstrap/css/bootstrap.min.css" rel="stylesheet">

   <link href="<?= PROOT ?>css/plugins/icofont/icofont.min.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/plugins/animate-css/animate.min.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/plugins/venobox/venobox.css" rel="stylesheet">

   <link href="<?= PROOT ?>css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/style.css" rel="stylesheet">
   <link href="<?= PROOT ?>css/alertMsg.css" rel="stylesheet">
   <?= $this->content('head'); ?>
   
</head>

<body class="animated fadeInLeft">
   
   <!-- ======= Menu ======= -->
      <header id="header">
      <div class="container d-flex" style="max-width: 1220px;">
         <div class="logo mr-auto">
            <h1 class="text-light"><a href="<?= PROOT ?>"><span>Beefeat</span></a></h1>
         </div>

         <nav class="nav-menu d-none d-lg-block">
            <ul>
               <li class="active"><a href="#header">Inicio</a></li>
               <li><a href="<?=PROOT?>#servicios">Servicios</a></li>
               <li><a href="<?=PROOT?>#about">Nosotros</a></li>
               <li><a href="<?=PROOT?>#valores">Valores</a></li>
               <li><a href="<?=PROOT?>#elegirnos">Porque Elegirnos</a></li>
               <li><a href="<?=PROOT?>#preguntas">Preguntas</a></li>
               <li><a href="<?=PROOT?>home/testimonios">Testimonios</a></li>
               <li><a href="<?=PROOT?>#contact">Contactenos</a></li>
               <?php if($this->usuario):
               ?>
               <li><a href="<?= PROOT ?>home/cliente"><?=$this->usuario->usuario ?></a></li>
               <?php 
               else:
               ?>
               <li><a href="<?= PROOT ?>users/login">Zona de clientes</a></li>
               <?php endif;?>
               <!-- <li class="drop-down"><a href="">Drop Down</a>
               <ul>
                  <li><a href="#">Drop Down 1</a></li>
                  <li class="drop-down"><a href="#">Drop Down 2</a>
                     <ul>
                        <li><a href="#">Deep Drop Down 1</a></li>
                        <li><a href="#">Deep Drop Down 2</a></li>
                        <li><a href="#">Deep Drop Down 3</a></li>
                        <li><a href="#">Deep Drop Down 4</a></li>
                        <li><a href="#">Deep Drop Down 5</a></li>
                     </ul>
                  </li>
                  <li><a href="#">Drop Down 3</a></li>
                  <li><a href="#">Drop Down 4</a></li>
                  <li><a href="#">Drop Down 5</a></li>
               </ul>
            </li>
            <li><a href="#contact">Contact Us</a></li> -->

            </ul>
         </nav><!-- .nav-menu -->

      </div>
   </header><!-- Menu -->
   <?= Session::displayMsg() ?>
   <?= $this->content('body'); ?>

   <footer id="footer">
      <div class="footer-top">
         <div class="container">
            <div class="row">

               <div class="col-lg-3 col-md-6 footer-info">
                  <h3>El Zapatero</h3>
                  <p>
                     Floridablanca - Santander <br>
                     Colombia<br><br>
                     <strong>Whatsapp:</strong> <a href="https://api.whatsapp.com/send?phone=57 <?=DatosEmpresa::obtenerTelefono();?>&text=Estamos disponibles de lunes a viernes de 8:00 AM a 12:00 PM y de 2:00 PM a 8:00 PM sábados 9:00 AM a 12:00 PM y de 2:00 PM a 5:00 PM. Si nos escribes por fuera de este horario, te contestaremos tan pronto estemos de regreso.">+57 <?=DatosEmpresa::obtenerTelefono();?></a><br>
                     <strong>Email:</strong> <?=DatosEmpresa::obtenerCorreo();?><br>
                     
                  </p>
                  <div class="social-links mt-3">
                     <a href="https://www.facebook.com/ElzapateroEmbellecimientoyArreglo/" class="facebook"><i class="bx bxl-facebook"></i></a>
                     <a href="https://www.instagram.com/elzapateroembellecimiento/" class="instagram"><i class="bx bxl-instagram"></i></a>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="container">
         <div class="copyright">
            &copy; Copyright <strong><span>El Zapatero</span></strong>. Todos los derechos reservados
         </div>
         <div class="credits">
            Designed by <a href="#">Fabian Hernandez</a>
         </div>
      </div>
   </footer>

   <script src="<?= PROOT ?>js/plugins/jquery/jquery.min.js"></script>
   <script src="<?= PROOT ?>js/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= PROOT ?>js/plugins/jquery.easing/jquery.easing.min.js"></script>
   <script src="<?= PROOT ?>js/plugins/jquery-sticky/jquery.sticky.js"></script>
   <script src="<?= PROOT ?>js/plugins/waypoints/jquery.waypoints.min.js"></script>
   <script src="<?= PROOT ?>js/plugins/isotope-layout/isotope.pkgd.min.js"></script>
   <script src="<?= PROOT ?>js/plugins/sweetalert/sweetalert.min.js"></script>
   <script src="<?= PROOT ?>js/plugins/validate/jquery.validate.min.js"></script>
   <script src="<?= PROOT ?>js/plugins/venobox/venobox.min.js"></script>

   <script src="<?= PROOT ?>js/alertMsg.js"></script>
   <script src="<?= PROOT ?>js/main.js"></script>

   <?= $this->content('footer'); ?>
</body>

</html>