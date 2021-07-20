<?php

use Core\FH; ?>
<form method="post" action="" id="frm" role="form">
   <div class="row">
      <?= FH::inputBlock('hidden', 'Codigo del departamento antiguo *', 'codigo_depto_old', $this->datos->codigo_depto, ['class' => 'form-control'], ['class' => 'd-none form-group col-md-4'], []) ?>
      <?= FH::inputBlock('text', 'Codigo del departamento *', 'codigo_depto', $this->datos->codigo_depto, ['class' => 'form-control'], ['class' => 'form-group col-md-4'], []) ?>
      <?= FH::inputBlock('text', 'Nombre del departamento *', 'departamento', $this->datos->departamento, ['class' => 'form-control'], ['class' => 'form-group col-md-8'], []) ?>
   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <?php if (empty($this->datos->codigo_depto)) : ?>
         <button type="button" class="btn btn-info" onClick="guardar();return;">Guardar</button>
      <?php else : ?>
         <button type="button" class="btn btn-info" onClick="actualizar();return;">Actualizar</button>
      <?php endif; ?>
   </div>
</form>