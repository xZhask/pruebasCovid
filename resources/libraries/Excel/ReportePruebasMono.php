<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Color;

require_once '../../../App/models/ClsPrueba.php';

$objPruebas = new clsPruebas();

$periodo = $_GET['periodo'];
$tipo_benef = $_GET['tipo_benef'];
$tvirus = 'M';

$fecha = $periodo . '-01';
$DiasMes = date('t', strtotime($fecha));
$mes = date('n', strtotime($fecha));

$HastaCelda = '';
if ($DiasMes === '30') $HastaCelda = 'AG';
else if ($DiasMes === '31') $HastaCelda = 'AH';
else if ($DiasMes === '28') $HastaCelda = 'AE';
else if ($DiasMes === '29') $HastaCelda = 'AF';

/* CREACIÓN ARCHIVO EXCEL */
$estiloCabecera = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '1abc9c',
        ],
    ],
];

$estiloIpress = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];
$estiloPCR = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '74b9ff',
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]
    ],
];
$estiloSER = [

    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '81ecec',
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
            'color' => ['argb' => '000'],
        ]
    ],
];
$estiloANT = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [

            'rgb' => 'ffeaa7',
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]
    ],

];
$estiloTotales = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '1abc9c',
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => 'FFFFFF'],
        ]
    ],
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
    ],
];
$EstiloHospitales = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'f6e58d',
        ],
    ],
];
$EstiloLima = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'f1f2f6',
        ],
    ],
];
$EstiloProvincia = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'F8EFBA',
        ],
    ],
];
$EstiloLista = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
        ],
    ],
];
$Titulo = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '000'],
        'size' => 16
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],

];
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getStyle('A2:' . $HastaCelda . '2')->applyFromArray($estiloCabecera);


$sheet->setCellValue('A1', $periodo);
$sheet->setCellValue('A2', 'IPRESS');
$spreadsheet->getActiveSheet()->mergeCells('A2:B2');
$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(50);
//$sheet->getColumnDimension('C')->setWidth(10);

foreach (range('C', 'Z') as $columnID) {
    $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setWidth(5);
}
$sheet->getColumnDimension('AA')->setWidth(5);
$sheet->getColumnDimension('AB')->setWidth(5);
$sheet->getColumnDimension('AC')->setWidth(5);
$sheet->getColumnDimension('AD')->setWidth(5);
$sheet->getColumnDimension('AE')->setWidth(5);
$sheet->getColumnDimension('AF')->setWidth(5);
$sheet->getColumnDimension('AG')->setWidth(5);
$sheet->getColumnDimension('AH')->setWidth(5);

/* CABECERA */
$rowArray = [];
for ($i = 1; $i <= $DiasMes; $i++) {
    array_push($rowArray, $i);
}
array_push($rowArray, 'Total');

$spreadsheet->getActiveSheet()
    ->fromArray(
        $rowArray,
        NULL,
        'C2'
    );

/* CREACIÓN DE ARREGLOS */
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

/* INICIO DE FILAS */
$FilaRegiones = 3;
$FilaUnidades = 3;
$FilaTipoPruebas = 3;
/** */

foreach ($Arr_regiones as $Region) {
    $cant_unidades = count($Region['unidades']);
    $filaReg_Hasta = intval($FilaRegiones + ($cant_unidades) - 1);
    $sheet->setCellValue('A' . $FilaRegiones, $Region['region']);
    $spreadsheet->getActiveSheet()->mergeCells('A' . $FilaRegiones . ':A' . $filaReg_Hasta);

    foreach ($Region['unidades'] as $Unidades) {
        $sheet->setCellValue('B' . $FilaUnidades, $Unidades['unidad']);

        $Arr_PCR = [];
        $SumaFila_PCR = 0;

        //$Arr_Totales_PCR = [];
        for ($i = 1; $i <= $DiasMes; $i++) {
            if (!isset($Unidades['reporte'][$i])) {
                $pcr = '-';
            } else {
                $pcr = $Unidades['reporte'][$i]['pcr'];
                if (empty($pcr)) $pcr = '0';
                $SumaFila_PCR += intval($pcr);
            }
            array_push($Arr_PCR, $pcr);
        }
        array_push($Arr_PCR, $SumaFila_PCR);
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $Arr_PCR,
                NULL,
                'C' . $FilaUnidades
            );
        $FilaUnidades++;
    }
    $FilaRegiones = $filaReg_Hasta + 1;
}

/* TOTALES */
$totales_PCR = [];
$totales_Dia = [];
for ($i = 1; $i <= $DiasMes; $i++) {
    $sumaDiaPCR = 0;
    $TotalDia = 0;
    foreach ($Arr_regiones as $Region) {
        $cant_unidades = count($Region['unidades']);
        foreach ($Region['unidades'] as $Unidades) {
            if (isset($Unidades['reporte'][$i])) {
                $pcr = intval($Unidades['reporte'][$i]['pcr']);
                $sumaDiaPCR += $pcr;
                $TotalDia = $sumaDiaPCR;
            }
        }
    }
    array_push($totales_PCR, $sumaDiaPCR);
    array_push($totales_Dia, $TotalDia);
}
$spreadsheet->getActiveSheet()->mergeCells('A' . $FilaRegiones . ':B' . $FilaRegiones);
$sheet->setCellValue('A' . $FilaRegiones, 'TOTALES : ');

$spreadsheet->getActiveSheet()->getStyle('A' . $FilaRegiones . ':' . $HastaCelda . $FilaRegiones)->applyFromArray($estiloTotales);
$spreadsheet->getActiveSheet()
    ->fromArray(
        $totales_PCR,
        NULL,
        'C' . $FilaRegiones
    );
$sumrange = 'C' . $FilaRegiones . ':' . $HastaCelda . $FilaRegiones;
$sheet->setCellValue($HastaCelda . $FilaRegiones, '=SUM(' . $sumrange . ')');
$spreadsheet->getActiveSheet()->getStyle('A3:' . $HastaCelda . $FilaRegiones)->applyFromArray($estiloIpress);

$spreadsheet->getActiveSheet()->mergeCells('A1:' . $HastaCelda . '1');
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(60, 'pt');
$sheet->setCellValue('A1', 'REPORTE PRUEBAS V. DEL MONO, PERIODO ' . $periodo);
$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($Titulo);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="RepGeneral.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
