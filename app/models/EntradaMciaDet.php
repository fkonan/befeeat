<?php

namespace App\Models;

use Core\Model;
use Core\H;
use Core\DB;

class EntradaMciaDet extends Model
{

   public $id, $entrada_id, $producto_id, $unidad_medida, $cantidad, $valor ,$subtotal, $usuario_id, $fecha_reg, $fecha_act;

   protected static $_table = 'entrada_mcia_det';

   const blackList = ['id'];

   public static function listar()
   {

      
   }

  
}
