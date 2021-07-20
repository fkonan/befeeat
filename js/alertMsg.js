function alertMsg(title = '', msg = '', type = 'success', callback) {
	Swal.fire({
		title: title,
		text: msg,
		icon: type,
		showConfirmButton: true,
		confirmButtonText: 'Aceptar'
	}).then((result) => {
      callback(result.value);
	});
}

function validarAccion(
	title = '¿Está seguro de realizar esta acción?',
	msg = 'El proceso no tendra reversa en caso de aceptar culminar esta acción.'
) {
	Swal.fire({
		title: title,
		text: msg,
		icon: 'warning',
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33'
	}).then((result) => {
		if (result.value) {
			rta = true;
		} else {
			rta = false;
		}
		alert(rta);
	});
}
