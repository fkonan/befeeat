<?php

use Core\FH; ?>

<?php $this->start('body'); ?>

<form role="form" method="post" action="" id="frmRegistro">
   <div class="row">

      <div class="col-md-7">


         <div class="row justify-content-center text-center">
            <?= FH::inputBlock('text', 'Documento de identidad *', 'documento', $this->documento, ['class' => 'form-control'], ['class' => 'form-group col-md-7 text-white'], []) ?>
         </div>
         <div class="row justify-content-center text-center">
            <button type="button" id="btnValidar" onClick="validar();" class="btn btn-success col-md-3 mr-1">Descargar cartón</button>
            <a href="<?= PROOT ?>registro/nuevo" class="btn btn-info col-md-3"><strong>Volver</strong></a>
         </div>
      </div>
      <div class="col-md-5">
         <div class="alert alert-success mt-3" role="alert">
            Amigo asociado, si ya se registró al bingo, puede descargar su cartón y las instrucciones del juego, digite su documento de identidad.<br><br>
            <b>¿Necesita ayuda?</b><br>
            Celular - whatsapp: 318 271 0233 – 316 326 0241<br>
            Correo: soporte@fundacoop.org<br>
            Chat en línea: <a href="www.fundacoop.org" target="_blank">www.fundacoop.org</a>
         </div>
      </div>
   </div>
   <hr class="solid">
   <div class="row justify-content-center" style=" display: none;text-align:-webkit-center;" id="datosCarton">
      <div class="col-7">
         <div class="card bg-light">
            <div class="card-header text-center font-weight-bold">Descargue su cartón y las instrucciones del Bingo (formatos PDF)</div>
            <div class="card-body text-center">
               <p class="card-text"><a onClick="descargar();" class="badge-success" href="#">>Descargar cartón del bingo.<</a> </p> <p class="card-text"><a class="badge-secondary" href="https://drive.google.com/file/d/1HM6jYKn3NG2kUuhPCCx0VmS0R5Sep0ND/view" target="_blank">Descargar instrucciones y reglamento.</a></p>
              
               <p><b>Por favor lea atentamente las instrucciones del bingo</b>, para que conozca la mecánica del juego y los premios. Recuerde que el evento es el día 7 de noviembre a las 3 p.m. y se transmitirá por el facebook live de Cooprofesores.</p>
            </div>
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
            }
         },
         messages: {
            documento: {
               required: "Este campo es requerido."
            }
         }
      });
   });
   let carton = '';

   function validar() {
      if ($("#frmRegistro").valid()) {
         var formData = jQuery('#frmRegistro').serialize();
         jQuery.ajax({
            url: '<?= PROOT ?>registro/carton',
            method: "POST",
            data: formData,
            success: function(resp) {
               if (resp.success) {
                  // $('#datosCarton').removeClass("d-none");.
                  //$("#enlaceCarton").attr("href", "<?= PROOT ?>"+resp.carton);
                  carton = resp.carton;
                  $('#datosCarton').slideDown("slow");
               } else {
                  alertMsg('Documento no registrado en el bingo', resp.mensaje, 'error', '', true);
                  // $('#datosCarton').addClass("d-none");
                  $('#datosCarton').slideUp("slow");
                  return;
                  //jQuery('#frmEmpresa').modal('hide');
               }
            }
         });
      }
   }

   function descargar() {
      var link = document.createElement('a');
      link.href = "<?= PROOT ?>" + carton;
      link.download = carton.substring(11);
      link.dispatchEvent(new MouseEvent('click'));
   }

   function validarDocumento(documento) {

      jQuery.ajax({
         url: '<?= PROOT ?>registro/validarDocumento/' + documento,
         method: "GET",
         success: function(resp) {
            if (resp.success) {
               $('#btnGuardar').prop("disabled", false);
            } else {
               alertMsg('Ha ocurrido un error con el registro!', resp.mensaje, 'error', 2000);
               $('#btnGuardar').prop("disabled", true);
               return;
               //jQuery('#frmEmpresa').modal('hide');
            }
         }
      });
   }
</script>

<?php $this->end(); ?>