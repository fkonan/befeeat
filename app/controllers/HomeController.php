<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Usuarios;
use Core\Router;
use Core\Session;
use Core\H;
use Spipu\Html2Pdf\Html2Pdf;

class HomeController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
      $this->currentUser = Usuarios::currentUser();
   }

   public function indexAction()
   {
     
      if ($this->currentUser)
      {
         
         $this->view->render('home/index');
      }
      else
      { 
         Router::redirect('usuarios/login');
      }
   }

   public function descargarAction()
   {
      $path = '/var/tmp/test.pdf';
      $html2pdf = new Html2Pdf('P', 'A4', 'fr');
      $html2pdf->setDefaultFont('Arial');
      $html2pdf->writeHTML($_POST["content"]);
      $html2pdf->output($path);
   }
}
