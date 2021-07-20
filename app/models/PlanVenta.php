<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;
use Core\H;
use Core\DB;

class PlanVenta extends Model
{

   public $id, $mascota_id, $periocidad, $fecha_ult_compra, $fecha_reg, $fecha_act, $usuario_id;

   protected static $_table = 'plan_venta';

   const blackList = ['id'];

   public static function listar()
   {
      $sql = "SELECT pv.id,cli.nombre AS cliente,masco.nombre AS mascota,raza,periocidad,fecha_ult_compra
         FROM plan_venta AS pv
         INNER JOIN mascotas AS masco ON pv.`mascota_id`=masco.id
         INNER JOIN clientes AS cli ON masco.`cliente_id`=cli.`id`
         INNER JOIN razas ON masco.`raza_id`=razas.id";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results()[0];
      else
         return [];
   }
}
