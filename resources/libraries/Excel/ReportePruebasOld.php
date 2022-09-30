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

$fecha = $periodo . '-01';
$DiasMes = date('t', strtotime($fecha));

$HastaCelda = '';
if ($DiasMes === '30') $HastaCelda = 'AH';
else if ($DiasMes === '31') $HastaCelda = 'AI';
else if ($DiasMes === '28') $HastaCelda = 'AF';
else if ($DiasMes === '29') $HastaCelda = 'AG';

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
        ],
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
            'color' => ['argb' => '000'],
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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$spreadsheet->getActiveSheet()->getStyle('A2:' . $HastaCelda . '2')->applyFromArray($estiloCabecera);
$spreadsheet->getActiveSheet()->getStyle('A3:C239')->applyFromArray($estiloIpress);

$sheet->setCellValue('A1', $periodo);
$sheet->setCellValue('A2', 'IPRESS');
$spreadsheet->getActiveSheet()->mergeCells('A2:C2');
$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(50);
$sheet->getColumnDimension('C')->setWidth(10);

$sheet->getColumnDimension('D')->setWidth(5);
$sheet->getColumnDimension('E')->setWidth(5);
$sheet->getColumnDimension('F')->setWidth(5);
$sheet->getColumnDimension('G')->setWidth(5);
$sheet->getColumnDimension('H')->setWidth(5);
$sheet->getColumnDimension('I')->setWidth(5);
$sheet->getColumnDimension('J')->setWidth(5);
$sheet->getColumnDimension('K')->setWidth(5);
$sheet->getColumnDimension('L')->setWidth(5);
$sheet->getColumnDimension('M')->setWidth(5);
$sheet->getColumnDimension('N')->setWidth(5);
$sheet->getColumnDimension('O')->setWidth(5);
$sheet->getColumnDimension('P')->setWidth(5);
$sheet->getColumnDimension('Q')->setWidth(5);
$sheet->getColumnDimension('R')->setWidth(5);
$sheet->getColumnDimension('S')->setWidth(5);
$sheet->getColumnDimension('T')->setWidth(5);
$sheet->getColumnDimension('U')->setWidth(5);
$sheet->getColumnDimension('V')->setWidth(5);
$sheet->getColumnDimension('W')->setWidth(5);
$sheet->getColumnDimension('X')->setWidth(5);
$sheet->getColumnDimension('Y')->setWidth(5);
$sheet->getColumnDimension('Z')->setWidth(5);
$sheet->getColumnDimension('AA')->setWidth(5);
$sheet->getColumnDimension('AB')->setWidth(5);
$sheet->getColumnDimension('AC')->setWidth(5);
$sheet->getColumnDimension('AD')->setWidth(5);
$sheet->getColumnDimension('AE')->setWidth(5);
$sheet->getColumnDimension('AF')->setWidth(5);
$sheet->getColumnDimension('AG')->setWidth(5);


$rowArray = [];
for ($i = 1; $i <= $DiasMes; $i++) {
    array_push($rowArray, $i);
}
array_push($rowArray, 'Total');

$spreadsheet->getActiveSheet()
    ->fromArray(
        $rowArray,
        NULL,
        'D2'
    );

$FilaRegiones = 3;
$FilaIpress = 3;
$FilaTipoPruebas = 3;

$ListadoRegiones = $objPruebas->ListarRegiones();

