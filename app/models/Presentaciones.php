<?php

namespace App\Models;

use Core\Model;
use Core\H;
use Core\DB;

class Presentaciones extends Model
{

   public $id, $presentacion, $usuario_id, $fecha_reg;

   protected static $_table = 'presentaciones';

   const blackList = ['id'];

   public static function listarPresentaciones()
   {
      $presentacion = self::find(['order' => 'presentacion']);
      $array = [];
      foreach ($presentacion as $presentacion) {
         $array[$presentacion->id] = $presentacion->presentacion;
      }
      return $array;
   }
}
