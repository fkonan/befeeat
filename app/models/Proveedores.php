<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;
use Core\DB;
use Core\H;

class Proveedores extends Model

{
   public $id, $tipo_documento, $documento, $dv, $tipo_persona, $razon_social, $representante, $departamento_id, $municipio_id, $direccion, $telefono, $celular, $correo, $web, $estado, $fecha_reg, $fecha_act,$rut;

   protected static $_table = 'proveedores';

   const blackList = ['id'];

   public static function listar()
   {
      $sql = "SELECT prov.id,tipo_documento,documento,dv,tipo_persona,razon_social,representante,departamento,municipio,direccion,telefono,celular,rut,correo,web,estado,fecha_reg,fecha_act
      FROM proveedores AS prov
      INNER JOIN departamentos AS depto ON prov.`departamento_id`=depto.`codigo_depto`
      INNER JOIN municipios AS muni ON prov.`municipio_id`=muni.`codigo_muni`
      ORDER BY fecha_reg";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public static function listarProv()
   {
      $prov = self::find(['order' => 'razon_social']);
      $array = [];
      foreach ($prov as $prov) {
         $array[$prov->id] = $prov->razon_social;
      }
      return $array;
   }
}
