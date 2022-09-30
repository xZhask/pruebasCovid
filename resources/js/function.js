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
$('.closebtn').click(function() {
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
	$(document).on('click', '#BtnAddPruebaC', function() {
		abrirFormPrueba('C');
	});
});
$(function() {
	$(document).on('click', '#BtnAddPruebaM', function() {
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
	$(document).on('click', '#btn-clave', function() {
		accionNav();
		$('#modal2').css('display', 'table');
		$('#modal2').css('position', 'absolute');
	});
});
$(function() {
	$(document).on('click', '#BtnAddUsuario', function() {
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
	$(document).on('click', '.edit-user', function() {
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

		let tr = $(this).closest('tr');
		let usuario = $(tr).find('td').eq(0).html();
		let nombre = $(tr).find('td').eq(1).html();
		let tipousuario = $(tr).find('td').eq(3).html();
		let idregion = $(tr).find('td').eq(4).html();

		$('#dniUsuario').val(usuario);
		$('#nombreUsuario').val(nombre);
		$('#TipoUsuario').val(tipousuario);
		$('#RegionUsuario').val(idregion);
	});
});
$(function() {
	$(document).on('change', '#cbxreset', function(e) {
		$('#passUsuario').val('');
		if (e.target.checked) {
			$('#passUsuario').prop('readonly', false);
			$('#passUsuario').removeClass('input-readonly');
		} else {
			$('#passUsuario').prop('readonly', 'true');
			$('#passUsuario').addClass('input-readonly');
		}
	});
});

$(function() {
	$(document).on('click', '#tb-listadoC .btn-edit', function(e) {
		e.preventDefault();
		let tr = $(this).closest('tr');
		let idreporte = $(tr).find('td').eq(0).html();
		abrirEditarReporte(idreporte, 'C');
	});
});
$(function() {
	$(document).on('click', '#tb-listadoM .btn-edit', function(e) {
		e.preventDefault();
		let tr = $(this).closest('tr');
		let idreporte = $(tr).find('td').eq(0).html();
		abrirEditarReporte(idreporte, 'M');
	});
});

const abrirEditarReporte = (idreporte, tvirus) => {
	let data = { accion: 'BUSCAR_REPORTE', idreporte: idreporte };
	let RespuestaAjax = ajaxFunction(data);

	let json = JSON.parse(RespuestaAjax);
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
	$('#modal').css('display', 'table');
	$('#modal').css('position', 'absolute');
};
/* -------------------------------------------------- */
const ajaxFunction = (data) => {
	let respuesta;
	$.ajax({
		type: 'POST',
		url: 'App/controllers/controller.php',
		data: data,
		async: false,
		//dataType: 'JSON',
		error: function() {
			alert('Error occured');
		},
		success: function(response) {
			respuesta = response;
		}
	});
	return respuesta;
};
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
	let data = { accion: 'LISTAR_REGISTROS_HOY', fecha: fecha, tvirus: tvirus };
	let RespuestaAjax = ajaxFunction(data);
	$(tabla).html(RespuestaAjax);
};
function RegistrarReporte() {
	let virus = $('#tvirus').val();
	let tabla = `#tb-listado${virus}`;
	let fecha = $(`#FechaFiltro${virus}`).val();
	let ipress = $('#IdIpress').val();
	if (ipress === '') Swal.fire('No ha seleccionado una Ipress', 'Ingrese IPRESS', 'warning');
	else {
		let formulario = $('#FrmPrueba').serializeArray();
		$('#btn-registrar').prop('disabled', true);
		$('#btn-registrar').addClass('btn-disabled');
		let RespuestaAjax = ajaxFunction(formulario);
		if (RespuestaAjax === 'REGISTRADO' || RespuestaAjax === 'ACTUALIZADO') {
			Swal.fire(`Se ha ${RespuestaAjax} Correctamente`, '', 'success');
			cerrarmodal();
			CargarListadoHoy(fecha, virus, tabla);
		} else Swal.fire('No se Registró', RespuestaAjax, 'error');

		$('#btn-registrar').prop('disabled', false);
		$('#btn-registrar').removeClass('btn-disabled');
	}
}

$(function() {
	$(document).on('click', '#tb-listadoC .btn-delete', function(e) {
		let tabla = `#tb-listadoC`;
		let fecha = $(`#FechaFiltroC`).val();
		e.preventDefault();
		let tr = $(this).closest('tr');
		let idreporte = $(tr).find('td').eq(0).html();
		eliminarRegistro(idreporte, fecha, 'C', tabla);
	});
});
$(function() {
	$(document).on('click', '#tb-listadoM .btn-delete', function(e) {
		let tabla = `#tb-listadoM`;
		let fecha = $(`#FechaFiltroM`).val();
		e.preventDefault();
		let tr = $(this).closest('tr');
		let idreporte = $(tr).find('td').eq(0).html();
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
			let data = { accion: 'ELIMINAR_REGISTRO', idreporte: idreporte };
			let RespuestaAjax = ajaxFunction(data);
			if (RespuestaAjax === 'ELIMINADO') {
				Swal.fire(RespuestaAjax, 'Se ha eliminado el registro', 'success');
				CargarListadoHoy(fecha, virus, tabla);
			}
		}
	});
};
function Limpiar() {
	FrmPrueba.reset();
	frmUsuario.reset();
}
$(function() {
	$(document).on('click', '#BtnBuscarRepC', function() {
		GenerarReporte('C');
	});
});
$(function() {
	$(document).on('click', '#BtnBuscarRepM', function() {
		GenerarReporte('M');
	});
});
const GenerarReporte = (tvirus) => {
	let accion = tvirus === 'C' ? 'GENERAR_REPORTE_COVID' : 'GENERAR_REPORTE_VMONO';
	let tb = $('#tipo_benef').val();
	let tipo_benef = '';
	tipo_benef = tb === 'T' ? $('#tipo_titular').val() : tb;
	let periodo = $('#periodo').val();
	$('#t-report').html('<tr><td>Cargando...</td></tr>');
	let data = { accion: accion, periodo: periodo, tipo_benef: tipo_benef };
	let RespuestaAjax = ajaxFunction(data);
	$('#t-report').html(RespuestaAjax);
	CargarBtnExport(tvirus);
};
function CargarBtnExport(tvirus) {
	let ruta = tvirus === 'C' ? 'ReportePruebasCovid.php' : 'ReportePruebasMono.php';
	let tb = $('#tipo_benef').val();
	periodo = $('#periodo').val();
	tipo_benef = tb === 'T' ? $('#tipo_titular').val() : tb;
	$('#BtnExport').prop('href', `resources/libraries/Excel/${ruta}?periodo=${periodo}&tipo_benef=${tipo_benef}`);
}
$(function() {
	$(document).on('submit', '#frm-login', function(e) {
		e.preventDefault();
		let DataFrmLogin = $('#frm-login').serializeArray();
		let RespuestaAjax = ajaxFunction(DataFrmLogin);
		if (RespuestaAjax === 'INICIO') window.location.assign('index.php');
		else {
			Swal.fire('Error de inicio', RespuestaAjax, 'error');
			$('#pass').val('');
		}
	});
});
function logout() {
	let RespuestaAjax = ajaxFunction({ accion: 'LOGOUT' });
	window.location.assign('login.html');
}
const CambiarPass = () => {
	let clave1 = $('#Clave1').val();
	let clave2 = $('#Clave2').val();
	if (clave1 === '' || clave2 === '') Swal.fire('Ingrese todos los campos', '', 'error');
	else {
		if (clave1 !== clave2) Swal.fire('Las contraseñas no coinciden', 'escriba la misma contraseña', 'error');
		else {
			let form = $('#FrmCambioClave').serializeArray();
			let RespuestaAjax = ajaxFunction(form);
			if (RespuestaAjax === 'SE MODIFICÓ CONTRASEÑA') {
				Swal.fire(RespuestaAjax, '', 'success');
				$('.modal').css('display', 'none');
				document.getElementById('FrmCambioClave').reset();
			} else Swal.fire('Ocurrió un Error', '', 'error');
		}
	}
};
$(function() {
	$(document).on('keyup', '#FiltrarUser', function() {
		ListarUsuario();
	});
});
const ListarUsuario = () => {
	let filtroUser = $('#FiltrarUser').val();
	let data = { accion: 'LISTAR_USUARIOS', filtro: filtroUser };
	let RespuestaAjax = ajaxFunction(data);
	$('#tbusuarios').html(RespuestaAjax);
};
const cargarRegiones = () => {
	let RespuestaAjax = ajaxFunction({ accion: 'LISTAR_REGIONES' });
	$('#RegionUsuario').html(RespuestaAjax);
};
const BuscarPersona = () => {
	let dni = $('#dniUsuario').val();
	let data = { accion: 'CONSULTA_DNI', dni: dni };
	let RespuestaAjax = ajaxFunction(data);
	json = JSON.parse(RespuestaAjax);
	if (json['success'] === true) $('#nombreUsuario').val(json['data'].nombre_completo);
};
const RegistrarUsuario = () => {
	let form = $('#frmUsuario').serializeArray();
	let RespuestaAjax = ajaxFunction(form);
	Swal.fire(RespuestaAjax, 'Se registró correctamente al usuario', 'success');
	ListarUsuario();
	cerrarmodal();
};
$(function() {
	$(document).on('click', '.btnCambiarEstado', function() {
		let tr = $(this).closest('tr');
		let usuario = $(tr).find('td').eq(0).html();
		let estado = $(tr).find('td').eq(5).html();
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
			if (result.isConfirmed) CambiarEstado(usuario, estado);
		});
	});
});
const CambiarEstado = (usuario, estado) => {
	let data = { accion: 'CAMBIAR_ESTADO', usuario: usuario, estado: estado };
	let RespuestaAjax = ajaxFunction(data);
	Swal.fire(RespuestaAjax, 'Se actualizó información', 'success');
	ListarUsuario();
};
$(function() {
	$(document).on('change', '#tipo_benef', function() {
		let tipo_benef = $('#tipo_benef').val();
		let select_toggle = tipo_benef == 'T' ? 'block' : 'none';
		$('#tipo_titular').css('display', select_toggle);
	});
});
$(function() {
	$(document).on('click', '.menu', function() {
		accionNav();
	});
});
$(function() {
	$(document).on('click', '#lnk-listado', function() {
		abrir_seccion('listado.php');
		remove_addClass('#lnk-listado');
		accionNav();
	});
});
const accionNav = () => {
	let element = document.querySelector('.nav');
	element.classList.toggle('active');
};
