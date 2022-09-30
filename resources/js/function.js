function abrir_seccion(contenido) {
	$.ajax({
		method: 'POST',
		url: 'App/views/' + contenido
	}).done(function(html) {
		$('#section').html(html);
		cerrarmodal();
	});
}
const FrmPrueba = document.querySelector('#FrmPrueba');
const frmUsuario = document.querySelector('#frmUsuario');

function remove_addClass(link) {
	$('.nav .active').removeClass('active');
	$(link).addClass('active');
}
function abrirListado() {
	abrir_seccion('listado.php');
	remove_addClass('#lnk-listado');
}
function abrirListadoMono() {
	abrir_seccion('listadoMono.php');
	remove_addClass('#lnk-listadoM');
	accionNav();
}
function abrirReporteC() {
	abrir_seccion('reporteC.html');
	remove_addClass('#lnk-reportec');
	accionNav();
}
function abrirReporteM() {
	abrir_seccion('reporteM.html');
	remove_addClass('#lnk-reporteM');
	accionNav();
}
function abrirUsuarios() {
	abrir_seccion('usuarios.html');
	remove_addClass('#lnk-usuarios');
	accionNav();
}

$('.closebtn').click(function(event) {
	cerrarmodal();
});
$('.close-modal-area').click(function(event) {
	event.preventDefault();
	cerrarmodal();
});
const cerrarmodal = () => {
	$('.modal').css('display', 'none');
	Limpiar();
};
$(function() {
	$(document).on('click', '#BtnAddPruebaC', function(event) {
		abrirFormPrueba('C');
	});
});
$(function() {
	$(document).on('click', '#BtnAddPruebaM', function(event) {
		abrirFormPrueba('M');
	});
});
const abrirFormPrueba = (tvirus) => {
	if (tvirus === 'C') {
		$('.input-ant').removeClass('nvisible');
		$('.input-ser').removeClass('nvisible');
	} else {
		$('.input-ant').addClass('nvisible');
		$('.input-ser').addClass('nvisible');
	}
	$('#AccionReporte').val('REGISTRAR_REPORTE');
	$('#modal').css('display', 'table');
	$('#modal').css('position', 'absolute');
	$('#Fecha').prop('readonly', false);
	$('#Ipress').prop('readonly', false);
	$('#tvirus').val(tvirus);
	CargarFechaActual(`Fecha`);
};
$(function() {
	$(document).on('click', '#btn-clave', function(event) {
		accionNav();
		$('#modal2').css('display', 'table');
		$('#modal2').css('position', 'absolute');
	});
});
$(function() {
	$(document).on('click', '#BtnAddUsuario', function(event) {
		$('#accionUsuario').val('REGISTRAR_USUARIO');
		$('#modalUsuario').css('display', 'table');
		$('#modalUsuario').css('position', 'absolute');
		$('.cont-check').css('display', 'none');
		$('#passUsuario').prop('readonly', false);
		$('#passUsuario').removeClass('input-readonly');
		$('#tnbuscarPersona').removeClass('inactive');
		$('#tnbuscarPersona').prop('disabled', false);
		$('#dniUsuario').removeClass('input-readonly');
		$('#dniUsuario').prop('readonly', false);
	});
});
$(function() {
	$(document).on('click', '.edit-user', function(event) {
		$('#accionUsuario').val('EDITAR_USUARIO');
		$('#modalUsuario').css('display', 'table');
		$('#modalUsuario').css('position', 'absolute');
		$('.cont-check').css('display', 'block');
		$('#passUsuario').prop('readonly', 'true');
		$('#passUsuario').addClass('input-readonly');
		$('#tnbuscarPersona').addClass('inactive');
		$('#tnbuscarPersona').prop('disabled', true);
		$('#dniUsuario').addClass('input-readonly');
		$('#dniUsuario').prop('readonly', true);

		var parent = $(this).closest('table');
		var tr = $(this).closest('tr');
		usuario = $(tr).find('td').eq(0).html();
		nombre = $(tr).find('td').eq(1).html();
		tipousuario = $(tr).find('td').eq(3).html();
		idregion = $(tr).find('td').eq(4).html();

		$('#dniUsuario').val(usuario);
		$('#nombreUsuario').val(nombre);
		$('#TipoUsuario').val(tipousuario);
		$('#RegionUsuario').val(idregion);
	});
});
$(function() {
	$(document).on('change', '#cbxreset', function(event) {
		$('#passUsuario').val('');
		if (event.target.checked) {
			$('#passUsuario').prop('readonly', false);
			$('#passUsuario').removeClass('input-readonly');
		} else {
			$('#passUsuario').prop('readonly', 'true');
			$('#passUsuario').addClass('input-readonly');
		}
	});
});

