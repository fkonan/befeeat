<?php $this->setSiteTitle('Entradas de mercancía') ?>

<?php $this->start('head'); ?>
<link href="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/group-by-v2/bootstrap-table-group-by.css" rel="stylesheet">
<link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Entradas de mercancía</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <!-- <table data-group-by-formatter="formato" data-group-by="true" data-group-by-toggle="true" data-group-by-show-toggle-icon="true" data-group-by-field="producto" data-group-by-collapsed-groups="producto" data-group-by-collapsed-groups=producto class="table table-striped table-condensed table-bordered table-hover" id="table"> -->
         <table id="myTable" data-toggle="table" data-detail-view="true" data-detail-formatter="myFunction">
            <thead class="text-center">
               <tr class="bg-info">
                  <th data-field="id" class="col-auto">Id</th>
                  <th data-field="orden" class="col-auto">Orden</th>
                  <th data-field="bodega" class="col-auto">Bodega</th>
                  <th data-field="proveedor" class="col-auto">Proveedor</th>
                  <th data-field="total" class="col-auto">Total</th>
                  <th data-field="acciones" class="col-auto">Acciones</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->id; ?></td>
                     <td><?= $datos->numero_orden; ?></td>
                     <td><?= $datos->bodega; ?></td>
                     <td><?= $datos->razon_social; ?></td>
                     <td class="format-number"><?= $datos->total; ?></td>
                     <td>
                        <a href="<?= PROOT ?>entradaMcia/edit/<?= $datos->id; ?>" class="btn btn-primary btn-xs btn-sm col-auto btnEditar">
                           Editar Entrada
                        </a>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php $this->end(); ?>
