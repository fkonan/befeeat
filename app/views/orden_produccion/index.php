<?php $this->setSiteTitle('Orden de producción') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Ordenes de producción</h3>
   </div>
   <div class="card-body pt-2">
      <a href="<?=PROOT?>ordenProduccion/nuevo" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
            <thead class="text-center">
               <th class="col-auto bg-info">No de la orden</th>
               <th class="col-auto bg-info">Producto</th>
               <th class="col-auto bg-info">Unidad de medida</th>
               <th class="col-auto bg-info">Cantidad</th>
               <th class="col-auto bg-info">valor</th>
               <th class="col-auto bg-info">Estado</th>
               <th class="col-auto bg-info">Fecha de la orden</th>
               <th class="col-auto bg-info">Observaciones</th>
               <th class="col-auto bg-info">Acciones</th>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->numero_orden; ?></td>
                     <td><?= $datos->producto; ?></td>
                     <td><?= $datos->unidad_medida; ?></td>
                     <td><?= $datos->cantidad; ?></td>
                     <td><?= $datos->valor; ?></td>
                     <td><?= $datos->estado; ?></td>
                     <td><?= $datos->fecha_reg; ?></td>
                     <td><?= $datos->observaciones; ?></td>
                     <td>
                        <div class="row">
                           <a href="#" onClick="editar(<?= $datos->id ?>);" class="btn btn-info btn-xs btn-sm col">
                              Editar
                           </a> |
                           <a href="#" class="btn btn-danger btn-xs btn-sm col" onClick="eliminar(<?= $datos->id ?>);">
                              <?php echo ($datos->estado==0)?'Activar':'Inactivar'?>
                           </a>
                        </div>
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
<script src="<?= PROOT ?>js/plugins/footable/footable.js"></script>
<script src="<?= PROOT ?>js/plugins/footable/footableConfig.js"></script>
<script>
   function editar(id) {
      jQuery.ajax({
         url: '<?= PROOT ?>ordenProduccion/editar',
         data: {
            id: id
         },
         method: "GET",
         success: function(resp) {
            jQuery('#modalTitulo').html('Actualizar Registro');
            jQuery('#bodyModal').html(resp);
            jQuery('#frmModal').modal({
               backdrop: 'static',
               keyboard: false
            });
            jQuery('#frmModal').modal('show');
         }
      });
   }

   function guardar() {
      if ($("#frmProductos").valid()) {
         var form = jQuery('#frmProductos').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>ordenProduccion/nuevo',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito', 'success');
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>productos';
                  }, 3000);
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error');
                  return;
               }
            }
         });
      }
   }

   function actualizar() {
      if ($("#frmProductos").valid()) {
         var form = jQuery('#frmProductos').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>productos/editar',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido actualizado con exito', 'success');
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>productos';
                  }, 3000);
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error');
                  return;
               }
            }
         });
      }
   }

   function eliminar(id) {
      swal({
            title: "Activar/inactivar regisrtro",
            text: "¿Esta usted seguro que desea realizar esta acción?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
         },
         function(isConfirm) {
            if (isConfirm) {
               jQuery.ajax({
                  url: '<?= PROOT ?>productos/eliminar',
                  method: "POST",
                  data: {
                     id: id
                  },
                  success: function(resp) {
                     if (resp.success) {
                        window.location.href = '<?= PROOT ?>productos';
                     } else {
                        alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 2500);
                        return;
                     }
                  }
               });
            }
         });
   }

   jQuery('#frmModal').on('show.bs.modal', function() {
      $("#frmProductos").validate({
         lang: 'es',
         rules: {
            tipo_producto: {
               required: true
            },
            codigo: {
               required: true
            },
            producto: {
               required: true
            },
            unidad_medida_id: {
               required: true
            },
            precio: {
               required: true
            },
            codigo_barras: {
               required: true
            }
         },
         messages: {
            tipo_producto: {
               required: "Este campo es requerido."
            },
            codigo: {
               required: "Este campo es requerido."
            },
            producto: {
               required: "Este campo es requerido."
            },
            unidad_medida_id: {
               required: "Este campo es requerido."
            },
            precio: {
               required: "Este campo es requerido."
            },
            codigo_barras: {
               required: "Este campo es requerido."
            }
         }
      });
   });
</script>
<?php $this->end(); ?>