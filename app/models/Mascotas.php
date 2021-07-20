<?php

namespace App\Models;

use Core\Model;
use Core\H;
use Core\DB;

class Mascotas extends Model
{

   public $id, $cliente_id, $nombre, $raza_id, $peso,$edad,$cumpleaños,$enfermedades,$observacion,$usuario_id, $fecha_reg;

   protected static $_table = 'mascotas';

   const blackList = ['id'];

   public static function listar()
   {
      $sql = "SELECT mas.id,cli.id,cli.documento,cli.nombre AS cliente,cli.direccion,cli.celular,mas.nombre AS mascota,raza,peso,cumpleaños,edad,enfermedades,observacion,mas.fecha_reg
      FROM mascotas AS mas
      INNER JOIN clientes AS cli ON mas.cliente_id=cli.id
      INNER JOIN razas ON mas.raza_id=razas.id
      ORDER BY mas.nombre;";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public static function listarMascotas()
   {
      $mascota = self::find(['order' => 'nombre']);
      $array = [];
      foreach ($mascota as $mascota) {
         $array[$mascota->id] = $mascota->nombre;
      }
      return $array;
   }
}
