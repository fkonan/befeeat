<?php

namespace App\Models;

use Core\Model;
use Core\H;
use Core\DB;

class Inventario extends Model
{

   public $id, $materia_prima_id, $cantidad, $fecha_reg, $usuario_id;

   protected static $_table = 'inventario_mp';

   const blackList = ['id'];

   public static function detalle($id_materia)
   {
     $sql = "SELECT id, materia_prima_id, cantidad, fecha_reg, usuario_id FROM inventario_mp WHERE materia_prima_id ={$id_materia}";

     $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
          return $db->query($sql)->results();
         else
            return [];          

      
   }

  
}
