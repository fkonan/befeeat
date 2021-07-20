<?php $this->setSiteTitle('Razas') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Listado de Razas</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
            <thead class="text-center">
               <th class="col-auto bg-info">Raza</th>
               <th class="col-auto bg-info">Acciones</th>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->raza; ?></td>
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
         url: '<?= PROOT ?>razas/nuevo',
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
         url: '<?= PROOT ?>razas/editar',
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
            url: '<?= PROOT ?>razas/nuevo',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>razas';
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
            url: '<?= PROOT ?>razas/editar',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido actualizado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>razas';
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
               url: '<?= PROOT ?>razas/eliminar',
               method: "POST",
               data: {
                  codigo_depto: codigo_depto
               },
               success: function(resp) {
                  if (resp.success) {
                     alertMsg('Proceso exitoso!', 'El registro ha sido eliminado con exito.', 'success', function(confirmed) {
                        if (confirmed)
                           window.location.href = '<?= PROOT ?>razas';
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
            raza: {
               required: true
            }
         },
         messages: {
            raza: {
               required: "Este campo es requerido."
            }
         }
      });
   });
</script>
<?php $this->end(); ?>