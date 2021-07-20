<?php

use Core\FH; ?>
<form method="post" action="" id="frm" role="form">
   <div class="row">
      <?= FH::inputBlock('hidden', 'id *', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'd-none form-group col-md-4'], []) ?>
      
      <?= FH::inputBlock('text', 'Codigo del producto *', 'codigo', $this->datos->codigo, ['class' => 'form-control'], ['class' => 'form-group col-md-3'], []) ?>
      
      <?= FH::inputBlock('text', 'Descripción del producto *', 'descripcion', $this->datos->descripcion, ['class' => 'form-control'], ['class' => 'form-group col-md-7'], []) ?>
      
      <?= FH::selectBlock('Unidad medida *','unidad_medida',$this->datos->unidad_medida,$this->unidad_medida,['class'=>'form-control','placeHolder'=>'seleccione'],['class'=>'form-group col-md-2'],[]) ?>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <?php if (empty($this->datos->id)) : ?>
         <button type="button" class="btn btn-info" onClick="guardar();return;">Guardar</button>
      <?php else : ?>
         <button type="button" class="btn btn-info" onClick="actualizar();return;">Actualizar</button>
      <?php endif; ?>
   </div>
</form>