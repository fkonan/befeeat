<?php

use Core\FH; ?>
<form method="post" action="" id="frm" role="form">
   <div class="row">
      <?= FH::inputBlock('hidden', 'Id', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'form-group col-md-12 d-none'], []) ?>

      <?= FH::selectBlock('Dueño de la mascota *', 'cliente_id', $this->datos->cliente_id, $this->clientes, ['class' => 'form-control', 'placeHolder' => 'seleccione', "style"=>"width: 100%;"], ['class' => 'form-group col-md-5'], []) ?>
      <?= FH::inputBlock('text', 'Nombre de la mascota *', 'nombre', $this->datos->nombre, ['class' => 'form-control'], ['class' => 'form-group col-md-3'], []) ?>
      <?= FH::selectBlock('Raza de la mascota *', 'raza_id', $this->datos->raza_id, $this->razas, ['class' => 'form-control', 'placeHolder' => 'seleccione', "style"=>"width: 100%;"], ['class' => 'form-group col-md-4'], []) ?>

      <?= FH::inputBlock('number', 'Peso', 'peso', $this->datos->peso, ['class' => 'form-control'], ['class' => 'form-group col-md-1'], []) ?>
      <?= FH::inputBlock('date', 'Fecha de cumpleaños', 'cumpleaños', $this->datos->cumpleaños, ['class' => 'form-control'], ['class' => 'form-group col-md-2'], []) ?>
      <?= FH::inputBlock('number', 'Edad', 'edad', $this->datos->edad, ['class' => 'form-control'], ['class' => 'form-group col-md-2'], []) ?>
      <?= FH::inputBlock('text', 'Enfermedades', 'enfermedades', $this->datos->enfermedades, ['class' => 'form-control'], ['class' => 'form-group col-md-7'], []) ?>
      <?= FH::inputBlock('text', 'Observación adicional', 'observacion', $this->datos->observacion, ['class' => 'form-control'], ['class' => 'form-group col-md-12'], []) ?>

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
<script>
   $(document).ready(function() {
      $('#cliente_id').select2({theme: "classic",width: 'resolve'});
      $('#raza_id').select2({theme: "classic",width: 'resolve'});
   });
</script>