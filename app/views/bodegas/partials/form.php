<?php

use Core\FH; ?>
<form method="post" action="" id="frm" role="form">
   <div class="row">
      <?= FH::inputBlock('hidden', 'Id', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'form-group col-md-12 d-none'], []) ?>

      <?= FH::inputBlock('text', 'Nombre de la bodega *', 'bodega', $this->datos->bodega, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::selectBlock('Departamento *', 'departamento_id', $this->datos->departamento_id, $this->deptos, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-6'], []) ?>

      <?= FH::selectBlock('Municipio *', 'municipio_id', $this->datos->municipio_id, $this->muni, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Dirección *', 'direccion', $this->datos->direccion, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      
      <?= FH::inputBlock('text', 'Teléfono *', 'telefono', $this->datos->telefono, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Celular', 'celular', $this->datos->celular, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      
      <?= FH::inputBlock('text', 'Persona de contacto *', 'persona_contacto', $this->datos->persona_contacto, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Correo', 'correo', $this->datos->correo, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
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
   $('#departamento_id').on('change', function() {
      var departamento_id = this.value;
      if (departamento_id.length > 0) {
         $.ajax({
            type: "POST",
            url: '<?= PROOT ?>municipios/comboMuni/' + departamento_id,
            success: function(resp) {
               if (resp.success) {
                  var html = '';
                  html += '<option value="">Seleccionar</option>';
                  $('#municipio_id').html(html);
                  $.each(resp.muni, function(idx, opt) {
                     html += '<option value="' + idx + '">' + opt + '</option>';
                  });
                  $('#municipio_id').html(html);
                  $('#municipio_id').prop('disabled', false);
               } else {
                  $('#municipio_id').html(html);
                  $('#municipio_id').html('');
                  $('#municipio_id').prop('disabled', true);
                  $('#municipio_id').text('');
               }
            }
         });
      } else {
         $('#municipio_id').html('');
         $('#municipio_id').prop('disabled', true);
         $('#municipio_id').text('');
      }
   });
</script>