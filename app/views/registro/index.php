<?php

use App\Models\Users;

$user = Users::currentUser();
?>
<?php $this->setSiteTitle('Listado de clientes') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="<?= PROOT ?>adminlte/plugins/select2/css/select2.min.css">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Listado de Clientes</h3>
   </div>
   <div class="card-body pt-2">
      <?php if ($user->Typeuser != 4) : ?>
         <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <?php endif; ?> <div class="table-responsive">
         <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
            <thead class="text-center small">
               <th class="col-auto bg-info">Nit</th>
               <th class="col-auto bg-info">Nombre del cliente</th>
               <th class="col-auto bg-info">Sede</th>
               <th class="col-auto bg-info">Dirección</th>
               <th class="col-auto bg-info">Ciudad</th>
               <th class="col-auto bg-info">Teléfono fijo</th>
               <th class="col-auto bg-info">Celular</th>
               <th class="col-auto bg-info">Correo eléctrónico</th>
               <th class="col-auto bg-info">Forma de pago</th>
               <th class="col-auto bg-info">Mensajero</th>
               <th class="col-auto bg-info">Estado</th>
               <?php if ($user->Typeuser != 4) : ?>
                  <th class="col-auto bg-info">Acciones</th>
               <?php endif; ?>
            </thead>
            <tbody class="small">
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->Nit; ?></td>
                     <td><?= $datos->Nombre; ?></td>
                     <td><?= $datos->Sede; ?></td>
                     <td><?= $datos->Direccion; ?></td>
                     <td><?= $datos->Municipio; ?></td>
                     <td><?= $datos->Telefono; ?></td>
                     <td><?= $datos->Celular; ?></td>
                     <td><?= $datos->Email; ?></td>
                     <td><?= $datos->FormaDePago; ?></td>
                     <td><?= $datos->DistribuidorID; ?></td>
                     <td><?= $datos->Status; ?></td>
                     <?php if ($user->Typeuser != 4) : ?>
                        <td>
                           <div class="row">
                              <a href="#" onClick="editar('<?= $datos->Nit ?>');" class="btn btn-info btn-xs btn-sm col">
                                 <i class="fas fa-edit"></i>
                              </a> |
                              <a href="#" class="btn btn-danger btn-xs btn-sm col" onClick="eliminar('<?= $datos->Nit ?>');">
                                 <i class="far fa-trash-alt"></i>
                              </a>
                           </div>
                        </td>
                     <?php endif; ?>
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
<script src="<?= PROOT ?>adminlte/plugins/select2/js/select2.full.min.js"></script>
<script>
   function nuevo() {
      jQuery.ajax({
         url: '<?= PROOT ?>clientes/nuevo',
         method: "GET",
         success: function(resp) {
            jQuery('#definirTamaño').removeClass('modal-lg');
            jQuery('#definirTamaño').addClass('modal-xl');
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

   function editar(Nit) {
      jQuery.ajax({
         url: '<?= PROOT ?>clientes/editar',
         data: {
            Nit: Nit
         },
         method: "GET",
         success: function(resp) {
            jQuery('#definirTamaño').removeClass('modal-lg');
            jQuery('#definirTamaño').addClass('modal-xl');
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
      if ($("#frmClientes").valid()) {
         var form = jQuery('#frmClientes').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>clientes/nuevo',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido creado con exito', 'success', 2000);
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>clientes'; //will redirect to your blog page (an ex: blog.html)
                  }, 1500);
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 2000);
                  return;
               }
            }
         });
      }
   }

   function actualizar() {
      if ($("#frmClientes").valid()) {
         var form = jQuery('#frmClientes').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>clientes/editar',
            method: "POST",
            data: form,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha sido actualizado con exito', 'success', 2000);
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>clientes';
                  }, 1500);
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 2000);
                  return;
               }
            }
         });
      }
   }

   function eliminar(Nit) {
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
                  url: '<?= PROOT ?>clientes/eliminar',
                  method: "POST",
                  data: {
                     Nit: Nit
                  },
                  success: function(resp) {
                     if (resp.success) {
                        window.location.href = '<?= PROOT ?>clientes';
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
      $("#MunicipioID").select2({
         theme: "classic"
      });
      $("#frmfrmClientes").validate({
         lang: 'es',
         rules: {
            Nit: {
               required: true
            },
            Nombre: {
               required: true
            },
            Sede: {
               required: true
            },
            Direccion: {
               required: true
            },
            Telefono: {
               required: true
            },
            Celular: {
               required: true
            }
         },
         messages: {
            Nit: {
               required: "Este campo es requerido."
            },
            Nombre: {
               required: "Este campo es requerido."
            },
            Sede: {
               required: "Este campo es requerido."
            },
            Direccion: {
               required: "Este campo es requerido."
            },
            Telefono: {
               required: "Este campo es requerido."
            },
            Celular: {
               required: "Este campo es requerido."
            }
         }
      });
   });
</script>
<?php $this->end(); ?>