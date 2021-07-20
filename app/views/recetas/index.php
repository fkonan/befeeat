<?php $this->setSiteTitle('recetas') ?>

<?php $this->start('head'); ?>
<link href="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/group-by-v2/bootstrap-table-group-by.css" rel="stylesheet">
<link href="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Listado de recetas</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo registro</a>
      <div class="table-responsive">
         <!-- <table data-group-by-formatter="formato" data-group-by="true" data-group-by-toggle="true" data-group-by-show-toggle-icon="true" data-group-by-field="producto" data-group-by-collapsed-groups="producto" data-group-by-collapsed-groups=producto class="table table-striped table-condensed table-bordered table-hover" id="table"> -->
         <table data-group-by="true" data-group-by-formatter="formato" data-group-by-toggle="true" data-group-by-field="producto" data-group-by-collapsed-groups="producto" data-group-by-collapsed-groups=producto class="table table-striped table-condensed table-bordered table-hover" id="table">
            <thead class="text-center">
               <tr class="bg-info">
                  <th data-field="producto" class="col-auto">Producto</th>
                  <th data-field="materia_prima" class="col-auto">Materia prima</th>
                  <th data-field="porcentaje" class="col-auto">Porcentaje</th>
                  <th data-field="prod_id" class="col-auto d-none">prod_id</th>
                  <th data-field="mp_id" class="col-auto d-none">mp_id</th>
                  <th class="col-auto">Acciones</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->producto; ?></td>
                     <td><?= $datos->materia_prima; ?></td>
                     <td><?= $datos->porcentaje; ?></td>
                     <td><?= $datos->prod_id; ?></td>
                     <td><?= $datos->mp_id; ?></td>
                     <td>
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
<script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/group-by-v2/bootstrap-table-group-by.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
   function producto(grupo) {
      return [grupo];
   }
 
   function formato(value, index, data) {
      return `
      <div class="row">
         <div class="col">${value} <span class="fa fa-angle-down"></span> </div>
         <div class="col-md-2 text-right">
            <a href="#" data-id="${data[0].prod_id}" onClick="#" class="btn btn-primary btn-xs btn-sm col-auto btnEditar">
               Editar Receta
            </a> | 
            <a href="#" data-id="${data[0].prod_id}" onClick="#" class="btn btn-danger btn-xs btn-sm col-auto btnEliminar">
               Eliminar Receta
            </a>
         </div>
      </div>`;
   }

   $(function() {
      $('#table').bootstrapTable();
   })

   document.addEventListener('click', (e) => {
      if (e.target.matches('.btnEditar')) {
         e.preventDefault();
         e.stopPropagation();
         let id = e.target.dataset.id;
         jQuery.ajax({
            url: '<?= PROOT ?>recetas/editar',
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
      if (e.target.matches('.btnEliminar')) {
         e.preventDefault();
         e.stopPropagation();
         let id = e.target.dataset.id;
         eliminar(id);
      }
   }, true);

   function nuevo() {
      jQuery.ajax({
         url: '<?= PROOT ?>recetas/nuevo',
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

   function guardar() {
      var table = document.getElementById("tablaRecetas").getElementsByTagName('tbody')[0];
      var rowLength = table.rows.length;

      let arr = [];
      if (rowLength == 0) {
         alertMsg('Proceso fallido!', 'No ha agregado ningun producto a la table de recetas.', 'error', function(confirmed) {});
         return;
      }

      for (var i = 0; i < rowLength; i += 1) {
         var row = table.rows[i];
         arr[i] = {
            'materia_prima': row.cells[0].dataset.mp,
            'porcentaje': row.cells[1].dataset.porce
         };
      }
      let producto = document.getElementById('producto').value;
      jQuery.ajax({
         url: '<?= PROOT ?>recetas/validarReceta/' + producto,
         method: "GET",
         success: function(resp) {
            if (resp.success) {
               alertMsg('Receta ya creada!', 'La receta para este producto ya se encuentra registrada', 'error', function(confirmed) {});
               return;
            } else
               jQuery.ajax({
                  url: '<?= PROOT ?>recetas/nuevo',
                  method: "POST",
                  data: {
                     producto: producto,
                     arr: arr
                  },
                  success: function(resp) {
                     if (resp.success) {
                        alertMsg('Proceso exitoso!', 'El registro ha creado con exito.', 'success', function(confirmed) {
                           if (confirmed)
                              window.location.href = '<?= PROOT ?>recetas';
                        });
                     } else {
                        alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
                     }
                  }
               });
         }
      });
   }

   function actualizar() {
      var table = document.getElementById("tablaRecetas").getElementsByTagName('tbody')[0];
      var rowLength = table.rows.length;

      let arr = [];
      if (rowLength == 0) {
         alertMsg('Proceso fallido!', 'No ha agregado ningun producto a la table de recetas.', 'error', function(confirmed) {});
         return;
      }

      for (var i = 0; i < rowLength; i += 1) {
         var row = table.rows[i];
         arr[i] = {
            'materia_prima': row.cells[0].dataset.mp,
            'porcentaje': row.cells[1].dataset.porce
         };
      }

      let producto_old = document.getElementById('prod_id').value;
      let producto_new = document.getElementById('producto').value;
      if (producto_old == producto_new) {
         jQuery.ajax({
            url: '<?= PROOT ?>recetas/editar',
            method: "POST",
            data: {
               producto_old: producto_old,
               producto_new: producto_new,
               arr: arr
            },
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'El registro ha actualizado con exito.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>recetas';
                  });
               } else {
                  alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
               }
            }
         });
      } else{
         jQuery.ajax({
            url: '<?= PROOT ?>recetas/validarReceta/' + producto_new,
            method: "GET",
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Receta ya creada!', 'La receta para este producto ya se encuentra registrada', 'error', function(confirmed) {});
                  return;
               } else {
                  jQuery.ajax({
                     url: '<?= PROOT ?>recetas/editarReceta',
                     method: "POST",
                     data: {
                        producto_old: producto_old,
                        producto_new: producto_new,
                        arr: arr
                     },
                     success: function(resp) {
                        if (resp.success) {
                           alertMsg('Proceso exitoso!', 'El registro ha actualizado con exito.', 'success', function(confirmed) {
                              if (confirmed)
                                 window.location.href = '<?= PROOT ?>recetas';
                           });
                        } else {
                           alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
                        }
                     }
                  });
               }
            }
         });
      }
   }

   jQuery('#frmModal').on('show.bs.modal', function() {
      $('#table').bootstrapTable()

      cbProducto = $('#producto');
      cbProducto.select2({
         theme: "classic",
         width: 'resolve'
      });

      cbMateriaPrima = $('#materia_prima');
      cbMateriaPrima.select2({
         theme: "classic",
         width: 'resolve'
      });
   });

   function agregarFila() {
      let producto = document.getElementById('producto').value;
      let materia_prima = document.getElementById('materia_prima').value;
      let porcentaje = document.getElementById('porcentaje').value;

      if (producto.length == 0) {
         alertMsg('Campos vacios!', 'Debe seleccionar un producto para continuar', 'warning', function(confirmed) {});
         return;
      }

      if (materia_prima.length == 0) {
         alertMsg('Campos vacios!', 'Debe seleccionar la materia prima para continuar', 'warning', function(confirmed) {});
         return;
      }

      if (porcentaje.length == 0) {
         alertMsg('Campos vacios!', 'Debe digitar el porcentaje    para continuar', 'warning', 2500);
         return;
      }

      document.getElementById("tablaRecetas").getElementsByTagName('tbody')[0].insertRow(-1).innerHTML =
         `<tr>
            <td data-mp="${materia_prima}">
               ${$('#materia_prima').select2('data')[0].text}
            </td>
            <td data-porce="${porcentaje}">
               ${porcentaje}
            </td>
            <td>
               <div class="row">
                  <div class="col">
                     <a href="#" onClick="eliminarFila(this)" class="btn btn-danger btn-xs btn-sm col">
                        Eliminar
                     </a>
                  </div>
               </div>
            </td>
         </tr>`;
      $("#materia_prima").val('').trigger('change');
      $("#porcentaje").val('');
   }

   function eliminarFila(fila) {
      fila.closest("tr").remove();
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
               url: '<?= PROOT ?>recetas/eliminar',
               method: "POST",
               data: {
                  id: id
               },
               success: function(resp) {
                  if (resp.success) {
                     alertMsg('Proceso exitoso!', 'El registro ha eliminado con exito.', 'success', function(confirmed) {
                        if (confirmed)
                           window.location.href = '<?= PROOT ?>recetas';
                     });
                  } else {
                     alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.error, 'error', function(confirmed) {});
                  }
               }
            });
         }
      });
   }
</script>
<?php $this->end(); ?>