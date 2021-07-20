<?php

namespace App\Models;

use Core\Model;
use Core\H;
use Core\DB;

class EntradaMcia extends Model
{

   public $id, $tipo_entrada, $numero_orden, $proveedor_id, $bodega_id, $total, $observaciones, $fecha_reg, $fecha_act, $usuario_id;

   protected static $_table = 'entrada_mcia';

   const blackList = ['id'];

   public static function listar()
   {
      $sql = "SELECT ENTM.id,
      ENTM.tipo_entrada,
      ENTM.numero_orden,
      ENTM.bodega_id,
      ENTM.total,
      ENTM.observaciones,
      ENTM.total,
      PRO.razon_social,
      BO.bodega           
      FROM entrada_mcia AS ENTM
      INNER JOIN proveedores AS PRO ON ENTM.proveedor_id = PRO.id
      INNER JOIN bodegas as BO ON ENTM.bodega_id = BO.id";

      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public static function detalle($id)
   {

      $sql = "SELECT 
    DETM.cantidad,
    DETM.valor,
    DETM.cantidad,
    DETM.subtotal,    
    PROD.descripcion       
    FROM entrada_mcia_det AS DETM
    INNER JOIN materia_prima AS PROD ON DETM.producto_id = PROD.id
    WHERE DETM.entrada_id = {$id}";

      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }

   public static function inventario($materia_prima, $cantidad, $usuario)
   {
      $sql = "INSERT INTO inventario_mp(materia_prima_id,cantidad,fecha_reg,usuario_id) VALUES ({$materia_prima},{$cantidad}, NOW(),{$usuario})
      ON DUPLICATE KEY UPDATE cantidad = cantidad+{$cantidad}";

      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0) {
         return true;
      } else {
         return false;
      }
   }

   public static function listarEdit($id)
   {


      $sql = "SELECT ENTM.id,
                  ENTM.tipo_entrada,
                  ENTM.numero_orden,
                  ENTM.bodega_id,
                  ENTM.total,
                  ENTM.observaciones,
                  ENTM.total,
                  DETM.id as 'id_detalle',
                  DETM.cantidad,
                  DETM.valor,
                  DETM.subtotal,
                  PROD.descripcion,
                  PROD.id as 'id_materia',
                  PRO.id as 'id_proveedor',
                  PRO.razon_social,
                  BO.id as 'id_bodega',
                  BO.bodega           
                  FROM entrada_mcia AS ENTM
                  LEFT JOIN  entrada_mcia_det as DETM ON ENTM.id = DETM.entrada_id
                  INNER JOIN proveedores AS PRO ON ENTM.proveedor_id = PRO.id
                  INNER JOIN bodegas as BO ON ENTM.bodega_id = BO.id
                  LEFT JOIN materia_prima as PROD ON DETM.producto_id = PROD.id
                  WHERE ENTM.id = {$id}";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return $db->query($sql)->results();
      else
         return [];
   }


   //  public static function recetaPorProducto($producto)
   // {
   //    $sql = "SELECT rec.id AS rec_id,prod.id AS prod_id,prod.descripcion AS producto,mp.id AS mp_id,mp.descripcion AS materia_prima,porcentaje
   //    FROM recetas AS rec
   //    INNER JOIN productos AS prod ON rec.producto=prod.id
   //    INNER JOIN materia_prima AS mp ON rec.materia_prima=mp.id
   //    WHERE rec.producto={$producto}";

   //    $db = DB::getInstance();
   //    if ($db->query($sql)->count() > 0)
   //       return $db->query($sql)->results();
   //    else
   //       return [];
   // }

   public static function listarProductos()
   {
      $productos = Productos::find(['order' => 'descripcion']);
      $array = [];
      foreach ($productos as $productos) {
         $array[$productos->id] = $productos->descripcion;
      }
      return $array;
   }

   public static function listarMateriaPrima()
   {
      $materia_prima = MateriaPrima::find(['order' => 'descripcion']);
      $array = [];
      foreach ($materia_prima as $materia_prima) {
         $array[$materia_prima->id] = $materia_prima->descripcion;
      }
      return $array;
   }

   public static function eliminar($producto)
   {
      $sql = "DELETE from recetas WHERE producto={$producto};";
      $db = DB::getInstance();
      if ($db->query($sql)->count() > 0)
         return true;
      else
         return false;
   }
}
