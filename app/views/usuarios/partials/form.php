<?php

use Core\FH; ?>
<form class="m-t" role="form" action="" method="post" onsubmit="event.preventDefault(); validar();" id="frmUsuario">
   <?= FH::displayErrors($this->displayErrors) ?>
   <div class="row form-group">
      <?= FH::inputBlock('hidden', 'id', 'id', $this->datos->id, ['class' => 'form-control', 'placeholder' => 'Digite su nombre completo'], ['class' => 'col-md-6 d-none'], $this->displayErrors) ?>
      <?= FH::inputBlock('text', 'Nombre completo <code>*</code>', 'nombres', $this->datos->nombres, ['class' => 'form-control', 'placeholder' => 'Digite su nombre completo'], ['class' => 'col-md-6'], $this->displayErrors) ?>

      <?= FH::inputBlock('text', 'Apellidos <code>*</code>', 'apellidos', $this->datos->nombres, ['class' => 'form-control', 'placeholder' => 'Digite sus apellidos'], ['class' => 'col-md-6'], $this->displayErrors) ?>
   </div>
   <div class="row form-group">
      <?= FH::selectBlock('Género', 'genero', $this->datos->genero, ['FEMENINO' => 'FEMENINO', 'MASCULINO' => 'MASCULINO'], ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => ' col-md-6'], $this->displayErrors) ?>

      <?= FH::selectBlock('Ciudad', 'ciudad', $this->datos->ciudad, ['BUCARAMANGA' => 'BUCARAMANGA', 'FLORIDABLANCA' => 'FLORIDABLANCA', 'GIRÓN' => 'GIRÓN', 'PIEDECUESTA' => 'PIEDECUESTA'], ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'col-md-6'], $this->displayErrors) ?>

   </div>
   <div class="row form-group">
      <?= FH::inputBlock('text', 'Barrio', 'barrio', $this->datos->barrio, ['class' => 'form-control', 'placeholder' => 'Digite su barrio'], ['class' => 'col-md-6'], $this->displayErrors) ?>
   
      <?= FH::inputBlock('tel', 'Celular <code>*</code>', 'celular', $this->datos->celular, ['class' => 'form-control', 'placeholder' => 'Digite su número de celular'], ['class' => 'col-md-6'], $this->displayErrors) ?>
   </div>
   <div class="row form-group">
      <?= FH::inputBlock('text', 'Dirección <code>*</code>', 'direccion', $this->datos->direccion, ['class' => 'form-control', 'placeholder' => 'Digite su dirección'], ['class' => 'col-md-12'], $this->displayErrors) ?>
   </div>
   <div class="row form-group">
      <?= FH::inputBlock('email', 'Correo electrónico <code>*</code>', 'correo', $this->datos->correo, ['class' => 'form-control', 'placeholder' => 'Digite su correo electrónico'], ['class' => 'col-md-6'], $this->displayErrors) ?>

      <?= FH::inputBlock('text', 'Usuario <code>*</code>', 'usuario', $this->datos->usuario, ['class' => 'form-control', 'placeholder' => 'Digite su usuario','readOnly'=>'true'], ['class' => 'col-md-6'], $this->displayErrors) ?>
   </div>
   <div class="row">
      <div class="col-md-12">
         <button type="button" class="btn btn-info btn-block" onClick="actualizar();return;">Actualizar</button>
      </div>
   </div>
</form>