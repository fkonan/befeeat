<?php

use Core\FH; ?>
<?php $this->setSiteTitle('Entradas de mercancía') ?>

<?php $this->start('head'); ?>
<link href="<?= PROOT ?>css/plugins/footable/footable.bootstrap.css" rel="stylesheet">
<?php $this->end(); ?>
<?php $this->start('body'); ?>

<div class="row">
   <?= FH::inputBlock('hidden', 'Id', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'form-group col-md-12 d-none'], []) ?>
</div>
<div class="card card-secondary">
   <div class="card-header text-center">
      <h3 class="my-0">Detalle de la entrada de mercancía</h3>
   </div>
   <div class="card-body pt-2">

      <div class="row">
         <?= FH::inputBlock('text', 'Tipo de entrada', 'tipo_entrada', $this->datos->tipo_entrada, ['class' => 'form-control', 'readOnly' => 'true'], ['class' => 'form-group col-md-3'], []) ?>

         <?= FH::inputBlock('text', 'No orden/factura', 'numero_orden', $this->datos->numero_orden, ['class' => 'form-control', 'readOnly' => 'true'], ['class' => 'form-group col-md-2'], []) ?>

         <?= FH::inputBlock('text', 'Proveedor', 'razon_social', $this->datos->razon_social, ['class' => 'form-control', 'readOnly' => 'true'], ['class' => 'form-group col-md-4'], []) ?>

         <?= FH::inputBlock('text', 'Bodega', 'bodega', $this->datos->bodega, ['class' => 'form-control', 'readOnly' => 'true'], ['class' => 'form-group col-md-3'], []) ?>
      </div>

      <div class="row">
         <?= FH::inputBlock('text', 'Fecha de la entrada', 'fecha_reg', $this->datos->fecha_reg, ['class' => 'form-control', 'readOnly' => 'true'], ['class' => 'form-group col-md-3'], []) ?>
         <?= FH::inputBlock('text', 'Observaciones', 'observaciones', $this->datos->observaciones, ['class' => 'form-control', 'readOnly' => 'true'], ['class' => 'form-group col-md-9'], []) ?>
      </div>
      <hr>
      <div class="row">
         <div class="col-md-12">
            <h3 class="text-center">Listado de productos</h3>
            <div class="table-responsive">
               <table class="table table-striped table-condensed table-bordered table-hover" data-filtering="false">
                  <thead class="text-center">
                     <th class="col-auto bg-info">Codigo</th>
                     <th class="col-auto bg-info">Producto</th>
                     <th class="col-auto bg-info">Marca</th>
                     <th class="col-auto bg-info">Sabor</th>
                     <th class="col-auto bg-info">Unidad de medida</th>
                     <th class="col-auto bg-info">Cantidad</th>
                     <th class="col-auto bg-info">Valor</th>
                     <th class="col-auto bg-info">Subtotal</th>
                  </thead>
                  <tbody>
                     <?php foreach ($this->detalle as $datos) : ?>
                        <tr>
                           <td><?= $datos->codigo; ?></td>
                           <td><?= $datos->producto; ?></td>
                           <td><?= $datos->marca; ?></td>
                           <td><?= $datos->sabor; ?></td>
                           <td><?= $datos->unidad_medida; ?></td>
                           <td><?= $datos->cantidad; ?></td>
                           <td><?= $datos->valor; ?></td>
                           <td><?= $datos->subtotal; ?></td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th scope="row"></th>
                        <th scope="row"></th>
                        <th scope="row"></th>
                        <th scope="row"></th>
                        <th scope="row"></th>
                        <th scope="row"></th>
                        <th scope="row">Total</th>
                        <td><?= $this->datos->total; ?></td>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12 text-right">
            <a href="#" class="btn btn-danger btn-xs btn-sm" onClick="eliminar(<?= $this->datos->id ?>);">
               Eliminar entrada
            </a>
         </div>
      </div>
   </div>
</div>

<?php $this->end(); ?>
<?php $this->start('footer'); ?>
<script src="<?= PROOT ?>js/plugins/footable/footable.js"></script>
<script src="<?= PROOT ?>js/plugins/footable/footableConfig.js"></script>
<script>
   function eliminar(id) {
      swal({
            title: "Eliminar entrada",
            text: "¿Esto afectara el inventario. Esta usted seguro que desea realizar esta acción?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
         },
         function(isConfirm) {
            if (isConfirm) {
               jQuery.ajax({
                  url: '<?= PROOT ?>entradaMcia/eliminar',
                  method: "POST",
                  data: {
                     id: id
                  },
                  success: function(resp) {
                     if (resp.success) {
                        window.location.href = '<?= PROOT ?>entradaMcia';
                     } else {
                        alertMsg('Proceso fallido!', 'Ha ocurrido un error: ' + resp.errors, 'error', 3500);
                        return;
                     }
                  }
               });
            }
         });
   }
</script>
<?php $this->end(); ?>