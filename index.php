<?php
session_start();
if (empty($_SESSION['active'])) {
  header('location: login.html');
}
require_once 'App/models/ClsPrueba.php';

$objPruebas = new ClsPruebas();
$tipouser = $_SESSION['tipouser'];
if ($tipouser === 'RESPONSABLE') $ListadoIpress = $objPruebas->IpressPorRegion($_SESSION['region']);
else
  $ListadoIpress = $objPruebas->ListarIpress();

$Ipress = [];
while ($row = $ListadoIpress->fetch(PDO::FETCH_NAMED)) {
  $nombre = $row['ipress'];
  array_push($Ipress, $nombre);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="resources/js/jquery-ui-1.13.2/jquery-ui.min.css" />
  <link rel="stylesheet" href="resources/js/sweetalert2.min.css">
  <link rel="stylesheet" href="resources/css/styles.css">
  <link rel="stylesheet" href="resources/css/styles-responsive.css">
  <script src="https://kit.fontawesome.com/47b4aaa3bf.js" crossorigin="anonymous"></script>
  <title>App Epidemiología</title>
</head>

<body>
  <div class="wrapper">
    <div class="header">
      <div class="name">
        <img src="resources/img/dirsapol.png" alt="">
        <h2>UNIINSAN | Epidemiología</h2>
        <i class="fa-solid fa-bars menu"></i>
      </div>
      <div class="nav">
        <ul>
          <li><a id="lnk-listado" class="active" href="javascript:void(0)">Covid</a></li>
          <li><a id="lnk-listadoM" href="javascript:void(0)" onclick="abrirListadoMono()">V. mono</a></li>
          <? if ($tipouser === 'ADMINISTRADOR') { ?>
            <li class="li-toggle" id="li-report"> <a>Reportes <i class="fa-solid fa-caret-down"></i></a>
              <ul class="ul-toggle" id="ul-report">
                <div class="triangulo"></div>
                <li><a id="lnk-reporteC" href="javascript:void(0)" onclick="abrirReporteC()"><i class="fa-solid fa-chart-pie"></i> Rep. Covid</a></li>
                <li class="linea"></li>
                <li><a id="lnk-reporteM" href="javascript:void(0)" onclick="abrirReporteM()"><i class="fa-solid fa-magnifying-glass-chart"></i> Rep. Mono</a></li>
              </ul>
            </li>
            <li><a id="lnk-usuarios" href="javascript:void(0)" onclick="abrirUsuarios()">Usuarios</a></li>
          <? } ?>
          <li class="li-toggle" id="li-settings"><a>
              <div class="datouser"><?php echo $_SESSION['iduser']; ?></div>
            </a>
            <ul class="ul-toggle" id="ul-settings">
              <div class="triangulo"></div>
              <li>
                <p class="info_user"><?php echo $_SESSION['nombre'] . '<br>'; ?>
                  <span><?php
                        $nombre = $tipouser !== 'ADMINISTRADOR' ? $_SESSION['n_region'] : $tipouser;
                        echo $nombre;
                        ?><span>
                </p>
              </li>
              <li class="linea"></li>
              <li id="btn-clave"><a href="javascript:void(0)"><i class="fa-solid fa-key"></i> Camb. Contraseña</a></li>
              <li class="linea"></li>
              <li><a id="btn-logout" href="javascript:void(0)" onclick="logout()"><i class="fa-solid fa-power-off"></i> Salir</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <div class="section" id="section">
      <!-- Ajax -->
    </div>
  </div>
  <div id="modal" class="modal">
    <div class="modal-dialog">
      <a href="#" class="close-modal-area"></a>
      <div class="modal-content">
        <header>
          <h5 id="TittleForm">Nuevo Registro</h5>
          <a href="javascript:void(0)" class="closebtn">×</a>
        </header>
        <div class="body-modal">
          <form id="FrmPrueba">
            <input type="hidden" name="accion" id="AccionReporte">
            <input type="hidden" name="IdReporte" id="IdReporte">
            <input type="hidden" name="tvirus" id="tvirus">
            <div class="cont-input-form">
              <input type="date" name="Fecha" id="Fecha">
            </div>
            <div class=" cont-input-form">
              <input type="hidden" name="IdIpress" id="IdIpress">
              <input type="text" name="Ipress" id="Ipress" placeholder="Ingresar Ipress">
            </div>
            <div class="cont-input-form">
              <p class="p-subtittle">Titulares</p>
              <div class="cont-input-form">
                <p class="tittle-prueba">PCR</p>
              </div>
              <div class="cont-input-form input-ant">
                <p class="tittle-prueba">ANT</p>
              </div>
              <div class="cont-input-form input-ser">
                <p class="tittle-prueba">SER</p>
              </div>
            </div>
            <div class="cont-input-form">
              <p>Actividad:</p>
              <div class="cont-input-form">
                <input type="text" class="number-prueba" name="pcr_ta" id="pcr_ta" placeholder="PCR" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
                <input type="text" class="number-prueba input-ant" name="ant_ta" id="ant_ta" placeholder="ANT" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
                <input type="text" class="number-prueba input-ser" name="ser_ta" id="ser_ta" placeholder="SER" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
              </div>
            </div>
            <div class="cont-input-form">
              <p>Dsiponib.:</p>
              <div class="cont-input-form">
                <input type="text" class="number-prueba" name="pcr_td" id="pcr_td" placeholder="PCR" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
                <input type="text" class="number-prueba input-ant" name="ant_td" id="ant_td" placeholder="ANT" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
                <input type="text" class="number-prueba input-ser" name="ser_td" id="ser_td" placeholder="SER" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
              </div>
            </div>
            <div class="cont-input-form">
              <p>Retiro:</p>
              <div class="cont-input-form">
                <input type="text" class="number-prueba" name="pcr_tr" id="pcr_tr" placeholder="PCR" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
                <input type="text" class="number-prueba input-ant" name="ant_tr" id="ant_tr" placeholder="ANT" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
                <input type="text" class="number-prueba input-ser" name="ser_tr" id="ser_tr" placeholder="SER" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
              </div>
            </div>
            <div class="cont-input-form">
              <p class="p-subtittle">Familiares</p>
              <div class="cont-input-form">
              </div>
            </div>
            <div class="cont-input-form">
              <p class="p-subtittle"></p>
              <div class="cont-input-form">
                <input type="text" class="number-prueba" name="pcr_f" id="pcr_f" placeholder="PCR" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
                <input type="text" class="number-prueba input-ant" name="ant_f" id="ant_f" placeholder="ANT" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
                <input type="text" class="number-prueba input-ser" name="ser_f" id="ser_f" placeholder="SER" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" autocomplete="off">
              </div>
            </div>
            <div class="cont-input-form">
              <input type="text" name="Comentario" id="Comentario" placeholder="Comentario...">
            </div>
            <button type="button" class="btnform" id="btn-registrar" onclick="RegistrarReporte()">Registrar</button>
          </form>

        </div>

      </div>
    </div>
  </div>
  <div id="modal2" class="modal">
    <div class="modal-dialog">
      <a href="#" class="close-modal-area"></a>
      <div class="modal-content">
        <header>
          <h5 id="TittleForm">Cambio de Contraseña</h5>
          <a href="javascript:void(0)" class="closebtn">×</a>
        </header>
        <div class="body-modal">
          <form id="FrmCambioClave">
            <input type="hidden" name="accion" id="AccionClave" value="CAMBIAR_PASS">
            <div class="cont-input-form">
              <input type="password" name="Clave1" id="Clave1" placeholder="Ingresar Contraseña">
            </div>
            <div class="cont-input-form">
              <input type="password" name="Clave2" id="Clave2" placeholder="Repetir Contraseña">
            </div>
            <button type="button" class="btnform" onclick="CambiarPass()">Cambiar Contraseña</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="modalUsuario" class="modal">
    <div class="modal-dialog">
      <a href="#" class="close-modal-area"></a>
      <div class="modal-content">
        <header>
          <h5 id="TittleForm">Agregar usuario</h5>
          <a href="javascript:void(0)" class="closebtn">×</a>
        </header>
        <div class="body-modal">
          <form id="frmUsuario">
            <input type="hidden" name="accion" id="accionUsuario" value="">
            <div class="cont-input-form cont-input-search">
              <input type="text" name="dniUsuario" id="dniUsuario" placeholder="DNI DE USUARIO">
              <button type="button" id="btnbuscarPersona" onclick="BuscarPersona()"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="cont-input-form">
              <input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de Usuario" readonly>
            </div>
            <div class="cont-input-form">
              <select name="RegionUsuario" id="RegionUsuario">
                <option value="0">Seleccione Región</option>
              </select>
            </div>
            <div class="cont-input-form">
              <select name="TipoUsuario" id="TipoUsuario">
                <option value="RESPONSABLE">RESPONSABLE DE MACRO</option>
                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
              </select>
            </div>
            <div class="cont-check">
              <input type="checkbox" name="cbxreset" id="cbxreset"> <label for="cbxreset">Resetear Contraseña</label>
            </div>
            <div class="cont-input-form">
              <input type="password" name="passUsuario" id="passUsuario" placeholder="Contraseña">
            </div>
            <button type="button" class="btnform" onclick="RegistrarUsuario()">Registrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="resources/js/sweetalert2.all.min.js"></script>
  <script language="javascript" src="resources/js/jquery-3.6.1.min.js"></script>
  <script language="javascript" src="resources/js/jquery-ui-1.13.2/jquery-ui.min.js"></script>
  <script language="javascript" src="resources/js/function.js"></script>
  <script src="resources/js/main.js"></script>
  <script>
    $(document).ready(function() {
      abrirListado()
      let ListaIpress = <?= json_encode($Ipress); ?>;
      $("#Ipress").autocomplete({
        source: ListaIpress,
        select: function(event, item) {
          FiltroIpress = item.item.value;
          $.ajax({
            method: "POST",
            url: "App/controllers/controller.php",
            data: {
              accion: "BUSCAR_IPRESS",
              filtro: FiltroIpress,
            },
          }).done(function(resultado) {
            json = JSON.parse(resultado);
            Ipress = json.ipress;
            console.log(Ipress);
            $("#IdIpress").val(Ipress.codigoipress);
          });
        },
      });
      CargarFechaActual('Fecha')
    });
  </script>
</body>
<script>
  Fecha.max = new Date().toISOString().split('T')[0];
</script>

</html>