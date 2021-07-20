<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Departamentos;

class DepartamentosController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
   }

   public function indexAction()
   {
      $datos = Departamentos::find();
      $this->view->datos = $datos;
      $this->view->render('departamentos/index');
   }

   public function nuevoAction()
   {
      $datos = new Departamentos();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), Departamentos::blackList);
         $existe = Departamentos::findById('codigo_depto', $datos->codigo_depto);
         if (!$existe) {
            if ($datos->save())
               $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
            else
               $resp = ['success' => false, 'error' => $datos->getErrorMessages()];
         } else
            $resp = ['success' => false, 'error' => 'Este departamento ya se encuentra registrado.'];

         $this->jsonResponse($resp);
      }

      $this->view->datos = $datos;
      $this->view->renderModal('departamentos/crear');
   }

   public function editarAction()
   {
      if ($this->request->isPost()) {
         $codigo_depto = $this->request->get('codigo_depto_old');
         $datos = Departamentos::findById('codigo_depto', $codigo_depto);
         if (!$datos) Router::redirect('departamentos');

         $datos->assign($this->request->get());
         $existe = Departamentos::findById('codigo_depto', $datos->codigo_depto);
         if (!$existe) {
            $resultado = $datos->actualizar($datos);
            if ($resultado)
               $resp = ['success' => true];
            else
               $resp = ['success' => false, 'error' => 'No se ha podido actualizar el registro.'];
         } else
            $resp = ['success' => false, 'error' => 'Este departamento ya se encuentra registrado.'];
         $this->jsonResponse($resp);
      } else {
         $codigo_depto = $this->request->get('codigo_depto');
         $datos = Departamentos::findById('codigo_depto', $codigo_depto);
         if (!$datos) Router::redirect('departamentos');

         $this->view->datos = $datos;
         $this->view->renderModal('departamentos/editar');
      }
   }

   public function eliminarAction()
   {
      $codigo_depto = $this->request->get('codigo_depto');
      $datos = Departamentos::findById('codigo_depto', $codigo_depto);

      if ($datos) {
         $datos->eliminar($codigo_depto);
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }
}