while ($fila = $ListadoRegiones->fetch(PDO::FETCH_NAMED)) {
    $idregion = $fila['idregion'];
    $cantidad = $fila['cantidadIpress'];

    $sheet->setCellValue('A' . $FilaRegiones, $fila['region']);
    $spreadsheet->getActiveSheet()->mergeCells('A' . $FilaRegiones . ':A' . intval($FilaRegiones + ($cantidad * 3) - 1));

    $IpressPorRegion = $objPruebas->IpressPorRegion($idregion);
    while ($row = $IpressPorRegion->fetch(PDO::FETCH_NAMED)) {
        $sheet->setCellValue('B' . $FilaIpress, $row['ipress']);
        $spreadsheet->getActiveSheet()->mergeCells('B' . $FilaIpress . ':B' . intval($FilaIpress + 2));
        $sheet->setCellValue('C' . $FilaTipoPruebas, 'PCR');
        //----------------------------------
        $ArrayPcr = [];
        $sumapcr = 0;
        for ($i = 1; $i <= $DiasMes; $i++) {
            $fechainicial = $year . '/' . $mes . '/' . $i;
            $PruebasPorDia = $objPruebas->ReporteMensual(1, $row['codigoipress'], $fechainicial);
            if ($PruebasPorDia->rowCount() > 0) {
                $PruebasPorDia = $PruebasPorDia->fetch(PDO::FETCH_NAMED);
                $PruebasPorDia = $PruebasPorDia['cantidad'];
                array_push($ArrayPcr, $PruebasPorDia);
                $sumapcr = $sumapcr + $PruebasPorDia;
            } else {
                $PruebasPorDia = '0';
                array_push($ArrayPcr, '0');
            }
        }
        array_push($ArrayPcr, $sumapcr);
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $ArrayPcr,
                NULL,
                'D' . $FilaTipoPruebas
            );
        $spreadsheet->getActiveSheet()->getStyle('C' . $FilaTipoPruebas . ':' . $HastaCelda . $FilaTipoPruebas)->applyFromArray($estiloPCR);
        //----------------------------------
        $FilaTipoPruebas++;
        $sheet->setCellValue('C' . $FilaTipoPruebas, 'ANT');
        $ArraySer = [];
        $sumaser = 0;
        for ($i = 1; $i <= $DiasMes; $i++) {
            $fechainicial = $year . '/' . $mes . '/' . $i;
            $PruebasPorDia = $objPruebas->ReporteMensual(2, $row['codigoipress'], $fechainicial);
            if ($PruebasPorDia->rowCount() > 0) {
                $PruebasPorDia = $PruebasPorDia->fetch(PDO::FETCH_NAMED);
                $PruebasPorDia = $PruebasPorDia['cantidad'];
                array_push($ArraySer, $PruebasPorDia);
                $sumaser = $sumaser + $PruebasPorDia;
            } else {
                $PruebasPorDia = '0';
                array_push($ArraySer, '0');
            }
        }
        array_push($ArraySer, $sumaser);
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $ArraySer,
                NULL,
                'D' . $FilaTipoPruebas
            );
        $spreadsheet->getActiveSheet()->getStyle('C' . $FilaTipoPruebas . ':' . $HastaCelda . $FilaTipoPruebas)->applyFromArray($estiloSER);
        $FilaTipoPruebas++;
        $sheet->setCellValue('C' . $FilaTipoPruebas, 'SER');
        $ArrayAnt = [];
        $sumaant = 0;
        for ($i = 1; $i <= $DiasMes; $i++) {
            $fechainicial = $year . '/' . $mes . '/' . $i;
            $PruebasPorDia = $objPruebas->ReporteMensual(3, $row['codigoipress'], $fechainicial);
            if ($PruebasPorDia->rowCount() > 0) {
                $PruebasPorDia = $PruebasPorDia->fetch(PDO::FETCH_NAMED);
                $PruebasPorDia = $PruebasPorDia['cantidad'];
                array_push($ArrayAnt, $PruebasPorDia);
                $sumaant = $sumaant + $PruebasPorDia;
            } else {
                $PruebasPorDia = '0';
                array_push($ArrayAnt, '0');
            }
        }
        array_push($ArrayAnt, $sumaant);
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $ArrayAnt,
                NULL,
                'D' . $FilaTipoPruebas
            );
        $spreadsheet->getActiveSheet()->getStyle('C' . $FilaTipoPruebas . ':' . $HastaCelda . $FilaTipoPruebas)->applyFromArray($estiloANT);
        $FilaTipoPruebas++;
        $FilaIpress = intval($FilaIpress + 2);
        $FilaIpress++;
    }

    $FilaRegiones = intval($FilaRegiones + ($cantidad * 3) - 1);
    $FilaRegiones++;
}
$PcrMES = 0;
$SerMES = 0;
$AntMES = 0;
$spreadsheet->getActiveSheet()->mergeCells('A' . $FilaRegiones . ':B' . intval($FilaRegiones + 2));
$spreadsheet->getActiveSheet()->getStyle('A' . $FilaRegiones . ':B' . $FilaRegiones)->applyFromArray($estiloTotales);
$sheet->setCellValue('A' . $FilaRegiones, 'TOTALES : ');
$sheet->setCellValue('C' . $FilaRegiones, 'PCR');
$spreadsheet->getActiveSheet()->getRowDimension($FilaRegiones)->setRowHeight(35, 'pt');
$ArrayPcrTotalDia = [];
for ($i = 1; $i <= $DiasMes; $i++) {
    $fechainicial = $year . '/' . $mes . '/' . $i;
    $TotalPcr = $objPruebas->TotalxDia($fechainicial, 1);
    $TotalPcr = $TotalPcr->fetch(PDO::FETCH_NAMED);
    $TotalPcr = $TotalPcr['total'];
    array_push($ArrayPcrTotalDia, $TotalPcr);
    $PcrMES = $PcrMES + intval($TotalPcr);
}
array_push($ArrayPcrTotalDia, $PcrMES);
$spreadsheet->getActiveSheet()
    ->fromArray(
        $ArrayPcrTotalDia,
        NULL,
        'D' . $FilaRegiones
    );
