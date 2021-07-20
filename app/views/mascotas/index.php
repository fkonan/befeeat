<?php $this->setSiteTitle('Mascotas') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Listado de mascotas</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
            <thead class="text-center">
               <th class="col-auto bg-info">Mascota</th>
               <th class="col-auto bg-info">Raza</th>
               <th class="col-auto bg-info">Peso</th>
               <th class="col-auto bg-info">Cumpleaños</th>
               <th class="col-auto bg-info">Edad</th>
               <th class="col-auto bg-info">Enfermedades</th>
               <th class="col-auto bg-info">Fecha de registro</th>
               <th class="col-auto bg-info">Acciones</th>
               <th data-breakpoints="all">Documento dueño</th>
               <th data-breakpoints="all">Dueño</th>
               <th data-breakpoints="all">Dirección dueño</th>
               <th data-breakpoints="all">Celular dueño</th>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->mascota; ?></td>
                     <td><?= $datos->raza; ?></td>
                     <td><?= $datos->peso; ?></td>
                     <td><?= $datos->cumpleaños; ?></td>
                     <td><?= $datos->edad; ?></td>
                     <td><?= $datos->enfermedades; ?></td>
                     <td><?= $datos->fecha_reg; ?></td>
                     <td>
                        <div class="row">
                           <a href="#" onClick="editar(<?= $datos->id ?>);" class="btn btn-info btn-xs btn-sm col">
                              Editar
                           </a> |
                           <a href="#" class="btn btn-danger btn-xs btn-sm col" onClick="eliminar(<?= $datos->id ?>);">
                              Eliminar
                           </a>
                        </div>
                     </td>
                     <td><?= $datos->documento; ?></td>
                     <td><?= $datos->cliente; ?></td>
                     <td><?= $datos->direccion; ?></td>
                     <td><?= $datos->celular; ?></td>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   function nuevo() {
      jQuery.ajax({
         url: '<?= PROOT ?>mascotas/nuevo',
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
         url: '<?= PROOT ?>mascotas/editar',
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
            url: '<?= PROOT ?>mascotas/nuevo',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>mascotas';
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
            url: '<?= PROOT ?>mascotas/editar',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido actualizado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>mascotas';
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
         text: "¿Esta usted seguro de realizar esta acción?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Aceptar',
         cancelButtonText: 'Cancelar',
         confirmButtonColor: '#d33',
      }).then((result) => {
         if (result.isConfirmed) {
            jQuery.ajax({
               url: '<?= PROOT ?>mascotas/eliminar',
               method: "POST",
               data: {
                  id: id
               },
               success: function(resp) {
                  if (resp.success) {
                     alertMsg('Proceso exitoso!', 'El registro ha sido inactivado/activado con exito.', 'success', function(confirmed) {
                        if (confirmed)
                           window.location.href = '<?= PROOT ?>mascotas';
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
            cliente_id: {
               required: true
            },
            nombre: {
               required: true
            },
            raza_id: {
               required: true
            },
            peso: {
               required: true
            }
         },
         messages: {
            cliente_id: {
               required: "Este campo es requerido."
            },
            nombre: {
               required: "Este campo es requerido."
            },
            raza_id: {
               required: "Este campo es requerido."
            },
            peso: {
               required: "Este campo es requerido."
            }
         }
      });
   });
</script>
<?php $this->end(); ?>