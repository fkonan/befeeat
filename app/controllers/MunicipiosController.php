<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use Core\H;
use App\Models\Municipios;
use App\Models\Departamentos;

class MunicipiosController extends Controller
{
   public function onConstruct()
   {
      $this->view->setLayout('index_admin');
   }

   public function indexAction()
   {
      $datos = Municipios::listar();
      $this->view->datos = $datos;
      $this->view->render('municipios/index');
   }

   public function nuevoAction()
   {
      $datos = new Municipios();
      if ($this->request->isPost()) {
         $datos->assign($this->request->get(), Municipios::blackList);
         $existe = Municipios::findFirst(
            [
               'conditions' => 'codigo_depto=?  and codigo_muni= ?',
               'bind' => [$datos->codigo_depto, $datos->codigo_muni]
            ]
         );
         if (!$existe) {
            if ($datos->save())
               $resp = ['success' => true, 'error' => $datos->getErrorMessages()];
            else
               $resp = ['success' => false, 'error' => $datos->getErrorMessages()];
         } else
            $resp = ['success' => false, 'error' => 'Este municipio ya se encuentra registrado.'];


         $this->jsonResponse($resp);
      }

      $deptos = Departamentos::listarDeptos();
      $this->view->deptos = $deptos;
      $this->view->datos = $datos;
      $this->view->renderModal('municipios/crear');
   }

   public function editarAction()
   {

      if ($this->request->isPost()) {

         $codigo_muni = $this->request->get('codigo_muni_old');
         $codigo_depto = $this->request->get('codigo_depto_old');
         $datos = Municipios::findFirst([
            'conditions' => "codigo_muni=? and codigo_depto=?",
            'bind' => [$codigo_muni, $codigo_depto]
         ]);
         if (!$datos) Router::redirect('municipios');

         $datos->assign($this->request->get());
         $existe = Municipios::findFirst(
            [
               'conditions' => 'codigo_depto=?  and codigo_muni= ?',
               'bind' => [$datos->codigo_depto, $datos->codigo_muni]
            ]
         );

         if (!$existe || ($datos->codigo_depto==$datos->codigo_depto_old && $datos->codigo_muni==$datos->codigo_muni_old)) {
            $resultado = $datos->actualizar($datos);
            if ($resultado)
               $resp = ['success' => true];
            else
               $resp = ['success' => false, 'error' => 'No se ha podido actualizar el registro.'];
         } else
            $resp = ['success' => false, 'error' => 'Este municipio ya se encuentra registrado.'];

         $this->jsonResponse($resp);
      } else {
         $codigo_muni = $this->request->get('codigo_muni');
         $codigo_depto = $this->request->get('codigo_depto');
         $datos = Municipios::findFirst([
            'conditions' => "codigo_muni=? and codigo_depto=?",
            'bind' => [$codigo_muni, $codigo_depto]
         ]);

         if (!$datos) Router::redirect('municipios');

         $deptos = Departamentos::listarDeptos();
         $this->view->deptos = $deptos;
         $this->view->datos = $datos;
         $this->view->renderModal('municipios/editar');
      }
   }

   public function eliminarAction()
   {
      $codigo_depto = $this->request->get('codigo_depto');
      $codigo_muni = $this->request->get('codigo_muni');
      $datos = Municipios::findFirst([
         'conditions' => "codigo_muni=? and codigo_depto=?",
         'bind' => [$codigo_muni, $codigo_depto]
      ]);

      if ($datos) {
         $datos->eliminar($codigo_depto, $codigo_muni);
         $resp = ['success' => true];
         return $this->jsonResponse($resp);
      }
   }

   public function comboMuniAction($codigo_depto)
   {
      $muni = Municipios::find([
         'conditions' => 'codigo_depto= ? ',
         'bind' => ['codigo_depto' => $codigo_depto],
         'order' => 'municipio'
      ]);
      $array = [];
      foreach ($muni as $muni) {
         $array[$muni->codigo_muni] = $muni->municipio;
      }
      $resp = ['success' => true, 'muni' => $array];
      $this->jsonResponse($resp);
   }
}
