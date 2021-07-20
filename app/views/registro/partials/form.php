<?php

use Core\FH; ?>
<?php $this->start('body'); ?>

<div class="row justify-content-center">
   <div class="col-md-5">
      <h4 class="text-darkgreen">Quedan <b><?= $this->contador->contador ?></b> cupos para el bingo</h4>
   </div>
</div>
<hr class="solid">
<form role="form" method="post" action="" id="frmRegistro">
   <div class="row text-white">
      <div class="col-md-7">
         <div class="row">
            <?= FH::inputBlock('number', 'Documento de identidad *', 'documento', $this->datos->documento, ['class' => 'form-control', 'onBlur' => 'validarDocumento(this.value)'], ['class' => 'form-group col-md-6'], []) ?>

            <?= FH::inputBlock('text', 'Nombres del Asociado *', 'nombres', $this->datos->nombres, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
         </div>

         <div class="row">
            <?= FH::inputBlock('text', 'Apellidos del Asociado *', 'apellidos', $this->datos->apellidos, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>

            <?= FH::inputBlock('text', 'Correo electrónico *', 'correo', $this->datos->correo, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>
         </div>
         <div class="row">
            <?= FH::inputBlock('text', 'Celular *', 'celular', $this->datos->celular, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], []) ?>

            <?= FH::selectBlock(
               'Oficina de registro',
               'oficina_registro',
               $this->datos->oficina_registro,
               [
                  'BUCARAMANGA' => 'BUCARAMANGA',
                  'CIUDADELA REAL DE MINAS' => 'CIUDADELA REAL DE MINAS',
                  'FLORIDABLANCA' => 'FLORIDABLANCA',
                  'PIEDECUESTA' => 'PIEDECUESTA',
                  'SAN GIL' => 'SAN GIL',
                  'BARBOSA' => 'BARBOSA',
                  'MALAGA' => 'MALAGA',
                  'BARRANCABERMEJA' => 'BARRANCABERMEJA',
                  'SOATA' => 'SOATA',
                  'PAMPLONA' => 'PAMPLONA',
                  'AGUACHICA' => 'AGUACHICA',
                  'VALLEDUPAR' => 'VALLEDUPAR'
               ],
               ['class' => 'form-control', 'placeHolder' => 'seleccione'],
               ['class' => 'form-group col-md-6'],
               []
            ) ?>
         </div>
      </div>
      <div class="col-md-5">
         <div class="alert alert-success mt-3" role="alert">
            Amigo asociado, llene todos los datos solicitados para registrarse en el bingo del día 7 de noviembre, luego podrá descargar su cartón y las instrucciones del juego.<br><br>
            <b>¿Necesita ayuda?</b><br>
            <b>Celular - whatsapp:</b> 318 271 0233 – 316 326 0241<br>
            <b>Correo:</b> soporte@fundacoop.org<br>
            <b>Chat en línea:</b> <a href="http://www.fundacoop.org" target="_blank">www.fundacoop.org</a>
         </div>
         <div class="col-md-12">

         </div>
      </div>
   </div>

   <div class="modal-footer">
      <div class="row">
         <div class="col-md-12">
            <p class="text-white">Al enviar mis datos personales, autorizo de manera previa, expresa e invequívoca a la Fundación
               Cooprofesores a darles tratamiento,todo ello conforme a las finalidades misionales de la organización.
            </p>
         </div>


         <div class="col-md-12 mt-3">
            <button type="button" id="btnGuardar" onClick="guardar();" class="btn btn-warning btn-block">Registrarse al Bingo</button>
         </div>
         <div class="col-md-12 mt-3" id="divVolver">
            <a id="volver" class="btn btn-info btn-block" href="<?= PROOT ?>home">Volver</a>
         </div>

      </div>

   </div>
</form>
<?php $this->end(); ?>
<?php $this->start('footer'); ?>
<script>
   $(document).ready(function() {
      $("#frmRegistro").validate({
         lang: 'es',
         rules: {
            documento: {
               required: true
            },
            nombres: {
               required: true
            },
            apellidos: {
               required: true
            },
            correo: {
               required: true,
               email: true
            },
            celular: {
               required: true
            },
            oficina_registro: {
               required: true
            }
         },
         messages: {
            documento: {
               required: "Este campo es requerido."
            },
            nombres: {
               required: "Este campo es requerido."
            },
            apellidos: {
               required: "Este campo es requerido."
            },
            correo: {
               required: "Este campo es requerido.",
               email: "Debe digitar una dirección de correo valida."
            },
            celular: {
               required: "Este campo es requerido."
            },
            oficina_registro: {
               required: "Este campo es requerido."
            }
         }
      });


   });
   var click = 0;

   function guardar() {
      if ($("#frmRegistro").valid()) {

         var formData = jQuery('#frmRegistro').serialize();
         var documento = jQuery('#documento').val();
         validarDocumento(documento);


         $('#btnGuardar').prop("disabled", true);
         jQuery.ajax({
            url: '<?= PROOT ?>registro/nuevo',
            method: "POST",
            data: formData,
            beforeSend: function() {
               
               click = click + 1;
               $('#btnGuardar').addClass("d-none");
               $('#volver').addClass("mt-5");
               $('#divVolver').addClass("mt-5");

               if (click > 1) {
                  alertMsg('Ha ocurrido un error con el registro!', 'Contactar con el administrador.', 'error', 9000);
                  return false;
               }
            },
            success: function(resp) {
               if (resp.success) {
                  $('#btnGuardar').prop("disabled", false);
                  alertMsg('Registro exitoso al bingo.', 'Ya puede descargar su cartón, las instrucciones y reglamento.', 'success', 9000);
                  
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>registro/carton/' + documento;
                  }, 2000);
               } else {
                  alertMsg('Usted ya se encuentra registrado al bingo.', 'Solo se permite una inscripción por asociado, usted ya puede descargar su cartón.' , 'error', 9000);
                  return false;
               }
            }
         });
         return false;
         // } else {
         //    $('#btnGuardar').removeClass("d-none");
         //    $('#volver').removeClass("mt-5");
         //    $('#divVolver').removeClass("mt-5");
         // }
      }
   }
   var click2 = 0;

   function validarDocumento(documento) {
      console.log('evento');
      jQuery.ajax({
         url: '<?= PROOT ?>registro/validarDocumento/' + documento,
         method: "GET",

         success: function(resp) {
            if (resp.success) {
               $('#nombres').prop("disabled", false);
               $('#apellidos').prop("disabled", false);
               $('#correo').prop("disabled", false);
               $('#celular').prop("disabled", false);
               $('#oficina_registro').prop("disabled", false);
               $('#btnGuardar').prop("disabled", false);
               click2 = 0;
               setTimeout(function() {
                  $('#btnGuardar').removeClass("d-none");
                  $('#volver').removeClass("mt-5");
                  $('#divVolver').removeClass("mt-5");
               }, 2500);
               return true;
            } else {
               alertMsg(resp.mensaje[0], resp.mensaje[1], 'error', '', true);
               if (resp.mensaje[2] == 'DESCARGAR') {
                  var documento = jQuery('#documento').val();
                  setTimeout(function() {
                     window.location.href = '<?= PROOT ?>registro/carton/' + documento;
                  }, 4500);
               }
               click = 0;
               $('#nombres').prop("disabled", true);
               $('#apellidos').prop("disabled", true);
               $('#correo').prop("disabled", true);
               $('#celular').prop("disabled", true);
               $('#oficina_registro').prop("disabled", true);
               $('#btnGuardar').prop("disabled", true);

               return false;
            }
         }

      });

   }
</script>

<?php $this->end(); ?>