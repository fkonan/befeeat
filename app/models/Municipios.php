<?php

namespace App\Models;

use Core\Model;
use Core\Validators\RequiredValidator;
use Core\DB;
use Core\H;

class Municipios extends Model
{

   public $codigo_muni, $codigo_muni_old, $municipio, $codigo_depto, $codigo_depto_old;

   protected static $_table = 'municipios';

   const blackList = ['id'];

   public function validator()
   {
      $this->runValidation(new RequiredValidator($this, ['field' => 'codigo_muni', 'msg' => 'El campo es requerido.']));
      $this->runValidation(new RequiredValidator($this, ['field' => 'municipio', 'msg' => 'El campo es requerido.']));
      $this->runValidation(new RequiredValidator($this, ['field' => 'codigo_depto', 'msg' => 'El campo es requerido.']));
   }

   public static function listarMuni($codigo_depto = '')
   {
      if ($codigo_depto == '') {
         $muni = self::find([
            'order' => 'municipio'
         ]);
         $array = [];
         foreach ($muni as $muni) {
            $array[$muni->codigo_muni] = $muni->municipio;
         }
         return $array;
      } else {
         $muni = self::find([
            'conditions' => 'codigo_depto= ? ',
            'bind' => ['codigo_depto' => $codigo_depto],
            'order' => 'municipio'
         ]);
         $array = [];
         foreach ($muni as $muni) {
            $array[$muni->codigo_muni] = $muni->municipio;
         }
         return $muni;
      }
   }

   public static function listar()
   {
      $sql = "SELECT muni.codigo_depto,departamento,codigo_muni,municipio FROM municipios AS muni 
      INNER JOIN departamentos AS depto ON muni.codigo_depto=depto.codigo_depto ORDER BY muni.codigo_depto,codigo_muni";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public function actualizar($campos)
   {
      $sql = "UPDATE municipios 
      SET codigo_depto='{$campos->codigo_depto}',codigo_muni='{$campos->codigo_muni}',municipio='{$campos->municipio}' 
      WHERE codigo_depto='{$campos->codigo_depto_old}' and codigo_muni='{$campos->codigo_muni_old}'";
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

   public function eliminar($codigo_depto, $codigo_muni)
   {
      $sql = "DELETE FROM municipios WHERE codigo_depto='{$codigo_depto}' and codigo_muni='{$codigo_muni}'";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return true;
      else
         return false;
   }
}
