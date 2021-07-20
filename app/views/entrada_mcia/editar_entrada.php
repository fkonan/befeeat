<?php

use Core\FH;
use Core\H;
// H::dnd($this->datos[0]->id);
?>
<?php $this->setSiteTitle('Entradas de mercancía') ?>

<?php $this->start('head'); ?>
<!-- <link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<link href="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/group-by-v2/bootstrap-table-group-by.css" rel="stylesheet">
<link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Editar entradas de mercancía</h3>
   </div>
   <div class="card-body pt-2">
      <form method="post" action="" id="frmEntradaMcia" role="form">
         <h3>Cabecera</h3>
         <hr>
         <div class="row">
            <?= FH::inputBlock('hidden', 'Id', 'id', $this->datos[0]->id, ['class' => 'form-control'], ['class' => 'form-group col-md-12 d-none'], []) ?>
         </div>
         <div class="row">
            <?= FH::selectBlock('Tipo de entrada *', 'tipo_entrada', $this->datos[0]->tipo_entrada, [
               'INVENTARIO INICIAL' => 'INVENTARIO INICIAL',
               'PRODUCTO TERMINADO' => 'PRODUCTO TERMINADO',
               'MATERIA PRIMA' => 'MATERIA PRIMA'
            ], ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-3'], []) ?>

            <?= FH::inputBlock('text', 'No orden/factura *', 'numero_orden', $this->datos[0]->numero_orden, ['class' => 'form-control', 'style' => ' height: 29px!important'], ['class' => 'form-group col-md-2'], []) ?>

            <?= FH::selectBlock('Proveedor *', 'proveedor_id', $this->datos[0]->id_proveedor, $this->proveedores, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-4'], []) ?>

            <?= FH::selectBlock('Bodega *', 'bodega_id', $this->datos[0]->id_bodega, $this->bodegas, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-3'], []) ?>
         </div>
         <div class="row">
            <div class="col-md-9 form-group">
               <label>Observaciones</label>
               <textarea class="form-control" name="observaciones" id="observaciones"><?= $this->datos[0]->observaciones ?></textarea>
            </div>
            <div class="col-md-3 form-group pt-5">
               <button class="btn btn-primary form-control" type="button" onclick="actualizarCabecera(<?= $this->datos[0]->id ?>)">Actualizar Cabecera</button>
            </div>
         </div>

         <h3>Detalle</h3>
         <hr>
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
                  <input type="number" class="form-control" name="cantidad" id="cantidad" style="height: 29px!important">
               </label>
            </div>
            <div class="col-md-3">
               <label for="cantidad" class="control-label d-block">
                  Valor por Kg*
                  <input type="number" class="form-control" name="valor" id="valor" style="height: 29px!important">
               </label>
            </div>
            <div class="col-md-3 pt-3">
               <button type="button" class="btn btn-info btn-block" onclick="addDetalle(<?= $this->datos[0]->id ?>)" id="btnAgregar">Agregar Detalle</button>
            </div>
         </div>

         <div class="row pt-2">
            <div class="col-md-12">
               <table id="tablaMateria" class="table table-striped table-condensed table-bordered table-hover">
                  <thead class="text-center">
                     <th class="col-auto bg-info">Materia prima</th>
                     <th class="col-auto bg-info">Cantidad</th>
                     <th class="col-auto bg-info">Valor unitario</th>
                     <th class="col-auto bg-info">Subtotal</th>
                     <th class="col-auto bg-info">Acciones</th>
                  </thead>
                  <tbody>
                     <?php foreach ($this->datos as $datos) : ?>
                        <tr>
                           <td><?= $datos->descripcion; ?></td>
                           <td><?= $datos->cantidad; ?></td>
                           <td><?= $datos->valor; ?></td>
                           <td><?= $datos->subtotal; ?></td>
                           <td><a href="#" class="btn btn-primary btn-xs btn-sm" onclick="editarDetalle(<?= $datos->id_detalle ?>,<?= $datos->cantidad ?>, <?= $datos->id_materia ?>, <?= $datos->valor ?>, <?= $datos->subtotal ?>,<?= $datos->total ?>, <?= $datos->id ?>)">
                                 Editar Detalle
                              </a>
                              <a href="#" class="btn btn-danger btn-xs btn-sm" onclick="deleteDetalle(<?= $datos->id_detalle ?>,<?= $datos->cantidad ?>, <?= $datos->id_materia ?>, <?= $datos->subtotal ?>, <?= $datos->id ?>)">
                                 Eliminar Detalle
                              </a>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>

         <div class="row pb-2 pt-2">
            <div class="col-md-3 form-inline pb-2">
               <strong>Total :</strong>&nbsp;&nbsp;
               <input type="text" name="total" id="total" class="form-control" value="<?= $this->datos[0]->total ?>" readonly style="border: none!important;outline: none!important;">

            </div>
            <div class="col-md-6 pb-2"></div>
            <div class="col-md-3">
               <a style="float: right;" href="<?= PROOT ?>EntradaMcia/index" class="btn btn-link">Regresar</a>
            </div>
         </div>
      </form>
   </div>
</div>

<?php $this->end(); ?>
<?php $this->start('footer'); ?>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/group-by-v2/bootstrap-table-group-by.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   function editarDetalle(id_detalle, cantidad, id_materia, valor, subtotal, total, id) {
      $('#frmModal').ready(function() {
         $('.select2').select2({
            theme: "classic",
            width: '100%'

         });
      });

      let datos_materia = <?= json_encode($this->productos) ?>;
      console.log(id_materia);

      jQuery('#modalTitulo').text('Editar Entrada Detalle');
      jQuery('#bodyModal').html(`
      <div class="row pt-2">
      <div class="col-md-3">
      <label for="materia_prima" class="control-label d-block">
       Materia Prima
      <select class="form-control select2" style="width:100%;" name="materia_prima_modal" id="materia_prima_modal"></select>       
      </label>       
      </div>

      <div class="col-md-3">
               <label for="cantidad" class="control-label d-block">
                  Cantidad en Kg*
                  <input type="number" class="form-control" name="cantidad_modal" id="cantidad_modal" required style="height: 29px!important" value="${cantidad}">
               </label>
      </div>

      <div class="col-md-3">
               <label for="cantidad" class="control-label d-block">
                  Valor por Kg*
                  <input type="number" class="form-control" name="valor_modal" id="valor_modal" required style="height: 29px!important" value="${valor}">
               </label>
            </div>
      
      <div class="col-md-3">
               <label for="cantidad" class="control-label d-block">
                  Subtotal*
                  <input type="number" class="form-control" name="subtotal_modal" id="subtotal_modal" readonly style="height: 29px!important" value="${subtotal}">
               </label>
      </div>
      <div class="col-md-3 pt-3">
      <button type="button" class="btn btn-info btn-block" onclick="updateDetalle(${id_detalle}, ${subtotal}, ${total}, ${id}, ${cantidad}, ${id_materia})" id="btnAgregar">Actualizar Detalle</button>
      </div>

      </div>
      `);

      for (let key in datos_materia) {
         $('#materia_prima_modal').append(`<option value="${key}">${datos_materia[key]}</option>`);
         if (key == id_materia) {
            $('#materia_prima_modal').val(key);
         }
      }
      jQuery('#frmModal').modal('show');

      $('#cantidad_modal').change(function() {
         let cantidad = document.getElementById('cantidad_modal').value;
         let valor = document.getElementById('valor_modal').value;
         let subtotal_update = parseInt(cantidad) * parseInt(valor);
         $('#subtotal_modal').val(subtotal_update);

      });

      $('#valor_modal').change(function() {
         let cantidad = document.getElementById('cantidad_modal').value;
         let valor = document.getElementById('valor_modal').value;
         let subtotal_update = parseInt(cantidad) * parseInt(valor);
         $('#subtotal_modal').val(subtotal_update);

      });
   }

   function updateDetalle(id_detalle, subtotal_old, total_old, id, cantidad_old, id_materia_old) {

      let materia_prima = document.getElementById('materia_prima_modal').value;
      let cantidad = document.getElementById('cantidad_modal').value;
      let valor = document.getElementById('valor_modal').value;
      let subtotal = document.getElementById('subtotal_modal').value;
      let total = (parseInt(total_old) - parseInt(subtotal_old)) + parseInt(subtotal);

      if (total < 0) {
         alertMsg('Error de inventario!', 'El total de la compra no puede ser menor a cero(0)', 'warning', function(confirmed) {});
         return;
      }

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

      if (subtotal.length == 0) {
         alertMsg('Campos vacios!', 'El subtotal no puede ir vacio para continuar vuelva a escribir los valores de cantidad y valor', 'warning', 2500);
         return;
      }

      jQuery.ajax({
         url: '<?= PROOT ?>EntradaMcia/editDetalle',
         method: "POST",
         data: {
            id: id,
            id_detalle: id_detalle,
            id_materia_old: id_materia_old,
            cantidad_old: cantidad_old,
            cantidad: cantidad,
            materia_prima: materia_prima,
            valor: valor,
            subtotal: subtotal,
            total: total

         },
         success: function(resp) {
            if (resp.success) {
               alertMsg('Proceso exitoso!', 'El registro se actualizo con exito.', 'success', function(confirmed) {
                  if (confirmed)
                     window.location.reload();
               });
            } else {
               alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.msg, 'error', 3500);
               return;
            }
         }
      });
   }

   function addDetalle(id) {

      let materia_prima = document.getElementById('materia_prima').value;
      let cantidad = document.getElementById('cantidad').value;
      let valor = document.getElementById('valor').value;
      let subtotal = parseInt(cantidad) * parseInt(valor);

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

      jQuery.ajax({
         url: '<?= PROOT ?>EntradaMcia/editAddDetalle',
         method: "POST",
         data: {
            id: id,
            materia_prima: materia_prima,
            cantidad: cantidad,
            valor: valor,
            subtotal: subtotal,
         },
         success: function(resp) {
            if (resp.success) {
               alertMsg('Proceso exitoso!', 'El registro se ha creado con exito.', 'success', function(confirmed) {
                  if (confirmed)
                     window.location.reload();
               });
            } else {
               alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.msg, 'error', 3500);
               return;
            }
         }
      });
   }

   function actualizarCabecera(id) {

      let tipo_entrada = document.getElementById('tipo_entrada').value;
      let numero_orden = document.getElementById('numero_orden').value;
      let proveedor_id = document.getElementById('proveedor_id').value;
      let bodega_id = document.getElementById('bodega_id').value;
      let observaciones = document.getElementById('observaciones').value;

      if (tipo_entrada.length == 0) {
         alertMsg('Campos vacios!', 'Debe seleccionar un tipo de entrada para continuar', 'warning', function(confirmed) {});
         return;
      }

      if (numero_orden.length == 0) {
         alertMsg('Campos vacios!', 'Debe digitar el numero de la orden para continuar', 'warning', function(confirmed) {});
         return;
      }

      if (proveedor_id.length == 0) {
         alertMsg('Campos vacios!', 'Debes seleccionar el proveedor para continuar', 'warning', function(confirmed) {});
         return;
      }

      if (bodega_id.length == 0) {
         alertMsg('Campos vacios!', 'Debes seleccionar la bodega para continuar', 'warning', function(confirmed) {});
         return;
      }

      jQuery.ajax({
         url: '<?= PROOT ?>EntradaMcia/updateCabecera',
         method: "POST",
         data: {
            id: id,
            tipo_entrada: tipo_entrada,
            numero_orden: numero_orden,
            proveedor_id: proveedor_id,
            bodega_id: bodega_id,
            observaciones: observaciones,

         },
         success: function(resp) {
            if (resp.success) {
               alertMsg('Proceso exitoso!', 'Se ha actualizado la cabecera con exito.', 'success', function(confirmed) {
                  if (confirmed)
                     window.location.reload();
               });
            } else {
               alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.msg, 'error', function(confirmed) {});
               return;
            }
         }
      });
   }

   function deleteDetalle(id_detalle, cantidad, id_materia, subtotal, id) {
      swal.fire({
         title: "Eliminar Detalle",
         text: "¿Esto afectara el inventario. Esta usted seguro que desea realizar esta acción?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Aceptar',
         cancelButtonText: 'Cancelar',
         confirmButtonColor: '#d33',
      }).then((result) => {
         if (result.isConfirmed) {
            jQuery.ajax({
               url: '<?= PROOT ?>entradaMcia/deleteDetalle',
               method: "POST",
               data: {
                  id: id,
                  id_detalle: id_detalle,
                  cantidad: cantidad,
                  id_materia: id_materia,
                  subtotal: subtotal
               },
               success: function(resp) {
                  if (resp.success) {
                     window.location.reload();
                  } else {
                     alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.msg, 'error', function(confirmed) {});
                  }
               }
            });
         } else if (result.isDenied) {
            return;
         }
      });
   }

   // function agregarFila() {


   //    let materia_prima = document.getElementById('materia_prima').value;
   //    let cantidad = document.getElementById('cantidad').value;
   //    let valor = document.getElementById('valor').value;
   //    let total = document.getElementById('total_oculto').value;
   //    let subtotal = cantidad * valor;
   //    let total_subtotal = new Intl.NumberFormat("es-CO").format(subtotal);

   //    if (materia_prima.length == 0) {
   //       alertMsg('Campos vacios!', 'Debe seleccionar una materia para continuar', 'warning', function(confirmed) {});
   //       return;
   //    }

   //    if (cantidad.length == 0) {
   //       alertMsg('Campos vacios!', 'Debe digitar la cantidad de la materia prima para continuar', 'warning', function(confirmed) {});
   //       return;
   //    }

   //    if (valor.length == 0) {
   //       alertMsg('Campos vacios!', 'Debe digitar el valor de la materia prima  para continuar', 'warning', 2500);
   //       return;
   //    }

   //    document.getElementById("tablaMateria").getElementsByTagName('tbody')[0].insertRow(-1).innerHTML =
   //       `<tr>
   //          <td data-mp="${materia_prima}">
   //             ${$('#materia_prima').select2('data')[0].text}
   //          </td>
   //          <td data-cantidad="${cantidad}">
   //             ${cantidad}
   //          </td>   
   //          <td data-valor="${valor}">
   //          ${valor}
   //          </td>
   //          <td data-subtotal="${subtotal}">
   //          ${total_subtotal}
   //          </td>
   //          <td>
   //             <div class="row">
   //                <div class="col">
   //                   <a href="#" onClick="eliminarFila(this,${subtotal})" class="btn btn-danger btn-xs btn-sm col">
   //                      Eliminar
   //                   </a>
   //                </div>
   //             </div>
   //          </td>
   //       </tr>`;
   //    $("#materia_prima").val('').trigger('change');
   //    $("#cantidad").val('');
   //    $("#valor").val('');

   //    let total_oculto = Number(total) + Number(subtotal);
   //    let suma_total = new Intl.NumberFormat("es-CO").format(total_oculto);
   //    $('#total').val(suma_total);
   //    $('#total_oculto').val(total_oculto);
   // }

   // function eliminarFila(fila, subtotal) {
   //    let total = document.getElementById('total_oculto').value;
   //    let resta_total = Number(total) - Number(subtotal);
   //    if (resta_total < 0) {
   //       resta_total = 0;
   //    }
   //    let resta = new Intl.NumberFormat("es-CO").format(resta_total);
   //    $('#total').val(resta);
   //    $('#total_oculto').val(resta_total);
   //    fila.closest("tr").remove();

   // }

   // function guardar() {

   //    // data
   //    let tipo_entrada = document.getElementById('tipo_entrada').value;
   //    let numero_orden = document.getElementById('numero_orden').value;
   //    let proveedor_id = document.getElementById('proveedor_id').value;
   //    let bodega_id = document.getElementById('bodega_id').value;
   //    let total = document.getElementById('total_oculto').value;

   //    //validar campos requeridos
   //    if (tipo_entrada.length == 0) {
   //       alertMsg('Campos vacios!', 'Debe seleccionar un tipo de entrada para continuar', 'warning', function(confirmed) {});
   //       return;
   //    }
   //    if (numero_orden.length == 0) {
   //       alertMsg('Campos vacios!', 'Debe digitar el numero de orden para continuar', 'warning', function(confirmed) {});
   //       return;
   //    }

   //    if (proveedor_id.length == 0) {
   //       alertMsg('Campos vacios!', 'Debe seleccionar el proveedor para continuar', 'warning', function(confirmed) {});
   //       return;
   //    }
   //    if (bodega_id.length == 0) {
   //       alertMsg('Campos vacios!', 'Debe seleccionar la bodega para continuar', 'warning', function(confirmed) {});
   //       return;
   //    }
   //    if (total <= 0) {
   //       alertMsg('Campos vacios!', 'El total del ingreso no puede ir en ceros', 'warning', function(confirmed) {});
   //       return;
   //    }

   //    var entrada = $("#frmEntradaMcia").serializeArray();

   //    var table = document.getElementById("tablaMateria").getElementsByTagName('tbody')[0]; // devuelve el tbody      
   //    var rowLength = table.rows.length; // retorna el numero de rows

   //    let arr = [];
   //    if (rowLength == 0) {
   //       alertMsg('Proceso fallido!', 'No ha agregado ningun producto a la tabla de entrada de mercancia.', 'error', function(confirmed) {});
   //       return;
   //    }

   //    for (var i = 0; i < rowLength; i += 1) {
   //       var row = table.rows[i];
   //       arr[i] = {
   //          'materia_prima': row.cells[0].dataset.mp,
   //          'cantidad': row.cells[1].dataset.cantidad,
   //          'valor': row.cells[2].dataset.valor,
   //          'subtotal': row.cells[3].dataset.subtotal
   //       };
   //    }


   //    jQuery.ajax({
   //       url: '<?= PROOT ?>entradaMcia/nuevo',
   //       method: "POST",
   //       data: {
   //          entrada: entrada,
   //          arr: arr
   //       },
   //       success: function(resp) {
   //          if (resp.success) {
   //             alertMsg('Proceso exitoso!', 'El registro se ha creado con exito.', 'success', function(confirmed) {
   //                if (confirmed)
   //                   window.location.href = '<?= PROOT ?>EntradaMcia/index';
   //             });
   //          } else {
   //             alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
   //             return;
   //          }
   //       }
   //    });

   // }


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

   cbTipoEntrada = $('#materia_prima');
   cbTipoEntrada.select2({
      theme: "classic",
      width: '100%'
   });
</script>
<?php $this->end(); ?>