$(function() {
	$(document).on('click', '#tb-listadoC .btn-edit', function(event) {
		event.preventDefault();
		var parent = $(this).closest('table');
		var tr = $(this).closest('tr');
		let idreporte = $(tr).find('td').eq(0).html();

		abrirEditarReporte(idreporte, 'C');
	});
});
$(function() {
	$(document).on('click', '#tb-listadoM .btn-edit', function(event) {
		event.preventDefault();
		var parent = $(this).closest('table');
		var tr = $(this).closest('tr');
		let idreporte = $(tr).find('td').eq(0).html();

		abrirEditarReporte(idreporte, 'M');
	});
});

const abrirEditarReporte = (idreporte, tvirus) => {
	$.ajax({
		method: 'POST',
		url: 'App/controllers/controller.php',
		data: {
			accion: 'BUSCAR_REPORTE',
			idreporte: idreporte
		}
	}).done(function(resultado) {
		let json = JSON.parse(resultado);
		$('#IdReporte').val(idreporte);
		$('#Fecha').val(json.fecha);
		$('#IdIpress').val(json.codigo);
		$('#Ipress').val(json.ipress);
		$('#Comentario').val(json.comentario);
		$('#tvirus').val(json.virus);

		$('#Fecha').prop('readonly', 'true');
		$('#Ipress').prop('readonly', 'true');
		$('#AccionReporte').val('EDITAR_REGISTRO');
		$('#TittleForm').html('Editar Registro');

		let arrBeneficiarios = [ 'ta', 'td', 'tr', 'f' ];
		let arrPruebas = [ 'pcr', 'ant', 'ser' ];

		for (let i = 0; i < arrBeneficiarios.length; i++) {
			const element = arrBeneficiarios[i];
			let tb = element.toUpperCase();

			let reporte = json.reporte[`${tb}`];

			for (let j = 0; j < arrPruebas.length; j++) {
				const elementPrueba = arrPruebas[j];
				let prueba = typeof reporte !== 'undefined' ? json.reporte[`${tb}`][`${elementPrueba}`] : '0';
				$(`#${elementPrueba}_${element}`).val(prueba);
			}
		}
		if (tvirus === 'C') {
			$('.input-ant').removeClass('nvisible');
			$('.input-ser').removeClass('nvisible');
		} else {
			$('.input-ant').addClass('nvisible');
			$('.input-ser').addClass('nvisible');
		}
	});
	$('#modal').css('display', 'table');
	$('#modal').css('position', 'absolute');
};

/* -------------------------------------------------- */
function CargarFechaActual(idcontrol) {
	let date = new Date();
	let year = date.getFullYear();
	let month = date.getMonth() + 1;
	let day = date.getDate();

	if (month < 10) month = `0${month}`;
	if (day < 10) day = `0${day}`;

	fullfecha = `${year}-${month}-${day}`;
	$(`#${idcontrol}`).val(fullfecha);
}
$(function() {
	$(document).on('change', '#FechaFiltroC', function(event) {
		let fecha = $('#FechaFiltroC').val();
		let tabla = '#tb-listadoC';
		CargarListadoHoy(fecha, 'C', tabla);
	});
});
$(function() {
	$(document).on('change', '#FechaFiltroM', function(event) {
		let fecha = $('#FechaFiltroM').val();
		let tabla = '#tb-listadoM';
		CargarListadoHoy(fecha, 'M', tabla);
	});
});
const CargarListadoHoy = (fecha, tvirus, tabla) => {
	$.ajax({
		method: 'POST',
		url: 'App/controllers/controller.php',
		data: {
			accion: 'LISTAR_REGISTROS_HOY',
			fecha: fecha,
			tvirus: tvirus
		}
	}).done(function(resultado) {
		$(tabla).html(resultado);
	});
};
function RegistrarReporte() {
	virus = $('#tvirus').val();
	tabla = `#tb-listado${virus}`;
	fecha = $(`#FechaFiltro${virus}`).val();

	ipress = $('#IdIpress').val();
	if (ipress === '') {
		Swal.fire('No ha seleccionado una Ipress', 'Ingrese IPRESS', 'warning');
	} else {
		formulario = $('#FrmPrueba').serializeArray();
		$('#btn-registrar').prop('disabled', true);
		$('#btn-registrar').addClass('btn-disabled');
		$.ajax({
			method: 'POST',
			url: 'App/controllers/controller.php',
			data: formulario
		}).done(function(resultado) {
			if (resultado === 'REGISTRADO' || resultado === 'ACTUALIZADO') {
				Swal.fire(`Se ha ${resultado} Correctamente`, '', 'success');
				cerrarmodal();
				CargarListadoHoy(fecha, virus, tabla);
			} else Swal.fire('No se Registró', resultado, 'error');

			$('#btn-registrar').prop('disabled', false);
			$('#btn-registrar').removeClass('btn-disabled');
		});
	}
}

