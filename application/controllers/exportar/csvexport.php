<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Csvexport extends CI_Controller {

    private $sheet;
    private $alignment_general;
    private $style_cabecera_general;
    private $style_tabs;
    private $style_tabs_all;
    private $style_subtitulo;
    private $style_subtitulo_all;
    private $style_subitem;
    private $style_subitem_all;
    private $style_indicador;
    private $style_indicador_all;
    private $style_contenido;
    private $style_contenido_all;
    private $marco;
    private $divisoria;
    private $style_impar;
    private $style_filter;

    function __construct() {
        parent::__construct();
        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "-1");
        $this->load->library('PHPExcel');
        $this->load->model('export_model');
        $this->load->model('modellocalresumen');
        
//        ini_set("memory_limit", "1024M");
    }

    public function index() {
        echo '';
    }

    public function set_styles() {

        $this->alignment_general = array(
            'alignment' => array(
                'wrap' => true,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
        );

        $this->style_cabecera_general = array(
            'font' => array(
                'bold' => true,
                'size' => 13
            )
        );


        $this->style_tabs = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'BFBFBF')
            ),
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        );

        $this->style_tabs_all = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'BFBFBF')
            ),
            'font' => array(
                'bold' => true,
                'size' => 12
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        );

        $this->style_subtitulo = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '1F497D')
            ),
            'font' => array(
                'bold' => true,
                'size' => 12,
                'color' => array('rgb' => 'FFFFFF')
            )
        );

        $this->style_subtitulo_all = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '1F497D')
            ),
            'font' => array(
                'bold' => true,
                'size' => 12,
                'color' => array('rgb' => 'FFFFFF')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->style_subitem = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '538DD5')
            ),
            'font' => array(
                'bold' => true,
                'size' => 11,
                'italic' => true,
                'color' => array('rgb' => 'FFFFFF')
            )
        );

        $this->style_subitem_all = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '538DD5')
            ),
            'font' => array(
                'bold' => true,
                'size' => 11,
                'color' => array('rgb' => 'FFFFFF')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->style_indicador = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
            ),
            'font' => array(
                'bold' => true
            )
        );

        $this->style_indicador_all = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'CCECFF')
            ),
            'font' => array(
                'bold' => true
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $this->style_contenido = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
            ),
        );

        $this->style_contenido_all = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );


        $this->marco = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        );

        $this->divisoria = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => '4F81BD')
                )
            )
        );

        $this->style_impar = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DAEEF3')
            )
        );

        $this->style_filter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'font' => array(
                'bold' => true
            )
        );
    }

    public function por_codigo() {

        $idCodigo = $_GET['idCodigo'];

        ////////////////////////////////
        //Colores y Estilos
        ////////////////////////////////
        $this->set_styles();

        // pestaña
        $this->sheet = $this->phpexcel->getActiveSheet(0);

        ////////////////////////////////
        // Formato de la hoja ( Set Orientation, size and scaling )
        ////////////////////////////////
        $this->sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT); // horizontal
        $this->sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $this->sheet->getPageSetup()->setRowsToRepeatAtTop(array(1, 5)); // cabecera de impresion
        $this->sheet->getDefaultStyle()->getFont()->setName('Calibri');
        $this->sheet->getDefaultStyle()->getFont()->setSize(11);
        $this->sheet->getDefaultStyle()->applyFromArray($this->alignment_general);
        $this->sheet->getSheetView()->setZoomScale(100);
        $this->sheet->getDefaultColumnDimension()->setWidth(12); //default size column
        $this->sheet->getColumnDimension('G')->setAutoSize(true);

        $this->sheet->getRowDimension(9)->setRowHeight(30);
        $this->sheet->getRowDimension(91)->setRowHeight(27);
        $this->sheet->getRowDimension(97)->setRowHeight(27);
        $this->sheet->getRowDimension(101)->setRowHeight(27);


        ////////////////////////////////
        // Logo
        ////////////////////////////////
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setWorksheet($this->sheet);
        $objDrawing->setName("inei");
        $objDrawing->setDescription("Inei");
        $objDrawing->setPath("assets/img/inei.jpeg");
        $objDrawing->setCoordinates('A1');
        $objDrawing->setHeight(75);
        $objDrawing->setOffsetX(15);
        $objDrawing->setOffsetY(4);

        ////////////////////////////////
        // Cabecera General
        ////////////////////////////////
        $this->cell_value_with_merge('C3', 'INSTITUTO NACIONAL DE ESTADÍSTICA E INFORMÁTICA', 'C3:G3');
        $this->cell_value_with_merge('C4', 'CENSO DE INFRAESTRUCTURA EDUCATIVA 2013', 'C4:G4');
        $this->sheet->getStyle('C3:G4')->applyFromArray($this->style_cabecera_general);


        ////////////////////////////////
        // Cuerpo
        ////////////////////////////////

        $indice = 6; //fila inicial

        $sql = "SELECT * FROM Local_Resumen WHERE codigo_de_local = '" . $idCodigo . "' and pc_c_2_Rfinal_resul = 1";
        $query = $this->convert_utf8->convert_result($this->export_model->only_query($sql));

        foreach ($query as $key => $row) {
            $nombre_ie = $row['nombres_IIEE'];

            ////////////////////////////////
            // Información General
            ////////////////////////////////

            $this->cell_value_with_merge('A' . $indice, 'INFORMACIÓN GENERAL DE LA ' . $nombre_ie, 'A' . $indice . ':G' . ($indice + 1));
            $this->sheet->getStyle('A' . $indice . ':G' . ($indice + 1))->applyFromArray($this->style_tabs);

            $this->cell_value_with_merge('A' . ($indice + 2), 'INFORMACIÓN DEL LOCAL ESCOLAR', 'A' . ($indice + 2) . ':G' . ($indice + 2));
            $this->sheet->getStyle('A' . ($indice + 2) . ':G' . ($indice + 2))->applyFromArray($this->style_subtitulo);


            $this->cell_value_with_merge('A' . ($indice + 3), 'Nombre de la Institución Educativa:', 'A' . ($indice + 3) . ':B' . ($indice + 3));
            $this->cell_value_with_merge('C' . ($indice + 3), strtoupper($nombre_ie), 'C' . ($indice + 3) . ':G' . ($indice + 3));

            $this->cell_value_with_merge('A' . ($indice + 4), 'Código del Local Escolar:', 'A' . ($indice + 4) . ':B' . ($indice + 4));
            $this->sheet->getCellByColumnAndRow(2, ($indice + 4))->setValueExplicit($row['codigo_de_local'], PHPExcel_Cell_DataType::TYPE_STRING);
            $this->sheet->mergeCells('C' . ($indice + 4) . ':G' . ($indice + 4));
            $this->sheet->getStyle('C' . ($indice + 4) . ':G' . ($indice + 4))->applyFromArray($this->style_contenido);



            $this->cell_value_with_merge('A' . ($indice + 5), 'Nivel Educativo:', 'A' . ($indice + 5) . ':B' . ($indice + 5));
            $this->cell_value_with_merge('C' . ($indice + 5), strtoupper($row['nivel']), 'C' . ($indice + 5) . ':G' . ($indice + 5));

            $this->cell_value_with_merge('A' . ($indice + 6), 'Total de Alumnos:', 'A' . ($indice + 6) . ':B' . ($indice + 6));
            $this->cell_value_with_merge('C' . ($indice + 6), $row['Talum'] . ' ALUMNOS', 'C' . ($indice + 6) . ':G' . ($indice + 6));

            $this->cell_value_with_merge('A' . ($indice + 8), 'Nombre del Director:', 'A' . ($indice + 8) . ':B' . ($indice + 8));
            $this->cell_value_with_merge('C' . ($indice + 8), strtoupper($row['Director_IIEE']), 'C' . ($indice + 8) . ':G' . ($indice + 8));

            $this->cell_value_with_merge('A' . ($indice + 9), 'Teléfono:', 'A' . ($indice + 9) . ':B' . ($indice + 9));
            $this->cell_value_with_merge('C' . ($indice + 9), $row['tel_IE'], 'C' . ($indice + 9) . ':G' . ($indice + 9));

            $this->cell_value_with_merge('A' . ($indice + 10), 'Dirección:', 'A' . ($indice + 10) . ':B' . ($indice + 10));
            $this->cell_value_with_merge('C' . ($indice + 10), strtoupper($row['direcc_IE']), 'C' . ($indice + 10) . ':G' . ($indice + 10));



            $this->cell_value_with_merge('A' . ($indice + 12), 'Región:', 'A' . ($indice + 12) . ':B' . ($indice + 12));
            $this->cell_value_with_merge('C' . ($indice + 12), strtoupper($row['dpto_nombre']), 'C' . ($indice + 12) . ':G' . ($indice + 12));

            $this->cell_value_with_merge('A' . ($indice + 13), 'Provincia:', 'A' . ($indice + 13) . ':B' . ($indice + 13));
            $this->cell_value_with_merge('C' . ($indice + 13), strtoupper($row['prov_nombre']), 'C' . ($indice + 13) . ':G' . ($indice + 13));

            $this->cell_value_with_merge('A' . ($indice + 14), 'Distrito:', 'A' . ($indice + 14) . ':B' . ($indice + 14));
            $this->cell_value_with_merge('C' . ($indice + 14), strtoupper($row['dist_nombre']), 'C' . ($indice + 14) . ':G' . ($indice + 14));

            $this->cell_value_with_merge('A' . ($indice + 15), 'Centro Poblado:', 'A' . ($indice + 15) . ':B' . ($indice + 15));
            $this->cell_value_with_merge('C' . ($indice + 15), strtoupper($row['centroPoblado']), 'C' . ($indice + 15) . ':G' . ($indice + 15));

            $this->cell_value_with_merge('A' . ($indice + 16), 'Área:', 'A' . ($indice + 16) . ':B' . ($indice + 16));
            $this->cell_value_with_merge('C' . ($indice + 16), strtoupper($row['des_area']), 'C' . ($indice + 16) . ':G' . ($indice + 16));



            $this->cell_value_with_merge('A' . ($indice + 18), 'Propietario del Predio:', 'A' . ($indice + 18) . ':B' . ($indice + 18));
            $this->cell_value_with_merge('C' . ($indice + 18), strtoupper($row['prop_IE']), 'C' . ($indice + 18) . ':G' . ($indice + 18));


            $this->cell_value_with_merge('A' . ($indice + 20), 'Georreferencia:', 'A' . ($indice + 20) . ':B' . ($indice + 20));


            $this->sheet->getStyle('C' . ($indice + 3) . ':G' . ($indice + 18))->applyFromArray($this->style_contenido);
            $this->sheet->getStyle('A' . ($indice + 3) . ':B' . ($indice + 20))->applyFromArray($this->style_indicador);



            $this->sheet->setCellValue('B' . ($indice + 21), 'Latitud:');
            $this->sheet->setCellValue('C' . ($indice + 21), $row['LatitudPunto_UltP']);

            $this->sheet->setCellValue('D' . ($indice + 21), 'Longitud:');
            $this->sheet->setCellValue('E' . ($indice + 21), $row['LongitudPunto_UltP']);

            $this->sheet->setCellValue('F' . ($indice + 21), 'Altitud:');
            $this->sheet->setCellValue('G' . ($indice + 21), $row['AltitudPunto_UltP'] . " msnm");


            $this->sheet->getStyle('B' . ($indice + 21))->applyFromArray($this->style_indicador);
            $this->sheet->getStyle('D' . ($indice + 21))->applyFromArray($this->style_indicador);
            $this->sheet->getStyle('F' . ($indice + 21))->applyFromArray($this->style_indicador);

            $this->sheet->getStyle('C' . ($indice + 21))->applyFromArray($this->style_contenido);
            $this->sheet->getStyle('E' . ($indice + 21))->applyFromArray($this->style_contenido);
            $this->sheet->getStyle('G' . ($indice + 21))->applyFromArray($this->style_contenido);



            ////////////////////////////////
            // Imagen de Local
            ////////////////////////////////
            $ruta_foto = ( $row['RutaFoto'] == null ) ? 'imagen-no-disponible.jpg' : $row['RutaFoto'];
//            $url_external = 'http://www.jc.pe/portafolio/cie/cap3/' . $ruta_foto;
            $url_external = 'http://webinei.inei.gob.pe/cie/2013/cap3/' . $ruta_foto;
            $array_foto = explode("/", $ruta_foto);
            $name_foto = array_pop($array_foto); // quito y le asigno el valor del ultimo indice del array.
            $img = 'assets/img/temporal/' . $name_foto;

            ///////// proxy ////////
            /* $aContext = array(
              'http' => array(
              'proxy' => 'tcp://172.16.100.1:3128',
              'request_fulluri' => true,
              ),
              );
              $cxContext = stream_context_create($aContext);
              $get_url = file_get_contents($url_external, false, $cxContext); */
            ///////// -- proxy  -- ////////
            $get_url = file_get_contents($url_external); // sin proxy
            $get_img = file_put_contents($img, $get_url);

            $objDrawing2 = new PHPExcel_Worksheet_Drawing();
            $objDrawing2->setWorksheet($this->sheet);
            $objDrawing2->setName("Imagen_I.E.");
            $objDrawing2->setDescription("Imagen de la Institución Educativa");
            $objDrawing2->setPath($img);
            $objDrawing2->setCoordinates('A' . ($indice + 23));
            $objDrawing2->setHeight(415);
            $objDrawing2->setOffsetX(16);
            $objDrawing2->setOffsetY(0);


            ///////////////////////////////////////////
            // Información de la Infraestructura page 2
            ///////////////////////////////////////////
            $this->cell_value_with_merge('A' . ($indice + 44), 'INFORMACIÓN DE LA INFRAESTRUCTURA DE LA ' . $nombre_ie, 'A' . ($indice + 44) . ':G' . ($indice + 45));
            $this->sheet->getStyle('A' . ($indice + 44) . ':G' . ($indice + 45))->applyFromArray($this->style_tabs);


            $this->cell_value_with_merge('A' . ($indice + 46), 'NÚMERO PREDIOS Y EDIFICACIONES', 'A' . ($indice + 46) . ':G' . ($indice + 46));
            $this->sheet->getStyle('A' . ($indice + 46) . ':G' . ($indice + 46))->applyFromArray($this->style_subtitulo);

            $this->cell_value_with_merge('A' . ($indice + 47), 'Predios:', 'A' . ($indice + 47) . ':B' . ($indice + 47));
            $this->sheet->setCellValue('C' . ($indice + 47), $row['cPred']);
            $this->cell_value_with_merge('D' . ($indice + 47), 'predio(s)', 'D' . ($indice + 47) . ':E' . ($indice + 47));

            $this->cell_value_with_merge('A' . ($indice + 48), 'Edificaciones:', 'A' . ($indice + 48) . ':B' . ($indice + 48));
            $this->sheet->setCellValue('C' . ($indice + 48), $row['cEdif']);
            $this->cell_value_with_merge('D' . ($indice + 48), 'edificación(es)', 'D' . ($indice + 48) . ':E' . ($indice + 48));

            $this->cell_value_with_merge('A' . ($indice + 49), 'Total de Pisos:', 'A' . ($indice + 49) . ':B' . ($indice + 49));
            $this->sheet->setCellValue('C' . ($indice + 49), $row['Piso']);
            $this->cell_value_with_merge('D' . ($indice + 49), 'piso(s)', 'D' . ($indice + 49) . ':E' . ($indice + 49));

            $this->cell_value_with_merge('A' . ($indice + 50), 'Área del Terreno:', 'A' . ($indice + 50) . ':B' . ($indice + 50));
            $this->sheet->setCellValue('C' . ($indice + 50), $row['P1_B_3_9_At_Local']);
            $this->cell_value_with_merge('D' . ($indice + 50), 'm2', 'D' . ($indice + 50) . ':E' . ($indice + 50));


            $this->sheet->getStyle('A' . ($indice + 47) . ':B' . ($indice + 50))->applyFromArray($this->style_indicador);
            $this->sheet->getStyle('D' . ($indice + 47) . ':E' . ($indice + 50))->applyFromArray($this->style_contenido);



            $this->cell_value_with_merge('A' . ($indice + 52), 'OTRAS EDIFICACIONES', 'A' . ($indice + 52) . ':G' . ($indice + 52));
            $this->sheet->getStyle('A' . ($indice + 52) . ':G' . ($indice + 52))->applyFromArray($this->style_subtitulo);

            $this->cell_value_with_merge('A' . ($indice + 53), 'Patio:', 'A' . ($indice + 53) . ':B' . ($indice + 53));
            $this->sheet->setCellValue('C' . ($indice + 53), $row['P']);
            $this->cell_value_with_merge('D' . ($indice + 53), 'patio(s)', 'D' . ($indice + 53) . ':E' . ($indice + 53));

            $this->cell_value_with_merge('A' . ($indice + 54), 'Losa Deportiva:', 'A' . ($indice + 54) . ':B' . ($indice + 54));
            $this->sheet->setCellValue('C' . ($indice + 54), $row['LD']);
            $this->cell_value_with_merge('D' . ($indice + 54), 'losa(s) deportiva(s)', 'D' . ($indice + 54) . ':E' . ($indice + 54));

            $this->cell_value_with_merge('A' . ($indice + 55), 'Cisterna - Tanque:', 'A' . ($indice + 55) . ':B' . ($indice + 55));
            $this->sheet->setCellValue('C' . ($indice + 55), $row['CTE']);
            $this->cell_value_with_merge('D' . ($indice + 55), 'cistena(s) - tanque(s)', 'D' . ($indice + 55) . ':E' . ($indice + 55));

            $this->cell_value_with_merge('A' . ($indice + 56), 'Muro de Contención:', 'A' . ($indice + 56) . ':B' . ($indice + 56));
            $this->sheet->setCellValue('C' . ($indice + 56), $row['MC']);
            $this->cell_value_with_merge('D' . ($indice + 56), 'muro(s) de contención(es)', 'D' . ($indice + 56) . ':F' . ($indice + 56));


            $this->sheet->getStyle('A' . ($indice + 53) . ':B' . ($indice + 56))->applyFromArray($this->style_indicador);
            $this->sheet->getStyle('D' . ($indice + 53) . ':E' . ($indice + 56))->applyFromArray($this->style_contenido);



            $this->cell_value_with_merge('A' . ($indice + 58), 'SERVICIOS BÁSICOS Y COMUNICACIONES', 'A' . ($indice + 58) . ':G' . ($indice + 58));
            $this->sheet->getStyle('A' . ($indice + 58) . ':G' . ($indice + 58))->applyFromArray($this->style_subtitulo);

            $this->cell_value_with_merge('A' . ($indice + 59), 'Energía Eléctrica:', 'A' . ($indice + 59) . ':B' . ($indice + 59));
            $this->sheet->setCellValue('C' . ($indice + 59), ( $row['P2_C_2LocE_1_Energ'] == 1) ? 'TIENE' : 'NO TIENE' );

            $this->cell_value_with_merge('A' . ($indice + 60), 'Agua Potable:', 'A' . ($indice + 60) . ':B' . ($indice + 60));
            $this->sheet->setCellValue('C' . ($indice + 60), ( $row['P2_C_2LocE_2_Agua'] == 1) ? 'TIENE' : 'NO TIENE' );

            $this->cell_value_with_merge('A' . ($indice + 61), 'Alcantarillado:', 'A' . ($indice + 61) . ':B' . ($indice + 61));
            $this->sheet->setCellValue('C' . ($indice + 61), ( $row['P2_C_2LocE_3_Alc'] == 1) ? 'TIENE' : 'NO TIENE' );

            $this->cell_value_with_merge('A' . ($indice + 62), 'Telefonía Fija:', 'A' . ($indice + 62) . ':B' . ($indice + 62));
            $this->sheet->setCellValue('C' . ($indice + 62), ( $row['P2_C_2LocE_4_Tfija'] == 1) ? 'TIENE' : 'NO TIENE' );

            $this->cell_value_with_merge('A' . ($indice + 63), 'Telefonía Móvil:', 'A' . ($indice + 63) . ':B' . ($indice + 63));
            $this->sheet->setCellValue('C' . ($indice + 63), ( $row['P2_C_2LocE_5_Tmov'] == 1) ? 'TIENE' : 'NO TIENE' );

            $this->cell_value_with_merge('A' . ($indice + 64), 'Internet:', 'A' . ($indice + 64) . ':B' . ($indice + 64));
            $this->sheet->setCellValue('C' . ($indice + 64), ( $row['P2_C_2LocE_6_Int'] == 1) ? 'TIENE' : 'NO TIENE' );


            $this->sheet->getStyle('A' . ($indice + 59) . ':B' . ($indice + 64))->applyFromArray($this->style_indicador);



            $this->cell_value_with_merge('A' . ($indice + 66), 'ESPACIOS EDUCATIVOS QUE FUNCIONAN EN LAS EDIFICACIONES', 'A' . ($indice + 66) . ':G' . ($indice + 66));
            $this->sheet->getStyle('A' . ($indice + 66) . ':G' . ($indice + 66))->applyFromArray($this->style_subtitulo);

            $this->cell_value_with_merge('A' . ($indice + 67), 'Aula Común:', 'A' . ($indice + 67) . ':B' . ($indice + 67));
            $this->sheet->setCellValue('C' . ($indice + 67), $row['e_1']);
            $this->cell_value_with_merge('D' . ($indice + 67), 'aula(s)', 'D' . ($indice + 67) . ':E' . ($indice + 67));

            $this->cell_value_with_merge('A' . ($indice + 68), 'Pedagógico:', 'A' . ($indice + 68) . ':B' . ($indice + 68));
            $this->sheet->setCellValue('C' . ($indice + 68), $row['e_2']);
            $this->cell_value_with_merge('D' . ($indice + 68), 'espacio(s) pedagógico(s)', 'D' . ($indice + 68) . ':E' . ($indice + 68));

            $this->cell_value_with_merge('A' . ($indice + 69), 'Administrativo:', 'A' . ($indice + 69) . ':B' . ($indice + 69));
            $this->sheet->setCellValue('C' . ($indice + 69), $row['e_3']);
            $this->cell_value_with_merge('D' . ($indice + 69), 'espacio(s) administrativo(s)', 'D' . ($indice + 69) . ':E' . ($indice + 69));

            $this->cell_value_with_merge('A' . ($indice + 70), 'Complementario:', 'A' . ($indice + 70) . ':B' . ($indice + 70));
            $this->sheet->setCellValue('C' . ($indice + 70), $row['e_4']);
            $this->cell_value_with_merge('D' . ($indice + 70), 'espacio(s) complementario(s)', 'D' . ($indice + 70) . ':E' . ($indice + 70));

            $this->cell_value_with_merge('A' . ($indice + 71), 'Servicios:', 'A' . ($indice + 71) . ':B' . ($indice + 71));
            $this->sheet->setCellValue('C' . ($indice + 71), $row['e_5']);
            $this->cell_value_with_merge('D' . ($indice + 71), 'servicio(s)', 'D' . ($indice + 71) . ':E' . ($indice + 71));


            $this->sheet->getStyle('A' . ($indice + 67) . ':B' . ($indice + 71))->applyFromArray($this->style_indicador);
            $this->sheet->getStyle('D' . ($indice + 67) . ':E' . ($indice + 71))->applyFromArray($this->style_contenido);



            $this->cell_value_with_merge('A' . ($indice + 73), 'CARACTERÍSTICAS DE LAS EDIFICACIONES', 'A' . ($indice + 73) . ':G' . ($indice + 73));
            $this->sheet->getStyle('A' . ($indice + 73) . ':G' . ($indice + 73))->applyFromArray($this->style_subtitulo);

            $this->cell_value_with_merge('A' . ($indice + 74), 'EDIFICACIONES POR EJECUTOR DE LA OBRA', 'A' . ($indice + 74) . ':G' . ($indice + 74));
            $this->sheet->getStyle('A' . ($indice + 74) . ':D' . ($indice + 74))->applyFromArray($this->style_subitem);

            $this->cell_value_with_merge('A' . ($indice + 75), 'Gobierno Nacional / Proyecto Especial:', 'A' . ($indice + 75) . ':D' . ($indice + 75));
            $this->sheet->setCellValue('E' . ($indice + 75), $row['eo_1']);
            $this->cell_value_with_merge('F' . ($indice + 75), 'edificación(es)', 'F' . ($indice + 75) . ':G' . ($indice + 75));

            $this->cell_value_with_merge('A' . ($indice + 76), 'Gobierno Regional / Local:', 'A' . ($indice + 76) . ':D' . ($indice + 76));
            $this->sheet->setCellValue('E' . ($indice + 76), $row['eo_2']);
            $this->cell_value_with_merge('F' . ($indice + 76), 'edificación(es)', 'F' . ($indice + 76) . ':G' . ($indice + 76));

            $this->cell_value_with_merge('A' . ($indice + 77), 'APAFA / Autoconstrucción:', 'A' . ($indice + 77) . ':D' . ($indice + 77));
            $this->sheet->setCellValue('E' . ($indice + 77), $row['eo_3']);
            $this->cell_value_with_merge('F' . ($indice + 77), 'edificación(es)', 'F' . ($indice + 77) . ':G' . ($indice + 77));

            $this->cell_value_with_merge('A' . ($indice + 78), 'Entidades Cooperantes /  ONG\'S:', 'A' . ($indice + 78) . ':D' . ($indice + 78));
            $this->sheet->setCellValue('E' . ($indice + 78), $row['eo_4']);
            $this->cell_value_with_merge('F' . ($indice + 78), 'edificación(es)', 'F' . ($indice + 78) . ':G' . ($indice + 78));

            $this->cell_value_with_merge('A' . ($indice + 79), 'Empresa Privada:', 'A' . ($indice + 79) . ':D' . ($indice + 79));
            $this->sheet->setCellValue('E' . ($indice + 79), $row['eo_5']);
            $this->cell_value_with_merge('F' . ($indice + 79), 'edificación(es)', 'F' . ($indice + 79) . ':G' . ($indice + 79));


            $this->sheet->getStyle('A' . ($indice + 75) . ':D' . ($indice + 79))->applyFromArray($this->style_indicador);
            $this->sheet->getStyle('F' . ($indice + 75) . ':G' . ($indice + 79))->applyFromArray($this->style_contenido);


            $this->cell_value_with_merge('A' . ($indice + 80), 'EDIFICACIONES SEGÚN AÑO DE CONSTRUCCIÓN', 'A' . ($indice + 80) . ':G' . ($indice + 80));
            $this->sheet->getStyle('A' . ($indice + 80) . ':D' . ($indice + 80))->applyFromArray($this->style_subitem);

            $this->cell_value_with_merge('A' . ($indice + 81), 'Antes y Durante 1977:', 'A' . ($indice + 81) . ':D' . ($indice + 81));
            $this->sheet->setCellValue('E' . ($indice + 81), $row['a_1']);
            $this->cell_value_with_merge('F' . ($indice + 81), 'edificación(es)', 'F' . ($indice + 81) . ':G' . ($indice + 81));

            $this->cell_value_with_merge('A' . ($indice + 82), 'Entre 1978 Y 1998:', 'A' . ($indice + 82) . ':D' . ($indice + 82));
            $this->sheet->setCellValue('E' . ($indice + 82), $row['a_2']);
            $this->cell_value_with_merge('F' . ($indice + 82), 'edificación(es)', 'F' . ($indice + 82) . ':G' . ($indice + 82));

            $this->cell_value_with_merge('A' . ($indice + 83), 'Después de 1998:', 'A' . ($indice + 83) . ':D' . ($indice + 83));
            $this->sheet->setCellValue('E' . ($indice + 83), $row['a_3']);
            $this->cell_value_with_merge('F' . ($indice + 83), 'edificación(es)', 'F' . ($indice + 83) . ':G' . ($indice + 83));


            $this->sheet->getStyle('A' . ($indice + 81) . ':D' . ($indice + 83))->applyFromArray($this->style_indicador);
            $this->sheet->getStyle('F' . ($indice + 81) . ':G' . ($indice + 83))->applyFromArray($this->style_contenido);


            $this->cell_value_with_merge('A' . ($indice + 84), 'EDIFICACIONES SEGÚN SISTEMA ESTRUCTURAL PREDOMINANTE', 'A' . ($indice + 84) . ':G' . ($indice + 84));
            $this->sheet->getStyle('A' . ($indice + 84) . ':D' . ($indice + 84))->applyFromArray($this->style_subitem);

            $this->cell_value_with_merge('A' . ($indice + 85), 'Pórticos de concreto armado y/o muros de albañilería (dual):', 'A' . ($indice + 85) . ':D' . ($indice + 85));
            $this->sheet->setCellValue('E' . ($indice + 85), $row['estruc_1']);
            $this->cell_value_with_merge('F' . ($indice + 85), 'edificación(es)', 'F' . ($indice + 85) . ':G' . ($indice + 85));

            $this->cell_value_with_merge('A' . ($indice + 86), 'Albañilería confinada o armada:', 'A' . ($indice + 86) . ':D' . ($indice + 86));
            $this->sheet->setCellValue('E' . ($indice + 86), $row['estruc_2']);
            $this->cell_value_with_merge('F' . ($indice + 86), 'edificación(es)', 'F' . ($indice + 86) . ':G' . ($indice + 86));

            $this->cell_value_with_merge('A' . ($indice + 87), 'Estructura de acero:', 'A' . ($indice + 87) . ':D' . ($indice + 87));
            $this->sheet->setCellValue('E' . ($indice + 87), $row['estruc_3']);
            $this->cell_value_with_merge('F' . ($indice + 87), 'edificación(es)', 'F' . ($indice + 87) . ':G' . ($indice + 87));

            $this->cell_value_with_merge('A' . ($indice + 88), 'Madera (normalizada):', 'A' . ($indice + 88) . ':D' . ($indice + 88));
            $this->sheet->setCellValue('E' . ($indice + 88), $row['estruc_4']);
            $this->cell_value_with_merge('F' . ($indice + 88), 'edificación(es)', 'F' . ($indice + 88) . ':G' . ($indice + 88));

            $this->cell_value_with_merge('A' . ($indice + 89), 'Adobe:', 'A' . ($indice + 89) . ':D' . ($indice + 89));
            $this->sheet->setCellValue('E' . ($indice + 89), $row['estruc_5']);
            $this->cell_value_with_merge('F' . ($indice + 89), 'edificación(es)', 'F' . ($indice + 89) . ':G' . ($indice + 89));

            $this->cell_value_with_merge('A' . ($indice + 90), 'Albañilería sin confinar:', 'A' . ($indice + 90) . ':D' . ($indice + 90));
            $this->sheet->setCellValue('E' . ($indice + 90), $row['estruc_6']);
            $this->cell_value_with_merge('F' . ($indice + 90), 'edificación(es)', 'F' . ($indice + 90) . ':G' . ($indice + 90));

            $this->cell_value_with_merge('A' . ($indice + 91), 'Construcciones precarias (triplay, quincha, tapial, similares):', 'A' . ($indice + 91) . ':D' . ($indice + 91));
            $this->sheet->setCellValue('E' . ($indice + 91), $row['estruc_7']);
            $this->cell_value_with_merge('F' . ($indice + 91), 'edificación(es)', 'F' . ($indice + 91) . ':G' . ($indice + 91));

            $this->cell_value_with_merge('A' . ($indice + 92), 'Aulas provisionales:', 'A' . ($indice + 92) . ':D' . ($indice + 92));
            $this->sheet->setCellValue('E' . ($indice + 92), $row['estruc_8']);
            $this->cell_value_with_merge('F' . ($indice + 92), 'edificación(es)', 'F' . ($indice + 92) . ':G' . ($indice + 92));


            $this->sheet->getStyle('A' . ($indice + 84) . ':D' . ($indice + 92))->applyFromArray($this->style_indicador);
            $this->sheet->getStyle('F' . ($indice + 84) . ':G' . ($indice + 92))->applyFromArray($this->style_contenido);


            $this->cell_value_with_merge('A' . ($indice + 93), 'INTERVENCIÓN A REALIZAR', 'A' . ($indice + 93) . ':G' . ($indice + 93));
            $this->sheet->getStyle('A' . ($indice + 93) . ':D' . ($indice + 93))->applyFromArray($this->style_subitem);

            $this->cell_value_with_merge('A' . ($indice + 94), 'Número de Edificaciones para Mantenimiento:', 'A' . ($indice + 94) . ':D' . ($indice + 94));
            $this->sheet->setCellValue('E' . ($indice + 94), $row['eman']);
            $this->cell_value_with_merge('F' . ($indice + 94), 'edificación(es)', 'F' . ($indice + 94) . ':G' . ($indice + 94));

            $this->cell_value_with_merge('A' . ($indice + 95), 'Número de Edificaciones para Reforzamiento Estructural:', 'A' . ($indice + 95) . ':D' . ($indice + 95));
            $this->sheet->setCellValue('E' . ($indice + 95), $row['ereh']);
            $this->cell_value_with_merge('F' . ($indice + 95), 'edificación(es)', 'F' . ($indice + 95) . ':G' . ($indice + 95));

            $this->cell_value_with_merge('A' . ($indice + 96), 'Número de Edificaciones para Demolición:', 'A' . ($indice + 96) . ':D' . ($indice + 96));
            $this->sheet->setCellValue('E' . ($indice + 96), $row['edem']);
            $this->cell_value_with_merge('F' . ($indice + 96), 'edificación(es)', 'F' . ($indice + 96) . ':G' . ($indice + 96));


            $this->sheet->getStyle('A' . ($indice + 93) . ':D' . ($indice + 96))->applyFromArray($this->style_indicador);
            $this->sheet->getStyle('F' . ($indice + 93) . ':G' . ($indice + 96))->applyFromArray($this->style_contenido);
        }


        ////////////////////////////////
        // SALIDA EXCEL ( Propiedades del archivo excel )
        ////////////////////////////////
        $this->sheet->setTitle("CIE 2013");
        $this->phpexcel->getProperties()
                ->setTitle("INEI - CIE2013")
                ->setDescription("CIE2013");
        header("Content-Type: application/vnd.ms-excel");
        $nombreArchivo = 'CIE2013_' . date('Y-m-d');
        header("Content-Disposition: attachment; filename=\"$nombreArchivo.xls\"");
        header("Cache-Control: max-age=0");

        // Genera Excel
        $writer = PHPExcel_IOFactory::createWriter($this->phpexcel, "Excel5");
