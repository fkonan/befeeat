<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Razas;

class RazasController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
   }

   public function indexAction()
   {
      $datos = Razas::find();
      $this->view->datos = $datos;
      $this->view->render('razas/index');
   }

   public function nuevoAction()
   {
      $datos = new Razas();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), Razas::blackList);
         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $this->view->datos = $datos;
      $this->view->renderModal('razas/crear');
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = Razas::findById('id',(int) $id);
      if (!$datos) Router::redirect('Razas');

      if ($this->request->isPost()) {

         $datos->assign($this->request->get());

         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }
      $this->view->datos = $datos;
      $this->view->renderModal('razas/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = Razas::findById('id',(int) $id);

      if ($datos) {
         $datos->delete();
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }
}
