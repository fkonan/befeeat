<?php

use Core\FH; ?>
<form method="post" action="" id="frm" role="form">
   <?= FH::inputBlock('hidden', 'id *', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'd-none form-group col-md-4'], []) ?>
   <div class="row">
      <div class="col-md-4">
         <label for="producto" class="control-label d-block">
            Producto
            <select class="form-control" style="width:100%;" name="producto" id="producto">
               <option selected value="">Seleccionar</option>
               <?php foreach ($this->productos as $value => $display) {
                  $html .= '<option value="' . $value . '">' . $display . '</option>';
               }
               echo $html;
               ?>
            </select>
         </label>
      </div>
      <div class="col-md-4">
         <label for="materia_prima" class="control-label d-block">
            Materia prima
            <select class="form-control" style="width:100%;" name="materia_prima" id="materia_prima">
               <option selected value="">Seleccionar</option>
               <?php $html = "";
               foreach ($this->materia_prima as $value => $display) {
                  $html .= '<option value="' . $value . '">' . $display . '</option>';
               }
               echo $html;
               ?>
            </select>
         </label>
      </div>
      <?= FH::inputBlock('number', 'Porcentaje *', 'porcentaje', $this->datos->porcentaje, ['class' => 'form-control w-100'], ['class' => 'form-group col-md-2 form-inline'], []) ?>
      <div class="col-md-2 form-inline">
         <button type="button" id="btnAgregar" class="btn btn-info float-right" onclick="agregarFila()">Agregar</button>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <table id="tablaRecetas" class="table table-striped table-condensed table-bordered table-hover" >
            <thead class="text-center">
               <th class="col-auto bg-info">Materia prima</th>
               <th class="col-auto bg-info">Porcentaje</th>
               <th class="col-auto bg-info">Acciones</th>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
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