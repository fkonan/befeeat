$(document).ready(function() {
   document.getElementById("lado").selectedIndex = "1";

	var current_fs, next_fs, previous_fs; //fieldsets
	var opacity;

	$('.next').click(function(e) {
      var validator = $( "#msform" ).validate();
      if(e.currentTarget.id=='paso1'){
         if(validator.element( "#servicio_id" )==true && validator.element( "#categoria_id" )==true&& validator.element( "#subcategoria_id" )==true){
            //if ($("#msform").valid()) {

            current_fs = $(this).closest('fieldset');
            next_fs = $(this).closest('fieldset').next();

            next_fs.show();

            current_fs.animate(
               { opacity: 0 },
               {
                  step: function(now) {
                     opacity = 1 - now;

                     current_fs.css({
                        display: 'none',
                        position: 'relative'
                     });
                     next_fs.css({ opacity: opacity });
                  },
                  duration: 800
               }
            );
         }
      }
      if(e.currentTarget.id=='paso2'){
         if(validator.element( "#pares" )==true && validator.element( "#lado" )==true && validator.element( "#fecha_recoge" )==true && validator.element( "#hora_recoge" )==true){
            //if ($("#msform").valid()) {
   
            current_fs = $(this).closest('fieldset');
            next_fs = $(this).closest('fieldset').next();
   
            next_fs.show();
   
            current_fs.animate(
               { opacity: 0 },
               {
                  step: function(now) {
                     opacity = 1 - now;
   
                     current_fs.css({
                        display: 'none',
                        position: 'relative'
                     });
                     next_fs.css({ opacity: opacity });
                  },
                  duration: 800
               }
            );
         }
      }
	});

	$('.previous').click(function() {
		current_fs = $(this).closest('fieldset');
		previous_fs = $(this).closest('fieldset').prev();

		previous_fs.show();

		current_fs.animate(
			{ opacity: 0 },
			{
				step: function(now) {
					opacity = 1 - now;

					current_fs.css({
						display: 'none',
						position: 'relative'
					});
					previous_fs.css({ opacity: opacity });
				},
				duration: 800
			}
		);
	});

	$('.submit').click(function() {
		return false;
	});
});
