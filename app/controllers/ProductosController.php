<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Productos;
use App\Models\Usuarios;

class ProductosController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
      $this->currentUser=Usuarios::currentUser();
   }

   public function indexAction()
   {
      $datos = Productos::find();
      $this->view->datos = $datos;
      $this->view->render('productos/index');
   }

   public function nuevoAction()
   {
      $datos = new Productos();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), Productos::blackList);
         $datos->estado = 1;
         $datos->usuario_id = $this->currentUser->id;
         $datos->fecha_reg = date('Y-m-d H:i:s');
         if ($datos->save())
            $resp = ['success' => true, 'errors' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'errors' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }
      $this->view->unidad_medida = UNIDAD_MEDIDA;
      $this->view->datos = $datos;
      $this->view->renderModal('productos/crear');
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = Productos::findById('id', (int) $id);
      if (!$datos) Router::redirect('productos');

      if ($this->request->isPost()) {

         $datos->assign($this->request->get());
         $datos->fecha_act = date('Y-m-d H:i:s');

         if ($datos->save())
            $resp = ['success' => true, 'errors' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'errors' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $this->view->unidad_medida = UNIDAD_MEDIDA;
      $this->view->datos = $datos;
      $this->view->renderModal('productos/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = Productos::findById('id', (int) $id);
      if ($datos) {
         if ($datos->estado == 0) {
            $datos->fecha_act = date('Y-m-d H:i:s');
            $datos->estado = 1;
         } else {
            $datos->estado = 0;
            $datos->fecha_act = date('Y-m-d H:i:s');
         }

         $datos->save();
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }

   public function validarAction()
   {
      $codigo = $this->request->get('codigo');
      $datos = Productos::findById('codigo', $codigo);
      if ($datos) {
         return $this->jsonResponse(false);
      }else{
         return $this->jsonResponse(true);
      }
   }
}
