<?php

use Core\FH; ?>
<form method="post" action="" id="frm" role="form">
   <?= FH::inputBlock('hidden', 'id *', 'id', $this->datos->id, ['class' => 'form-control'], ['class' => 'd-none form-group col-md-4'], []) ?>
   <div class="row">
      <div class="col-md-4">
         <div class="row">
            <div class="col-md-12">
               <label for="mascota_id" class="control-label d-block">
                  Seleccione la mascota
                  <select class="form-control" style="width:100%;" name="mascota_id" id="mascota_id">
                     <option selected value="">Seleccionar</option>
                     <?php $html=""; foreach ($this->mascotas as $value => $display) {
                        $html .= '<option value="' . $value . '">' . $display . '</option>';
                     }
                     echo $html;
                     ?>
                  </select>
               </label>
            </div>
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header bg-secondary">
                     Datos de la mascota
                  </div>
                  <div class="card-body">
                     <p class="card-text mb-0" id="pNombre">Nombre: </p>
                     <p class="card-text mb-0" id="pRaza">Raza: </p>
                     <p class="card-text mb-0" id="pPeso">Peso: </p>
                     <p class="card-text mb-0" id="pCumpleaños">Cumpleaños: </p>
                     <p class="card-text mb-0" id="pEdad">Edad: </p>
                     <p class="card-text mb-0" id="pEnfermedades">Enfermedades: </p>
                     <hr>
                     <p class="card-text mb-0" id="pDueño">Dueño: </p>
                     <p class="card-text mb-0" id="pCelular">Celular: </p>
                     <p class="card-text mb-0" id="pDueño">Dirección: </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-8">
         <div class="row">
            <?= FH::selectBlock('Producto *', 'producto_id', $this->detalle->producto_id, $this->prodcutos, ['class' => 'form-control', 'placeHolder' => 'seleccione', "style" => "width: 100%;"], ['class' => 'form-group col-md-4'], []) ?>
            <?= FH::selectBlock('Presentación *', 'presentacion', $this->detalle->presentacion, $this->presentacion, ['class' => 'form-control', 'placeHolder' => 'seleccione', "style" => "width: 100%;"], ['class' => 'form-group col-md-2'], []) ?>
            <?= FH::inputBlock('number', 'Cantidad *', 'cantidad', $this->detalle->cantidad, ['class' => 'form-control'], ['class' => 'form-group col-md-2'], []) ?>
            <div class="col-md-2">
               <button type="button" class="btn btn-info" onClick="agregar();return;">Agregar</button>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <table id="tablaProductos" class="table table-striped table-condensed table-bordered table-hover">
                  <thead class="text-center">
                     <th class="col-auto bg-info">Prodcuto</th>
                     <th class="col-auto bg-info">Presentación</th>
                     <th class="col-auto bg-info">Cantidad</th>
                     <th class="col-auto bg-info">Acciones</th>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>
         <div class="row">
            <?= FH::inputBlock('number', 'Periocidad (dias) *', 'periocidad', $this->datos->periocidad, ['class' => 'form-control'], ['class' => 'form-group col-md-2'], []) ?>
            <?= FH::inputBlock('date', 'Fecha ultima compra *', 'fecha_ult_compra', $this->datos->fecha_ult_compra, ['class' => 'form-control'], ['class' => 'form-group col-md-3'], []) ?>
         </div>
      </div>
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
<script>
  
</script>
<!-- 
var dueño=document.getElementById('pDueño');
undefined
dueño.innerHTML='sddd'; -->