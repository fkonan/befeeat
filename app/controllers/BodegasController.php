<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Bodegas;
use App\Models\Departamentos;
use App\Models\Municipios;
use App\Models\Usuarios;

class BodegasController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
      $this->currentUser=Usuarios::currentUser();
   }

   public function indexAction()
   {
      $datos = Bodegas::listar();
      $this->view->datos = $datos;
      $this->view->render('bodegas/index');
   }

   public function nuevoAction()
   {
      $datos = new Bodegas();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), Bodegas::blackList);
         $datos->estado = 1;
         $datos->usuario_id = $this->currentUser->id;
         $datos->fecha_reg = date('Y-m-d H:i:s');
         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $deptos = Departamentos::listarDeptos();

      $this->view->deptos = $deptos;
      $this->view->muni = [];
      $this->view->datos = $datos;
      $this->view->renderModal('bodegas/crear');
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = Bodegas::findById('id', (int) $id);
      if (!$datos) Router::redirect('bodegas');

      if ($this->request->isPost()) {

         $datos->assign($this->request->get());

         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $deptos = Departamentos::listarDeptos();
      $muni = Municipios::listarMuni();

      $this->view->deptos = $deptos;
      $this->view->muni = $muni;

      $this->view->datos = $datos;
      $this->view->renderModal('bodegas/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = Bodegas::findById('id', (int) $id);
      if ($datos) {
         if ($datos->estado == 0)
            $datos->estado = 1;
         else
            $datos->estado = 0;

         $datos->save();
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }
}