$spreadsheet->getActiveSheet()->getStyle('A' . $FilaRegiones . ':' . $HastaCelda . $FilaRegiones)->applyFromArray($estiloTotales);
$FilaRegiones++;

$sheet->setCellValue('C' . $FilaRegiones, 'ANT');
$spreadsheet->getActiveSheet()->getRowDimension($FilaRegiones)->setRowHeight(35, 'pt');
$ArrayAntTotalDia = [];
for ($i = 1; $i <= $DiasMes; $i++) {
    $fechainicial = $year . '/' . $mes . '/' . $i;
    $TotalAnt = $objPruebas->TotalxDia($fechainicial, 2);
    $TotalAnt = $TotalAnt->fetch(PDO::FETCH_NAMED);
    $TotalAnt = $TotalAnt['total'];
    array_push($ArrayAntTotalDia, $TotalAnt);
    $AntMES = $AntMES + intval($TotalAnt);
}
array_push($ArrayAntTotalDia, $AntMES);
$spreadsheet->getActiveSheet()
    ->fromArray(
        $ArrayAntTotalDia,
        NULL,
        'D' . $FilaRegiones
    );
$spreadsheet->getActiveSheet()->getStyle('A' . $FilaRegiones . ':' . $HastaCelda . $FilaRegiones)->applyFromArray($estiloTotales);
$FilaRegiones++;

$sheet->setCellValue('C' . $FilaRegiones, 'SER');
$spreadsheet->getActiveSheet()->getRowDimension($FilaRegiones)->setRowHeight(35, 'pt');
$ArraySerTotalDia = [];
for ($i = 1; $i <= $DiasMes; $i++) {
    $fechainicial = $year . '/' . $mes . '/' . $i;
    $TotalSer = $objPruebas->TotalxDia($fechainicial, 2);
    $TotalSer = $TotalSer->fetch(PDO::FETCH_NAMED);
    $TotalSer = $TotalSer['total'];
    array_push($ArraySerTotalDia, $TotalSer);
    $SerMES = $SerMES + intval($TotalSer);
}
array_push($ArraySerTotalDia, $SerMES);
$spreadsheet->getActiveSheet()
    ->fromArray(
        $ArraySerTotalDia,
        NULL,
        'D' . $FilaRegiones
    );
$spreadsheet->getActiveSheet()->getStyle('A' . $FilaRegiones . ':' . $HastaCelda . $FilaRegiones)->applyFromArray($estiloTotales);

$spreadsheet->getActiveSheet()->getStyle('A3:B11')->applyFromArray($EstiloHospitales);
$spreadsheet->getActiveSheet()->getStyle('A12:B71')->applyFromArray($EstiloLima);
$spreadsheet->getActiveSheet()->getStyle('A72:B239')->applyFromArray($EstiloProvincia);
$spreadsheet->getActiveSheet()->getStyle('A3:B239')->applyFromArray($EstiloLista);

$conditional = new Conditional();
$conditional->setConditionType(Conditional::CONDITION_CELLIS);
$conditional->setOperatorType(Conditional::OPERATOR_GREATERTHAN);
$conditional->addCondition(0);
$conditional->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)
    ->getEndColor()->setARGB(Color::COLOR_RED);
$conditional->getStyle()->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

$conditionalStyles = $spreadsheet->getActiveSheet()->getStyle('D3:' . $HastaCelda . '239')->getConditionalStyles();
$conditionalStyles[] = $conditional;

$spreadsheet->getActiveSheet()->getStyle('D3:' . $HastaCelda . '239')->setConditionalStyles($conditionalStyles);



header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="RepGeneral.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