<?php $this->start('footer'); ?>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/group-by-v2/bootstrap-table-group-by.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   var $table = $('#myTable');

   function myFunction(index, row) {
      var html = [];
   }

   $table.on('expand-row.bs.table', function(e, index, row, $detail) {

      jQuery.ajax({
         url: '<?= PROOT ?>entradaMcia/detalle',
         dataType: 'json',
         method: "POST",
         data: {
            id: row['id']
         },
         success: function(resp) {
            if (resp.success) {
               var data = resp.datos;
               var html = "";
               html =
                  `
                  <div class="table-responsive-md">
                     <table class="table" >
                        <thead class="thead-dark">
                           <tr>
                              <th style="width:300px; overflow:auto">Producto</th>
                              <th>Cantidad</th>
                              <th >Valor</th>
                              <th>Subtotal</th>
                           </tr>
                        </thead>
                        <tbody>
                  `;
               data.forEach(function(arrayItem) {
                  html = html +
                     `
                  <tr>
                     <td>${arrayItem.descripcion}</td>
                     <td>${arrayItem.cantidad}</td>
                     <td>${new Intl.NumberFormat("es-CO").format(arrayItem.valor)}</td>
                     <td>${new Intl.NumberFormat("es-CO").format(arrayItem.subtotal)}</td>
                  </tr>
                  `;
               });
               html = html + `</tbody></table></div>`;
               $detail.append(html);
            } else {
               $detail.html('<p>No hay Detalles...</p>');
            }
         }
      });
   });

   $table.on("click-row.bs.table", function(e, row, $tr) {
      if ($tr.next().is('tr.detail-view')) {
         $table.bootstrapTable('collapseRow', $tr.data('index'));
      } else {
         $table.bootstrapTable('expandRow', $tr.data('index'));
      }
   });

   $('.format-number').each(function() {
      var number = $(this).text();
      var format = new Intl.NumberFormat("es-CO").format(number);
      $(this).text(format);
   });

   function nuevo() {
      jQuery.ajax({
         url: '<?= PROOT ?>entradaMcia/nuevo',
         method: "GET",
         success: function(resp) {
            jQuery('#modalTitulo').html('Nueva Entrada');
            jQuery('#bodyModal').html(resp);
            jQuery('#frmModal').modal({
               backdrop: 'static',
               keyboard: false
            });
            jQuery('#frmModal').modal('show');
         }
      });
   }

   function agregarFila() {
      let materia_prima = document.getElementById('materia_prima').value;
      let cantidad = document.getElementById('cantidad').value;
      let valor = document.getElementById('valor').value;
      let total = document.getElementById('total_oculto').value;
      let subtotal = cantidad * valor;
      let total_subtotal = new Intl.NumberFormat("es-CO").format(subtotal);

      if (materia_prima.length == 0) {
         alertMsg('Campos vacios!', 'Debe seleccionar una materia para continuar', 'warning', function(confirmed) {});
         return;
      }

      if (cantidad.length == 0) {
         alertMsg('Campos vacios!', 'Debe digitar la cantidad de la materia prima para continuar', 'warning', function(confirmed) {});
         return;
      }

      if (valor.length == 0) {
         alertMsg('Campos vacios!', 'Debe digitar el valor de la materia prima  para continuar', 'warning', 2500);
         return;
      }

      document.getElementById("tablaMateria").getElementsByTagName('tbody')[0].insertRow(-1).innerHTML =
         `<tr>
            <td data-mp="${materia_prima}">
               ${$('#materia_prima').select2('data')[0].text}
            </td>
            <td data-cantidad="${cantidad}">
               ${cantidad}
            </td>   
            <td data-valor="${valor}">
            ${valor}
            </td>
            <td data-subtotal="${subtotal}">
            ${total_subtotal}
            </td>
            <td>
               <div class="row">
                  <div class="col">
                     <a href="#" onClick="eliminarFila(this,${subtotal})" class="btn btn-danger btn-xs btn-sm col">
                        Eliminar
                     </a>
                  </div>
               </div>
            </td>
         </tr>`;
      $("#materia_prima").val('').trigger('change');
      $("#cantidad").val('');
      $("#valor").val('');

      let total_oculto = Number(total) + Number(subtotal);
      let suma_total = new Intl.NumberFormat("es-CO").format(total_oculto);
      $('#total').val(suma_total);
      $('#total_oculto').val(total_oculto);
   }

   function eliminarFila(fila, subtotal) {
      let total = document.getElementById('total_oculto').value;
      let resta_total = Number(total) - Number(subtotal);
      if (resta_total < 0) {
         resta_total = 0;
      }
      let resta = new Intl.NumberFormat("es-CO").format(resta_total);
      $('#total').val(resta);
      $('#total_oculto').val(resta_total);
      fila.closest("tr").remove();

   }

   function guardar() {

      // data
      let tipo_entrada = document.getElementById('tipo_entrada').value;
      let numero_orden = document.getElementById('numero_orden').value;
      let proveedor_id = document.getElementById('proveedor_id').value;
      let bodega_id = document.getElementById('bodega_id').value;
      let total = document.getElementById('total_oculto').value;

      //validar campos requeridos
      if (tipo_entrada.length == 0) {
         alertMsg('Campos vacios!', 'Debe seleccionar un tipo de entrada para continuar', 'warning', function(confirmed) {});
         return;
      }
      if (numero_orden.length == 0) {
         alertMsg('Campos vacios!', 'Debe digitar el numero de orden para continuar', 'warning', function(confirmed) {});
         return;
      }

      if (proveedor_id.length == 0) {
         alertMsg('Campos vacios!', 'Debe seleccionar el proveedor para continuar', 'warning', function(confirmed) {});
         return;
      }
      if (bodega_id.length == 0) {
         alertMsg('Campos vacios!', 'Debe seleccionar la bodega para continuar', 'warning', function(confirmed) {});
         return;
      }
      if (total <= 0) {
         alertMsg('Campos vacios!', 'El total del ingreso no puede ir en ceros', 'warning', function(confirmed) {});
         return;
      }

      var entrada = $("#frmEntradaMcia").serializeArray();

      var table = document.getElementById("tablaMateria").getElementsByTagName('tbody')[0]; // devuelve el tbody      
      var rowLength = table.rows.length; // retorna el numero de rows

      let arr = [];
      if (rowLength == 0) {
         alertMsg('Proceso fallido!', 'No ha agregado ningun producto a la tabla de entrada de mercancia.', 'error', function(confirmed) {});
         return;
      }

      for (var i = 0; i < rowLength; i += 1) {
         var row = table.rows[i];
         arr[i] = {
            'materia_prima': row.cells[0].dataset.mp,
            'cantidad': row.cells[1].dataset.cantidad,
            'valor': row.cells[2].dataset.valor,
            'subtotal': row.cells[3].dataset.subtotal
         };
      }


      jQuery.ajax({
         url: '<?= PROOT ?>entradaMcia/nuevo',
         method: "POST",
         data: {
            entrada: entrada,
            arr: arr
         },
         success: function(resp) {
            if (resp.success) {
               alertMsg('Proceso exitoso!', 'El registro se ha creado con exito.', 'success', function(confirmed) {
                  if (confirmed)
                     window.location.href = '<?= PROOT ?>EntradaMcia/index';
               });
            } else {
               alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
               return;
            }
         }
      });

   }


   function eliminar(id) {
      swal({
            title: "Eliminar entrada",
            text: "¿Esto afectara el inventario. Esta usted seguro que desea realizar esta acción?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
         },
         function(isConfirm) {
            if (isConfirm) {
               jQuery.ajax({
                  url: '<?= PROOT ?>entradaMcia/eliminar',
                  method: "POST",
                  data: {
                     id: id
                  },
                  success: function(resp) {
                     if (resp.success) {
                        window.location.href = '<?= PROOT ?>entradaMcia';
                     } else {
                        alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 3500);
                        return;
                     }
                  }
               });
            }
         });
   }

   jQuery('#frmModal').on('show.bs.modal', function() {
      $('#table').bootstrapTable()

      cbProducto = $('#producto');
      cbProducto.select2({
         theme: "classic",
         width: 'resolve'
      });

      cbMateriaPrima = $('#materia_prima');
      cbMateriaPrima.select2({
         theme: "classic",
         width: 'resolve'
      });
      cbTipoEntrada = $('#tipo_entrada');
      cbTipoEntrada.select2({
         theme: "classic",
         width: '100%'
      });

      cbBodega = $('#bodega_id');
      cbBodega.select2({
         theme: "classic",
         width: '100%'
      });

      cbProvedoor = $('#proveedor_id');
      cbProvedoor.select2({
         theme: "classic",
         width: '100%'
      });
   });
</script>
<?php $this->end(); ?>