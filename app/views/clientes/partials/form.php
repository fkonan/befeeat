<?php

use Core\FH; ?>
<form method="post" action="" id="frm" role="form">
   <div class="row">
      <?= FH::inputBlock('hidden', 'Id', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'form-group col-md-12 d-none'], []) ?>

      <?= FH::selectBlock('Tipo de documento *', 'tipo_documento', $this->datos->tipo_documento, $this->tipo_documento, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-4'], []) ?>
      <?= FH::inputBlock('text', 'Documento *', 'documento', $this->datos->documento, ['class' => 'form-control'], ['class' => 'form-group col-md-4'], []) ?>
      <?= FH::inputBlock('text', 'Div ', 'dv', $this->datos->dv, ['class' => 'form-control'], ['class' => 'form-group col-md-4'], []) ?>

      <?= FH::selectBlock('Tipo de persona *', 'tipo_persona', $this->datos->tipo_persona, $this->tipo_per, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-4'], []) ?>
      <?= FH::inputBlock('text', 'Razón social', 'razon_social', $this->datos->razon_social, ['class' => 'form-control d-none'], ['class' => 'form-group col-md-8 d-none'], []) ?>
      <?= FH::inputBlock('text', 'Nombre cliente *', 'nombre', $this->datos->nombre, ['class' => 'form-control'], ['class' => 'form-group col-md-8'], []) ?>

      <?= FH::selectBlock('Departamento *', 'departamento_id', $this->datos->departamento_id, $this->deptos, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-6'], []) ?>

      <?= FH::selectBlock('Municipio *', 'municipio_id', $this->datos->municipio_id, $this->muni, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Dirección *', 'direccion', $this->datos->direccion, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>

      <?= FH::inputBlock('text', 'Teléfono *', 'telefono', $this->datos->telefono, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Celular', 'celular', $this->datos->celular, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>

      <?= FH::inputBlock('text', 'Correo *', 'correo', $this->datos->correo, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Pagina web/red social', 'web', $this->datos->web, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <div class="form-group col-md-6">
         <div class="form-check mt-4">
         <?php $gran_sup=($this->datos->gran_superficie)?'checked':'';?>
            <input type="checkbox" name="gran_superficie" class="form-check-input" value="<?=$this->datos->gran_superficie?>" id="gran_superficie" <?= $gran_sup;?>>
            <label class="form-check-label" for="gran_superficie">Es gran superficie?</label>
         </div>
      </div>
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

   $('#tipo_persona').on('change', function() {
      let tipo_persona = this.value;
      let razon_social = document.getElementById('razon_social');
      let div_razon_social = document.getElementById('razon_social').parentNode;
      if (tipo_persona == 'NATURAL') {
         razon_social.classList.add('d-none');
         div_razon_social.classList.add('d-none');
      } else {
         razon_social.classList.remove('d-none');
         div_razon_social.classList.remove('d-none');
      }
   });

   $('#documento').on('change', function() {
      var documento = this.value;
      if (documento.length > 0) {
         $.ajax({
            type: "POST",
            url: '<?= PROOT ?>clientes/validarDuplicado/' + documento,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Cliente ya existe!', 'El cliente ya se encuentra registrado en la base de datos', 'warning', function(confirmed) {});
                  document.getElementById('btnGuardar').disabled = true;
                  return;
               } else {
                  document.getElementById('btnGuardar').disabled = false;
               }
            }
         });
      }
   });
</script>