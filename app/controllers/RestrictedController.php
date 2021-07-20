<?php

namespace App\Controllers;

use App\Models\Usuarios;
use Core\Router;
use Core\Controller;
use Core\H;

class RestrictedController extends Controller
{
   public function indexAction()
   {
      if ($_SERVER['PATH_INFO'] == '/usuarios/login') {
         if (Usuarios::currentUser())
            Router::redirect('home/index');
      }

      $this->view->setLayout('index_admin');
      $this->view->render('restricted/index');
   }

   public function badTokenAction()
   {
      $this->view->render('restricted/badToken');
   }
}
