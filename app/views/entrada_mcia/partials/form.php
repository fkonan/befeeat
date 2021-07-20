<?php

use Core\FH; ?>
<form method="post" action="" id="frmEntradaMcia" role="form">
   <div class="row">
      <?= FH::inputBlock('hidden', 'Id', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'form-group col-md-12 d-none'], []) ?>
   </div>
   <div class="row">
      <?= FH::selectBlock('Tipo de entrada *', 'tipo_entrada', $this->datos->tipo_entrada, [
         'INVENTARIO INICIAL' => 'INVENTARIO INICIAL',
         'PRODUCTO TERMINADO' => 'PRODUCTO TERMINADO',
         'MATERIA PRIMA' => 'MATERIA PRIMA'
      ], ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-3'], []) ?>

      <?= FH::inputBlock('text', 'No orden/factura *', 'numero_orden', $this->datos->numero_orden, ['class' => 'form-control', 'style' => ' height: 29px!important'], ['class' => 'form-group col-md-2', 'style' => ' height: 29px!important'], []) ?>

      <?= FH::selectBlock('Proveedor *', 'proveedor_id', $this->datos->proveedor_id, $this->proveedores, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-4'], []) ?>

      <?= FH::selectBlock('Bodega *', 'bodega_id', $this->datos->bodega_id, $this->bodegas, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-3'], []) ?>
   </div>
   <div class="row">
      <div class="col-md-12 form-group">
         <label>Observaciones</label>
         <textarea class="form-control" name="observaciones" id="observaciones"></textarea>
      </div>

   </div>
   <h4><u>Detalle Entrada</u></h4>
   <div class="row">

      <div class="col-md-3">
         <label for="materia_prima" class="control-label d-block">
            Materia Prima
            <select class="form-control" style="width:100%;" name="materia_prima" id="materia_prima">
               <option selected value="">Seleccionar</option>
               <?php $html = "";
               foreach ($this->productos as $value => $display) {
                  $html .= '<option value="' . $value . '">' . $display . '</option>';
               }
               echo $html;
               ?>
            </select>
         </label>
      </div>
      <div class="col-md-3">
         <label for="cantidad" class="control-label d-block">
            Cantidad en Kg*
            <input type="number" class="form-control" name="cantidad" id="cantidad" required style="height: 29px!important">
         </label>
      </div> 
      <div class="col-md-3">
         <label for="cantidad" class="control-label d-block">
            Valor por Kg*
            <input type="number" class="form-control" name="valor" id="valor" required style="height: 29px!important">
         </label>
      </div>
      <div class="col-md-3 pt-3">
      <button type="button" class="btn btn-info" onclick="agregarFila()" id="btnAgregar">Agregar</button>
      </div>
   </div>
      
   <div class="row pt-2">
      <div class="col-md-12">
         <table id="tablaMateria" class="table table-striped table-condensed table-bordered table-hover" >
            <thead class="text-center">
               <th class="col-auto bg-info">Materia prima</th>
               <th class="col-auto bg-info">Cantidad</th>
               <th class="col-auto bg-info">Valor unitario</th>
               <th class="col-auto bg-info">Subtotal</th>
               <th class="col-auto bg-info">Acciones</th>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
   </div>
   
 
   <div class="row pb-2 pt-2">
   <div class="col-md-3 form-inline pb-2">
   <strong>Total :</strong>&nbsp;&nbsp;
   <input type="text" name="total" id="total" class="form-control"  readonly style="border: none!important;outline: none!important;">
   <input type="hidden" name= total_oculto id="total_oculto" value="0">
   </div>   
   </div>

    <hr>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <?php if (empty($this->datos->id)) : ?>
         <button type="button" class="btn btn-info" onClick="guardar();return;">Guardar</button>
      <?php else : ?>
         <button type="button" class="btn btn-info" onClick="actualizar();return;">Actualizar</button>
      <?php endif; ?>
   </div>
</form>


<script>
   // const d = document,
   //    $table = d.getElementById("table"),
   //    $template = d.getElementById("tablaTemplate").content,
   //    $fragment = d.createDocumentFragment();

   // d.addEventListener("click", e => {
   //    if (e.target.matches(".btnQuitar")) {
   //       e.path[2].remove();
   //    }
   //    if (e.target.matches("#btnGuardar")) {
   //       guardar();
   //    }
   //    if (e.target.matches("#btnAgregar")) {
   //       agregar();
   //    }
   // });

   function agregar() {
      // let producto_id = d.getElementById('producto_id').value;
      // if (producto_id.length == 0) {
      //    alertMsg('Faltan datos!', 'Debe agregar productos para continuar', 'error', 2500);
      //    return;
      // }
      // let codigo = d.getElementById('producto_id').options[d.getElementById('producto_id').selectedIndex].text.split(',')[0];
      // let producto = d.getElementById('producto_id').options[d.getElementById('producto_id').selectedIndex].text.split(',')[1];
      // let unidad_medida = d.getElementById('unidad_medida_id').options[d.getElementById('unidad_medida_id').selectedIndex].text;
      // let cantidad = d.getElementById('cantidad').value;
      // let valor = d.getElementById('valor').value;

      // $template.querySelector(".producto_id").textContent = producto_id;
      // $template.querySelector(".codigo").textContent = codigo;
      // $template.querySelector(".producto").textContent = producto;
      // $template.querySelector(".unidad_medida").textContent = unidad_medida;
      // $template.querySelector(".cantidad").textContent = cantidad;
      // $template.querySelector(".valor").textContent = valor;
      // $template.querySelector(".subtotal").textContent = cantidad * valor;

      // let $clone = d.importNode($template, true);
      // $fragment.appendChild($clone);
      // $table.querySelector("tbody").appendChild($fragment);
   }

   // function guardar() {
   //    // if ($("#frmEntradaMcia").valid()) {
   //    //    let form = d.getElementById("frmEntradaMcia");
   //    //    let tabla = datosTabla();
   //    //    if (tabla.length == 0) {
   //    //       alertMsg('Faltan datos!', 'Debe agregar productos para continuar', 'error', 2500);
   //    //       return;
   //    //    }
   //    //    jQuery.ajax({
   //    //       url: '<?= PROOT ?>entradaMcia/nuevo',
   //    //       method: "POST",
   //    //       data: {
   //    //          form: JSON.stringify({
   //    //             tipo_entrada: form.tipo_entrada.value,
   //    //             numero_orden: numero_orden.value,
   //    //             proveedor_id: proveedor_id.value,
   //    //             bodega_id: bodega_id.value,
   //    //             observaciones: observaciones.value
   //    //          }),
   //    //          tabla: tabla
   //    //       },
   //    //       success: function(resp) {
   //    //          if (resp.success) {
   //    //             alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito', 'success', 2000);
   //    //             window.location.href = '<?= PROOT ?>entradaMcia';
   //    //          } else {
   //    //             alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 2000);
   //    //             return;
   //    //          }
   //    //       }
   //    //    });
   //    // }
   // }

   // d.addEventListener("DOMContentLoaded", () => {
   //    $("#frmEntradaMcia").validate({
   //       lang: 'es',
   //       rules: {
   //          tipo_entrada: {
   //             required: true
   //          },
   //          numero_orden: {
   //             required: true
   //          },
   //          proveedor_id: {
   //             required: true
   //          },
   //          bodega_id: {
   //             required: true
   //          }

   //       },
   //       messages: {
   //          tipo_entrada: {
   //             required: "Este campo es requerido."
   //          },
   //          numero_orden: {
   //             required: "Este campo es requerido."
   //          },
   //          proveedor_id: {
   //             required: "Este campo es requerido."
   //          },
   //          bodega_id: {
   //             required: "Este campo es requerido."
   //          }
   //       }
   //    });
   // })

   function datosTabla() {
      // let tabla = new Array();
      // let tr = $table.querySelectorAll('tbody tr');

      // for (var i = 0; i < tr.length; i++) {
      //    tabla[i] = {
      //       "producto_id": tr[i].cells[0].textContent,
      //       "codigo": tr[i].cells[1].textContent,
      //       "unidad_medida": tr[i].cells[3].textContent,
      //       "cantidad": tr[i].cells[4].textContent,
      //       "valor": tr[i].cells[5].textContent,
      //       "subtotal": tr[i].cells[6].textContent
      //    }
      // }

      // //el codigo de abajo es como se haria con jquery(obsoleto)

      // // $('#table tr').each(function(row, tr) {
      // //    tabla[row] = {
      // //       "producto_id": $(tr).find('td:eq(0)').text(),
      // //       "codigo": $(tr).find('td:eq(1)').text(),
      // //       "unidad_medida": $(tr).find('td:eq(3)').text(),
      // //       "cantidad": $(tr).find('td:eq(4)').text(),
      // //       "valor": $(tr).find('td:eq(5)').text(),
      // //       "subtotal": $(tr).find('td:eq(6)').text()
      // //    }
      // // });
      // // tabla.shift();

      // return tabla;
   }
</script>