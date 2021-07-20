<?php

use Core\FH; ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Nueva orden de producció</h3>
   </div>
   <div class="card-body">
      <form method="post" action="" id="frmEntradaMcia" role="form">
         <div class="row">
            <?= FH::inputBlock('hidden', 'Id', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'form-group col-md-12 d-none'], []) ?>
         </div>
         <div class="row">
            <?= FH::inputBlock('text', 'No orden/factura *', 'numero_orden', $this->datos->numero_orden, ['class' => 'form-control'], ['class' => 'form-group col-md-2'], []) ?>

            <?= FH::selectBlock('Producto *', 'producto_id', $this->datos->producto_id, $this->producto_padre, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-10'], []) ?>

         </div>
         <div class="row">
            <?= FH::inputBlock('number', 'Cantidad *', 'cantidad', $this->datos->cantidad, ['class' => 'form-control'], ['class' => 'form-group col-md-3'], []) ?>

            <?= FH::inputBlock('number', 'Valor *', 'valor', $this->datos->valor, ['class' => 'form-control'], ['class' => 'form-group col-md-3'], []) ?>
            </div>
         <div class="row">
            <?= FH::inputBlock('text', 'Observaciones', 'observaciones', $this->datos->observaciones, ['class' => 'form-control'], ['class' => 'form-group col-md-12'], []) ?>
         </div>
         <div class="row">
            <div class="col-md-12 text-right">
               <button type="button" class="btn btn-info" id="btnAgregar">Agregar</button>
            </div>
         </div>
         <div class="row mt-2">
            <table class="table table-bordered table-hover table-sm" id="table">
               <thead class="text-center thead-light">
                  <th class="col-auto d-none">Producto id</th>
                  <th class="col-auto">Codigo</th>
                  <th class="col-auto">Producto</th>
                  <th class="col-auto">Un.Medida</th>
                  <th class="col-auto">Cant.</th>
                  <th class="col-auto">Valor</th>
                  <th class="col-auto">Subtotal</th>
                  <th class="col-auto">Acciones</th>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-12 text-right">
               <a href="<?= PROOT ?>entradaMcia" class="btn btn-secondary">Volver</a>
               <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
            </div>
         </div>
      </form>
   </div>
</div>
<template id="tablaTemplate">
   <tr>
      <td class="d-none producto_id"></td>
      <td class="codigo"></td>
      <td class="producto"></td>
      <td class="unidad_medida"></td>
      <td class="cantidad"></td>
      <td class="valor"></td>
      <td class="subtotal"></td>
      <td class="text-center">
         <button type="button" class="btn btn-block btn-danger btnQuitar">Quitar</button>
      </td>
   </tr>
</template>
<script>
   const d = document,
      $table = d.getElementById("table"),
      $template = d.getElementById("tablaTemplate").content,
      $fragment = d.createDocumentFragment();

   d.addEventListener("click", e => {
      if (e.target.matches(".btnQuitar")) {
         e.path[2].remove();
      }
      if (e.target.matches("#btnGuardar")) {
         guardar();
      }
      if (e.target.matches("#btnAgregar")) {
         agregar();
      }
   });

   function agregar() {
      let producto_id = d.getElementById('producto_id').value;
      if (producto_id.length == 0) {
         alertMsg('Faltan datos!', 'Debe agregar productos para continuar', 'error', 2500);
         return;
      }
      let codigo = d.getElementById('producto_id').options[d.getElementById('producto_id').selectedIndex].text.split(',')[0];
      let producto = d.getElementById('producto_id').options[d.getElementById('producto_id').selectedIndex].text.split(',')[1];
      let unidad_medida = d.getElementById('unidad_medida_id').options[d.getElementById('unidad_medida_id').selectedIndex].text;
      let cantidad = d.getElementById('cantidad').value;
      let valor = d.getElementById('valor').value;

      $template.querySelector(".producto_id").textContent = producto_id;
      $template.querySelector(".codigo").textContent = codigo;
      $template.querySelector(".producto").textContent = producto;
      $template.querySelector(".unidad_medida").textContent = unidad_medida;
      $template.querySelector(".cantidad").textContent = cantidad;
      $template.querySelector(".valor").textContent = valor;
      $template.querySelector(".subtotal").textContent = cantidad * valor;

      let $clone = d.importNode($template, true);
      $fragment.appendChild($clone);
      $table.querySelector("tbody").appendChild($fragment);
   }

   function guardar() {
      if ($("#frmEntradaMcia").valid()) {
         let form = d.getElementById("frmEntradaMcia");
         let tabla = datosTabla();
         if (tabla.length == 0) {
            alertMsg('Faltan datos!', 'Debe agregar productos para continuar', 'error', 2500);
            return;
         }
         jQuery.ajax({
            url: '<?= PROOT ?>entradaMcia/nuevo',
            method: "POST",
            data: {
               form: JSON.stringify({
                  tipo_entrada: form.tipo_entrada.value,
                  numero_orden: numero_orden.value,
                  proveedor_id: proveedor_id.value,
                  bodega_id: bodega_id.value,
                  observaciones: observaciones.value
               }),
               tabla: tabla
            },
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito', 'success', 2000);
                  window.location.href = '<?= PROOT ?>entradaMcia';
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 2000);
                  return;
               }
            }
         });
      }
   }

   d.addEventListener("DOMContentLoaded", () => {
      $("#frmEntradaMcia").validate({
         lang: 'es',
         rules: {
            tipo_entrada: {
               required: true
            },
            numero_orden: {
               required: true
            },
            proveedor_id: {
               required: true
            },
            bodega_id: {
               required: true
            }

         },
         messages: {
            tipo_entrada: {
               required: "Este campo es requerido."
            },
            numero_orden: {
               required: "Este campo es requerido."
            },
            proveedor_id: {
               required: "Este campo es requerido."
            },
            bodega_id: {
               required: "Este campo es requerido."
            }
         }
      });
   })

   function datosTabla() {
      let tabla = new Array();
      let tr = $table.querySelectorAll('tbody tr');
      
      for (var i = 0; i < tr.length; i++) {
         tabla[i] = {
            "producto_id": tr[i].cells[0].textContent,
            "codigo": tr[i].cells[1].textContent,
            "unidad_medida": tr[i].cells[3].textContent,
            "cantidad": tr[i].cells[4].textContent,
            "valor": tr[i].cells[5].textContent,
            "subtotal": tr[i].cells[6].textContent
         }
      }
      
      //el codigo de abajo es como se haria con jquery(obsoleto)

      // $('#table tr').each(function(row, tr) {
      //    tabla[row] = {
      //       "producto_id": $(tr).find('td:eq(0)').text(),
      //       "codigo": $(tr).find('td:eq(1)').text(),
      //       "unidad_medida": $(tr).find('td:eq(3)').text(),
      //       "cantidad": $(tr).find('td:eq(4)').text(),
      //       "valor": $(tr).find('td:eq(5)').text(),
      //       "subtotal": $(tr).find('td:eq(6)').text()
      //    }
      // });
      // tabla.shift();

      return tabla;
   }
</script>