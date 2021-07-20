<?php $this->setSiteTitle('Departamentos') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Departamentos</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
            <thead class="text-center">
               <th class="col-auto bg-info">Codigo del departamento</th>
               <th class="col-auto bg-info">Nombre del departamento</th>
               <th class="col-auto bg-info">Acciones</th>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->codigo_depto; ?></td>
                     <td><?= $datos->departamento; ?></td>
                     <td>
                        <div class="row">
                           <a href="#" onClick="editar('<?= $datos->codigo_depto ?>');" class="btn btn-info btn-xs btn-sm col">
                              Editar
                           </a> |
                           <a href="#" class="btn btn-danger btn-xs btn-sm col" onClick="eliminar('<?= $datos->codigo_depto ?>');">
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
         url: '<?= PROOT ?>departamentos/nuevo',
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

   function editar(codigo_depto) {
      jQuery.ajax({
         url: '<?= PROOT ?>departamentos/editar',
         data: {
            codigo_depto: codigo_depto
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
            url: '<?= PROOT ?>departamentos/nuevo',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>departamentos';
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
            url: '<?= PROOT ?>departamentos/editar',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido actualizado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>departamentos';
                  });
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
               }
            }
         });
      }
   }

   function eliminar(codigo_depto) {
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
               url: '<?= PROOT ?>departamentos/eliminar',
               method: "POST",
               data: {
                  codigo_depto: codigo_depto
               },
               success: function(resp) {
                  if (resp.success) {
                     alertMsg('Proceso exitoso!', 'El registro ha sido eliminado con exito.', 'success', function(confirmed) {
                        if (confirmed)
                           window.location.href = '<?= PROOT ?>departamentos';
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
            codigo_depto: {
               required: true
            },
            departamento: {
               required: true
            }
         },
         messages: {
            codigo_depto: {
               required: "Este campo es requerido."
            },
            departamento: {
               required: "Este campo es requerido."
            }
         }
      });
   });
</script>
<?php $this->end(); ?>