//
        $writer->save('php://output');
        echo '1';
        exit;
    }

    public function por_ubigeo() {
        //Probando ando 
//        $nombre_fichero = base_url.'/path/to/foo.txt';
//
//        if (file_exists($nombre_fichero)) {
//            echo "El fichero $nombre_fichero existe";
//        } else {
//            echo "El fichero $nombre_fichero no existe";
//        }
        //Fin de probando ando
        ////////////////////////////////
        //Colores y Estilos
        ////////////////////////////////
        $this->set_styles();

        // pestaña
        $this->sheet = $this->phpexcel->getActiveSheet(0);

        ////////////////////////////////
        // Formato de la hoja ( Set Orientation, size and scaling )
        ////////////////////////////////
        $this->sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); // vertical
        $this->sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        // $this->sheet->getPageSetup()->setRowsToRepeatAtTop(array(1,5)); // cabecera de impresion
        $this->sheet->getDefaultStyle()->getFont()->setName('Calibri');
        $this->sheet->getDefaultStyle()->getFont()->setSize(11);
        $this->sheet->getDefaultStyle()->applyFromArray($this->alignment_general);
        $this->sheet->getSheetView()->setZoomScale(100);
        $this->sheet->getDefaultColumnDimension()->setWidth(12); //default size column
        // column width
        $this->sheet->getColumnDimension('A')->setWidth(7);
        $this->sheet->getColumnDimension('B')->setWidth(35);
        $this->sheet->getColumnDimension('C')->setWidth(13);
        $this->sheet->getColumnDimension('D')->setWidth(20);
        $this->sheet->getColumnDimension('E')->setWidth(10);
        $this->sheet->getColumnDimension('F')->setWidth(35);
        $this->sheet->getColumnDimension('G')->setWidth(20);
        $this->sheet->getColumnDimension('H')->setWidth(35);
        $this->sheet->getColumnDimension('I')->setWidth(25);
        $this->sheet->getColumnDimension('J')->setWidth(25);
        $this->sheet->getColumnDimension('K')->setWidth(25);
        $this->sheet->getColumnDimension('L')->setWidth(25);
        $this->sheet->getColumnDimension('M')->setWidth(15);
        $this->sheet->getColumnDimension('N')->setWidth(20);
        $this->sheet->getColumnDimension('O')->setWidth(15);
        $this->sheet->getColumnDimension('P')->setWidth(15);
        $this->sheet->getColumnDimension('Q')->setWidth(15);
        $this->sheet->getColumnDimension('R')->setWidth(10);
        $this->sheet->getColumnDimension('S')->setWidth(15);

        $this->sheet->getColumnDimension('AB')->setWidth(15);

        $this->sheet->getColumnDimension('AF')->setWidth(20);
        $this->sheet->getColumnDimension('AG')->setWidth(20);
        $this->sheet->getColumnDimension('AH')->setWidth(20);
        $this->sheet->getColumnDimension('AI')->setWidth(25);
        $this->sheet->getColumnDimension('AJ')->setWidth(20);

        $this->sheet->getColumnDimension('AN')->setWidth(30);
        $this->sheet->getColumnDimension('AO')->setWidth(20);
        $this->sheet->getColumnDimension('AP')->setWidth(20);
        $this->sheet->getColumnDimension('AQ')->setWidth(20);
        $this->sheet->getColumnDimension('AR')->setWidth(20);
        $this->sheet->getColumnDimension('AS')->setWidth(20);
        $this->sheet->getColumnDimension('AT')->setWidth(30);
        $this->sheet->getColumnDimension('AU')->setWidth(20);

        $this->sheet->getColumnDimension('AV')->setWidth(25);
        $this->sheet->getColumnDimension('AW')->setWidth(30);
        $this->sheet->getColumnDimension('AX')->setWidth(25);

        ////////////////////////////////
        // Logo
        ////////////////////////////////
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setWorksheet($this->sheet);
        $objDrawing->setName("inei");
        $objDrawing->setDescription("Inei");
        $objDrawing->setPath("assets/img/inei.jpeg");
        $objDrawing->setCoordinates('B1');
        $objDrawing->setHeight(75);
        $objDrawing->setOffsetX(30);
        $objDrawing->setOffsetY(4);


        ////////////////////////////////
        // Cabecera General
        ////////////////////////////////
        $this->cell_value_with_merge('B3', 'INSTITUTO NACIONAL DE ESTADÍSTICA E INFORMÁTICA', 'B3:F3');
        $this->cell_value_with_merge('B4', 'CENSO DE INFRAESTRUCTURA EDUCATIVA 2013', 'B4:F4');
        $this->sheet->getStyle('B3:F4')->applyFromArray($this->style_cabecera_general);

        ////////////////////////////////
        // Cabecera Tabla
        ////////////////////////////////
        $iHead = 8;
        $this->cell_value_with_merge('A' . $iHead, 'NRO', 'A' . $iHead . ':A' . ($iHead + 5));
        $this->sheet->getStyle('A' . $iHead . ':A' . ($iHead + 5))->applyFromArray($this->style_tabs_all);

        $this->cell_value_with_merge('B' . $iHead, 'INFORMACIÓN GENERAL', 'B' . $iHead . ':Q' . $iHead);
        $this->sheet->getStyle('B' . $iHead . ':Q' . $iHead)->applyFromArray($this->style_tabs_all);

        $this->cell_value_with_merge('B' . ($iHead + 1), 'Nombre de la Institución Educativa', 'B' . ($iHead + 1) . ':B' . ($iHead + 5));
        $this->cell_value_with_merge('C' . ($iHead + 1), 'Código del Local Escolar', 'C' . ($iHead + 1) . ':C' . ($iHead + 5));
        $this->cell_value_with_merge('D' . ($iHead + 1), 'Nivel Educativo', 'D' . ($iHead + 1) . ':D' . ($iHead + 5));
        $this->cell_value_with_merge('E' . ($iHead + 1), 'Total de Alumnos', 'E' . ($iHead + 1) . ':E' . ($iHead + 5));
        $this->cell_value_with_merge('F' . ($iHead + 1), 'Nombre del Director', 'F' . ($iHead + 1) . ':F' . ($iHead + 5));
        $this->cell_value_with_merge('G' . ($iHead + 1), 'Teléfono', 'G' . ($iHead + 1) . ':G' . ($iHead + 5));
        $this->cell_value_with_merge('H' . ($iHead + 1), 'Dirección', 'H' . ($iHead + 1) . ':H' . ($iHead + 5));
        $this->cell_value_with_merge('I' . ($iHead + 1), 'Región', 'I' . ($iHead + 1) . ':I' . ($iHead + 5));
        $this->cell_value_with_merge('J' . ($iHead + 1), 'Provincia', 'J' . ($iHead + 1) . ':J' . ($iHead + 5));
        $this->cell_value_with_merge('K' . ($iHead + 1), 'Distrito', 'K' . ($iHead + 1) . ':K' . ($iHead + 5));
        $this->cell_value_with_merge('L' . ($iHead + 1), 'Centro Poblado', 'L' . ($iHead + 1) . ':L' . ($iHead + 5));
        $this->cell_value_with_merge('M' . ($iHead + 1), 'Área', 'M' . ($iHead + 1) . ':M' . ($iHead + 5));
        $this->cell_value_with_merge('N' . ($iHead + 1), 'Propietario del Predio', 'N' . ($iHead + 1) . ':N' . ($iHead + 5));
        $this->sheet->getStyle('B' . ($iHead + 1) . ':N' . ($iHead + 5))->applyFromArray($this->style_indicador_all);

        $this->cell_value_with_merge('O' . ($iHead + 1), 'GEORREFERENCIA', 'O' . ($iHead + 1) . ':Q' . ($iHead + 1));
        $this->sheet->getStyle('O' . ($iHead + 1) . ':Q' . ($iHead + 1))->applyFromArray($this->style_subtitulo_all);
        $this->cell_value_with_merge('O' . ($iHead + 2), 'Latitud', 'O' . ($iHead + 2) . ':O' . ($iHead + 5));
        $this->cell_value_with_merge('P' . ($iHead + 2), 'Longitud', 'P' . ($iHead + 2) . ':P' . ($iHead + 5));
        $this->cell_value_with_merge('Q' . ($iHead + 2), 'Altitud', 'Q' . ($iHead + 2) . ':Q' . ($iHead + 5));
        $this->sheet->getStyle('O' . ($iHead + 2) . ':Q' . ($iHead + 5))->applyFromArray($this->style_indicador_all);



        $this->cell_value_with_merge('R' . $iHead, 'INFORMACIÓN DE LA INFRAESTRUCTURA', 'R' . $iHead . ':AX' . $iHead);
        $this->sheet->getStyle('R' . $iHead . ':AX' . $iHead)->applyFromArray($this->style_tabs_all);

        $this->cell_value_with_merge('R' . ($iHead + 1), 'NÚMERO DE PREDIOS Y EDIFICACIONES', 'R' . ($iHead + 1) . ':U' . ($iHead + 1));
        $this->sheet->getStyle('R' . ($iHead + 1) . ':U' . ($iHead + 1))->applyFromArray($this->style_subtitulo_all);
        $this->cell_value_with_merge('R' . ($iHead + 2), 'Predios', 'R' . ($iHead + 2) . ':R' . ($iHead + 5));
        $this->cell_value_with_merge('S' . ($iHead + 2), 'Edificaciones', 'S' . ($iHead + 2) . ':S' . ($iHead + 5));
        $this->cell_value_with_merge('T' . ($iHead + 2), 'Total de Pisos', 'T' . ($iHead + 2) . ':T' . ($iHead + 5));
        $this->cell_value_with_merge('U' . ($iHead + 2), 'Área del Terreno', 'U' . ($iHead + 2) . ':U' . ($iHead + 5));

        $this->cell_value_with_merge('V' . ($iHead + 1), 'OTRAS EDIFICACIONES', 'V' . ($iHead + 1) . ':Y' . ($iHead + 1));
        $this->sheet->getStyle('V' . ($iHead + 1) . ':Y' . ($iHead + 1))->applyFromArray($this->style_subtitulo_all);
        $this->cell_value_with_merge('V' . ($iHead + 2), 'Patio', 'V' . ($iHead + 2) . ':V' . ($iHead + 5));
        $this->cell_value_with_merge('W' . ($iHead + 2), 'Losa Deportiva', 'W' . ($iHead + 2) . ':W' . ($iHead + 5));
        $this->cell_value_with_merge('X' . ($iHead + 2), 'Cisterna - Tanque', 'X' . ($iHead + 2) . ':X' . ($iHead + 5));
        $this->cell_value_with_merge('Y' . ($iHead + 2), 'Muro de Contención', 'Y' . ($iHead + 2) . ':Y' . ($iHead + 5));

        $this->cell_value_with_merge('Z' . ($iHead + 1), 'SERVICIOS BÁSICOS Y COMUNICACIONES', 'Z' . ($iHead + 1) . ':AE' . ($iHead + 1));
        $this->sheet->getStyle('Z' . ($iHead + 1) . ':AE' . ($iHead + 1))->applyFromArray($this->style_subtitulo_all);
        $this->cell_value_with_merge('Z' . ($iHead + 2), 'Energía Eléctrica', 'Z' . ($iHead + 2) . ':Z' . ($iHead + 5));
        $this->cell_value_with_merge('AA' . ($iHead + 2), 'Agua Potable', 'AA' . ($iHead + 2) . ':AA' . ($iHead + 5));
        $this->cell_value_with_merge('AB' . ($iHead + 2), 'Alcantarillado', 'AB' . ($iHead + 2) . ':AB' . ($iHead + 5));
        $this->cell_value_with_merge('AC' . ($iHead + 2), 'Telefonía Fija', 'AC' . ($iHead + 2) . ':AC' . ($iHead + 5));
        $this->cell_value_with_merge('AD' . ($iHead + 2), 'Telefonía Móvil', 'AD' . ($iHead + 2) . ':AD' . ($iHead + 5));
        $this->cell_value_with_merge('AE' . ($iHead + 2), 'Internet', 'AE' . ($iHead + 2) . ':AE' . ($iHead + 5));

        $this->sheet->getStyle('R' . ($iHead + 2) . ':AE' . ($iHead + 5))->applyFromArray($this->style_indicador_all);


        $this->cell_value_with_merge('AF' . ($iHead + 1), 'ESPACIOS EDUCATIVOS QUE FUNCIONAN EN LAS EDIFICACIONES', 'AF' . ($iHead + 1) . ':AX' . ($iHead + 1));
        $this->sheet->getStyle('AF' . ($iHead + 1) . ':AX' . ($iHead + 1))->applyFromArray($this->style_subtitulo_all);

        $this->cell_value_with_merge('AF' . ($iHead + 2), 'EDIFICACIONES POR EJECUTOR DE LA OBRA', 'AF' . ($iHead + 2) . ':AJ' . ($iHead + 3));
        $this->sheet->getStyle('AF' . ($iHead + 2) . ':AJ' . ($iHead + 3))->applyFromArray($this->style_subitem_all);
        $this->cell_value_with_merge('AF' . ($iHead + 4), 'Gobierno Nacional / Proyecto Especial', 'AF' . ($iHead + 4) . ':AF' . ($iHead + 5));
        $this->cell_value_with_merge('AG' . ($iHead + 4), 'Gobierno Regional / Local', 'AG' . ($iHead + 4) . ':AG' . ($iHead + 5));
        $this->cell_value_with_merge('AH' . ($iHead + 4), 'APAFA / Autoconstrucción', 'AH' . ($iHead + 4) . ':AH' . ($iHead + 5));
        $this->cell_value_with_merge('AI' . ($iHead + 4), 'Entidades Cooperantes /  ONG\'S', 'AI' . ($iHead + 4) . ':AI' . ($iHead + 5));
        $this->cell_value_with_merge('AJ' . ($iHead + 4), 'Empresa Privada', 'AJ' . ($iHead + 4) . ':AJ' . ($iHead + 5));

        $this->cell_value_with_merge('AK' . ($iHead + 2), 'EDIFICACIONES SEGÚN AÑO DE CONSTRUCCIÓN', 'AK' . ($iHead + 2) . ':AM' . ($iHead + 3));
        $this->sheet->getStyle('AK' . ($iHead + 2) . ':AM' . ($iHead + 3))->applyFromArray($this->style_subitem_all);
        $this->cell_value_with_merge('AK' . ($iHead + 4), 'Antes y Durante 1977', 'AK' . ($iHead + 4) . ':AK' . ($iHead + 5));
        $this->cell_value_with_merge('AL' . ($iHead + 4), 'Entre 1978 Y 1998', 'AL' . ($iHead + 4) . ':AL' . ($iHead + 5));
        $this->cell_value_with_merge('AM' . ($iHead + 4), 'Después de 1998', 'AM' . ($iHead + 4) . ':AM' . ($iHead + 5));

        $this->cell_value_with_merge('AN' . ($iHead + 2), 'EDIFICACIONES SEGÚN SISTEMA ESTRUCTURAL PREDOMINANTE', 'AN' . ($iHead + 2) . ':AU' . ($iHead + 3));
        $this->sheet->getStyle('AN' . ($iHead + 2) . ':AU' . ($iHead + 3))->applyFromArray($this->style_subitem_all);
        $this->cell_value_with_merge('AN' . ($iHead + 4), 'Pórticos de concreto armado y/o muros de albañilería (dual)', 'AN' . ($iHead + 4) . ':AN' . ($iHead + 5));
        $this->cell_value_with_merge('AO' . ($iHead + 4), 'Albañilería confinada o armada', 'AO' . ($iHead + 4) . ':AO' . ($iHead + 5));
        $this->cell_value_with_merge('AP' . ($iHead + 4), 'Estructura de acero', 'AP' . ($iHead + 4) . ':AP' . ($iHead + 5));
        $this->cell_value_with_merge('AQ' . ($iHead + 4), 'Madera (normalizada)', 'AQ' . ($iHead + 4) . ':AQ' . ($iHead + 5));
        $this->cell_value_with_merge('AR' . ($iHead + 4), 'Adobe', 'AR' . ($iHead + 4) . ':AR' . ($iHead + 5));
        $this->cell_value_with_merge('AS' . ($iHead + 4), 'Albañilería sin confinar', 'AS' . ($iHead + 4) . ':AS' . ($iHead + 5));
        $this->cell_value_with_merge('AT' . ($iHead + 4), 'Construcciones precarias (triplay, quincha, tapial, similares)', 'AT' . ($iHead + 4) . ':AT' . ($iHead + 5));
        $this->cell_value_with_merge('AU' . ($iHead + 4), 'Aulas provisionales', 'AU' . ($iHead + 4) . ':AU' . ($iHead + 5));

        $this->cell_value_with_merge('AV' . ($iHead + 2), 'INTERVENCIÓN A REALIZAR', 'AV' . ($iHead + 2) . ':AX' . ($iHead + 3));
        $this->sheet->getStyle('AV' . ($iHead + 2) . ':AX' . ($iHead + 3))->applyFromArray($this->style_subitem_all);
        $this->cell_value_with_merge('AV' . ($iHead + 4), 'Número de Edificaciones para Mantenimiento', 'AV' . ($iHead + 4) . ':AV' . ($iHead + 5));
        $this->cell_value_with_merge('AW' . ($iHead + 4), 'Número de Edificaciones para Reforzamiento Estructural', 'AW' . ($iHead + 4) . ':AW' . ($iHead + 5));
        $this->cell_value_with_merge('AX' . ($iHead + 4), 'Número de Edificaciones para Demolición', 'AX' . ($iHead + 4) . ':AX' . ($iHead + 5));

        $this->sheet->getStyle('AF' . ($iHead + 4) . ':AX' . ($iHead + 5))->applyFromArray($this->style_indicador_all);

        $this->sheet->getStyle('A' . $iHead . ':AX' . ($iHead + 5))->applyFromArray($this->marco);



        // Genera Excel
        ////////////////////////////////
        // Cuerpo
        ////////////////////////////////
        $_REQUEST['searchColegio'] = trim($_GET['searchColegio']);
        $_REQUEST['searchCodigo'] = $_GET['searchCodigo'];
        $_REQUEST['depa'] = $_GET['depa'];
        $_REQUEST['prov'] = $_GET['prov'];
        $_REQUEST['dist'] = $_GET['dist'];


        // $_REQUEST['searchColegio'] = '';
        // $_REQUEST['searchCodigo'] = '';
        // $_REQUEST['depa'] = '01';
        // $_REQUEST['prov'] = '01';
        // $_REQUEST['dist'] = '01';

        $indice = 14; //fila inicial
        $nro = 0;
        $query = $this->modellocalresumen->getIESearch($_REQUEST);

        $parametros = 'Resultados por ';
        $departamento = '';
        $provincia = '';
        $distrito = '';
        $ubigeo_total = '';

        foreach ($query as $key => $row) {

            $departamento = strtoupper($row['dpto_nombre']);
            $provincia = strtoupper($row['prov_nombre']);
            $distrito = strtoupper($row['dist_nombre']);

            $this->sheet->setCellValue('A' . $indice, ++$nro);
            $this->sheet->setCellValue('B' . $indice, strtoupper($row['nombres_IIEE']));
            $this->sheet->getCellByColumnAndRow(2, $indice)->setValueExplicit($row['codigo_de_local'], PHPExcel_Cell_DataType::TYPE_STRING);
            $this->sheet->setCellValue('D' . $indice, strtoupper($row['nivel']));
            $this->sheet->setCellValue('E' . $indice, $row['Talum']);
            $this->sheet->setCellValue('F' . $indice, strtoupper($row['Director_IIEE']));
            $this->sheet->setCellValue('G' . $indice, $row['tel_IE']);
            $this->sheet->setCellValue('H' . $indice, strtoupper($row['direcc_IE']));
            $this->sheet->setCellValue('I' . $indice, $departamento);
            $this->sheet->setCellValue('J' . $indice, $provincia);
            $this->sheet->setCellValue('K' . $indice, $distrito);
            $this->sheet->setCellValue('L' . $indice, strtoupper($row['centroPoblado']));
            $this->sheet->setCellValue('M' . $indice, strtoupper($row['des_area']));
            $this->sheet->setCellValue('N' . $indice, strtoupper($row['prop_IE']));
            $this->sheet->setCellValue('O' . $indice, $row['LatitudPunto_UltP']);
            $this->sheet->setCellValue('P' . $indice, $row['LongitudPunto_UltP']);
            $this->sheet->setCellValue('Q' . $indice, $row['AltitudPunto_UltP']);
            $this->sheet->setCellValue('R' . $indice, $row['cPred']);
            $this->sheet->setCellValue('S' . $indice, $row['cEdif']);
            $this->sheet->setCellValue('T' . $indice, $row['Piso']);
            $this->sheet->setCellValue('U' . $indice, $row['P1_B_3_9_At_Local']);
            $this->sheet->setCellValue('V' . $indice, $row['P']);
            $this->sheet->setCellValue('W' . $indice, $row['LD']);
            $this->sheet->setCellValue('X' . $indice, $row['CTE']);
            $this->sheet->setCellValue('Y' . $indice, $row['MC']);
            $this->sheet->setCellValue('Z' . $indice, ( $row['P2_C_2LocE_1_Energ'] == 1) ? 'TIENE' : 'NO TIENE' );
            $this->sheet->setCellValue('AA' . $indice, ( $row['P2_C_2LocE_2_Agua'] == 1) ? 'TIENE' : 'NO TIENE' );
            $this->sheet->setCellValue('AB' . $indice, ( $row['P2_C_2LocE_3_Alc'] == 1) ? 'TIENE' : 'NO TIENE' );
            $this->sheet->setCellValue('AC' . $indice, ( $row['P2_C_2LocE_4_Tfija'] == 1) ? 'TIENE' : 'NO TIENE' );
            $this->sheet->setCellValue('AD' . $indice, ( $row['P2_C_2LocE_5_Tmov'] == 1) ? 'TIENE' : 'NO TIENE' );
            $this->sheet->setCellValue('AE' . $indice, ( $row['P2_C_2LocE_6_Int'] == 1) ? 'TIENE' : 'NO TIENE' );
            $this->sheet->setCellValue('AF' . $indice, $row['eo_1']);
            $this->sheet->setCellValue('AG' . $indice, $row['eo_2']);
            $this->sheet->setCellValue('AH' . $indice, $row['eo_3']);
            $this->sheet->setCellValue('AI' . $indice, $row['eo_4']);
            $this->sheet->setCellValue('AJ' . $indice, $row['eo_5']);
            $this->sheet->setCellValue('AK' . $indice, $row['a_1']);
            $this->sheet->setCellValue('AL' . $indice, $row['a_2']);
            $this->sheet->setCellValue('AM' . $indice, $row['a_3']);
            $this->sheet->setCellValue('AN' . $indice, $row['estruc_1']);
            $this->sheet->setCellValue('AO' . $indice, $row['estruc_2']);
            $this->sheet->setCellValue('AP' . $indice, $row['estruc_3']);
            $this->sheet->setCellValue('AQ' . $indice, $row['estruc_4']);
            $this->sheet->setCellValue('AR' . $indice, $row['estruc_5']);
            $this->sheet->setCellValue('AS' . $indice, $row['estruc_6']);
            $this->sheet->setCellValue('AT' . $indice, $row['estruc_7']);
            $this->sheet->setCellValue('AU' . $indice, $row['estruc_8']);
            $this->sheet->setCellValue('AV' . $indice, $row['eman']);
            $this->sheet->setCellValue('AW' . $indice, $row['ereh']);
            $this->sheet->setCellValue('AX' . $indice, $row['edem']);

            if ($indice % 2 != 0) {
                $this->sheet->getStyle('A' . $indice . ':AX' . $indice)->applyFromArray($this->style_impar);
            }
            $this->sheet->getStyle('A' . $indice . ':AX' . $indice)->applyFromArray($this->style_contenido_all);

            $indice++;
        }

        $this->sheet->getStyle('Q' . $iHead . ':Q' . ($indice - 1))->applyFromArray($this->divisoria);

        // filtro de busqueda
        if ($_REQUEST['searchColegio'] != '') {
            $parametros .= ' Institución Educativa: ' . strtoupper($_REQUEST['searchColegio']) . '  - ';
            $ubigeo_total .= '';
        }
        if ($_REQUEST['searchCodigo'] != '') {
            $parametros .= '  Código de Local: ' . $_REQUEST['searchCodigo'] . '  - ';
        }
        if ($_REQUEST['depa'] != '') {
            $parametros .= '  Región: ' . $departamento . '  - ';
        }
        if ($_REQUEST['prov'] != '') {
            $parametros .= '  Provincia: ' . $provincia . '  - ';
        }
        if ($_REQUEST['dist'] != '') {
            $parametros .= '  Distrito: ' . $distrito;
        }

        $this->cell_value_with_merge('B6', $parametros, 'B6:G6');
        $this->cell_value_with_merge('H6', 'Total de Resultados: ' . $nro . ' registros', 'H6:H6');
        $this->sheet->getStyle('B6:H6')->applyFromArray($this->style_filter);



        ////////////////////////////////
        // SALIDA EXCEL ( Propiedades del archivo excel )
        ////////////////////////////////
        $this->sheet->setTitle("CIE 2013");
        $this->phpexcel->getProperties()
                ->setTitle("INEI - CIE2013")
                ->setDescription("CIE2013");
        header('Content-Type: application/vnd.ms-excel');
        $nombreArchivo = 'CIE2013_' . $departamento.'_';
        header("Content-Disposition: attachment; filename=\"$nombreArchivo.xls\"");
        header("Cache-Control: max-age=0");

        // Genera Excel
        $writer = PHPExcel_IOFactory::createWriter($this->phpexcel, "Excel5");
//        
        $writer->save('php://output');
        echo '1';
        exit;
    }

    function cell_value_with_merge($cell, $content, $merge) {
        $this->sheet->setCellValue($cell, $content);
        $this->sheet->mergeCells($merge);
    }

}

?>