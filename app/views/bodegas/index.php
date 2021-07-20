<?php $this->setSiteTitle('bodegas') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Listado de bodegas</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
            <thead class="text-center">
               <th class="col-auto bg-info">Nombre de la bodega</th>
               <th class="col-auto bg-info">Persona de contacto</th>
               <th class="col-auto bg-info">Departamento</th>
               <th class="col-auto bg-info">Municipio</th>
               <th class="col-auto bg-info">Dirección</th>
               <th class="col-auto bg-info">Teléfono</th>
               <th class="col-auto bg-info">Correo</th>
               <th class="col-auto bg-info">Celular</th>
               <th class="col-auto bg-info">Estado</th>
               <th class="col-auto bg-info">Acciones</th>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->bodega; ?></td>
                     <td><?= $datos->persona_contacto; ?></td>
                     <td><?= $datos->departamento; ?></td>
                     <td><?= $datos->municipio; ?></td>
                     <td><?= $datos->direccion; ?></td>
                     <td><?= $datos->telefono; ?></td>
                     <td><?= $datos->correo; ?></td>
                     <td><?= $datos->celular; ?></td>
                     <td class="<?php echo ($datos->estado == 0) ? 'text-danger' : 'text-success' ?>"><?= ($datos->estado) ? 'Activo' : 'Inactivo'; ?></td>
                     <td>
                        <div class="row">
                           <a href="#" onClick="editar(<?= $datos->id ?>);" class="btn btn-info btn-xs btn-sm col">
                              Editar
                           </a> |
                           <a href="#" class="btn btn-danger btn-xs btn-sm col" onClick="eliminar(<?= $datos->id ?>);">
                              <?php echo ($datos->estado == 0) ? 'Activar' : 'Inactivar' ?>
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
   function nuevo() {
      jQuery.ajax({
         url: '<?= PROOT ?>bodegas/nuevo',
         method: "GET",
         success: function(resp) {
            jQuery('#modalTitulo').html('Nuevo Registro');
            jQuery('#bodyModal').html(resp);
            jQuery('#frmModal').modal({
               backdrop: 'static',
               keyboard: false
            });
            jQuery('#frmModal').modal('show');
         }
      });
   }

   function editar(id) {
      jQuery.ajax({
         url: '<?= PROOT ?>bodegas/editar',
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
      if ($("#frm").valid()) {
         var form = jQuery('#frm').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>bodegas/nuevo',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>bodegas';
                  });
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
               }
            }
         });
      }
   }

   function actualizar() {
      if ($("#frm").valid()) {
         var form = jQuery('#frm').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>bodegas/editar',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido actualizado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>bodegas';
                  });
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
               }
            }
         });
      }
   }

   function eliminar(id) {
      Swal.fire({
         title: "Eliminar regisrtro",
         text: "¿Esta usted seguro de eliminar este registro?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Aceptar',
         cancelButtonText: 'Cancelar',
         confirmButtonColor: '#d33',
      }).then((result) => {
         if (result) {
            jQuery.ajax({
               url: '<?= PROOT ?>bodegas/eliminar',
               method: "POST",
               data: {
                  id: id
               },
               success: function(resp) {
                  if (resp.success) {
                     alertMsg('Proceso exitoso!', 'El registro ha sido eliminado con exito.', 'success', function(confirmed) {
                        if (confirmed)
                           window.location.href = '<?= PROOT ?>bodegas';
                     });
                  } else {
                     alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
                  }
               }
            });
         }
      });
   }

   jQuery('#frmModal').on('show.bs.modal', function() {
      $("#frm").validate({
         lang: 'es',
         rules: {
            bodega: {
               required: true
            },
            departamento_id: {
               required: true
            },
            municipio_id: {
               required: true
            },
            direccion: {
               required: true
            },
            telefono: {
               required: true
            },
            persona_contacto: {
               required: true
            }
         },
         messages: {
            tipo_doc: {
               required: "Este campo es requerido."
            },
            departamento_id: {
               required: "Este campo es requerido."
            },
            municipio_id: {
               required: "Este campo es requerido."
            },
            direccion: {
               required: "Este campo es requerido."
            },
            telefono: {
               required: "Este campo es requerido."
            },
            persona_contacto: {
               required: "Este campo es requerido."
            }
         }
      });
   });
</script>
<?php $this->end(); ?>