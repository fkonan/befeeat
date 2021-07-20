<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Clientes;
use App\Models\Departamentos;
use App\Models\Municipios;

class ClientesController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
   }

   public function indexAction()
   {
      $datos = Clientes::listar();
      $this->view->datos = $datos;
      $this->view->render('clientes/index');
   }

   public function nuevoAction()
   {
      $datos = new Clientes();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), Clientes::blackList);
         $datos->estado = 'ACTIVO';
         $datos->fecha_reg = date('Y-m-d H:i:s');

         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $tipo_documento = TIPOS_DOCUMENTO;
      $tipo_per = TIPO_PERSONA;
      $deptos = Departamentos::listarDeptos();

      $this->view->tipo_documento = $tipo_documento;
      $this->view->tipo_per = $tipo_per;
      $this->view->deptos = $deptos;
      $this->view->muni = [];
      $datos->tipo_documento = 'Cédula de Ciudadanía';
      $datos->tipo_persona = 'NATURAL';
      $this->view->datos = $datos;
      $this->view->renderModal('clientes/crear');
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = Clientes::findById('id', (int) $id);
      if (!$datos) Router::redirect('Clientes');

      if ($this->request->isPost()) {

         $datos->assign($this->request->get());

         if (!empty($_POST['gran_superficie'])) {
            $datos->gran_superficie = 1;
         } else {
            $datos->gran_superficie = 0;
         }
         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $tipo_documento = TIPOS_DOCUMENTO;
      $tipo_per = TIPO_PERSONA;
      $deptos = Departamentos::listarDeptos();
      $muni = Municipios::listarMuni();

      $this->view->tipo_documento = $tipo_documento;
      $this->view->tipo_per = $tipo_per;
      $this->view->deptos = $deptos;
      $this->view->muni = $muni;

      $this->view->datos = $datos;
      $this->view->renderModal('clientes/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = Clientes::findById('id', (int) $id);
      if ($datos) {
         if ($datos->estado == 'INACTIVO')
            $datos->estado = 'ACTIVO';
         else
            $datos->estado = 'INACTIVO';
         $datos->save();
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }

   public function validarDuplicadoAction($documento)
   {
      $datos = Clientes::findFirst([
         'conditions' => 'documento=?',
         'bind' => [$documento]
      ]);
      if ($datos) {
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      } else {
         $resp = ['success' => false];
         return $this->jsonResponse($resp);
      }
   }
}
