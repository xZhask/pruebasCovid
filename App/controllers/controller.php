<?php
require_once '../models/ClsPrueba.php';
require_once '../models/ClsUsuario.php';

$accion = $_POST['accion'];
controlador($accion);

function controlador($accion)
{
    $objPruebas = new ClsPruebas();
    $objUsuario = new ClsUsuario();

    switch ($accion) {
        case 'BUSCAR_IPRESS':
            $Ipress = $objPruebas->BuscarIPress_Nombre($_POST['filtro']);
            if ($Ipress->rowCount() > 0) {
                $Ipress = $Ipress->fetch(PDO::FETCH_NAMED);
                $Ipress = ['ipress' => $Ipress];
                echo json_encode($Ipress);
            }
            break;

        case 'LISTAR_REGISTROS_HOY':
            $fecha = $_POST['fecha'];
            $t_virus = $_POST['tvirus'];
            session_start();
            if ($_SESSION['tipouser'] === 'ADMINISTRADOR') {
                $Listado = $objPruebas->ListarIpressRegistrosHoy($fecha, $t_virus);
            } else {
                $Listado = $objPruebas->ListarIpressxMacroRegistrosHoy($fecha, $_SESSION['region'], $t_virus);
            }

            $table = '';
            if ($Listado->rowCount() > 0) {
                $suma_pcr = 0;
                $suma_ant = 0;
                $suma_ser = 0;
                while ($fila = $Listado->fetch(PDO::FETCH_NAMED)) {
                    $IDreporte = $fila['idreporte'];
                    $fecha = $fila['fecharegistro'];
                    $hora = date("d-m-Y h:i:s", strtotime($fecha));
                    $table .= '<tr>';
                    $table .= '<td rowspan="2" class="nvisible">' . $IDreporte . '</td>';
                    $table .= '<td rowspan="2" class="nvisible">' . $fila['codigoipress'] . '</td>';
                    $table .= '<td rowspan="2" class="text-left"><h3>' . $fila['ipress'] . '</h3><p>' . $fila['nombre'] . '</p><p>' . $hora . '</p></td>';
                    $table .= '<td>Titulares</td>';
                    $detalle = [];

                    $CantidadPruebasT = $objPruebas->CantidadPorPrueba($IDreporte, 'T');
                    if ($CantidadPruebasT->rowCount() > 0) {
                        $CantidadPruebasT = $CantidadPruebasT->fetch(PDO::FETCH_NAMED);
                        $ArrTitulares = [$CantidadPruebasT['c_pcr'], $CantidadPruebasT['c_ant'], $CantidadPruebasT['c_ser']];
                        $Total_T = $CantidadPruebasT['c_pcr'] + $CantidadPruebasT['c_ant'] + $CantidadPruebasT['c_ser'];
                    }

                    $tipo_benef = ['TA', 'TD', 'TR'];
                    $tit_pcr = 0;
                    $tit_ant = 0;
                    $tit_ser = 0;
                    for ($i = 0; $i <= 2; $i++) {
                        $CantidadPruebasT = $objPruebas->CantidadPorPrueba($IDreporte, $tipo_benef[$i]);
                        if ($CantidadPruebasT->rowCount() > 0) {
                            $CantidadPruebasT = $CantidadPruebasT->fetch(PDO::FETCH_NAMED);

                            $tit_pcr += $CantidadPruebasT['c_pcr'];
                            $tit_ant += $CantidadPruebasT['c_ant'];
                            $tit_ser += $CantidadPruebasT['c_ser'];
                        }
                    }
                    $ArrTitulares = [$tit_pcr, $tit_ant, $tit_ser];
                    $Total_T = $tit_pcr + $tit_ant + $tit_ser;

                    $fam_pcr = 0;
                    $fam_ant = 0;
                    $fam_ser = 0;
                    $CantidadPruebasF = $objPruebas->CantidadPorPrueba($IDreporte, 'F');
                    if ($CantidadPruebasF->rowCount() > 0) {
                        $CantidadPruebasF = $CantidadPruebasF->fetch(PDO::FETCH_NAMED);
                        $fam_pcr = $CantidadPruebasF['c_pcr'];
                        $fam_ant = $CantidadPruebasF['c_ant'];
                        $fam_ser = $CantidadPruebasF['c_ser'];
                    }
                    $ArrFamiliares = [$fam_pcr, $fam_ant, $fam_ser];
                    $Total_F = $fam_pcr + $fam_ant + $fam_ser;

                    array_push($detalle, ['T' => $ArrTitulares, 'F' => $ArrFamiliares]);

                    $table .= '<td>' . $detalle[0]['T'][0] . '</td>';
                    if ($t_virus === 'C') {
                        $table .= '<td>' . $detalle[0]['T'][1] . '</td>';
                        $table .= '<td>' . $detalle[0]['T'][2] . '</td>';
                        $table .= '<td>' . $Total_T . '</td>';
                    }
                    $table .= '<td rowspan="2" class="nvisible">' . $fila['comentario'] . '</td>';
                    if ($_SESSION['tipouser'] === 'ADMINISTRADOR') {
                        $table .= '<td rowspan="2"><i class="fa-solid fa-pencil asphalt btn-edit"></i></td>';
                        $table .= '<td rowspan="2"><i class="fa-regular fa-circle-xmark red btn-delete"></i></td>';
                    }
                    $table .= '</tr>';
                    $table .= '<tr>';
                    $table .= '<td>Familiares</td>';
                    $table .= '<td>' . $detalle[0]['F'][0] . '</td>';
                    if ($t_virus === 'C') {
                        $table .= '<td>' . $detalle[0]['F'][1] . '</td>';
                        $table .= '<td>' . $detalle[0]['F'][2] . '</td>';

                        $table .= '<td>' . $Total_F . '</td>';
                    }
                    $table .= '</tr>';
                    $suma_pcr += intval($detalle[0]['F'][0] + $detalle[0]['T'][0]);
                    $suma_ant += $detalle[0]['F'][1] + $detalle[0]['T'][1];
                    $suma_ser += $detalle[0]['F'][2] + $detalle[0]['T'][2];
                }
                if ($_SESSION['tipouser'] === 'ADMINISTRADOR') {
                    $table .= '<tr class="fila-totales"><td colspan="2">Total:</td>';
                    $table .= '<td>' . $suma_pcr . '</td>';
                    if ($t_virus === 'C') {
                        $table .= '<td>' . $suma_ant . '</td>';
                        $table .= '<td>' . $suma_ser . '</td>';

                        $table .= '<td>' . intval($suma_pcr + $suma_ant + $suma_ser) . '</td>';
                    }
                    $table .= '<td></td><td></td>';
                    $table .= '</tr>';
                }
            }
            echo $table;
            break;
        case 'REGISTRAR_REPORTE':
            $Fecha = $_POST['Fecha'];
            $Ipress = $_POST['IdIpress'];
            $fechaActual = date('Y/m/d H:i:s');
            $tipo_virus = $_POST['tvirus'];

            session_start();
            $RegistroExistente = $objPruebas->BuscarRegistradoHoy($Fecha, $Ipress, $tipo_virus);
            if ($RegistroExistente->rowCount() > 0) {
                echo 'YA SE HA INGRESADO REGISTRO PARA LA IPRESS EN LA FECHA SELECCIONADA';
            } else {
                $DatosReporte = [
                    'codigoipress' => $Ipress,
                    'fecha' => $Fecha,
                    'comentario' => $_POST['Comentario'],
                    'idusuario' => $_SESSION['iduser'],
                    'fecharegistro' => $fechaActual,
                    'virus' => $tipo_virus
                ];
                $idregistro = $objPruebas->RegistrarReporte($DatosReporte);
                //DETALLE
                if ($idregistro !== '0') {
                    $t_beneficiarios = ['ta', 'td', 'tr', 'f'];
                    for ($i = 0; $i <= 3; $i++) {
                        $pcr = $_POST['pcr_' . $t_beneficiarios[$i]];
                        $ant = $_POST['ant_' . $t_beneficiarios[$i]];
                        $ser = $_POST['ser_' . $t_beneficiarios[$i]];

                        if (empty($pcr)) $pcr = 0;
                        if (empty($ant)) $ant = 0;
                        if (empty($ser)) $ser = 0;

                        if ((!empty($pcr) && $pcr > 0) || (!empty($ant) && $ant > 0) || (!empty($ser) && $ser > 0)) {
                            $DatosDetalle = [
                                'idreporte' => $idregistro,
                                'tipo_beneficiario' => strtoupper($t_beneficiarios[$i]),
                                'c_pcr' => $pcr,
                                'c_ant' => $ant,
                                'c_ser' => $ser,
                            ];
                            $objPruebas->RegistrarDetallePruebas($DatosDetalle);
                        }
                    }
                    echo 'REGISTRADO';
                } else {
                    echo 'OCURRIÓ UN INCONVENIENTE, INTENTE DENUEVO';
                }
            }
            break;
        case 'GENERAR_REPORTE_COVID':
            $tvirus = 'C';
            $periodo = $_POST['periodo'];
            $tipo_benef = $_POST['tipo_benef'];
            $fecha = $periodo . '-01';
            $mes = date('n', strtotime($fecha));
            $Arr_regiones = [];

            $ListadoRegiones = $objPruebas->ListarRegiones();
            $Regiones = $ListadoRegiones->fetchAll(PDO::FETCH_OBJ);

            foreach ($Regiones as $Region) {
                $Arr_Unidades = [];
                $idregion = $Region->idregion;
                $ListadoUnidades = $objPruebas->IpressPorRegion($idregion);
                $Unidades = $ListadoUnidades->fetchAll(PDO::FETCH_OBJ);

                foreach ($Unidades as $Unidad) {
                    $Arr_Reportes = [];
                    $Arr_Reporte = [];
                    $ArrReporteDiario = [];
                    $ArrPruebas = [];
                    $idipress = $Unidad->codigoipress;
                    $ListadoReportes = $objPruebas->ReportesxMes($mes, $idipress, $tvirus);
                    $Reportes = $ListadoReportes->fetchAll(PDO::FETCH_OBJ);

                    foreach ($Reportes as $Reporte) {
                        $idreporte = $Reporte->idreporte;
                        array_push($Arr_Reportes, $Reporte->dia);
                        // PRUEBAS
                        if ($tipo_benef === 'G') $ListadoDetalleReporte = $objPruebas->DetallePruebasxReporteGeneral($idreporte);
                        else if ($tipo_benef === 'T') $ListadoDetalleReporte = $objPruebas->DetallePruebasxReporteTitulares($idreporte);
                        else $ListadoDetalleReporte = $objPruebas->DetallePruebasxReporte($idreporte, $tipo_benef);

                        //DETALLEPRUEBAS
                        $prueba_pcr = 0;
                        $prueba_ant = 0;
                        $prueba_ser = 0;
                        if ($ListadoDetalleReporte->rowCount() > 0) {
                            $Pruebas = $ListadoDetalleReporte->fetch(PDO::FETCH_NAMED);
                            $prueba_pcr = $Pruebas['c_pcr'];
                            $prueba_ant = $Pruebas['c_ant'];
                            $prueba_ser = $Pruebas['c_ser'];
                        }
                        $Arr_Reporte = ['pcr' => $prueba_pcr, 'ant' => $prueba_ant, 'ser' => $prueba_ser];
                        array_push($ArrPruebas, $Arr_Reporte);
                    }
                    $ArrReporteDiario = array_combine($Arr_Reportes, $ArrPruebas);
                    array_push($Arr_Unidades, ['unidad' => $Unidad->ipress, 'reporte' => $ArrReporteDiario]);
                }
                array_push($Arr_regiones, ['region' => $Region->region, 'unidades' => $Arr_Unidades]);
            }

            /* ----------- CREACIÓN DE TABLA --------- */


            $DiasMes = date('t', strtotime($fecha));
            /* THEAD - CABECERA DE TABLA */
            $tabla = '<table>';
            $tabla .= '<thead><tr><th class="wheadmax" colspan="3">IPRESS</th>';
            for ($i = 1; $i <= $DiasMes; $i++) {
                $tabla .= '<th class="td-num">' . $i . '</th>';
            }
            $tabla .= '<th>Total</th></tr>';
            $tabla .= '</thead>';
            /* TBODY - CAUERPO DE TABLA */
            $tabla .= '<tbody>';
            $contador = 0;
            foreach ($Arr_regiones as $Region) {
                $ColorFila = ($contador % 2 !== 0) ? 'fila_color' : '';
                $cant_unidades = count($Region['unidades']);
                $tabla .= '<tr>';
                $tabla .= '<td class="border-bold ' . $ColorFila . '" rowspan=' . intval(($cant_unidades * 3) + 1) . '>' . $Region['region'] . '</td></tr>';

                foreach ($Region['unidades'] as $Unidades) {
                    $Arr_PCR = [];
                    $Arr_SER = [];
                    $Arr_ANT = [];

                    for ($i = 1; $i <= $DiasMes; $i++) {
                        if (!isset($Unidades['reporte'][$i])) {
                            $pcr = '-';
                            $ant = '-';
                            $ser = '-';
                        } else {
                            $pcr = $Unidades['reporte'][$i]['pcr'];
                            $ant = $Unidades['reporte'][$i]['ant'];
                            $ser = $Unidades['reporte'][$i]['ser'];
                            if (empty($pcr)) $pcr = 0;
                            if (empty($ant)) $ant = 0;
                            if (empty($ser)) $ser = 0;
                        }
                        array_push($Arr_PCR, $pcr);
                        array_push($Arr_ANT, $ant);
                        array_push($Arr_SER, $ser);
                    }

                    $tabla .= '<tr><td rowspan="3" class="border-bold text-left w-medium td-ipress ' . $ColorFila . '">' . $Unidades['unidad'] . '</td>';
                    $tabla .= '<td class="pcr">PCR</td>';
                    $total_fila_pcr = 0;
                    $total_fila_ant = 0;
                    $total_fila_ser = 0;
                    foreach ($Arr_PCR as $prueba) {
                        $tabla .= '<td class="pcr">' . $prueba . '</td>';
                        $suma = ($prueba !== '-') ? ($total_fila_pcr += $prueba) : '-';
                    }
                    $tabla .= '<td class="pcr">' . $total_fila_pcr . '</td>';
                    $tabla .= '</tr>';
                    $tabla .= '<tr><td class="ant">ANT</td>';
                    foreach ($Arr_ANT as $prueba) {
                        $tabla .= '<td class="ant">' . $prueba . '</td>';
                        $suma = ($prueba !== '-') ? ($total_fila_ant += $prueba) : '-';
                    }
                    $tabla .= '<td class="ant">' . $total_fila_ant . '</td>';
                    $tabla .= '</tr>';
                    $tabla .= '<tr><td class="ser border-bot-bold">SER</td>';
                    foreach ($Arr_SER as $prueba) {
                        $tabla .= '<td class="ser border-bot-bold">' . $prueba . '</td>';
                        $suma = ($prueba !== '-') ? ($total_fila_ser += $prueba) : '-';
                    }
                    $tabla .= '<td class="ser border-bot-bold">' . $total_fila_ser . '</td>';
                    $tabla .= '</tr>';
                }
                $contador++;
            }
            $tabla .= '</tbody>';
            /* TOTALES */
            $totales_PCR = [];
            $totales_ANT = [];
            $totales_SER = [];
            $totales_Dia = [];
            $SumaColPCR = 0;
            $SumaColANT = 0;
            $SumaColSER = 0;
            $SumaColTotal = 0;
            for ($i = 1; $i <= $DiasMes; $i++) {
                $sumaDiaPCR = 0;
                $sumaDiaANT = 0;
                $sumaDiaSER = 0;
                $TotalDia = 0;
                foreach ($Arr_regiones as $Region) {
                    $cant_unidades = count($Region['unidades']);
                    foreach ($Region['unidades'] as $Unidades) {
                        if (isset($Unidades['reporte'][$i])) {
                            $pcr = intval($Unidades['reporte'][$i]['pcr']);
                            $ant = intval($Unidades['reporte'][$i]['ant']);
                            $ser = intval($Unidades['reporte'][$i]['ser']);
                            $sumaDiaPCR += $pcr;
                            $sumaDiaANT += $ant;
                            $sumaDiaSER += $ser;
                            $TotalDia = ($sumaDiaSER + $sumaDiaPCR + $sumaDiaANT);
                            $SumaColPCR += $pcr;
                            $SumaColANT += $ant;
                            $SumaColSER += $ser;
                        }
                    }
                }
                $SumaColTotal += ($TotalDia);
                array_push($totales_PCR, $sumaDiaPCR);
                array_push($totales_ANT, $sumaDiaANT);
                array_push($totales_SER, $sumaDiaSER);
                array_push($totales_Dia, $TotalDia);
            }
            array_push($totales_PCR, $SumaColPCR);
            array_push($totales_ANT, $SumaColANT);
            array_push($totales_SER, $SumaColSER);
            array_push($totales_Dia, $SumaColTotal);
            $tabla .= '<tfoot>';
            $tabla .= '<tr><th colspan="2" rowspan="4">TOTALES</th><th>PCR</th>';
            foreach ($totales_PCR as $total) {
                $tabla .= '<th>' . $total . '</td>';
            }
            $tabla .= '</tr>';
            $tabla .= '<tr><th>ANT</th>';
            foreach ($totales_ANT as $total) {
                $tabla .= '<th>' . $total . '</td>';
            }
            $tabla .= '</tr>';
            $tabla .= '<tr><th>SER</th>';
            foreach ($totales_SER as $total) {
                $tabla .= '<th>' . $total . '</td>';
            }
            $tabla .= '</tr>';
            $tabla .= '<tr><th></th>';
            foreach ($totales_Dia as $total) {
                $tabla .= '<th>' . $total . '</td>';
            }
            $tabla .= '</tr>';
            $tabla .= '</tfoot>';
            $tabla .= '</table>';
            echo $tabla;
            break;
        case 'LOGIN':
            $usuario = [
                'user' => $_POST['User'],
                'pass' => md5($_POST['Pass']),
            ];
            $user_existe = $objUsuario->Validarusuario($usuario);
            if ($user_existe->rowCount() > 0) {
                $user_existe = $user_existe->fetch(PDO::FETCH_NAMED);
                session_start();
                $_SESSION['active'] = true;
                $_SESSION['nombre'] = $user_existe['nombre'];
                $_SESSION['iduser'] = $user_existe['usuario'];
                $_SESSION['tipouser'] = $user_existe['tipousuario'];
                $_SESSION['region'] = '';

                $extraeRegion = $objUsuario->ExtraeRegion($_SESSION['iduser']);
                if ($extraeRegion->rowCount() > 0) {
                    $extraeRegion = $extraeRegion->fetch(PDO::FETCH_NAMED);
                    $_SESSION['region'] = $extraeRegion['idregion'];
                    $_SESSION['n_region'] = $extraeRegion['region'];
                }

                echo 'INICIO';
            } else {
                echo 'No existe registro con este usuario';
            }
            break;
        case 'LOGOUT':
            session_start();
            $_SESSION['active'] = false;
            session_destroy();
            break;
        case 'EDITAR_REGISTRO':
            $IdReporte = $_POST['IdReporte'];
            $Comentario = $_POST['Comentario'];

            $objPruebas->EliminarPruebas($IdReporte);

            session_start();
            $DatosReporte = [
                'idreporte' => $IdReporte,
                'comentario' => $Comentario,
                'idusuario' => $_SESSION['iduser']
            ];
            $objPruebas->EditarReporte($DatosReporte);

            $t_beneficiarios = ['ta', 'td', 'tr', 'f'];
            for ($i = 0; $i <= 3; $i++) {
                $pcr = $_POST['pcr_' . $t_beneficiarios[$i]];
                $ant = $_POST['ant_' . $t_beneficiarios[$i]];
                $ser = $_POST['ser_' . $t_beneficiarios[$i]];

                if (empty($pcr)) $pcr = 0;
                if (empty($ant)) $ant = 0;
                if (empty($ser)) $ser = 0;

                if ((!empty($pcr) && $pcr > 0) || (!empty($ant) && $ant > 0) || (!empty($ser) && $ser > 0)) {
                    $DatosDetalle = [
                        'idreporte' => $IdReporte,
                        'tipo_beneficiario' => strtoupper($t_beneficiarios[$i]),
                        'c_pcr' => $pcr,
                        'c_ant' => $ant,
                        'c_ser' => $ser,
                    ];
                    $objPruebas->RegistrarDetallePruebas($DatosDetalle);
                }
            }
            echo 'ACTUALIZADO';

            break;
        case 'ELIMINAR_REGISTRO':
            $IdReporte = $_POST['idreporte'];
            $objPruebas->EliminarPruebas($IdReporte);
            $objPruebas->EliminarReporte($IdReporte);
            echo 'ELIMINADO';
            break;
        case 'CAMBIAR_PASS':
            session_start();
            $DatosUsuario = [
                'usuario' => $_SESSION['iduser'],
                'pass' => md5($_POST['Clave1'])
            ];
            $objUsuario->CambioPass($DatosUsuario);
            echo 'SE MODIFICÓ CONTRASEÑA';
            break;
        case 'LISTAR_USUARIOS':
            session_start();
            $filtro = $_POST['filtro'];
            if (empty($filtro)) $ListadoUsuarios = $objUsuario->ListarUsuario();
            else $ListadoUsuarios = $objUsuario->FiltrarUsuario($filtro);
            $ListadoUsuarios = $ListadoUsuarios->fetchAll(PDO::FETCH_OBJ);
            $tabla = '';
            foreach ($ListadoUsuarios as $usuario) {
                $iduser = $usuario->usuario;
                $region = '';
                $idregion = '';

                $DatosRegion = $objUsuario->ExtraeRegion($iduser);
                if ($DatosRegion->rowCount() > 0) {
                    $DatosRegion = $DatosRegion->fetch(PDO::FETCH_NAMED);
                    $region = $DatosRegion['region'];
                    $idregion = $DatosRegion['idregion'];
                }

                $tabla .= '<tr>';
                $tabla .= '<td>' . $iduser . '</td>';
                $tabla .= '<td>' . $usuario->nombre . '</td>';
                $tabla .= '<td>' . $region . '</td>';
                $tabla .= '<td class="nvisible">' . $usuario->tipousuario . '</td>';
                $tabla .= '<td class="nvisible">' . $idregion . '</td>';
                $tabla .= '<td class="nvisible">' . $usuario->estado . '</td>';
                $estado = $usuario->estado;
                $tabla .= '<td><i class="fa-solid fa-user-pen edit-user asphalt"></i></td>';
                if ($estado === 'A') $tabla .= '<td><i class="fa-solid fa-toggle-on icon-active btnCambiarEstado"></i></td>';
                else $tabla .= '<td><i class="fa-solid fa-toggle-off icon-inactive btnCambiarEstado"></i></td>';
                $tabla .= '</tr>';
            }
            echo $tabla;
            break;
        case 'LISTAR_REGIONES':
            session_start();
            $Regiones = $objPruebas->ListarRegiones();
            $Regiones = $Regiones->fetchAll(PDO::FETCH_OBJ);
            $opciones = '<option value="0">SELECCIONE MACRO</option>';
            foreach ($Regiones as $region) {
                $opciones .= '<option value="' . $region->idregion . '">' . $region->region . '</option>';
            }
            echo $opciones;
            break;
        case 'CONSULTA_DNI':
            $dni = $_POST['dni'];
            $token =
                'e49fddfa2a41c2c2f26d48840f7d81a66dc78dc2b0e085742a883f0ab0f84158';
            $url =
                'https://apiperu.dev/api/dni/' . $dni . '?api_token=' . $token;
            $curl = curl_init();

            $header = [];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt(
                $curl,
                CURLOPT_CAINFO,
                dirname(__FILE__) . '/cacert-2022-02-01.pem'
            );
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo 'cURL Error #:' . $err;
            } else {
                echo $response;
            }
            break;
        case 'REGISTRAR_USUARIO':
            $dni = $_POST['dniUsuario'];
            $UserExiste = $objUsuario->BuscararUsuario($dni);
            if ($UserExiste->rowCount() > 0) {
                echo 'USUARIO YA SE ENCUENTRA REGISTRADO';
            } else {
                $DatosUsuario = [
                    'usuario' => $_POST['dniUsuario'],
                    'pass' => $_POST['passUsuario'],
                    'nombre' => $_POST['nombreUsuario'],
                    'tipousuario' => $_POST['TipoUsuario'],
                    'idregion' => $_POST['RegionUsuario'],
                ];
                $objUsuario->RegistrarUsuario($DatosUsuario);
                echo 'SE REGISTRÓ USUARIO';
            }
            break;
        case 'EDITAR_USUARIO':
            $passUser = $_POST['passUsuario'];
            $usuario = $_POST['dniUsuario'];
            if ($passUser !== '') {
                $DatosUser = [
                    'usuario' => $usuario,
                    'pass' => md5($passUser)
                ];
                $objUsuario->CambioPass($DatosUser);
            }
            $DatosUsuario = [
                'usuario' => $usuario,
                'tipousuario' => $_POST['TipoUsuario'],
                'idregion' => $_POST['RegionUsuario'],
            ];
            $objUsuario->ActualizarUsuario($DatosUsuario);
            echo 'SE ACTUALIZÓ INFORMACIÓN';
            break;
        case 'CAMBIAR_ESTADO':
            $usuario = $_POST['usuario'];
            $estado = $_POST['estado'];

            $objUsuario->CambiarEstado($usuario, $estado);
            echo 'SE ACTUALIZÓ INFORMACIÓN';
            break;
        case 'BUSCAR_REPORTE':
            $idreporte = $_POST['idreporte'];
            $ArrReporte = [];
            $ArrDetalle = [];

            $Busqueda = $objPruebas->BuscarReporte($idreporte);
            $Busqueda = $Busqueda->fetchAll(PDO::FETCH_OBJ);
            foreach ($Busqueda as $reporte) {
                $ArrReporte = ['fecha' => $reporte->fecha, 'codigo' => $reporte->codigoipress, 'ipress' => $reporte->ipress, 'virus' => $reporte->virus, 'reporte' => [], 'comentario' => $reporte->comentario];
            }

            $BusquedaDetalle = $objPruebas->BuscarDetalleReporte($idreporte);
            $BusquedaDetalle = $BusquedaDetalle->fetchAll(PDO::FETCH_OBJ);
            $arrTb = [];
            $arr2 = [];
            foreach ($BusquedaDetalle as $reporte) {
                $arr =
                    [
                        'pcr' => $reporte->c_pcr,
                        'ant' => $reporte->c_ant,
                        'ser' => $reporte->c_ser,
                    ];
                array_push($arrTb, $reporte->tipo_beneficiario);
                array_push($arr2, $arr);
            }

            $ArrDetalle = array_combine($arrTb, $arr2);
            $ArrReporte['reporte'] = $ArrDetalle;
            echo json_encode($ArrReporte);
            break;
        case 'GENERAR_REPORTE_VMONO':
            $tvirus = 'M';
            $periodo = $_POST['periodo'];
            $tipo_benef = $_POST['tipo_benef'];
            $fecha = $periodo . '-01';
            $mes = date('n', strtotime($fecha));
            $Arr_regiones = [];

            $ListadoRegiones = $objPruebas->ListarRegiones();
            $Regiones = $ListadoRegiones->fetchAll(PDO::FETCH_OBJ);

            foreach ($Regiones as $Region) {
                $Arr_Unidades = [];
                $idregion = $Region->idregion;
                $ListadoUnidades = $objPruebas->IpressPorRegion($idregion);
                $Unidades = $ListadoUnidades->fetchAll(PDO::FETCH_OBJ);

                foreach ($Unidades as $Unidad) {
                    $Arr_Reportes = [];
                    $Arr_Reporte = [];
                    $ArrReporteDiario = [];
                    $ArrPruebas = [];
                    $idipress = $Unidad->codigoipress;
                    $ListadoReportes = $objPruebas->ReportesxMes($mes, $idipress, $tvirus);
                    $Reportes = $ListadoReportes->fetchAll(PDO::FETCH_OBJ);

                    foreach ($Reportes as $Reporte) {
                        $idreporte = $Reporte->idreporte;
                        array_push($Arr_Reportes, $Reporte->dia);
                        // PRUEBAS
                        if ($tipo_benef === 'G') $ListadoDetalleReporte = $objPruebas->DetallePruebasxReporteGeneral($idreporte);
                        else if ($tipo_benef === 'T') $ListadoDetalleReporte = $objPruebas->DetallePruebasxReporteTitulares($idreporte);
                        else $ListadoDetalleReporte = $objPruebas->DetallePruebasxReporte($idreporte, $tipo_benef);
                        $prueba_pcr = 0;
                        if ($ListadoDetalleReporte->rowCount() > 0) {
                            $Pruebas = $ListadoDetalleReporte->fetch(PDO::FETCH_NAMED);
                            $prueba_pcr = $Pruebas['c_pcr'];
                        }
                        $Arr_Reporte = ['pcr' => $prueba_pcr];
                        array_push($ArrPruebas, $Arr_Reporte);
                    }
                    $ArrReporteDiario = array_combine($Arr_Reportes, $ArrPruebas);
                    array_push($Arr_Unidades, ['unidad' => $Unidad->ipress, 'reporte' => $ArrReporteDiario]);
                }
                array_push($Arr_regiones, ['region' => $Region->region, 'unidades' => $Arr_Unidades]);
            }

            /* ----------- CREACIÓN DE TABLA --------- */


            $DiasMes = date('t', strtotime($fecha));
            /* THEAD - CABECERA DE TABLA */
            $tabla = '<table>';
            $tabla .= '<thead><tr><th class="wheadmax blue" colspan="2">IPRESS</th>';
            for ($i = 1; $i <= $DiasMes; $i++) {
                $tabla .= '<th class="td-num blue">' . $i . '</th>';
            }
            $tabla .= '<th class="blue">Total</th></tr>';
            $tabla .= '</thead>';
            /* TBODY - CAUERPO DE TABLA */
            $tabla .= '<tbody>';
            $contador = 0;
            foreach ($Arr_regiones as $Region) {
                $ColorFila = ($contador % 2 !== 0) ? 'fila_color' : '';
                $cant_unidades = count($Region['unidades']);
                $tabla .= '<tr>';
                $tabla .= '<td class="border-bold ' . $ColorFila . '" rowspan=' . intval(($cant_unidades) + 1) . '>' . $Region['region'] . '</td></tr>';

                foreach ($Region['unidades'] as $Unidades) {
                    $Arr_PCR = [];
                    for ($i = 1; $i <= $DiasMes; $i++) {
                        if (!isset($Unidades['reporte'][$i])) {
                            $pcr = '-';
                        } else {
                            $pcr = $Unidades['reporte'][$i]['pcr'];
                            if (empty($pcr)) $pcr = 0;
                        }
                        array_push($Arr_PCR, $pcr);
                    }

                    $tabla .= '<tr><td class="border-bold text-left w-medium td-ipress ' . $ColorFila . '">' . $Unidades['unidad'] . '</td>';
                    //$tabla .= '<td>PCR</td>';
                    $total_fila_pcr = 0;
                    foreach ($Arr_PCR as $prueba) {
                        $tabla .= '<td>' . $prueba . '</td>';
                        $suma = ($prueba !== '-') ? ($total_fila_pcr += $prueba) : '-';
                    }
                    $tabla .= '<td>' . $total_fila_pcr . '</td>';
                    $tabla .= '</tr>';
                }
                $contador++;
            }
            $tabla .= '</tbody>';
            /* TOTALES */
            $totales_PCR = [];
            $totales_Dia = [];
            $SumaColPCR = 0;
            $SumaColTotal = 0;
            for ($i = 1; $i <= $DiasMes; $i++) {
                $sumaDiaPCR = 0;
                $TotalDia = 0;
                foreach ($Arr_regiones as $Region) {
                    $cant_unidades = count($Region['unidades']);
                    foreach ($Region['unidades'] as $Unidades) {
                        if (isset($Unidades['reporte'][$i])) {
                            $pcr = intval($Unidades['reporte'][$i]['pcr']);
                            $sumaDiaPCR += $pcr;
                            $TotalDia = ($sumaDiaPCR);
                            $SumaColPCR += $pcr;
                        }
                    }
                }
                $SumaColTotal += ($TotalDia);
                array_push($totales_PCR, $sumaDiaPCR);
                array_push($totales_Dia, $TotalDia);
            }
            array_push($totales_PCR, $SumaColPCR);
            array_push($totales_Dia, $SumaColTotal);
            $tabla .= '<tfoot>';
            $tabla .= '<tr><th colspan="2">TOTALES</th>';
            foreach ($totales_PCR as $total) {
                $tabla .= '<th>' . $total . '</td>';
            }
            $tabla .= '</tr>';
            $tabla .= '</table>';
            echo $tabla;
            break;
    }
}
