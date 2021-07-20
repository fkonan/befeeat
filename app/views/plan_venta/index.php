<?php $this->setSiteTitle('Plan de venta') ?>

<?php $this->start('head'); ?>
<link href="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Listado de planes de venta</h3>
   </div>
   <div class="card-body pt-2">
      <a href="#" onClick="nuevo();" class="btn btn-info btn-md float-right mb-2">Nuevo plan de venta</a>
      <div class="table-responsive">
         <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
            <thead class="text-center">
               <th class="col-auto bg-info">Cliente</th>
               <th class="col-auto bg-info">Mascota</th>
               <th class="col-auto bg-info">Raza</th>
               <th class="col-auto bg-info">Periocidad (días)</th>
               <th class="col-auto bg-info">Fecha ultima compra</th>
               <th class="col-auto bg-info">Acciones</th>
            </thead>
            <tbody>
               <?php foreach ($this->datos as $datos) : ?>
                  <tr>
                     <td><?= $datos->cliente; ?></td>
                     <td><?= $datos->mascota; ?></td>
                     <td><?= $datos->raza; ?></td>
                     <td><?= $datos->periocidad; ?></td>
                     <td><?= $datos->fecha_ult_compra; ?></td>
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
<script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
   jQuery('#frmModal').on('show.bs.modal', function() {
      
   });

   function nuevo() {
      jQuery.ajax({
         url: '<?= PROOT ?>planVenta/nuevo',
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
</script>

<?php $this->end(); ?>