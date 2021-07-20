<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\Validators\UniqueValidator;
use Core\DB;
use Core\H;

class Clientes extends Model

{
   public $id, $tipo_documento, $documento, $dv, $tipo_persona, $razon_social, $nombre,$gran_superficie, $departamento_id;
   public $municipio_id, $direccion,$telefono, $celular, $correo, $web, $estado,$rut, $fecha_reg, $fecha_act;

   protected static $_table = 'clientes';

   const blackList = ['id'];

   public static function listar()
   {
      $sql = "SELECT cli.id,tipo_documento,documento,dv,tipo_persona,razon_social,gran_superficie,nombre,departamento,municipio,direccion,telefono,celular,rut,correo,web,estado,fecha_reg,fecha_act
      FROM clientes AS cli
      INNER JOIN departamentos AS depto ON cli.departamento_id=depto.codigo_depto
      INNER JOIN municipios AS muni ON cli.municipio_id=muni.codigo_muni
      ORDER BY fecha_reg";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public static function listarClientes()
   {
      $clientes = self::find(['order' => 'nombre']);
      $array = [];
      foreach ($clientes as $clientes) {
         $array[$clientes->id] = $clientes->nombre;
      }
      return $array;
   }
}
