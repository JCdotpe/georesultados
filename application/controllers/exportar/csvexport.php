<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Csvexport extends CI_Controller
{
	private $sheet;
	
	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
		$this->load->model('export_model');
		$this->load->model('modellocalresumen');

		ini_set("memory_limit","128M");
	}

	public function index()
	{
		echo 'hola';
	}

	public function por_codigo()
	{

		$idCodigo = $_GET['idCodigo'];

		////////////////////////////////
		//Colores y Estilos
		////////////////////////////////
		$alignment_general = array(
			'alignment' => array(
				'wrap' => true,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
		);

		$style_cabecera_general = array(
			'font' => array(
				'bold' => true,
				'size' => 13
			)
		);

		$style_tabs  = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'BFBFBF')
			),
			'font' => array(
				'bold' => true,
				'size' => 12
			)
		);

		$style_subtitulo  = array(
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

		$style_subitem  = array(
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
		

		$style_indicador = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			),
			'font' => array(
				'bold' => true
			)
		);

		$style_contenido = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			),
		);

			

		// pestaña
		$sheet = $this->phpexcel->getActiveSheet(0);

		////////////////////////////////
		// Formato de la hoja ( Set Orientation, size and scaling )
		////////////////////////////////
		$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);// horizontal
		$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$sheet->getPageSetup()->setRowsToRepeatAtTop(array(1,5)); // cabecera de impresion
		// $sheet->getPageSetup()->setFitToPage(false); // ajustar pagina
		// $sheet->getPageSetup()->setFitToWidth(1);
		// $sheet->getPageSetup()->setFitToHeight(0);
		$sheet->getDefaultStyle()->getFont()->setName('Calibri');
		$sheet->getDefaultStyle()->getFont()->setSize(11);
		$sheet->getDefaultStyle()->applyFromArray($alignment_general);
		$sheet->getSheetView()->setZoomScale(100);
		$sheet->getDefaultColumnDimension()->setWidth(12); //default size column


		////////////////////////////////
		// Logo
		////////////////////////////////
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($sheet);
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
		$sheet->setCellValue('C3','INSTITUTO NACIONAL DE ESTADÍSTICA E INFORMÁTICA');
			$sheet->mergeCells('C3:G3');
		$sheet->setCellValue('C4','CENSO DE INFRAESTRUCTURA EDUCATIVA 2013');
			$sheet->mergeCells('C4:G4');
			$sheet->getStyle('C3:G4')->applyFromArray($style_cabecera_general);


		////////////////////////////////
		// Cuerpo
		////////////////////////////////

		$indice = 6; //fila inicial

		$sql = "SELECT * FROM Local_Resumen WHERE codigo_de_local = '".$idCodigo."' and pc_c_2_Rfinal_resul = 1";
		$query = $this->convert_utf8->convert_result( $this->export_model->only_query( $sql ) );

		foreach ($query as $key => $row)
		{
			$nombre_ie = $row['nombres_IIEE'];

			////////////////////////////////
			// Información General
			////////////////////////////////

			$sheet->setCellValue('A'.$indice,'INFORMACIÓN GENERAL DE LA '.$nombre_ie);
			$sheet->mergeCells('A'.$indice.':G'.($indice+1));
			$sheet->getStyle('A'.$indice.':G'.($indice+1))->applyFromArray($style_tabs);

			$sheet->setCellValue('A'.($indice+2),'INFORMACIÓN DEL LOCAL ESCOLAR');
				$sheet->mergeCells('A'.($indice+2).':G'.($indice+2));
				$sheet->getStyle('A'.($indice+2).':G'.($indice+2))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+3),'Nombre de la I.E:');
				$sheet->mergeCells('A'.($indice+3).':B'.($indice+3));
				$sheet->getStyle('A'.($indice+3).':B'.($indice+3))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+3),$nombre_ie);
				$sheet->mergeCells('C'.($indice+3).':G'.($indice+3));
				$sheet->getStyle('C'.($indice+3).':G'.($indice+3))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+4),'Código del Local:');
				$sheet->mergeCells('A'.($indice+4).':B'.($indice+4));
				$sheet->getStyle('A'.($indice+4).':B'.($indice+4))->applyFromArray($style_indicador);
			$sheet->getCellByColumnAndRow(2, ($indice+4))->setValueExplicit($row['codigo_de_local'],PHPExcel_Cell_DataType::TYPE_STRING);
				$sheet->mergeCells('C'.($indice+4).':G'.($indice+4));
				$sheet->getStyle('C'.($indice+4).':G'.($indice+4))->applyFromArray($style_contenido);
				
			$sheet->setCellValue('A'.($indice+5),'Nivel Educativo:');
				$sheet->mergeCells('A'.($indice+5).':B'.($indice+5));
				$sheet->getStyle('A'.($indice+5).':B'.($indice+5))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+5),$row['nivel']);
				$sheet->mergeCells('C'.($indice+5).':G'.($indice+5));
				$sheet->getStyle('C'.($indice+5).':G'.($indice+5))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+6),'Total de Alumnos:');
				$sheet->mergeCells('A'.($indice+6).':B'.($indice+6));
				$sheet->getStyle('A'.($indice+6).':B'.($indice+6))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+6),$row['Talum'].' alumnos');
				$sheet->mergeCells('C'.($indice+6).':G'.($indice+6));
				$sheet->getStyle('C'.($indice+6).':G'.($indice+6))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+8),'Nombre del Director:');
				$sheet->mergeCells('A'.($indice+8).':B'.($indice+8));
				$sheet->getStyle('A'.($indice+8).':B'.($indice+8))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+8),$row['Director_IIEE']);
				$sheet->mergeCells('C'.($indice+8).':G'.($indice+8));
				$sheet->getStyle('C'.($indice+8).':G'.($indice+8))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+9),'Teléfono:');
				$sheet->mergeCells('A'.($indice+9).':B'.($indice+9));
				$sheet->getStyle('A'.($indice+9).':B'.($indice+9))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+9),$row['tel_IE']);
				$sheet->mergeCells('C'.($indice+9).':G'.($indice+9));
				$sheet->getStyle('C'.($indice+9).':G'.($indice+9))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+10),'Dirección:');
				$sheet->mergeCells('A'.($indice+10).':B'.($indice+10));
				$sheet->getStyle('A'.($indice+10).':B'.($indice+10))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+10),$row['direcc_IE']);
				$sheet->mergeCells('C'.($indice+10).':G'.($indice+10));
				$sheet->getStyle('C'.($indice+10).':G'.($indice+10))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+12),'Departamento:');
				$sheet->mergeCells('A'.($indice+12).':B'.($indice+12));
				$sheet->getStyle('A'.($indice+12).':B'.($indice+12))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+12),$row['dpto_nombre']);
				$sheet->mergeCells('C'.($indice+12).':G'.($indice+12));
				$sheet->getStyle('C'.($indice+12).':G'.($indice+12))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+13),'Provincia:');
				$sheet->mergeCells('A'.($indice+13).':B'.($indice+13));
				$sheet->getStyle('A'.($indice+13).':B'.($indice+13))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+13),$row['prov_nombre']);
				$sheet->mergeCells('C'.($indice+13).':G'.($indice+13));
				$sheet->getStyle('C'.($indice+13).':G'.($indice+13))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+14),'Distrito:');
				$sheet->mergeCells('A'.($indice+14).':B'.($indice+14));
				$sheet->getStyle('A'.($indice+14).':B'.($indice+14))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+14),$row['dist_nombre']);
				$sheet->mergeCells('C'.($indice+14).':G'.($indice+14));
				$sheet->getStyle('C'.($indice+14).':G'.($indice+14))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+15),'Centro Poblado:');
				$sheet->mergeCells('A'.($indice+15).':B'.($indice+15));
				$sheet->getStyle('A'.($indice+15).':B'.($indice+15))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+15),$row['centroPoblado']);
				$sheet->mergeCells('C'.($indice+15).':G'.($indice+15));
				$sheet->getStyle('C'.($indice+15).':G'.($indice+15))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+16),'Área Urbana o Rural:');
				$sheet->mergeCells('A'.($indice+16).':B'.($indice+16));
				$sheet->getStyle('A'.($indice+16).':B'.($indice+16))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+16),$row['des_area']);
				$sheet->mergeCells('C'.($indice+16).':G'.($indice+16));
				$sheet->getStyle('C'.($indice+16).':G'.($indice+16))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+18),'Propietario Local:');
				$sheet->mergeCells('A'.($indice+18).':B'.($indice+18));
				$sheet->getStyle('A'.($indice+18).':B'.($indice+18))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+18),$row['prop_IE']);
				$sheet->mergeCells('C'.($indice+18).':G'.($indice+18));
				$sheet->getStyle('C'.($indice+18).':G'.($indice+18))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+20),'Georeferencia:');
				$sheet->mergeCells('A'.($indice+20).':B'.($indice+20));
				$sheet->getStyle('A'.($indice+20).':B'.($indice+20))->applyFromArray($style_indicador);
			
			$sheet->setCellValue('B'.($indice+21),'Latitud:');
				$sheet->getStyle('B'.($indice+21))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+21),$row['LatitudPunto_UltP']);
				$sheet->getStyle('C'.($indice+21))->applyFromArray($style_contenido);
			
			$sheet->setCellValue('D'.($indice+21),'Longitud:');
				$sheet->getStyle('D'.($indice+21))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+21),$row['LongitudPunto_UltP']);
				$sheet->getStyle('E'.($indice+21))->applyFromArray($style_contenido);

			$sheet->setCellValue('F'.($indice+21),'Altitud:');
				$sheet->getStyle('F'.($indice+21))->applyFromArray($style_indicador);
			$sheet->setCellValue('G'.($indice+21),$row['AltitudPunto_UltP']);
				$sheet->getStyle('G'.($indice+21))->applyFromArray($style_contenido);

			////////////////////////////////
			// Imagen de Local
			////////////////////////////////
			$ruta_foto = ( $row['RutaFoto'] == null ) ? 'imagen-no-disponible.jpg' : $row['RutaFoto'];
			$url_external = 'http://www.jc.pe/portafolio/cie/cap3/'.$ruta_foto;
			$array_foto = explode("/", $ruta_foto);
			$name_foto = array_pop($array_foto); // quito y le asigno el valor del ultimo indice del array.
			$img = 'assets/img/temporal/'.$name_foto;

			///////// proxy ////////
			$aContext = array(
				'http' => array(
					'proxy' => 'tcp://172.16.100.1:3128',
					'request_fulluri' => true,
				),
			);
			$cxContext = stream_context_create($aContext);
			$get_url = file_get_contents($url_external, false, $cxContext);
			// $get_url = file_get_contents($url_external); // sin proxy
			$get_img = file_put_contents($img, $get_url);

			$objDrawing2 = new PHPExcel_Worksheet_Drawing();
			$objDrawing2->setWorksheet($sheet);
			$objDrawing2->setName("Imagen_I.E.");
			$objDrawing2->setDescription("Imagen de la IE");
			$objDrawing2->setPath($img);
			$objDrawing2->setCoordinates('A'.($indice+23));
			$objDrawing2->setHeight(430);
			$objDrawing2->setOffsetX(8);
			$objDrawing2->setOffsetY(5);


			///////////////////////////////////////////
			// Información de la Infraestructura page 2
			///////////////////////////////////////////

			$sheet->setCellValue('A'.($indice+45),'INFORMACIÓN DE LA INFRAESTRUCTURA DE LA '.$nombre_ie);
				$sheet->mergeCells('A'.($indice+45).':G'.($indice+46));
				$sheet->getStyle('A'.($indice+45).':G'.($indice+46))->applyFromArray($style_tabs);


			$sheet->setCellValue('A'.($indice+47),'NÚMERO PREDIOS Y EDIFICACIONES');
				$sheet->mergeCells('A'.($indice+47).':G'.($indice+47));
				$sheet->getStyle('A'.($indice+47).':G'.($indice+47))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+48),'Predios:');
				$sheet->mergeCells('A'.($indice+48).':B'.($indice+48));
				$sheet->getStyle('A'.($indice+48).':B'.($indice+48))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+48),$row['cPred']);
			$sheet->setCellValue('D'.($indice+48),'predio(s)');
				$sheet->mergeCells('D'.($indice+48).':E'.($indice+48));
				$sheet->getStyle('D'.($indice+48).':E'.($indice+48))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+49),'Edificaciones:');
				$sheet->mergeCells('A'.($indice+49).':B'.($indice+49));
				$sheet->getStyle('A'.($indice+49).':B'.($indice+49))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+49),$row['cEdif']);
			$sheet->setCellValue('D'.($indice+49),'edificación(es)');
				$sheet->mergeCells('D'.($indice+49).':E'.($indice+49));
				$sheet->getStyle('D'.($indice+49).':E'.($indice+49))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+50),'Total de Pisos:');
				$sheet->mergeCells('A'.($indice+50).':B'.($indice+50));
				$sheet->getStyle('A'.($indice+50).':B'.($indice+50))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+50),$row['Piso']);
			$sheet->setCellValue('D'.($indice+50),'piso(s)');
				$sheet->mergeCells('D'.($indice+50).':E'.($indice+50));
				$sheet->getStyle('D'.($indice+50).':E'.($indice+50))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+51),'Área del Terreno:');
				$sheet->mergeCells('A'.($indice+51).':B'.($indice+51));
				$sheet->getStyle('A'.($indice+51).':B'.($indice+51))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+51),$row['P1_B_3_9_At_Local']);
			$sheet->setCellValue('D'.($indice+51),'m2');
				$sheet->mergeCells('D'.($indice+51).':E'.($indice+51));
				$sheet->getStyle('D'.($indice+51).':E'.($indice+51))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+53),'OTRAS EDIFICACIONES');
				$sheet->mergeCells('A'.($indice+53).':G'.($indice+53));
				$sheet->getStyle('A'.($indice+53).':G'.($indice+53))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+54),'Patio:');
				$sheet->mergeCells('A'.($indice+54).':B'.($indice+54));
				$sheet->getStyle('A'.($indice+54).':B'.($indice+54))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+54),$row['P']);
			$sheet->setCellValue('D'.($indice+54),'patio(s)');
				$sheet->mergeCells('D'.($indice+54).':E'.($indice+54));
				$sheet->getStyle('D'.($indice+54).':E'.($indice+54))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+55),'Losa Deportiva:');
				$sheet->mergeCells('A'.($indice+55).':B'.($indice+55));
				$sheet->getStyle('A'.($indice+55).':B'.($indice+55))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+55),$row['LD']);
			$sheet->setCellValue('D'.($indice+55),'losa(s) deportiva(s)');
				$sheet->mergeCells('D'.($indice+55).':E'.($indice+55));
				$sheet->getStyle('D'.($indice+55).':E'.($indice+55))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+56),'Cisterna - Tanque:');
				$sheet->mergeCells('A'.($indice+56).':B'.($indice+56));
				$sheet->getStyle('A'.($indice+56).':B'.($indice+56))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+56),$row['CTE']);
			$sheet->setCellValue('D'.($indice+56),'cistena(s) - tanque(s)');
				$sheet->mergeCells('D'.($indice+56).':E'.($indice+56));
				$sheet->getStyle('D'.($indice+56).':E'.($indice+56))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+57),'Muro de Contención:');
				$sheet->mergeCells('A'.($indice+57).':B'.($indice+57));
				$sheet->getStyle('A'.($indice+57).':B'.($indice+57))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+57),$row['MC']);
			$sheet->setCellValue('D'.($indice+57),'muro(s) de contención(es)');
				$sheet->mergeCells('D'.($indice+57).':F'.($indice+57));
				$sheet->getStyle('D'.($indice+57).':F'.($indice+57))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+59),'SERVICIOS BÁSICOS Y COMUNICACIONES');
				$sheet->mergeCells('A'.($indice+59).':G'.($indice+59));
				$sheet->getStyle('A'.($indice+59).':G'.($indice+59))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+60),'Energía Eléctrica:');
				$sheet->mergeCells('A'.($indice+60).':B'.($indice+60));
				$sheet->getStyle('A'.($indice+60).':B'.($indice+60))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+60), ( $row['P2_C_2LocE_1_Energ'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+61),'Agua Potable:');
				$sheet->mergeCells('A'.($indice+61).':B'.($indice+61));
				$sheet->getStyle('A'.($indice+61).':B'.($indice+61))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+61), ( $row['P2_C_2LocE_2_Agua'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+62),'Alcantarillado:');
				$sheet->mergeCells('A'.($indice+62).':B'.($indice+62));
				$sheet->getStyle('A'.($indice+62).':B'.($indice+62))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+62), ( $row['P2_C_2LocE_3_Alc'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+63),'Telefonía Fija:');
				$sheet->mergeCells('A'.($indice+63).':B'.($indice+63));
				$sheet->getStyle('A'.($indice+63).':B'.($indice+63))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+63), ( $row['P2_C_2LocE_4_Tfija'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+64),'Telefonía Móvil:');
				$sheet->mergeCells('A'.($indice+64).':B'.($indice+64));
				$sheet->getStyle('A'.($indice+64).':B'.($indice+64))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+64), ( $row['P2_C_2LocE_5_Tmov'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+65),'Internet:');
				$sheet->mergeCells('A'.($indice+65).':B'.($indice+65));
				$sheet->getStyle('A'.($indice+65).':B'.($indice+65))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+65), ( $row['P2_C_2LocE_6_Int'] == 1) ? 'TIENE' : 'NO TIENE' );
			

			$sheet->setCellValue('A'.($indice+67),'ESPACIOS EDUCATIVOS QUE FUNCIONAN EN LAS EDIFICACIONES');
				$sheet->mergeCells('A'.($indice+67).':G'.($indice+67));
				$sheet->getStyle('A'.($indice+67).':G'.($indice+67))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+68),'Aula Común:');
				$sheet->mergeCells('A'.($indice+68).':B'.($indice+68));
				$sheet->getStyle('A'.($indice+68).':B'.($indice+68))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+68),$row['e_1']);
			$sheet->setCellValue('D'.($indice+68),'aula(s)');
				$sheet->mergeCells('D'.($indice+68).':E'.($indice+68));
				$sheet->getStyle('D'.($indice+68).':E'.($indice+68))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+69),'Pedagógico:');
				$sheet->mergeCells('A'.($indice+69).':B'.($indice+69));
				$sheet->getStyle('A'.($indice+69).':B'.($indice+69))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+69),$row['e_2']);
			$sheet->setCellValue('D'.($indice+69),'espacio(s) pedagógico(s)');
				$sheet->mergeCells('D'.($indice+69).':E'.($indice+69));
				$sheet->getStyle('D'.($indice+69).':E'.($indice+69))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+70),'Administrativo:');
				$sheet->mergeCells('A'.($indice+70).':B'.($indice+70));
				$sheet->getStyle('A'.($indice+70).':B'.($indice+70))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+70),$row['e_3']);
			$sheet->setCellValue('D'.($indice+70),'espacio(s) administrativo(s)');
				$sheet->mergeCells('D'.($indice+70).':E'.($indice+70));
				$sheet->getStyle('D'.($indice+70).':E'.($indice+70))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+71),'Complementario:');
				$sheet->mergeCells('A'.($indice+71).':B'.($indice+71));
				$sheet->getStyle('A'.($indice+71).':B'.($indice+71))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+71),$row['e_4']);
			$sheet->setCellValue('D'.($indice+71),'espacio(s) complementario(s)');
				$sheet->mergeCells('D'.($indice+71).':E'.($indice+71));
				$sheet->getStyle('D'.($indice+71).':E'.($indice+71))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+72),'Servicios:');
				$sheet->mergeCells('A'.($indice+72).':B'.($indice+72));
				$sheet->getStyle('A'.($indice+72).':B'.($indice+72))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+72),$row['e_5']);
			$sheet->setCellValue('D'.($indice+72),'servicio(s)');
				$sheet->mergeCells('D'.($indice+72).':E'.($indice+72));
				$sheet->getStyle('D'.($indice+72).':E'.($indice+72))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+74),'CARACTERÍSTICAS DE LAS EDIFACIONES');
				$sheet->mergeCells('A'.($indice+74).':G'.($indice+74));
				$sheet->getStyle('A'.($indice+74).':G'.($indice+74))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+75),'EDIFICACIONES POR EJECUTOR DE LA OBRA');
				$sheet->mergeCells('A'.($indice+75).':D'.($indice+75));
				$sheet->getStyle('A'.($indice+75).':D'.($indice+75))->applyFromArray($style_subitem);

			$sheet->setCellValue('A'.($indice+76),'Gobierno Nacional / Proyecto Especial:');
				$sheet->mergeCells('A'.($indice+76).':D'.($indice+76));
				$sheet->getStyle('A'.($indice+76).':D'.($indice+76))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+76),$row['eo_1']);
			$sheet->setCellValue('F'.($indice+76),'edificación(es)');
				$sheet->mergeCells('F'.($indice+76).':G'.($indice+76));
				$sheet->getStyle('F'.($indice+76).':G'.($indice+76))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+77),'Gobierno Regional / Local:');
				$sheet->mergeCells('A'.($indice+77).':D'.($indice+77));
				$sheet->getStyle('A'.($indice+77).':D'.($indice+77))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+77),$row['eo_2']);
			$sheet->setCellValue('F'.($indice+77),'edificación(es)');
				$sheet->mergeCells('F'.($indice+77).':G'.($indice+77));
				$sheet->getStyle('F'.($indice+77).':G'.($indice+77))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+78),'APAFA / Autoconstrucción:');
				$sheet->mergeCells('A'.($indice+78).':D'.($indice+78));
				$sheet->getStyle('A'.($indice+78).':D'.($indice+78))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+78),$row['eo_3']);
			$sheet->setCellValue('F'.($indice+78),'edificación(es)');
				$sheet->mergeCells('F'.($indice+78).':G'.($indice+78));
				$sheet->getStyle('F'.($indice+78).':G'.($indice+78))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+79),"Entidades Cooperantes /  ONG'S:");
				$sheet->mergeCells('A'.($indice+79).':D'.($indice+79));
				$sheet->getStyle('A'.($indice+79).':D'.($indice+79))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+79),$row['eo_4']);
			$sheet->setCellValue('F'.($indice+79),'edificación(es)');
				$sheet->mergeCells('F'.($indice+79).':G'.($indice+79));
				$sheet->getStyle('F'.($indice+79).':G'.($indice+79))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+80),"Empresa Privada:");
				$sheet->mergeCells('A'.($indice+80).':D'.($indice+80));
				$sheet->getStyle('A'.($indice+80).':D'.($indice+80))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+80),$row['eo_5']);
			$sheet->setCellValue('F'.($indice+80),'edificación(es)');
				$sheet->mergeCells('F'.($indice+80).':G'.($indice+80));
				$sheet->getStyle('F'.($indice+80).':G'.($indice+80))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+81),'EDIFICACIONES SEGÚN AÑO DE CONSTRUCCIÓN');
				$sheet->mergeCells('A'.($indice+81).':D'.($indice+81));
				$sheet->getStyle('A'.($indice+81).':D'.($indice+81))->applyFromArray($style_subitem);

			$sheet->setCellValue('A'.($indice+82),'Antes y Durante 1977:');
				$sheet->mergeCells('A'.($indice+82).':D'.($indice+82));
				$sheet->getStyle('A'.($indice+82).':D'.($indice+82))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+82),$row['a_1']);
			$sheet->setCellValue('F'.($indice+82),'edificación(es)');
				$sheet->mergeCells('F'.($indice+82).':G'.($indice+82));
				$sheet->getStyle('F'.($indice+82).':G'.($indice+82))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+83),'Entre 1978 Y 1998:');
				$sheet->mergeCells('A'.($indice+83).':D'.($indice+83));
				$sheet->getStyle('A'.($indice+83).':D'.($indice+83))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+83),$row['a_2']);
			$sheet->setCellValue('F'.($indice+83),'edificación(es)');
				$sheet->mergeCells('F'.($indice+83).':G'.($indice+83));
				$sheet->getStyle('F'.($indice+83).':G'.($indice+83))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+84),'Después de 1998:');
				$sheet->mergeCells('A'.($indice+84).':D'.($indice+84));
				$sheet->getStyle('A'.($indice+84).':D'.($indice+84))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+84),$row['a_3']);
			$sheet->setCellValue('F'.($indice+84),'edificación(es)');
				$sheet->mergeCells('F'.($indice+84).':G'.($indice+84));
				$sheet->getStyle('F'.($indice+84).':G'.($indice+84))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+85),'INTERVENCIÓN A REALIZAR');
				$sheet->mergeCells('A'.($indice+85).':D'.($indice+85));
				$sheet->getStyle('A'.($indice+85).':D'.($indice+85))->applyFromArray($style_subitem);

			$sheet->setCellValue('A'.($indice+86),'Número de Edificaciones para Mantenimiento::');
				$sheet->mergeCells('A'.($indice+86).':D'.($indice+86));
				$sheet->getStyle('A'.($indice+86).':D'.($indice+86))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+86),$row['eman']);
			$sheet->setCellValue('F'.($indice+86),'edificación(es)');
				$sheet->mergeCells('F'.($indice+86).':G'.($indice+86));
				$sheet->getStyle('F'.($indice+86).':G'.($indice+86))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+87),'Número de Edificaciones para Reforzamiento Estructural:');
				$sheet->mergeCells('A'.($indice+87).':D'.($indice+87));
				$sheet->getStyle('A'.($indice+87).':D'.($indice+87))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+87),$row['ereh']);
			$sheet->setCellValue('F'.($indice+87),'edificación(es)');
				$sheet->mergeCells('F'.($indice+87).':G'.($indice+87));
				$sheet->getStyle('F'.($indice+87).':G'.($indice+87))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+88),'Número de Edificaciones para Demolición:');
				$sheet->mergeCells('A'.($indice+88).':D'.($indice+88));
				$sheet->getStyle('A'.($indice+88).':D'.($indice+88))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+88),$row['edem']);
			$sheet->setCellValue('F'.($indice+88),'edificación(es)');
				$sheet->mergeCells('F'.($indice+88).':G'.($indice+88));
				$sheet->getStyle('F'.($indice+88).':G'.($indice+88))->applyFromArray($style_contenido);

		}


		////////////////////////////////
		// SALIDA EXCEL ( Propiedades del archivo excel )
		////////////////////////////////
		$sheet->setTitle("CIE 2013");
		$this->phpexcel->getProperties()
		->setTitle("INEI - CIE2013")
		->setDescription("CIE2013");
		header("Content-Type: application/vnd.ms-excel");
		$nombreArchivo = 'CIE2013_'.date('Y-m-d');
		header("Content-Disposition: attachment; filename=\"$nombreArchivo.xls\""); 
		header("Cache-Control: max-age=0");
		
		// Genera Excel
		$writer = PHPExcel_IOFactory::createWriter($this->phpexcel, "Excel5");

		$writer->save('php://output');
		exit;

	}

	public function por_ubigeo()
	{
		////////////////////////////////
		//Colores y Estilos
		////////////////////////////////
		$alignment_general = array(
			'alignment' => array(
				'wrap' => true,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
		);

		$style_cabecera_general = array(
			'font' => array(
				'bold' => true,
				'size' => 13
			)
		);

		$style_tabs  = array(
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

		$style_subtitulo  = array(
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

		$style_subitem  = array(
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

		$style_indicador = array(
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

		$marco = array(
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

		$divisoria = array(
			'borders' => array(
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
					'color' => array('rgb' => '4F81BD')
				)
			)
		);

		$style_contenido = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$style_impar = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'DAEEF3')
			)
		);

		// pestaña
		$this->sheet = $this->phpexcel->getActiveSheet(0);

		////////////////////////////////
		// Formato de la hoja ( Set Orientation, size and scaling )
		////////////////////////////////
		$this->sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);// vertical
		$this->sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		// $this->sheet->getPageSetup()->setRowsToRepeatAtTop(array(1,5)); // cabecera de impresion
		$this->sheet->getDefaultStyle()->getFont()->setName('Calibri');
		$this->sheet->getDefaultStyle()->getFont()->setSize(11);
		$this->sheet->getDefaultStyle()->applyFromArray($alignment_general);
		$this->sheet->getSheetView()->setZoomScale(100);
		$this->sheet->getDefaultColumnDimension()->setWidth(12); //default size column


		// column width
		$this->sheet->getColumnDimension('A')->setWidth(7);
		$this->sheet->getColumnDimension('B')->setWidth(35);
		$this->sheet->getColumnDimension('C')->setWidth(10);
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

		$this->sheet->getColumnDimension('AN')->setWidth(25);
		$this->sheet->getColumnDimension('AO')->setWidth(30);
		$this->sheet->getColumnDimension('AP')->setWidth(25);


		////////////////////////////////
		// Logo
		////////////////////////////////
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($this->sheet);
		$objDrawing->setName("inei");
		$objDrawing->setDescription("Inei");
		$objDrawing->setPath("assets/img/inei.jpeg");
		$objDrawing->setCoordinates('L1');
		$objDrawing->setHeight(75);
		$objDrawing->setOffsetX(15);
		$objDrawing->setOffsetY(4);


		////////////////////////////////
		// Cabecera General
		////////////////////////////////
		$this->cell_value_with_merge('N3','INSTITUTO NACIONAL DE ESTADÍSTICA E INFORMÁTICA','N3:R3');
		$this->cell_value_with_merge('N4','CENSO DE INFRAESTRUCTURA EDUCATIVA 2013','N4:R4');
		$this->sheet->getStyle('N3:R4')->applyFromArray($style_cabecera_general);

		////////////////////////////////
		// Cabecera Tabla
		////////////////////////////////
		$this->cell_value_with_merge('A6','NRO','A6:A11');
		$this->sheet->getStyle('A6:A11')->applyFromArray($style_tabs);

		$this->cell_value_with_merge('B6','INFORMACIÓN GENERAL','B6:Q6');
		$this->sheet->getStyle('B6:Q6')->applyFromArray($style_tabs);

		$this->cell_value_with_merge('B7','Nombre de la I.E.','B7:B11');
		$this->cell_value_with_merge('C7','Código','C7:C11');
		$this->cell_value_with_merge('D7','Nivel Educativo','D7:D11');
		$this->cell_value_with_merge('E7','Total de Alumnos','E7:E11');
		$this->cell_value_with_merge('F7','Nombre del Director','F7:F11');
		$this->cell_value_with_merge('G7','Teléfono','G7:G11');
		$this->cell_value_with_merge('H7','Dirección','H7:H11');
		$this->cell_value_with_merge('I7','Departamento','I7:I11');
		$this->cell_value_with_merge('J7','Provincia','J7:J11');
		$this->cell_value_with_merge('K7','Distrito','K7:K11');
		$this->cell_value_with_merge('L7','Centro Poblado','L7:L11');
		$this->cell_value_with_merge('M7','Área Urbana o Rural','M7:M11');
		$this->cell_value_with_merge('N7','Propietario del Local','N7:N11');
		$this->sheet->getStyle('B7:N11')->applyFromArray($style_indicador);

		$this->cell_value_with_merge('O7','GEOREFERENCIA','O7:Q7');
		$this->sheet->getStyle('O7:Q7')->applyFromArray($style_subtitulo);
		$this->cell_value_with_merge('O8','Latitud','O8:O11');
		$this->cell_value_with_merge('P8','Longitud','P8:P11');
		$this->cell_value_with_merge('Q8','Altitud','Q8:Q11');
		$this->sheet->getStyle('O8:Q11')->applyFromArray($style_indicador);



		$this->cell_value_with_merge('R6','INFORMACIÓN DE LA INFRAESTRUCTURA','R6:AP6');
		$this->sheet->getStyle('R6:AP6')->applyFromArray($style_tabs);
		
		$this->cell_value_with_merge('R7','NÚMERO DE PREDIOS Y EDIFICACIONES','R7:U7');
		$this->sheet->getStyle('R7:U7')->applyFromArray($style_subtitulo);
		$this->cell_value_with_merge('R8','Predios','R8:R11');
		$this->cell_value_with_merge('S8','Edificaciones','S8:S11');
		$this->cell_value_with_merge('T8','Total de Pisos','T8:T11');
		$this->cell_value_with_merge('U8','Área del Terreno','U8:U11');

		$this->cell_value_with_merge('V7','OTRAS EDIFICACIONES','V7:Y7');
		$this->sheet->getStyle('V7:Y7')->applyFromArray($style_subtitulo);
		$this->cell_value_with_merge('V8','Patio','V8:V11');
		$this->cell_value_with_merge('W8','Losa Deportiva','W8:W11');
		$this->cell_value_with_merge('X8','Cisterna - Tanque','X8:X11');
		$this->cell_value_with_merge('Y8','Muro de Contención','Y8:Y11');

		$this->cell_value_with_merge('Z7','SERVICIOS BÁSICOS Y COMUNICACIONES','Z7:AE7');
		$this->sheet->getStyle('Z7:AE7')->applyFromArray($style_subtitulo);
		$this->cell_value_with_merge('Z8','Energía Eléctrica','Z8:Z11');
		$this->cell_value_with_merge('AA8','Agua Potable','AA8:AA11');
		$this->cell_value_with_merge('AB8','Alcantarillado','AB8:AB11');
		$this->cell_value_with_merge('AC8','Telefonía Fija','AC8:AC11');
		$this->cell_value_with_merge('AD8','Telefonía Móvil','AD8:AD11');
		$this->cell_value_with_merge('AE8','Internet','AE8:AE11');

		$this->sheet->getStyle('R8:AE11')->applyFromArray($style_indicador);

	
		$this->cell_value_with_merge('AF7','ESPACIOS EDUCATIVOS QUE FUNCIONAN EN LAS EDIFICACIONES','AF7:AP7');
		$this->sheet->getStyle('AF7:AP7')->applyFromArray($style_subtitulo);

		$this->cell_value_with_merge('AF8','EDIFICACIONES POR EJECUTOR DE LA OBRA','AF8:AJ9');
		$this->sheet->getStyle('AF8:AJ9')->applyFromArray($style_subitem);
		$this->cell_value_with_merge('AF10','Gobierno Nacional / Proyecto Especial','AF10:AF11');
		$this->cell_value_with_merge('AG10','Gobierno Regional / Local','AG10:AG11');
		$this->cell_value_with_merge('AH10','APAFA / Autoconstrucción','AH10:AH11');
		$this->cell_value_with_merge('AI10','Entidades Cooperantes /  ONG\'S','AI10:AI11');
		$this->cell_value_with_merge('AJ10','Empresa Privada','AJ10:AJ11');

		$this->cell_value_with_merge('AK8','EDIFICACIONES SEGÚN AÑO DE CONSTRUCCIÓN','AK8:AM9');
		$this->sheet->getStyle('AK8:AM9')->applyFromArray($style_subitem);
		$this->cell_value_with_merge('AK10','Antes y Durante 1977','AK10:AK11');
		$this->cell_value_with_merge('AL10','Entre 1978 Y 1998','AL10:AL11');
		$this->cell_value_with_merge('AM10','Después de 1998','AM10:AM11');

		$this->cell_value_with_merge('AN8','INTERVENCIÓN A REALIZAR','AN8:AP9');
		$this->sheet->getStyle('AN8:AP9')->applyFromArray($style_subitem);
		$this->cell_value_with_merge('AN10','Número de Edificaciones para Mantenimiento','AN10:AN11');
		$this->cell_value_with_merge('AO10','Número de Edificaciones para Reforzamiento Estructural','AO10:AO11');
		$this->cell_value_with_merge('AP10','Número de Edificaciones para Demolición','AP10:AP11');

		$this->sheet->getStyle('AF10:AP11')->applyFromArray($style_indicador);

		$this->sheet->getStyle('A6:AP11')->applyFromArray($marco);
		

		////////////////////////////////
		// Cuerpo
		////////////////////////////////
		$_REQUEST['searchColegio'] =  $_GET['searchColegio']; //'';
		$_REQUEST['searchCodigo'] = $_GET['searchCodigo']; //'';
		$_REQUEST['depa'] = $_GET['depa']; //'01';
		$_REQUEST['prov'] = $_GET['prov']; //'01';
		$_REQUEST['dist'] = $_GET['dist']; //'01';

		$indice = 12; //fila inicial
		$nro = 0;
		$query = $this->modellocalresumen->getIESearch($_REQUEST);

		foreach ($query as $key => $row)
		{
			$this->sheet->setCellValue('A'.$indice, ++$nro );
			$this->sheet->setCellValue('B'.$indice, $row['nombres_IIEE'] );
			// $this->sheet->setCellValue('C'.$indice, $row['codigo_de_local'] );
			$this->sheet->getCellByColumnAndRow(2, $indice)->setValueExplicit($row['codigo_de_local'],PHPExcel_Cell_DataType::TYPE_STRING);
			$this->sheet->setCellValue('D'.$indice, $row['nivel'] );
			$this->sheet->setCellValue('E'.$indice, $row['Talum'] );
			$this->sheet->setCellValue('F'.$indice, $row['Director_IIEE'] );
			$this->sheet->setCellValue('G'.$indice, $row['tel_IE'] );
			$this->sheet->setCellValue('H'.$indice, $row['direcc_IE'] );
			$this->sheet->setCellValue('I'.$indice, $row['dpto_nombre'] );
			$this->sheet->setCellValue('J'.$indice, $row['prov_nombre'] );
			$this->sheet->setCellValue('K'.$indice, $row['dist_nombre'] );
			$this->sheet->setCellValue('L'.$indice, $row['centroPoblado'] );
			$this->sheet->setCellValue('M'.$indice, $row['des_area'] );
			$this->sheet->setCellValue('N'.$indice, $row['prop_IE'] );
			$this->sheet->setCellValue('O'.$indice, $row['LatitudPunto_UltP'] );
			$this->sheet->setCellValue('P'.$indice, $row['LongitudPunto_UltP'] );
			$this->sheet->setCellValue('Q'.$indice, $row['AltitudPunto_UltP'] );
			$this->sheet->setCellValue('R'.$indice, $row['cPred'] );
			$this->sheet->setCellValue('S'.$indice, $row['cEdif'] );
			$this->sheet->setCellValue('T'.$indice, $row['Piso'] );
			$this->sheet->setCellValue('U'.$indice, $row['P1_B_3_9_At_Local'] );
			$this->sheet->setCellValue('V'.$indice, $row['P'] );
			$this->sheet->setCellValue('W'.$indice, $row['LD'] );
			$this->sheet->setCellValue('X'.$indice, $row['CTE'] );
			$this->sheet->setCellValue('Y'.$indice, $row['MC'] );
			$this->sheet->setCellValue('Z'.$indice, ( $row['P2_C_2LocE_1_Energ'] == 1) ? 'TIENE' : 'NO TIENE' );
			$this->sheet->setCellValue('AA'.$indice, ( $row['P2_C_2LocE_2_Agua'] == 1) ? 'TIENE' : 'NO TIENE' );
			$this->sheet->setCellValue('AB'.$indice, ( $row['P2_C_2LocE_3_Alc'] == 1) ? 'TIENE' : 'NO TIENE' );
			$this->sheet->setCellValue('AC'.$indice, ( $row['P2_C_2LocE_4_Tfija'] == 1) ? 'TIENE' : 'NO TIENE' );
			$this->sheet->setCellValue('AD'.$indice, ( $row['P2_C_2LocE_5_Tmov'] == 1) ? 'TIENE' : 'NO TIENE' );
			$this->sheet->setCellValue('AE'.$indice, ( $row['P2_C_2LocE_6_Int'] == 1) ? 'TIENE' : 'NO TIENE'  );
			$this->sheet->setCellValue('AF'.$indice, $row['eo_1'] );
			$this->sheet->setCellValue('AG'.$indice, $row['eo_2'] );
			$this->sheet->setCellValue('AH'.$indice, $row['eo_3'] );
			$this->sheet->setCellValue('AI'.$indice, $row['eo_4'] );
			$this->sheet->setCellValue('AJ'.$indice, $row['eo_5'] );
			$this->sheet->setCellValue('AK'.$indice, $row['a_1'] );
			$this->sheet->setCellValue('AL'.$indice, $row['a_2'] );
			$this->sheet->setCellValue('AM'.$indice, $row['a_3'] );
			$this->sheet->setCellValue('AN'.$indice, $row['eman'] );
			$this->sheet->setCellValue('AO'.$indice, $row['ereh'] );
			$this->sheet->setCellValue('AP'.$indice, $row['edem'] );

			if ( $indice % 2 != 0 )
			{
				$this->sheet->getStyle('A'.$indice.':AP'.$indice)->applyFromArray($style_impar);
			}

			$indice++;
		}

		$this->sheet->getStyle('A12:AP'.($indice - 1))->applyFromArray($style_contenido);
		$this->sheet->getStyle('Q6:Q'.($indice - 1))->applyFromArray($divisoria);



		////////////////////////////////
		// SALIDA EXCEL ( Propiedades del archivo excel )
		////////////////////////////////
		$this->sheet->setTitle("CIE 2013");
		$this->phpexcel->getProperties()
		->setTitle("INEI - CIE2013")
		->setDescription("CIE2013");
		header("Content-Type: application/vnd.ms-excel");
		$nombreArchivo = 'CIE2013_'.date('Y-m-d');
		header("Content-Disposition: attachment; filename=\"$nombreArchivo.xls\""); 
		header("Cache-Control: max-age=0");
		
		// Genera Excel
		$writer = PHPExcel_IOFactory::createWriter($this->phpexcel, "Excel5");

		$writer->save('php://output');
		exit;
	}

	function cell_value_with_merge($cell, $content, $merge)
	{
		$this->sheet->setCellValue($cell,$content);
		$this->sheet->mergeCells($merge);
	}

}

?>