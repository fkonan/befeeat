<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;
use Core\H;
use Core\DB;

class Componentes extends Model
{

   public $id, $producto, $materia_prima, $porcentaje;

   protected static $_table = 'componentes';

   const blackList = ['id'];

   public static function listar()
   {
      $sql = "SELECT prod.codigo as codigo_prod,prod.descripcion as producto,mp.codigo as codigo_mp,mp.descripcion as materia_prima,compo.porcentaje 
      FROM componentes AS compo
      INNER JOIN productos AS prod ON compo.producto=prod.id
      INNER JOIN materia_prima AS mp ON compo.materia_prima=mp.id";

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

}