$(function() {
	$(document).on('click', '#tb-listadoC .btn-delete', function(event) {
		tabla = `#tb-listadoC`;
		fecha = $(`#FechaFiltroC`).val();
		event.preventDefault();
		//var parent = $(this).closest('table');
		var tr = $(this).closest('tr');
		idreporte = $(tr).find('td').eq(0).html();
		eliminarRegistro(idreporte, fecha, 'C', tabla);
	});
});
$(function() {
	$(document).on('click', '#tb-listadoM .btn-delete', function(event) {
		tabla = `#tb-listadoM`;
		fecha = $(`#FechaFiltroM`).val();
		event.preventDefault();
		//var parent = $(this).closest('table');
		var tr = $(this).closest('tr');
		idreporte = $(tr).find('td').eq(0).html();
		eliminarRegistro(idreporte, fecha, 'M', tabla);
	});
});
const eliminarRegistro = (idreporte, fecha, virus, tabla) => {
	Swal.fire({
		title: 'Eliminar REGISTRO',
		text: 'Desea Eliminar Registro?',
		showCancelButton: true,
		confirmButtonColor: '#6777ef',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Anular',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				method: 'POST',
				url: 'App/controllers/controller.php',
				data: {
					accion: 'ELIMINAR_REGISTRO',
					idreporte: idreporte
				}
			}).done(function(resultado) {
				if (resultado === 'ELIMINADO') {
					Swal.fire(resultado, 'Se ha eliminado el registro', 'success');
					CargarListadoHoy(fecha, virus, tabla); //MODIFICAR
				}
			});
		}
	});
};
function Limpiar() {
	FrmPrueba.reset();
	frmUsuario.reset();
}

