<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Proveedores;
use App\Models\Departamentos;
use App\Models\Municipios;
use App\lib\utilities\Uploads;

class ProveedoresController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
   }

   public function indexAction()
   {
      $datos = Proveedores::listar();
      $this->view->datos = $datos;
      $this->view->render('proveedores/index');
   }

   public function nuevoAction()
   {
      $datos = new Proveedores();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), Proveedores::blackList);
         $datos->estado = 'ACTIVO';
         $datos->fecha_reg = date('Y-m-d H:i:s');

         if (!empty($_FILES['rut']['tmp_name'])) {

            $files['rut'] = $_FILES['rut'];
            $uploads = new Uploads($files);
            $uploads->runValidation();
            $imageserror = $uploads->validates();
            //si devuelve un array es porque hay error
            if (is_array($imageserror)) {
               $msg = "";
               foreach ($imageserror as $name => $message) {
                  $msg .= $message . " ";
               }
               $resp = ['success' => false, 'error' => $msg];
               $this->jsonResponse($resp);
               return;
            } else {
               if ($datos->save()) {
                  $path = 'documentos' . DS;

                  foreach ($uploads->getFiles() as $key => $file) {
                     $parts = explode('.', $file['name']);
                     $ext = end($parts);
                     $datos->rut = $path . $datos->documento . '.' . $ext;
                     $uploads->upload($path, $datos->documento . '.' . $ext, $file['tmp_name']);
                  }

                  $datos->save();
                  $resp = ['success' => true];
               } else
                  $resp = ['success' => false, 'error' => $datos->getErrorMessages()];
            }
         }
         if ($datos->save()) {
            $resp = ['success' => true];
         } else
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
      $datos->tipo_documento = 'Nit';
      $datos->tipo_persona = 'JURÍDICA';
      $this->view->datos = $datos;
      $this->view->renderModal('proveedores/crear');
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = Proveedores::findById('id', (int) $id);
      if ($this->request->isPost()) {

         if (!$datos) Router::redirect('proveedores');
            
         $datos->assign($this->request->get());

         if (!empty($_FILES['rut']['tmp_name'])) {

            $files['rut'] = $_FILES['rut'];
            $uploads = new Uploads($files);
            $uploads->runValidation();
            $imageserror = $uploads->validates();
            //si devuelve un array es porque hay error
            if (is_array($imageserror)) {
               $msg = "";
               foreach ($imageserror as $name => $message) {
                  $msg .= $message . " ";
               }
               $resp = ['success' => false, 'error' => $msg];
               $this->jsonResponse($resp);
               return;
            } else {
               if ($datos->save()) {
                  $path = 'documentos' . DS;

                  foreach ($uploads->getFiles() as $key => $file) {
                     $parts = explode('.', $file['name']);
                     $ext = end($parts);
                     $datos->rut = $path . $datos->documento . '.' . $ext;
                     $uploads->upload($path, $datos->documento . '.' . $ext, $file['tmp_name']);
                  }

                  $datos->save();
                  $resp = ['success' => true];
               } else
                  $resp = ['success' => false, 'error' => $datos->getErrorMessages()];
            }
         }
         if ($datos->save()) {
            $resp = ['success' => true];
         } else
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
      $datos->tipo_documento = 'Nit';
      $datos->tipo_persona = 'JURÍDICA';
      $this->view->datos = $datos;
      $this->view->renderModal('proveedores/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = Proveedores::findById('id', (int) $id);
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
      $datos = Proveedores::findFirst([
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
