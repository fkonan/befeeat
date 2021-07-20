<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\PlanVenta;
use App\Models\Mascotas;
use App\Models\Productos;
use App\Models\Presentaciones;
use App\Models\PlanVentaDet;

class PlanVentaController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
   }

   public function indexAction()
   {
      $datos = PlanVenta::listar();
      $this->view->datos = $datos;
      $this->view->render('plan_venta/index');
   }

   public function nuevoAction()
   {
      $datos = new PlanVenta();
      $detalle = new PlanVentaDet();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), PlanVenta::blackList);
         $datos->estado = 'ACTIVO';
         $datos->fecha_reg = date('Y-m-d H:i:s');

         if ($datos->save())
            $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $mascotas = Mascotas::listarMascotas();
      $productos = Productos::listarProductos();
      $presentacion = Presentaciones::listarPresentaciones();

      $this->view->mascotas = $mascotas;
      $this->view->productos = $productos;
      $this->view->presentacion = $presentacion;
      $this->view->datos = $datos;
      $this->view->detalle = $detalle;
      $this->view->renderModal('plan_venta/crear');
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = PlanVenta::findById('id', (int) $id);
      if (!$datos) Router::redirect('PlanVenta');

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
      $this->view->renderModal('plan_venta/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = PlanVenta::findById('id', (int) $id);
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
      $datos = PlanVenta::findFirst([
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

   public function cargarDatosMascotaAction()
   {
      $mascota_id = $this->request->get('mascota_id');
      $datos=PlanVenta::cargarDatosMascota($mascota_id);
      $resp = ['success' => true,'datos'=>$datos];
      return $this->jsonResponse($resp);
   }
}
