<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\OrdenProduccion;
use App\Models\Productos;
use App\Models\UnidadesMedida;

class OrdenProduccionController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
   }

   public function indexAction()
   {
      $datos = OrdenProduccion::listar();
      $this->view->datos = $datos;
      $this->view->render('orden_produccion/index');
   }

   public function nuevoAction()
   {
      $datos = new OrdenProduccion();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), OrdenProduccion::blackList);
         $datos->estado = 1;
         $datos->usuario_id = 1;
         $datos->fecha_reg = date('Y-m-d H:i:s');
         if ($datos->save())
            $resp = ['success' => true, 'errors' => $datos->getErrorMessages()];
         else
            $resp = ['success' => false, 'errors' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }

      $producto_padre = Productos::listarPadres();
      $producto_prima = Productos::listarMateriaPrima();
      $this->view->producto_padre = $producto_padre;
      $this->view->producto_prima = $producto_prima;
      $this->view->datos = $datos;
      $this->view->render('orden_produccion/crear');
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

      $unidades = UnidadesMedida::listarUnidades();
      $this->view->unidades = $unidades;
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
}
