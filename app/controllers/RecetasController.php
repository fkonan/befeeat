<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Recetas;
use App\Models\Usuarios;
use App\Models\Productos;

class RecetasController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
      $this->currentUser = Usuarios::currentUser();
   }

   public function indexAction()
   {
      $datos = Recetas::listar();
      $this->view->datos = $datos;
      $this->view->render('recetas/index');
   }

   public function nuevoAction()
   {
      $datos = new Recetas();
      if ($this->request->isPost()) {
         foreach ($_POST['arr'] as $campo) {
            $datos = new Recetas();
            $datos->producto = $_POST['producto'];
            $datos->materia_prima = $campo['materia_prima'];
            $datos->porcentaje = $campo['porcentaje'];
            $datos->usuario_id = $this->currentUser->id;
            $datos->fecha_reg = date('Y-m-d H:i:s');
            $datos->save();
         }
         $resp = ['success' => true];
         $this->jsonResponse($resp);
      }

      $productos = Recetas::listarProductos();
      $materia_prima = Recetas::listarMateriaPrima();
      $this->view->productos = $productos;
      $this->view->materia_prima = $materia_prima;
      $this->view->datos = $datos;
      $this->view->renderModal('recetas/crear');
   }

   public function editarAction()
   {
      if ($this->request->isPost()) {

         $producto_old = $_POST['producto_old'];
         $producto_new = $_POST['producto_new'];
         $eliminar = Recetas::eliminar($producto_old);
         if ($eliminar) {
            foreach ($_POST['arr'] as $campo) {
               $datos = new Recetas();
               $datos->producto = $producto_new;
               $datos->materia_prima = $campo['materia_prima'];
               $datos->porcentaje = $campo['porcentaje'];
               $datos->usuario_id = $this->currentUser->id;
               $datos->fecha_reg = date('Y-m-d H:i:s');
               $datos->save();
            }
            $resp = ['success' => true];
            $this->jsonResponse($resp);
         } else {
            $resp = ['success' => false, 'error' => 'Ha ocurrido un error al eliminar la receta.'];
            $this->jsonResponse($resp);
         }
      }

      $id = $this->request->get('id');
      $datos = Recetas::recetaPorProducto($id);
      $productos = Recetas::listarProductos();
      $materia_prima = Recetas::listarMateriaPrima();
      $this->view->productos = $productos;
      $this->view->materia_prima = $materia_prima;
      $this->view->datos = $datos;
      $this->view->renderModal('Recetas/editar_receta');
   }


   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = Recetas::eliminar($id);
      if ($datos) {
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }

   //no se esta usando esta validacion
   public function validarAction()
   {
      $codigo = $this->request->get('codigo');
      $datos = Recetas::findById('codigo', $codigo);
      if ($datos) {
         return $this->jsonResponse(false);
      } else {
         return $this->jsonResponse(true);
      }
   }

   //por borrar
   public function consultarProductoAction($id)
   {
      $datos = Productos::findById('id', (int)$id);
      $resp = ['datos' => $datos];
      return $this->jsonResponse($resp);
   }

   public function validarRecetaAction($producto)
   {
      $datos = Recetas::findFirst([
         'conditions' => 'producto=?',
         'bind' => [$producto]
      ]);
      if ($datos) {
         $resp = ['success' => true];
         $this->jsonResponse($resp);
      } else {
         $resp = ['success' => false];
         $this->jsonResponse($resp);
      }
   }
}
