<?php

namespace App\Models;

use App\Models\UserSessions;
use Core\Validators\RequiredValidator;
use Core\Validators\MatchesValidator;
use Core\Validators\UniqueValidator;
use Core\Model;
use Core\Session;
use Core\Cookie;
use Core\DB;
use Core\H;

class Usuarios extends Model

{
   protected static $_table = 'usuarios';

   public static $currentLoggedInUser = null;
   public $id, $tipo_documento, $documento, $nombres, $apellidos, $fecha_nacimiento, $genero, $direccion, $telefono, $celular;
   public $correo, $usuario, $password, $rol, $back_pass, $cambiar_pass, $token, $acl, $estado, $fecha_reg, $fecha_act;

   const blackList = ['id', 'usuario', 'documento', 'password'];

   public function beforeSave()
   {
      if ($this->isNew()) {
         $this->password = password_hash($this->password, PASSWORD_DEFAULT);
         $this->cambiar_pass = 1;
         $this->estado = 1;
         $this->fecha_reg = $this->timeStamps();
      } else {
         if($this->password!='')
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
         
         $this->fecha_act = $this->timeStamps();
      }
   }

   public static function findByUsername($UserName)
   {
      return self::findFirst(['conditions' => "usuario = ? ", 'bind' => [$UserName]]);
   }

   public static function currentUser()
   {
      if (!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
         self::$currentLoggedInUser = self::findFirst(
            [
               'conditions' => ['usuario = ?'],
               'bind' => [Session::get(CURRENT_USER_SESSION_NAME)]
            ]
         );
      }
      return self::$currentLoggedInUser;
   }


   public function login()
   {
      Session::set(CURRENT_USER_SESSION_NAME, $this->usuario);
   }

   public function logout()
   {
      Session::delete(CURRENT_USER_SESSION_NAME);
      if (Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
         Cookie::delete(REMEMBER_ME_COOKIE_NAME);
      }
      self::$currentLoggedInUser = null;
      return true;
   }

   public function acls()
   {
      if (empty($this->acl)) return [];
      return json_decode($this->acl, true);
   }

   // public static function validarUsuario($usuario)
   // {
   //    $sql = "SELECT id,documento,nombre,programa,usuario 
   //    FROM usuarios AS usu
   //    WHERE usuario='{$usuario}'";
   //    $db = DB::getInstance();

   //    if ($db->query($sql)->count() > 0) {

   //       return $db->query($sql, [], 'App\Models\Users')->results()[0];
   //    } else

   //       return false;
   // }
}
