<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Usuarios;
use App\Models\Presentaciones;

class PresentacionesController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
      $this->currentUser=Usuarios::currentUser();
   }

   public function indexAction()
   {
      $datos = Presentaciones::find();
      $this->view->datos = $datos;
      $this->view->render('presentaciones/index');
   }

   public function nuevoAction()
   {
      $datos = new Presentaciones();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), Presentaciones::blackList);
         $datos->usuario_id=$this->currentUser->id;
         $datos->fecha_reg = date('Y-m-d H:i:s');
         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $this->view->datos = $datos;
      $this->view->renderModal('presentaciones/crear');
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = Presentaciones::findById('id',(int) $id);
      if (!$datos) Router::redirect('presentaciones');

      if ($this->request->isPost()) {

         $datos->assign($this->request->get());
         $datos->usuario_id=$this->currentUser->id;
         $datos->fecha_reg = date('Y-m-d H:i:s');
         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }
      $this->view->datos = $datos;
      $this->view->renderModal('presentaciones/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = Presentaciones::findById('id',(int) $id);

      if ($datos) {
         $datos->delete();
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }
}
