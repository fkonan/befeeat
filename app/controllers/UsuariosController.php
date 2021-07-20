<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use App\Models\Usuarios;
use App\Models\Login;
use Core\H;
use Core\Session;

class UsuariosController extends Controller
{

   public function onConstruct()
   {
      
      $this->view->setLayout('index_admin');
   }

   public function loginAction()
   {
     
      $loginModel = new Login();
      if ($this->request->isPost()) {
         $loginModel->assign($this->request->get());

         $usuarios = Usuarios::findByUsername($this->request->get('usuario'));
         if ($usuarios && password_verify($this->request->get('password'), $usuarios->password)) {
            $usuarios->login();
            $resp = ['success' => true];
            $this->jsonResponse($resp);
         } else {
            $resp = ['success' => false, 'error' => 'Usuario o contraseña incorrectos o usuario inactivo.'];
            $this->jsonResponse($resp);
         }
      } else {
         if (Usuarios::currentUser())
            Router::redirect('home/index');
         else {

            $this->view->datos = $loginModel;
            $this->view->setLayout('login');
            $this->view->render('usuarios/login');
         }
      }
   }

   public function logoutAction()
   {
      if (Usuarios::currentUser()) {
         Usuarios::currentUser()->logout();
      }
      Router::redirect('usuarios/login');
   }


   public function indexAction()
   {
      $datos = Usuarios::find(['order' => 'fecha_reg desc']);
      $this->view->datos = $datos;
      $this->view->render('usuarios/index');
   }

   public function nuevoAction()
   {
      $usuario = new Usuarios();

      if ($this->request->isPost()) {
         $usuario = new Usuarios();
         $usuario->assign($this->request->get(), Usuarios::blackList);
         $usuario->back_pass = $this->request->get('password');
         $usuario->acl = '["' . $this->request->get('rol') . '"]';
         if ($usuario->save()) {
            $resp = ['success' => true];
         } else {
            $error = $usuario->getErrorMessages();
            $resp = ['success' => false, 'error' => $error];
         }

         $this->jsonResponse($resp);
      } else {
         $this->view->datos = $usuario;
         $this->view->postAction = PROOT . 'usuarios' . DS . 'nuevo';
         $this->view->displayErrors = $usuario->getErrorMessages();
         $this->view->render('usuarios/crear');
      }
   }

   public function cambiarClaveAction($id)
   {
      $usuario = Usuarios::findById((int)$id);
      if ($this->request->isPost()) {
         $usuario->back_pass = $this->request->get('password');
         $usuario->acl = '["' . $this->request->get('rol') . '"]';
         $respuesta = $usuario->save();
         if ($respuesta)
            $resp = ['success' => true, 'errors' => $usuario->getErrorMessages()];
         else
            $resp = ['success' => false, 'errors' => $usuario->getErrorMessages()];

         $this->jsonResponse($resp);
      } else {
         $this->view->usuario = $usuario;
         $this->view->renderModal('Usuarios/actualizar_clave');
      }
   }

   public function editarAction()
   {
      $id = $this->request->get('id');
      $datos = Usuarios::findById((int) $id);
      if (!$datos) Router::redirect('usuarios');

      if ($this->request->isPost()) {

         $datos->assign($this->request->get());
         //$datos->password = '';
         if ($datos->save())
            $resp = ['success' => true];
         else
            $resp = ['success' => false, 'error' => $datos->getErrorMessages()];

         $this->jsonResponse($resp);
      }
      $this->view->datos = $datos;
      $this->view->renderModal('usuarios/editar');
   }

   public function eliminarAction()
   {
      $id = $this->request->get('id');
      $datos = Usuarios::findById((int) $id);
      if ($datos->estado == 0)
         $datos->update(['estado' => 1]);
      else
         $datos->update(['estado' => 0]);

      $resp = ['success' => true];
      return $this->jsonResponse($resp);
   }
}
