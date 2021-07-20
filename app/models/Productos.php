<?php

namespace App\Models;

use Core\Model;
use Core\H;
use Core\DB;

class Productos extends Model
{
   public $id,$codigo,$descripcion, $info_nutricional,$marca, $sabor, $unidad_medida, $precio,$info_adicional, $codigo_barras, $estado, $fecha_reg, $fecha_act, $usuario_id;
   protected static $_table = 'productos';
   const blackList = ['id'];

   public static function listarProductos()
   {
      $productos = self::find(['order' => 'descripcion']);
      $array = [];
      foreach ($productos as $productos) {
         $array[$productos->id] = $productos->descripcion;
      }
      return $array;
   }
}