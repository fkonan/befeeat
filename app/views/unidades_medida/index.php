<?php $this->setSiteTitle('Unidades de medida') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Unidades de medida</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
            <thead class="text-center">
               <th class="col-auto bg-info">Unidad de medida</th>
               <th class="col-auto bg-info">Acciones</th>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->unidad_medida; ?></td>
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
         url: '<?= PROOT ?>unidadesMedida/nuevo',
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
         url: '<?= PROOT ?>unidadesMedida/editar',
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
      if ($("#frmUnidadesMedida").valid()) {
         var form = jQuery('#frmUnidadesMedida').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>unidadesMedida/nuevo',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito', 'success', 2000);
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>unidadesMedida';
                  }, 2000);
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 2000);
                  return;
               }
            }
         });
      }
   }

   function actualizar() {
      if ($("#frmUnidadesMedida").valid()) {
         var form = jQuery('#frmUnidadesMedida').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>unidadesMedida/editar',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido actualizado con exito', 'success', 2000);
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>unidadesMedida';
                  }, 1500);
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 2000);
                  return;
               }
            }
         });
      }
   }

   function eliminar(id) {
      swal({
            title: "Eliminar regisrtro",
            text: "¿Esta usted seguro de eliminar este registro?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
         },
         function(isConfirm) {
            if (isConfirm) {
               jQuery.ajax({
                  url: '<?= PROOT ?>unidadesMedida/eliminar',
                  method: "POST",
                  data: {
                     id: id
                  },
                  success: function(resp) {
                     if (resp.success) {
                        window.location.href = '<?= PROOT ?>unidadesMedida'; //will redirect to your blog page (an ex: blog.html)
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
      $("#frmUnidadesMedida").validate({
         lang: 'es',
         rules: {
            tipo_doc: {
               required: true
            }
         },
         messages: {
            tipo_doc: {
               required: "Este campo es requerido."
            }
         }
      });
   });
</script>
<?php $this->end(); ?>