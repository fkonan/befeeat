<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;
use Core\H;
use Core\DB;

class Bodegas extends Model
{

   public $id, $bodega, $departamento_id, $municipio_id, $direccion, $telefono, $celular, $persona_contacto, $correo, $estado, $fecha_reg, $fecha_act, $usuario_id;

   protected static $_table = 'bodegas';

   const blackList = ['id'];

   public static function listar()
   {
      $sql = "SELECT bod.id,bodega,departamento,municipio,direccion,telefono,celular,persona_contacto,correo,estado
      FROM bodegas AS bod 
      INNER JOIN departamentos AS depto ON bod.departamento_id=depto.codigo_depto
      INNER JOIN municipios AS muni ON bod.municipio_id=muni.codigo_muni";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public static function listarBod()
   {
      $bod = self::find(['order' => 'bodega']);
      $array = [];
      foreach ($bod as $bod) {
         $array[$bod->id] = $bod->bodega;
      }
      return $array;
   }
}
