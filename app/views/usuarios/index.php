<?php $this->setSiteTitle('Listado de usuarios') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Listado de Usuarios</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <table id="tabla" class=" small table table-striped table-condensed table-bordered table-hover" data-filtering="true">
            <thead class="bg-info text-center">
               <th class="col-auto bg-info">Usuario</th>
               <th class="col-auto bg-info">Nombres</th>
               <th class="col-auto bg-info">Apellidos</th>
               <th class="col-auto bg-info">Fecha de nacimiento</th>
               <th class="col-auto bg-info">Genero</th>
               <th class="col-auto bg-info">Ciudad</th>
               <th class="col-auto bg-info">Dirección</th>
               <th class="col-auto bg-info">Barrio</th>
               <th class="col-auto bg-info">Celular</th>
               <th class="col-auto bg-info">Correo</th>
               <th class="col-auto bg-info">Estado</th>
               <th class="col-auto bg-info">Fecha registro</th>
               <th class="col-auto bg-info">Rol</th>
               <th class="col-auto bg-info">Acciones</th>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->usuario; ?></td>
                     <td><?= $datos->nombres; ?></td>
                     <td><?= $datos->apellidos; ?></td>
                     <td><?= $datos->fecha_nacimiento; ?></td>
                     <td><?= $datos->genero; ?></td>
                     <td><?= $datos->ciudad; ?></td>
                     <td><?= $datos->direccion; ?></td>
                     <td><?= $datos->barrio; ?></td>
                     <td><?= $datos->celular; ?></td>
                     <td><?= $datos->correo; ?></td>
                     <td><?= ($datos->estado==0)?'<span class="text-danger">Inactivo</span>':'<span class="text-success">Activo</span>'; ?></td>
                     <td><?= $datos->fecha_reg; ?></td>
                     <td><?= $datos->rol_id; ?></td>
                     <td>
                        <div class="row">
                           <a href="#" onClick="editar(<?= $datos->id ?>);" class="btn btn-info btn-xs btn-sm col">
                              Editar
                           </a> |
                           <?php if($datos->estado==0):?>
                              <a href="#" class="btn btn-success btn-xs btn -sm col" onClick="activar(<?= $datos->id ?>);">
                                 Activar
                              </a>
                           <?php else:?>
                              <a href="#" class="btn btn-danger btn-xs btn -sm col" onClick="eliminar(<?= $datos->id ?>);">
                                 Desactivar
                              </a>
                           <?php endif;?>
                        </div>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<?php $this->partial('users', 'form_habilitar'); ?>
<?php $this->end(); ?>
<?php $this->start('footer'); ?>
<script src="<?= PROOT ?>js/plugins/dataTables/datatables.min.js"></script>
<script src="<?= PROOT ?>js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
   function editar(id) {
      jQuery.ajax({
         url: '<?= PROOT ?>users/editar',
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

   function actualizar() {
      if ($("#frmUsuario").valid()) {
         var form = jQuery('#frmUsuario').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>users/editar',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido actualizado con exito', 'success', 2000);
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>users';
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
            title: "Desactivar regisrtro",
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
                  url: '<?= PROOT ?>users/eliminar',
                  method: "POST",
                  data: {
                     id: id
                  },
                  success: function(resp) {
                     if (resp.success) {
                        alertMsg('Proceso exitoso!', 'El registro ha sido desactivado con exito', 'success', 2000);
                        setTimeout(function() {
                           window.location.href = '<?= PROOT ?>users';
                        }, 1500);
                     } else {
                        alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 2000);
                        return;
                     }
                  }
               });
            }
         });
   }

   function activar(id) {
      swal({
            title: "Activar regisrtro",
            text: "¿Esta usted seguro de eliminar este registro?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#28a745',
         },
         function(isConfirm) {
            if (isConfirm) {
               jQuery.ajax({
                  url: '<?= PROOT ?>users/eliminar',
                  method: "POST",
                  data: {
                     id: id
                  },
                  success: function(resp) {
                     if (resp.success) {
                        alertMsg('Proceso exitoso!', 'El registro ha sido desactivado con exito', 'success', 2000);
                        setTimeout(function() {
                           window.location.href = '<?= PROOT ?>users';
                        }, 1500);
                     } else {
                        alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 2000);
                        return;
                     }
                  }
               });
            }
         });
   }

   jQuery('#frmModal').on('show.bs.modal', function() {
      $("#frmUsuario").validate({
         lang: 'es',
         rules: {
            nombres: {
               required: true
            },
            apellidos: {
               required: true
            },
            direccion: {
               required: true
            },
            celular: {
               required: true,
               phoneUS: true
            },
            usuario: {
               required: true
            },
            confirm: {
               required: true
            },
            password: {
               required: true
            },
            correo: {
               required: true,
               email: true
            }
         },
         messages: {
            nombres: {
               required: "Este campo es requerido."
            },
            apellidos: {
               required: "Este campo es requerido."
            },
            direccion: {
               required: "Este campo es requerido."
            },
            celular: {
               required: "Este campo es requerido.",
               phoneUS: "Debe digitar un número de celular valido."
            },
            usuario: {
               required: "Este campo es requerido."
            },
            confirm: {
               required: "Este campo es requerido."
            },
            password: {
               required: "Este campo es requerido."
            },
            correo: {
               required: "Este campo es requerido.",
               email: "Debe digitar una dirección de correo valida."
            }
         }
      });
   });
</script>
<?php $this->end(); ?>