<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;
use Core\H;
use Core\DB;

class OrdenProduccion extends Model
{

   public $id, $numero_orden, $producto_id, $cantidad, $valor, $observaciones, $estado, $fecha_reg, $fecha_act, $usuario_id;

   protected static $_table = 'orden_produccion';

   const blackList = ['id'];

   public function validator()
   {
      $camposRequeridos = [
         'numero_orden' => 'tipo_producto',
         'producto_id' => 'codigo',
         'cantidad' => 'procucto',
         'valor' => 'unidad_medida_id'
      ];

      foreach ($camposRequeridos as $campo => $msn) {
         $this->runValidation(new RequiredValidator($this, ['field' => $campo, 'msg' => $msn . " es requerido."]));
      }
   }

   public static function listar()
   {
      $sql = "SELECT orden.id,numero_orden,producto,unidad_medida,cantidad,valor,observaciones,orden.estado,orden.fecha_reg
      FROM  orden_produccion as orden 
      INNER JOIN productos as prod on orden.`producto_id`=prod.`id`
      INNER JOIN unidades_medida as unid on prod.`unidad_medida_id`=unid.id
      ORDER BY orden.fecha_reg;";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public static function listarOrdenes($numero_orden)
   {
      $prod = self::find([
         'conditions' => 'numero_orden= ? ',
         'bind' => [$numero_orden]
      ]);
      return $prod;
   }
}
