<?php

use Core\FH; ?>
<form method="post" action="" id="frm" role="form" enctype="multipart/form-data">
   <div class="row">
      <?= FH::inputBlock('hidden', 'Id', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'form-group col-md-12 d-none'], []) ?>

      <?= FH::selectBlock('Tipo de documento *', 'tipo_documento', $this->datos->tipo_documento, $this->tipo_documento, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-4'], []) ?>
      <?= FH::inputBlock('text', 'Documento *', 'documento', $this->datos->documento, ['class' => 'form-control'], ['class' => 'form-group col-md-4'], []) ?>
      <?= FH::inputBlock('text', 'Div ', 'dv', $this->datos->dv, ['class' => 'form-control'], ['class' => 'form-group col-md-4'], []) ?>

      <?= FH::selectBlock('Tipo de persona *', 'tipo_persona', $this->datos->tipo_persona, $this->tipo_per, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-4'], []) ?>
      <?= FH::inputBlock('text', 'Razón social *', 'razon_social', $this->datos->razon_social, ['class' => 'form-control'], ['class' => 'form-group col-md-8'], []) ?>

      <?= FH::inputBlock('text', 'Nombre del representante *', 'representante', $this->datos->representante, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::selectBlock('Departamento *', 'departamento_id', $this->datos->departamento_id, $this->deptos, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-6'], []) ?>

      <?= FH::selectBlock('Municipio *', 'municipio_id', $this->datos->municipio_id, $this->muni, ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Dirección *', 'direccion', $this->datos->direccion, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>

      <?= FH::inputBlock('text', 'Teléfono *', 'telefono', $this->datos->telefono, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Celular', 'celular', $this->datos->celular, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>

      <?= FH::inputBlock('text', 'Correo *', 'correo', $this->datos->correo, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
      <?= FH::inputBlock('text', 'Pagina web', 'web', $this->datos->web, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>

      <div class="col-md-12">
         <input id="rut" name="rut" type="file" class="custom-file-input" value="<?= $this->datos->rut ?>" accept="application/pdf">
         <label for="rut" class="custom-file-label mt-4">
            <?php
            if (empty($this->datos->rut)) {
               echo 'Seleccionar archivo...';
            } else {
               echo $this->datos->rut;
            }
            ?>
         </label>
         <small>Tipos de archivos permitidos: (Pdf).</small>
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

   $('#documento').on('change', function() {
      var documento = this.value;
      if (documento.length > 0) {
         $.ajax({
            type: "POST",
            url: '<?= PROOT ?>proveedores/validarDuplicado/' + documento,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proveedor ya existe!', 'El proveedor ya se encuentra registrado en la base de datos', 'warning');
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