$(function() {
	$(document).on('click', '#BtnBuscarRepC', function(event) {
		GenerarReporte('C');
	});
});
$(function() {
	$(document).on('click', '#BtnBuscarRepM', function(event) {
		GenerarReporte('M');
	});
});
const GenerarReporte = (tvirus) => {
	let accion = tvirus === 'C' ? 'GENERAR_REPORTE_COVID' : 'GENERAR_REPORTE_VMONO';
	let tb = $('#tipo_benef').val();
	let tipo_benef = '';
	tipo_benef = tb === 'T' ? $('#tipo_titular').val() : tb;

	periodo = $('#periodo').val();
	$('#t-report').html('<tr><td>Cargando...</td></tr>');
	$.ajax({
		method: 'POST',
		url: 'App/controllers/controller.php',
		data: {
			accion: accion,
			periodo: periodo,
			tipo_benef: tipo_benef
		}
	}).done(function(resultado) {
		$('#t-report').html(resultado);
		CargarBtnExport(tvirus);
	});
};
function CargarBtnExport(tvirus) {
	let ruta = tvirus === 'C' ? 'ReportePruebasCovid.php' : 'ReportePruebasMono.php';
	let tb = $('#tipo_benef').val();
	periodo = $('#periodo').val();
	tipo_benef = tb === 'T' ? $('#tipo_titular').val() : tb;
	$('#BtnExport').prop('href', `resources/libraries/Excel/${ruta}?periodo=${periodo}&tipo_benef=${tipo_benef}`);
}
$(function() {
	$(document).on('submit', '#frm-login', function(event) {
		event.preventDefault();
		DataFrmLogin = $('#frm-login').serializeArray();
		$.ajax({
			method: 'POST',
			url: 'App/controllers/controller.php',
			data: DataFrmLogin
		}).done(function(resultado) {
			if (resultado === 'INICIO') {
				window.location.assign('index.php');
			} else {
				Swal.fire('Error de inicio', resultado, 'error');
				$('#pass').val('');
			}
		});
	});
});
function logout() {
	$.ajax({
		method: 'POST',
		url: 'App/controllers/controller.php',
		data: { accion: 'LOGOUT' }
	}).done(function(html) {
		window.location.assign('login.html');
	});
}
function CambiarPass() {
	clave1 = $('#Clave1').val();
	clave2 = $('#Clave2').val();
	if (clave1 === '' || clave2 === '') {
		Swal.fire('Ingrese todos los campos', '', 'error');
	} else {
		if (clave1 !== clave2) {
			Swal.fire('Las contraseñas no coinciden', 'escriba la misma contraseña', 'error');
		} else {
			form = $('#FrmCambioClave').serializeArray();
			$.ajax({
				method: 'POST',
				url: 'App/controllers/controller.php',
				data: form
			}).done(function(resultado) {
				if (resultado === 'SE MODIFICÓ CONTRASEÑA') {
					Swal.fire(resultado, '', 'success');
					$('.modal').css('display', 'none');
					document.getElementById('FrmCambioClave').reset();
				} else {
					Swal.fire('Ocurrió un Error', '', 'error');
				}
			});
		}
	}
}
$(function() {
	$(document).on('keyup', '#FiltrarUser', function(event) {
		ListarUsuario();
	});
});
function ListarUsuario() {
	let filtroUser = $('#FiltrarUser').val();
	$.ajax({
		method: 'POST',
		url: 'App/controllers/controller.php',
		data: { accion: 'LISTAR_USUARIOS', filtro: filtroUser }
	}).done(function(html) {
		$('#tbusuarios').html(html);
	});
}
function cargarRegiones() {
	$.ajax({
		method: 'POST',
		url: 'App/controllers/controller.php',
		data: { accion: 'LISTAR_REGIONES' }
	}).done(function(html) {
		$('#RegionUsuario').html(html);
	});
}
function BuscarPersona() {
	dni = $('#dniUsuario').val();
	$.ajax({
		method: 'POST',
		url: 'App/controllers/controller.php',
		data: {
			accion: 'CONSULTA_DNI',
			dni: dni
		}
	}).done(function(resultado) {
		json = JSON.parse(resultado);
		if (json['success'] === true) {
			$('#nombreUsuario').val(json['data'].nombre_completo);
		}
	});
}
function RegistrarUsuario() {
	form = $('#frmUsuario').serializeArray();
	$.ajax({
		method: 'POST',
		url: 'App/controllers/controller.php',
		data: form
	}).done(function(resultado) {
		Swal.fire(resultado, 'Se registró correctamente al usuario', 'success');
		ListarUsuario();
		cerrarmodal();
	});
}
$(function() {
	$(document).on('click', '.btnCambiarEstado', function(event) {
		var parent = $(this).closest('table');
		var tr = $(this).closest('tr');
		usuario = $(tr).find('td').eq(0).html();
		estado = $(tr).find('td').eq(5).html();
		estado === 'A' ? (estado = 'I') : (estado = 'A');
		Swal.fire({
			title: 'Activar/Desactivar Usuario',
			text: 'Desea cambiar de estado a Usuario?',
			showCancelButton: true,
			confirmButtonColor: '#6777ef',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Anular',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				CambiarEstado(usuario, estado);
			}
		});
	});
});
function CambiarEstado(usuario, estado) {
	$.ajax({
		method: 'POST',
		url: 'App/controllers/controller.php',
		data: { accion: 'CAMBIAR_ESTADO', usuario: usuario, estado: estado }
	}).done(function(resultado) {
		Swal.fire(resultado, 'Se actualizó información', 'success');
		ListarUsuario();
	});
}
$(function() {
	$(document).on('change', '#tipo_benef', function(event) {
		let tipo_benef = $('#tipo_benef').val();
		let select_toggle = tipo_benef == 'T' ? 'block' : 'none';
		$('#tipo_titular').css('display', select_toggle);
	});
});
$(function() {
	$(document).on('click', '.menu', function(event) {
		accionNav();
	});
});
$(function() {
	$(document).on('click', '#lnk-listado', function(event) {
		abrir_seccion('listado.php');
		remove_addClass('#lnk-listado');
		accionNav();
	});
});
const accionNav = () => {
	let element = document.querySelector('.nav');
	element.classList.toggle('active');
};
