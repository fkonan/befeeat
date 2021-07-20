<?php

namespace App\Models;

use Core\Model;
use Core\H;
use Core\DB;

class MateriaPrima extends Model
{

   public $id, $codigo, $descripcion, $unidad_medida, $usuario_id, $fecha_reg;

   protected static $_table = 'materia_prima';

   const blackList = ['id'];


   public static function listarMateriaP()
   {
      $materia = self::find(['order' => 'codigo']);
      $array = [];
      foreach ($materia as $materia_p) {
         $array[$materia_p->id] = $materia_p->descripcion;
      }
      return $array;
   }



}
