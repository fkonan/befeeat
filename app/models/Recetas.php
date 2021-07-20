<?php

namespace App\Models;

use Core\Model;
use Core\H;
use Core\DB;

class Recetas extends Model
{

   public $id, $producto, $materia_prima, $porcentaje, $usuario_id, $fecha_reg, $fecha_act;

   protected static $_table = 'recetas';

   const blackList = ['id'];

   public static function listar()
   {
      $sql = "SELECT rec.id AS rec_id,prod.id AS prod_id,prod.descripcion AS producto,mp.id as mp_id,mp.descripcion AS materia_prima,porcentaje
         FROM recetas AS rec
         INNER JOIN productos AS prod ON rec.producto=prod.id
         INNER JOIN materia_prima AS mp ON rec.materia_prima=mp.id order by prod.id";

      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public static function recetaPorProducto($producto)
   {
      $sql = "SELECT rec.id AS rec_id,prod.id AS prod_id,prod.descripcion AS producto,mp.id AS mp_id,mp.descripcion AS materia_prima,porcentaje
      FROM recetas AS rec
      INNER JOIN productos AS prod ON rec.producto=prod.id
      INNER JOIN materia_prima AS mp ON rec.materia_prima=mp.id
      WHERE rec.producto={$producto}";

      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public static function listarProductos()
   {
      $productos = Productos::find(['order' => 'descripcion']);
      $array = [];
      foreach ($productos as $productos) {
         $array[$productos->id] = $productos->descripcion;
      }
      return $array;
   }

   public static function listarMateriaPrima()
   {
      $materia_prima = MateriaPrima::find(['order' => 'descripcion']);
      $array = [];
      foreach ($materia_prima as $materia_prima) {
         $array[$materia_prima->id] = $materia_prima->descripcion;
      }
      return $array;
   }

   public static function eliminar($producto)
   {
      $sql = "DELETE from recetas WHERE producto={$producto};";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return true;
      else
         return false;
   }
}
