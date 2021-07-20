<?php

use Core\FH;
use App\Models\Adjuntos;
?>

<?php $this->start('head'); ?>
<script src="https://www.gstatic.com/firebasejs/ui/4.5.0/firebase-ui-auth.js"></script>
<link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/4.5.0/firebase-ui-auth.css" />
<?php $this->end(); ?>

<?php $this->setSiteTitle('Registro de Usuario'); ?>
<?php $this->start('body'); ?>

<div class="row mt-5">
   <!-- <div class="col-md-6">
      <div class="col-md-12 text-center">
         <h2 class="font-bold">Bienvenido a "EL ZAPATERO"</h2>
         <p>
            35 años de experiencia en el mercado de zapatería
         </p>
      </div>
      <div class="col-md-12 text-center">
         <img alt="logo" class="img img-responsive w-50" src="<?= PROOT ?>img/logo.png">
      </div>
   </div> -->

   <div class="col-md-12 mt-4">
      <div class="card">
         <div class="card-body">
            <h2 class="text-center">Formulario de Registro</h2>
            <hr />
            <form class="m-t" role="form" action="" method="post" onsubmit="event.preventDefault(); validar();" id="frmRegistro">
               <?= FH::displayErrors($this->displayErrors) ?>
               <div class="row form-group">
                  <?= FH::inputBlock('text', 'Nombre completo <code>*</code>', 'nombres', $this->datos->nombres, ['class' => 'form-control', 'placeholder' => 'Digite su nombre completo'], ['class' => 'col-md-3'], $this->displayErrors) ?>

                  <?= FH::inputBlock('text', 'Apellidos <code>*</code>', 'apellidos', $this->datos->nombres, ['class' => 'form-control', 'placeholder' => 'Digite sus apellidos'], ['class' => 'col-md-3'], $this->displayErrors) ?>

                  <?= FH::selectBlock('Género', 'genero', $this->datos->genero, ['FEMENINO' => 'FEMENINO', 'MASCULINO' => 'MASCULINO'], ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => ' col-md-3'], $this->displayErrors) ?>

                  <?= FH::selectBlock('Ciudad', 'ciudad', $this->datos->ciudad, ['BUCARAMANGA' => 'BUCARAMANGA', 'FLORIDABLANCA' => 'FLORIDABLANCA', 'GIRÓN' => 'GIRÓN', 'PIEDECUESTA' => 'PIEDECUESTA'], ['class' => 'form-control', 'placeHolder' => 'seleccione'], ['class' => 'col-md-3'], $this->displayErrors) ?>
               </div>
               <div class="row form-group">
                  <?= FH::inputBlock('text', 'Barrio', 'barrio', $this->datos->barrio, ['class' => 'form-control', 'placeholder' => 'Digite su barrio'], ['class' => 'col-md-3'], $this->displayErrors) ?>

                  <?= FH::inputBlock('text', 'Dirección <code>*</code>', 'direccion', $this->datos->direccion, ['class' => 'form-control', 'placeholder' => 'Digite su dirección'], ['class' => 'col-md-6'], $this->displayErrors) ?>

                  <?= FH::inputBlock('tel', 'Celular <code>*</code>', 'celular', $this->datos->celular, ['class' => 'form-control', 'placeholder' => 'Digite su número de celular'], ['class' => 'col-md-3'], $this->displayErrors) ?>
               </div>
               <div class="row form-group">
                  <?= FH::inputBlock('email', 'Correo electrónico <code>*</code>', 'correo', $this->datos->correo, ['class' => 'form-control', 'placeholder' => 'Digite su correo electrónico'], ['class' => 'col-md-4'], $this->displayErrors) ?>

                  <?= FH::inputBlock('text', 'Usuario <code>*</code>', 'usuario', $this->datos->usuario, ['class' => 'form-control', 'placeholder' => 'Digite su usuario'], ['class' => 'col-md-4'], $this->displayErrors) ?>

                  <?= FH::inputBlock('password', 'Contraseña <code>*</code>', 'password', $this->datos->password, ['class' => 'form-control', 'placeholder' => 'Digite contraseña'], ['class' => 'col-md-2'], $this->displayErrors) ?>

                  <?= FH::inputBlock('password', 'Repita su contraseña <code>*</code>', 'confirm', $this->datos->confirm, ['class' => 'form-control', 'placeholder' => 'Repita contraseña'], ['class' => 'col-md-2'], $this->displayErrors) ?>
               </div>
               <div class="row form-group">
                  <div class="form-check abc-checkbox abc-checkbox-primary">
                     <input id="chk_terminos" class="styled" name="chk_terminos" type="checkbox" checked>
                     <label for="chk_terminos">
                        ¿Autoriza el tratamiento de datos personales y acepta los terminos y condiciones?
                        <a href="<?= PROOT ?><?=Adjuntos::findFirst()->adjunto;?>" target="_blank">
                           (ver política)
                        </a>
                     </label>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <?= FH::submitTag('Registrarse', ['class' => 'btn btn-primary btn-block full-width']) ?>
                     <a class="btn btn-info btn-block full-width mt-3" role='button' href="<?= PROOT ?>users/login">Iniciar sesión</a>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<?php $this->end(); ?>
<?php $this->start('footer'); ?>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
   $(document).ready(function() {
      $("#frmRegistro").validate({
         lang: 'es',
         rules: {
            nombres: {
               required: true
            },
            apellidos: {
               required: true
            },
            direccion: {
               required: true
            },
            celular: {
               required: true,
               phoneUS: true
            },
            usuario: {
               required: true
            },
            confirm: {
               required: true
            },
            password: {
               required: true
            },
            correo: {
               required: true,
               email: true
            }
         },
         messages: {
            nombres: {
               required: "Este campo es requerido."
            },
            apellidos: {
               required: "Este campo es requerido."
            },
            direccion: {
               required: "Este campo es requerido."
            },
            celular: {
               required: "Este campo es requerido.",
               phoneUS: "Debe digitar un número de celular valido."
            },
            usuario: {
               required: "Este campo es requerido."
            },
            confirm: {
               required: "Este campo es requerido."
            },
            password: {
               required: "Este campo es requerido."
            },
            correo: {
               required: "Este campo es requerido.",
               email: "Debe digitar una dirección de correo valida."
            }
         }
      });
   });

   function validar() {
      if ($("#frmRegistro").valid()) {
         if (!jQuery("#chk_terminos").is(":checked")) {
            alert('Debe aceptar los terminos y condiciones');
            return;
         }
         var formData = jQuery('#frmRegistro').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>users/registro',
            method: "POST",
            data: formData,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Registro exitoso!', 'Bienvenido al sistema.', 'success', 2000);
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>users/login';
                  }, 2000);
               } else {
                  alertMsg('Ha ocurrido un error con el registro!', 'Contactar con el administrador.', 'error', 2000);
                  return;
                  //jQuery('#frmEmpresa').modal('hide');
               }
            }
         });
      }
   }
</script>
<?php $this->end(); ?>