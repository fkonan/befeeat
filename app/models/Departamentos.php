<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\H;
use Core\DB;

class Departamentos extends Model
{

   public $codigo_depto, $codigo_depto_old, $departamento;

   protected static $_table = 'departamentos';

   const blackList = ['id'];

   public static function listarDeptos()
   {
      $deptos = self::find(['order' => 'departamento']);
      $array = [];
      foreach ($deptos as $deptos) {
         $array[$deptos->codigo_depto] = $deptos->departamento;
      }
      return $array;
   }

   public function actualizar($campos)
   {
      $sql = "UPDATE departamentos set codigo_depto='{$campos->codigo_depto}',departamento='{$campos->departamento}' where codigo_depto='{$campos->codigo_depto_old}'";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return true;
      else {
         if ($db->query($sql)->error())
            return false;
         else
            return true;
      }
   }

   public function eliminar($codigo_depto)
   {
      $sql = "DELETE FROM departamentos WHERE codigo_depto='{$codigo_depto}'";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return true;
      else
         return false;
   }
}
