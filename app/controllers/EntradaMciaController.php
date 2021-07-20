<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Usuarios;
use App\Models\EntradaMcia;
use App\Models\EntradaMciaDet;
use App\Models\Proveedores;
use App\Models\Bodegas;
use App\Models\Productos;
use App\Models\Inventario;
use App\Models\UnidadesMedida;
use App\Models\MateriaPrima;

class EntradaMciaController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
      $this->currentUser = Usuarios::currentUser();
   }

   public function indexAction()
   {
      $datos = EntradaMcia::listar();
      // H::dnd($datos);
      $this->view->datos = $datos;
      $this->view->render('entrada_mcia/index');
   }

   public function detalleAction()
   {
      if ($this->request->isPost()) {

         $id = json_decode($_POST['id']);
         $datos = EntradaMcia::detalle($id);
         if ($datos) {
            $resp = ['success' => true,  'datos' => $datos];
            $this->jsonResponse($resp);
         } else {
            $resp = ['success' => false];
            $this->jsonResponse($resp);
         }

         // $detalle = EntradaMciaDet::detalle($id);
         // $this->view->datos = $datos;
         // $this->view->detalle = $detalle;
         // $this->view->render('entrada_mcia/detalle');

      }
   }

   public function nuevoAction()
   {
      $datos = new EntradaMcia();
      $contadorDetalle = 0;
      $contadorInventario = 0;
      if ($this->request->isPost()) {

         $datos->tipo_entrada = $_POST['entrada'][1]['value'];
         $datos->numero_orden = $_POST['entrada'][2]['value'];
         $datos->proveedor_id = $_POST['entrada'][3]['value'];
         $datos->bodega_id = $_POST['entrada'][4]['value'];
         $datos->total = $_POST['entrada'][10]['value'];
         $datos->observaciones = $_POST['entrada'][5]['value'];
         $datos->usuario_id = $this->currentUser->id;
         $datos->fecha_reg = date('Y-m-d H:i:s');
         $guarda = $datos->save();
         if ($guarda) {
            $entrada_id = $datos->id;
            foreach ($_POST['arr'] as $campo) {
               $detalle = new EntradaMciaDet();
               $detalle->entrada_id = $entrada_id;
               $detalle->producto_id = $campo['materia_prima'];
               $detalle->unidad_medida = 'GRAMOS';
               $detalle->cantidad = $campo['cantidad'];
               $detalle->valor = $campo['valor'];
               $detalle->subtotal = $campo['subtotal'];
               $detalle->usuario_id = $this->currentUser->id;
               $detalle->fecha_reg = date('Y-m-d H:i:s');
               $save = $detalle->save();
               if ($save) {
                  $contadorDetalle++;
               }
               $inventario = EntradaMcia::inventario($campo['materia_prima'], $campo['cantidad'], $this->currentUser->id);
               if ($inventario) {
                  $contadorInventario++;
               }
            }

            if ($contadorDetalle > 0 && $contadorInventario > 0) {
               $resp = ['success' => true];
               $this->jsonResponse($resp);
            } else {
               $resp = ['success' => false, 'errors' => 'Error al guardar el detalle de la entrada o el inventario'];
               $this->jsonResponse($resp);
            }
         } else {
            $resp = ['success' => false, 'errors' => 'Error al guardar la entrada'];
            $this->jsonResponse($resp);
         }
      }

      $bodegas = Bodegas::listarBod();
      $proveedores = Proveedores::listarProv();
      $productos = MateriaPrima::listarMateriaP();
      $this->view->datos = $datos;
      $this->view->bodegas = $bodegas;
      $this->view->proveedores = $proveedores;
      $this->view->productos = $productos;
      $this->view->renderModal('entrada_mcia/crear');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = new EntradaMcia();
      $datos = $datos->eliminar($id, 1); //$this->currentUser->id
      if ($datos[0]) {
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      } else {
         $resp = ['success' => false, 'errors' => $datos[1]];
         return $this->jsonResponse($resp);
      }
   }

   public function editAction($id)
   {
      $datos = EntradaMcia::listarEdit($id);

      if ($datos) {
         $bodegas = Bodegas::listarBod();
         $proveedores = Proveedores::listarProv();
         $productos = MateriaPrima::listarMateriaP();
         $this->view->datos = $datos;
         $this->view->bodegas = $bodegas;
         $this->view->proveedores = $proveedores;
         $this->view->productos = $productos;
         $this->view->render('entrada_mcia/editar_entrada');
      } else {
         Router::redirect('entradaMcia/index');
      }
   }

   public function  editDetalleAction()
   {
      if ($this->request->isPost()) {
         // si es la misma materia prima
         if ($this->request->get('materia_prima') == $this->request->get('id_materia_old')) {
            $inventario = Inventario::detalle($this->request->get('materia_prima'));
            if ($inventario) {
               // operacion para saber inventario
               $restaInventario = $inventario[0]->cantidad - $this->request->get('cantidad_old');
               $nuevoInventario = $restaInventario + $this->request->get('cantidad');
               if ($nuevoInventario > 0) {
                  $updateCantidad = Inventario::findById('id', (int)$inventario[0]->id);
                  $updateCantidad->cantidad = $nuevoInventario;
                  if ($updateCantidad->save()) {
                     //cabecera update
                     $entradaMcia = EntradaMcia::findById('id', (int) $_POST['id']);
                     $entradaMcia->total = $this->request->get('total');
                     // detalle update
                     $detalleMcia = EntradaMciaDet::findById('id', (int) $_POST['id_detalle']);
                     $detalleMcia->producto_id = $this->request->get('materia_prima');
                     $detalleMcia->cantidad = $this->request->get('cantidad');
                     $detalleMcia->valor = $this->request->get('valor');
                     $detalleMcia->subtotal = $this->request->get('subtotal');

                     if ($entradaMcia->save() && $detalleMcia->save()) {
                        $resp = ['success' => true, 'msg' => 'Se ha actualizado correctamente el detalle de la entrada'];
                        return $this->jsonResponse($resp);
                     } else {
                        $resp = ['success' => false, 'msg' => 'Ha ocurrido un problema actualizar el detalle'];
                        return $this->jsonResponse($resp);
                     }
                  } else {
                     $resp = ['success' => false, 'msg' => 'Error al actualizar el inventario'];
                     return $this->jsonResponse($resp);
                  }
               } else {
                  $resp = ['success' => false, 'msg' => 'El inventario no puede ser menor a cero(0)'];
                  return $this->jsonResponse($resp);
               }
            } else {
               $resp = ['success' => false, 'msg' => 'Producto no encontrado en el inventario'];
               return $this->jsonResponse($resp);
            }
         } else {
            // resto el inventario
            $inventario_old = Inventario::detalle($this->request->get('id_materia_old'));
            $restaAntInven = $inventario_old[0]->cantidad - $this->request->get('cantidad_old');
            $updateCantidadAnt = Inventario::findById('id', (int)$inventario_old[0]->id);
            $updateCantidadAnt->cantidad = $restaAntInven;

            if ($updateCantidadAnt->save()) {

               $inventario = Inventario::detalle($this->request->get('materia_prima'));

               if ($inventario) {

                  $nuevoInventario = $inventario[0]->cantidad + $this->request->get('cantidad');

                  if ($nuevoInventario > 0) {

                     $updateCantidad = Inventario::findById('id', (int)$inventario[0]->id);
                     $updateCantidad->cantidad = $nuevoInventario;

                     if ($updateCantidad->save()) {
                        //cabecera update
                        $entradaMcia = EntradaMcia::findById('id', (int) $_POST['id']);
                        $entradaMcia->total = $this->request->get('total');

                        // detalle update
                        $detalleMcia = EntradaMciaDet::findById('id', (int) $_POST['id_detalle']);
                        $detalleMcia->producto_id = $this->request->get('materia_prima');
                        $detalleMcia->cantidad = $this->request->get('cantidad');
                        $detalleMcia->valor = $this->request->get('valor');
                        $detalleMcia->subtotal = $this->request->get('subtotal');

                        if ($entradaMcia->save() && $detalleMcia->save()) {
                           $resp = ['success' => true, 'msg' => 'Se ha actualizado correctamente el detalle de la entrada'];
                           return $this->jsonResponse($resp);
                        } else {
                           $resp = ['success' => false, 'msg' => 'Ha ocurrido un problema actualizar el detalle'];
                           return $this->jsonResponse($resp);
                        }
                     } else {
                        $resp = ['success' => false, 'msg' => 'Error al actualizar el inventario'];
                        return $this->jsonResponse($resp);
                     }
                  } else {
                     $resp = ['success' => false, 'msg' => 'El inventario no puede ser menor a cero(0)'];
                     return $this->jsonResponse($resp);
                  }
               } else {
                  $resp = ['success' => false, 'msg' => 'Producto no encontrado en el inventario'];
                  return $this->jsonResponse($resp);
               }
            } else {
               $resp = ['success' => false, 'msg' => 'No se pudo actualizar el inventario correctamente'];
               return $this->jsonResponse($resp);
            }
         }
      }
   }

   public function editAddDetalleAction()
   {

      if ($this->request->isPost()) {

         $entrada = EntradaMcia::findById('id', (int) $_POST['id']);
         $entrada->total = $entrada->total + $this->request->get('subtotal');
         if ($entrada->save()) {

            $detalle = new EntradaMciaDet();
            $detalle->entrada_id = $this->request->get('id');
            $detalle->producto_id = $this->request->get('materia_prima');
            $detalle->unidad_medida = 'GRAMOS';
            $detalle->cantidad = $this->request->get('cantidad');
            $detalle->valor = $this->request->get('valor');
            $detalle->subtotal = $this->request->get('subtotal');
            $detalle->usuario_id = $this->currentUser->id;
            $detalle->fecha_reg = date('Y-m-d H:i:s');
            $save = $detalle->save();
            if ($save) {

               $inventario = EntradaMcia::inventario($this->request->get('materia_prima'), $this->request->get('cantidad'), $this->currentUser->id);
               if ($inventario) {
                  $resp = ['success' => true, 'msg' => 'Registro realizado con exito'];
                  return $this->jsonResponse($resp);
               } else {
                  $resp = ['success' => false, 'msg' => 'Ocurrio un error se al sumar el inventario'];
                  return $this->jsonResponse($resp);
               }
            } else {
               $resp = ['success' => false, 'msg' => 'Ocurrio un error se al crear el registro en el detalle'];
               return $this->jsonResponse($resp);
            }
         } else {
            $resp = ['success' => false, 'msg' => 'Ocurrio un error al actualizar el total del entrada'];
            return $this->jsonResponse($resp);
         }
      }
   }
   public function updateCabeceraAction()
   {
      if ($this->request->isPost()) {

         $entrada = EntradaMcia::findById('id', (int) $_POST['id']);
         $entrada->tipo_entrada = $this->request->get('tipo_entrada');
         $entrada->numero_orden = $this->request->get('numero_orden');
         $entrada->proveedor_id = $this->request->get('proveedor_id');
         $entrada->bodega_id = $this->request->get('bodega_id');
         $entrada->observaciones = $this->request->get('observaciones');

         if ($entrada->save()) {
            $resp = ['success' => true, 'msg' => 'Registro realizado con exito'];
            return $this->jsonResponse($resp);
         } else {
            $resp = ['success' => false, 'msg' => 'Ocurrio un error al actualizar la cabecera de la entrada'];
            return $this->jsonResponse($resp);
         }
      }
   }

   public function deleteDetalleAction()
   {
      if ($this->request->isPost()) {
         $inventario = Inventario::detalle($this->request->get('id_materia'));
         if ($inventario) {
            $restaInventario = $inventario[0]->cantidad - $this->request->get('cantidad');
            if ($restaInventario > 0) {
               $updateCantidad = Inventario::findById('id', (int)$inventario[0]->id);
               $updateCantidad->cantidad = $restaInventario;
               if ($updateCantidad->save()) {
                  //cabecera update
                  $entradaMcia = EntradaMcia::findById('id', (int)  $this->request->get('id'));
                  $entradaMcia->total = $entradaMcia->total - $this->request->get('subtotal');
                  $detalleMcia = EntradaMciaDet::findById('id', (int) $this->request->get('id_detalle'));
                  $detalleMcia->delete();
                  if ($entradaMcia->save()) {
                     $resp = ['success' => true, 'msg' => 'Se ha actualizado correctamente el detalle de la entrada'];
                     return $this->jsonResponse($resp);
                  } else {
                     $resp = ['success' => false, 'msg' => 'Ha ocurrido un problema actualizar el detalle'];
                     return $this->jsonResponse($resp);
                  }
               }
            } else {
               $resp = ['success' => false, 'msg' => 'El inventario no puede ser menor a cero(0)'];
               return $this->jsonResponse($resp);
            }
         }
      }
   }
}
