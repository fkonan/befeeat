<?php

use Core\FH; ?>

<form method="post" action="" id="frm" role="form">
   <div class="row">
      <?= FH::inputBlock('hidden', 'Id', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'form-group col-md-12 d-none'], []) ?>
      <?= FH::inputBlock('text', 'Codigo *', 'codigo', $this->datos->codigo, ['class' => 'form-control'], ['class' => 'form-group col-md-2'], []) ?>
      <?= FH::inputBlock('text', 'Descripción *', 'descripcion', $this->datos->descripcion, ['class' => 'form-control'], ['class' => 'form-group col-md-4'], []) ?>
      <?= FH::inputBlock('text', 'Marca *', 'marca', $this->datos->marca, ['class' => 'form-control'], ['class' => 'form-group col-md-2'], []) ?>
      <?= FH::inputBlock('text', 'Sabor *', 'sabor', $this->datos->sabor, ['class' => 'form-control'], ['class' => 'form-group col-md-2'], []) ?>
      <?= FH::selectBlock('Unidad de medida *', 'unidad_medida', $this->datos->unidad_medida, $this->unidad_medida, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-2'], []) ?>
   </div>
   <div class="row">
      <?= FH::inputBlock('text', 'Inf. nutricional', 'info_nutricional', $this->datos->info_nutricional, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Inf. adicional', 'info_adicional', $this->datos->info_adicional, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
   </div>
   <div class="row">
      <?= FH::inputBlock('number', 'Precio *', 'precio', $this->datos->precio, ['class' => 'form-control'], ['class' => 'form-group col-md-3'], []) ?>
      <?= FH::inputBlock('text', 'Codigo de barras', 'codigo_barras', $this->datos->codigo_barras, ['class' => 'form-control'], ['class' => 'form-group col-md-3'], []) ?>
      <?php if (!empty($this->datos->id)) : ?>
         <?= FH::selectBlock('Estado *', 'estado', $this->datos->estado, ['1' => 'ACTIVO', '0' => 'INACTIVO'], ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-2'], []) ?>
      <?php endif; ?>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <?php if (empty($this->datos->id)) : ?>
         <button type="button" class="btn btn-info" id="btnGuardar" onClick="guardar();return;">Guardar</button>
      <?php else : ?>
         <button type="button" class="btn btn-info" onClick="actualizar();return;">Actualizar</button>
      <?php endif; ?>
   </div>
</form>