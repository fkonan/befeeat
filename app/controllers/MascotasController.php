<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Mascotas;
use App\Models\Clientes;
use App\Models\Razas;
use App\Models\Usuarios;

class MascotasController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
      $this->currentUser = Usuarios::currentUser();
   }

   public function indexAction()
   {
      $datos = Mascotas::listar();
      $this->view->datos = $datos;
      $this->view->render('mascotas/index');
   }

   public function nuevoAction()
   {
      $datos = new Mascotas();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), Mascotas::blackList);
         $datos->usuario_id = $this->currentUser->id;
         $datos->fecha_reg = date('Y-m-d H:i:s');
         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $clientes = Clientes::listarClientes();
      $razas = Razas::listarRazas();

      $this->view->clientes = $clientes;
      $this->view->razas = $razas;
      $this->view->datos = $datos;
      $this->view->renderModal('mascotas/crear');
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = Mascotas::findById('id', (int) $id);
      if (!$datos) Router::redirect('mascotas');

      if ($this->request->isPost()) {

         $datos->assign($this->request->get());

         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }
      
      $clientes = Clientes::listarClientes();
      $razas = Razas::listarRazas();

      $this->view->clientes = $clientes;
      $this->view->razas = $razas;
      $this->view->datos = $datos;
      $this->view->datos = $datos;
      $this->view->renderModal('mascotas/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = Mascotas::findById('id', (int) $id);

      if ($datos) {
         $datos->delete();
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }
}
