<?php

use Core\FH;
?>
<?php $this->setSiteTitle('Inicio se sesión'); ?>
<?php $this->start('body'); ?>
<div class="container">
   <div class="row">
      <div class="col rounded" style="padding: 80px 60px 0px;">
         <div class="card">
            <div class="card-body">
               <h2 class="text-center">Iniciar sesión</h2>
               <form class="m-t" role="form" action="" method="post" onsubmit="event.preventDefault(); validar();" id="frm">
                  <div class="row form-group">
                     <?= FH::inputBlock('text', 'Usuario', 'usuario', $this->datos->usuario, ['class' => 'form-control', 'placeholder' => 'Digite su usario'], ['class' => 'col-md-12 form-group'], []) ?>
                     <?= FH::inputBlock('password', 'Contraseña', 'password', $this->datos->password, ['class' => 'form-control', 'placeholder' => 'Digite su contraseña'], ['class' => 'col-md-12 form-group'], []) ?>
                     <div class="col-md-12">
                        <?= FH::submitTag('Iniciar sesión', ['class' => 'btn btn-primary btn-block full-width m-b']) ?>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php $this->end(); ?>
<?php $this->start('footer'); ?>

<script>
   $(document).ready(function() {
      $("#frm").validate({
         lang: 'es',
         rules: {
            usuario: {
               required: true,
            },
            password: {
               required: true
            }
         },
         messages: {
            usuario: {
               required: "Este campo es requerido."
            },
            password: {
               required: "Este campo es requerido."
            }
         }
      });
   });

   function validar() {
      if ($("#frm").valid()) {
         var formData = jQuery('#frm').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>usuarios/login',
            method: "POST",
            data: formData,
            success: function(resp) {
               if (resp.success) {
                  alertMsg('Proceso exitoso!', 'Bienvenido al sistema.', 'success', function(confirmed) {
                     if (confirmed)
                        window.location.href = '<?= PROOT ?>home';
                  });
               } else {
                  alertMsg('Inicio de sesión fallido!', resp.error, 'error', function(confirmed) {});
               }
            }
         });
      }
   }
</script>
<?php $this->end(); ?>