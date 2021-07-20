<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\MateriaPrima;
use App\Models\Usuarios;

class MateriaPrimaController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
      $this->currentUser=Usuarios::currentUser();
   }

   public function indexAction()
   {
      $datos = MateriaPrima::find();
      $this->view->datos = $datos;
      $this->view->render('materia_prima/index');
   }

   public function nuevoAction()
   {
      $datos = new MateriaPrima();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), MateriaPrima::blackList);
         $datos->usuario_id =$this->currentUser->id;
         $datos->fecha_reg = date('Y-m-d H:i:s');
         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $this->view->unidad_medida = UNIDAD_MEDIDA;
      $this->view->datos = $datos;
      $this->view->renderModal('materia_prima/crear');
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = MateriaPrima::findById('id', (int) $id);
      if (!$datos) Router::redirect('materiaPrima');

      if ($this->request->isPost()) {

         $datos->assign($this->request->get());
         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $this->view->unidad_medida = UNIDAD_MEDIDA;
      $this->view->datos = $datos;
      $this->view->renderModal('materia_prima/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = MateriaPrima::findById('id', (int) $id);
      if ($datos) {
         $datos->delete();
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }

   public function validarAction()
   {
      $codigo = $this->request->get('codigo');
      $datos = MateriaPrima::findById('codigo', $codigo);
      if ($datos) {
         return $this->jsonResponse(false);
      }else{
         return $this->jsonResponse(true);
      }
   }
}
