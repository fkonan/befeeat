<?php

namespace App\Models;

use Core\Model;
use Core\H;
use Core\DB;

class Razas extends Model
{

   public $id, $raza;

   protected static $_table = 'razas';

   const blackList = ['id'];

   public static function listarRazas()
   {
      $lista = self::find(['order' => 'raza']);
      $array = [];
      foreach ($lista as $lista) {
         $array[$lista->id] = $lista->raza;
      }
      return $array;
   }
}
