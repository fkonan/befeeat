<?php $this->setSiteTitle('Proveedores') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Listado de proveedores</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
            <thead class="text-center">
               <th class="col-auto bg-info">Documento</th>
               <th class="col-auto bg-info">Tipo de persona</th>
               <th class="col-auto bg-info">Razón social</th>
               <th class="col-auto bg-info">Representante</th>
               <th class="col-auto bg-info">Dirección</th>
               <th class="col-auto bg-info">Teléfono</th>
               <th class="col-auto bg-info">Correo</th>
               <th class="col-auto bg-info">Estado</th>
               <th class="col-auto bg-info">Rut</th>
               <th class="col-auto bg-info">Acciones</th>
               <th data-breakpoints="all">Tipo de documento</th>
               <th data-breakpoints="all">Documento</th>
               <th data-breakpoints="all">Div</th>
               <th data-breakpoints="all">Tipo persona</th>
               <th data-breakpoints="all">Razón social</th>
               <th data-breakpoints="all">Representante</th>
               <th data-breakpoints="all">Deptartamento</th>
               <th data-breakpoints="all">Municipio</th>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->documento; ?></td>
                     <td><?= $datos->tipo_persona; ?></td>
                     <td><?= $datos->razon_social; ?></td>
                     <td><?= $datos->representante; ?></td>
                     <td><?= $datos->direccion; ?></td>
                     <td><?= $datos->telefono; ?></td>
                     <td><?= $datos->correo; ?></td>
                     <td class="<?php echo ($datos->estado == 'INACTIVO') ? 'text-danger' : 'text-success' ?>"><?= $datos->estado; ?></td>
                     <td class="text-center"><a href="<?= PROOT . $datos->rut ?>" target="_blank"><img src="<?= PROOT . 'img/pdf.png' ?>"></a></td>
                     <td>
                        <div class="row">
                           <a href="#" onClick="editar(<?= $datos->id ?>);" class="btn btn-info btn-xs btn-sm col">
                              Editar
                           </a> |
                           <a href="#" class="btn btn-danger btn-xs btn-sm col" onClick="eliminar(<?= $datos->id ?>);">
                              <?php echo ($datos->estado == 'INACTIVO') ? 'Activar' : 'Inactivar' ?>
                           </a>
                        </div>
                     </td>
                     <td><?= $datos->tipo_documento; ?></td>
                     <td><?= $datos->documento; ?></td>
                     <td><?= $datos->dv; ?></td>
                     <td><?= $datos->tipo_persona; ?></td>
                     <td><?= $datos->razon_social; ?></td>
                     <td><?= $datos->representante; ?></td>
                     <td><?= $datos->departamento; ?></td>
                     <td><?= $datos->municipio; ?></td>
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
         url: '<?= PROOT ?>proveedores/nuevo',
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
         url: '<?= PROOT ?>proveedores/editar',
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
         $.ajax({
            type: "POST",
            url: '<?= PROOT ?>proveedores/validarDuplicado/' + documento,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Cliente ya existe!', 'El proveedor ya se encuentra registrado en la base de datos', 'warning', function(confirmed) {});
                  document.getElementById('btnGuardar').disabled = true;
                  return;
               } else {
                  document.getElementById('btnGuardar').disabled = false;
               }
            }
         });
         var form = new FormData(jQuery('#frm')[0]);
         jQuery.ajax({
            url: '<?= PROOT ?>proveedores/nuevo',
            method: "POST",
            data: form,
            contentType: false,
            cache: false,
            processData: false,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>proveedores';
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
         var form = new FormData(jQuery('#frm')[0]);
         jQuery.ajax({
            url: '<?= PROOT ?>proveedores/editar',
            method: "POST",
            data: form,
            contentType: false,
            cache: false,
            processData: false,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido actualizado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>proveedores';
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
               url: '<?= PROOT ?>proveedores/eliminar',
               method: "POST",
               data: {
                  id: id
               },
               success: function(resp) {
                  if (resp.success) {
                     alertMsg('Proceso exitoso!', 'El registro ha sido inactivado/activado con exito.', 'success', function(confirmed) {
                        if (confirmed)
                           window.location.href = '<?= PROOT ?>proveedores';
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
            tipo_documento: {
               required: true
            },
            documento: {
               required: true
            },
            tipo_persona: {
               required: true
            },
            razon_social: {
               required: true
            },
            representante: {
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
            correo: {
               required: true
            }
         },
         messages: {
            tipo_documento: {
               required: "Este campo es requerido."
            },
            documento: {
               required: "Este campo es requerido."
            },
            tipo_persona: {
               required: "Este campo es requerido."
            },
            razon_social: {
               required: "Este campo es requerido."
            },
            representante: {
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
            correo: {
               required: "Este campo es requerido."
            }
         }
      });
   });
</script>
<?php $this->end(); ?>