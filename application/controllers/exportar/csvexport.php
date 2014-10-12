<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Csvexport extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
		$this->load->model('export_model');

		ini_set("memory_limit","12M");
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
		$objDrawing->setOffsetY(5);


		////////////////////////////////
		// Cabecera General
		////////////////////////////////
		$sheet->setCellValue('C2','INSTITUTO NACIONAL DE ESTADÍSTICA E INFORMÁTICA');
			$sheet->mergeCells('C2:G2');
		$sheet->setCellValue('C3','CENSO DE INFRAESTRUCTURA EDUCATIVA 2013');
			$sheet->mergeCells('C3:G3');
			$sheet->getStyle('C2:G3')->applyFromArray($style_cabecera_general);


		////////////////////////////////
		// Cuerpo
		////////////////////////////////

		$indice = 6; //fila inicial

		$sql = "SELECT * FROM Local_Resumen WHERE codigo_de_local = '".$idCodigo."'";
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

			$sheet->setCellValue('A'.($indice+4),'Código:');
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


			$sheet->setCellValue('A'.($indice+7),'Nombre del Director:');
				$sheet->mergeCells('A'.($indice+7).':B'.($indice+7));
				$sheet->getStyle('A'.($indice+7).':B'.($indice+7))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+7),$row['Director_IIEE']);
				$sheet->mergeCells('C'.($indice+7).':G'.($indice+7));
				$sheet->getStyle('C'.($indice+7).':G'.($indice+7))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+8),'Teléfono:');
				$sheet->mergeCells('A'.($indice+8).':B'.($indice+8));
				$sheet->getStyle('A'.($indice+8).':B'.($indice+8))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+8),$row['tel_IE']);
				$sheet->mergeCells('C'.($indice+8).':G'.($indice+8));
				$sheet->getStyle('C'.($indice+8).':G'.($indice+8))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+9),'Dirección:');
				$sheet->mergeCells('A'.($indice+9).':B'.($indice+9));
				$sheet->getStyle('A'.($indice+9).':B'.($indice+9))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+9),$row['direcc_IE']);
				$sheet->mergeCells('C'.($indice+9).':G'.($indice+9));
				$sheet->getStyle('C'.($indice+9).':G'.($indice+9))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+10),'Total de Alumnos:');
				$sheet->mergeCells('A'.($indice+10).':B'.($indice+10));
				$sheet->getStyle('A'.($indice+10).':B'.($indice+10))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+10),$row['Talum'].' alumnos');
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
			$sheet->setCellValue('C'.($indice+20),'Latitud:');
				$sheet->getStyle('C'.($indice+20).':C'.($indice+20))->applyFromArray($style_indicador);
			$sheet->setCellValue('D'.($indice+20),$row['LatitudPunto_UltP']);
				$sheet->getStyle('D'.($indice+20).':D'.($indice+20))->applyFromArray($style_contenido);
			$sheet->setCellValue('F'.($indice+20),'Longitud:');
				$sheet->getStyle('F'.($indice+20).':F'.($indice+20))->applyFromArray($style_indicador);
			$sheet->setCellValue('G'.($indice+20),$row['LongitudPunto_UltP']);
				$sheet->getStyle('G'.($indice+20).':G'.($indice+20))->applyFromArray($style_contenido);



			/////////////////////////////////////
			// Información de la Infraestructura
			/////////////////////////////////////

			$sheet->setCellValue('A'.($indice+23),'INFORMACIÓN DE LA INFRAESTRUCTURA DE LA '.$nombre_ie);
				$sheet->mergeCells('A'.($indice+23).':G'.($indice+24));
				$sheet->getStyle('A'.($indice+23).':G'.($indice+24))->applyFromArray($style_tabs);


			$sheet->setCellValue('A'.($indice+25),'NÚMERO PREDIOS Y EDIFICACIONES');
				$sheet->mergeCells('A'.($indice+25).':G'.($indice+25));
				$sheet->getStyle('A'.($indice+25).':G'.($indice+25))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+26),'Predios:');
				$sheet->mergeCells('A'.($indice+26).':B'.($indice+26));
				$sheet->getStyle('A'.($indice+26).':B'.($indice+26))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+26),$row['cPred']);
			$sheet->setCellValue('D'.($indice+26),'predio(s)');
				$sheet->mergeCells('D'.($indice+26).':E'.($indice+26));
				$sheet->getStyle('D'.($indice+26).':E'.($indice+26))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+27),'Edificaciones:');
				$sheet->mergeCells('A'.($indice+27).':B'.($indice+27));
				$sheet->getStyle('A'.($indice+27).':B'.($indice+27))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+27),$row['cEdif']);
			$sheet->setCellValue('D'.($indice+27),'edificación(es)');
				$sheet->mergeCells('D'.($indice+27).':E'.($indice+27));
				$sheet->getStyle('D'.($indice+27).':E'.($indice+27))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+28),'Total de Pisos:');
				$sheet->mergeCells('A'.($indice+28).':B'.($indice+28));
				$sheet->getStyle('A'.($indice+28).':B'.($indice+28))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+28),$row['Piso']);
			$sheet->setCellValue('D'.($indice+28),'piso(s)');
				$sheet->mergeCells('D'.($indice+28).':E'.($indice+28));
				$sheet->getStyle('D'.($indice+28).':E'.($indice+28))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+29),'Área del Terreno:');
				$sheet->mergeCells('A'.($indice+29).':B'.($indice+29));
				$sheet->getStyle('A'.($indice+29).':B'.($indice+29))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+29),$row['P1_B_3_9_At_Local']);
			$sheet->setCellValue('D'.($indice+29),'m2');
				$sheet->mergeCells('D'.($indice+29).':E'.($indice+29));
				$sheet->getStyle('D'.($indice+29).':E'.($indice+29))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+31),'OTRAS EDIFICACIONES');
				$sheet->mergeCells('A'.($indice+31).':G'.($indice+31));
				$sheet->getStyle('A'.($indice+31).':G'.($indice+31))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+32),'Patio:');
				$sheet->mergeCells('A'.($indice+32).':B'.($indice+32));
				$sheet->getStyle('A'.($indice+32).':B'.($indice+32))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+32),$row['P']);
			$sheet->setCellValue('D'.($indice+32),'patio(s)');
				$sheet->mergeCells('D'.($indice+32).':E'.($indice+32));
				$sheet->getStyle('D'.($indice+32).':E'.($indice+32))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+33),'Losa Deportiva:');
				$sheet->mergeCells('A'.($indice+33).':B'.($indice+33));
				$sheet->getStyle('A'.($indice+33).':B'.($indice+33))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+33),$row['LD']);
			$sheet->setCellValue('D'.($indice+33),'losa(s) deportiva(s)');
				$sheet->mergeCells('D'.($indice+33).':E'.($indice+33));
				$sheet->getStyle('D'.($indice+33).':E'.($indice+33))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+34),'Cisterna - Tanque:');
				$sheet->mergeCells('A'.($indice+34).':B'.($indice+34));
				$sheet->getStyle('A'.($indice+34).':B'.($indice+34))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+34),$row['CTE']);
			$sheet->setCellValue('D'.($indice+34),'cistena(s) - tanque(s)');
				$sheet->mergeCells('D'.($indice+34).':E'.($indice+34));
				$sheet->getStyle('D'.($indice+34).':E'.($indice+34))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+35),'Muro de Contención:');
				$sheet->mergeCells('A'.($indice+35).':B'.($indice+35));
				$sheet->getStyle('A'.($indice+35).':B'.($indice+35))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+35),$row['MC']);
			$sheet->setCellValue('D'.($indice+35),'muro(s) de contención(es)');
				$sheet->mergeCells('D'.($indice+35).':F'.($indice+35));
				$sheet->getStyle('D'.($indice+35).':F'.($indice+35))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+37),'SERVICIOS BÁSICOS Y COMUNICACIONES');
				$sheet->mergeCells('A'.($indice+37).':G'.($indice+37));
				$sheet->getStyle('A'.($indice+37).':G'.($indice+37))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+38),'Energía Eléctrica:');
				$sheet->mergeCells('A'.($indice+38).':B'.($indice+38));
				$sheet->getStyle('A'.($indice+38).':B'.($indice+38))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+38), ( $row['P2_C_2LocE_1_Energ'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+39),'Agua Potable:');
				$sheet->mergeCells('A'.($indice+39).':B'.($indice+39));
				$sheet->getStyle('A'.($indice+39).':B'.($indice+39))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+39), ( $row['P2_C_2LocE_2_Agua'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+40),'Alcantarillado:');
				$sheet->mergeCells('A'.($indice+40).':B'.($indice+40));
				$sheet->getStyle('A'.($indice+40).':B'.($indice+40))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+40), ( $row['P2_C_2LocE_3_Alc'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+41),'Telefonía Fija:');
				$sheet->mergeCells('A'.($indice+41).':B'.($indice+41));
				$sheet->getStyle('A'.($indice+41).':B'.($indice+41))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+41), ( $row['P2_C_2LocE_4_Tfija'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+42),'Telefonía Móvil:');
				$sheet->mergeCells('A'.($indice+42).':B'.($indice+42));
				$sheet->getStyle('A'.($indice+42).':B'.($indice+42))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+42), ( $row['P2_C_2LocE_5_Tmov'] == 1) ? 'TIENE' : 'NO TIENE' );

			$sheet->setCellValue('A'.($indice+43),'Internet:');
				$sheet->mergeCells('A'.($indice+43).':B'.($indice+43));
				$sheet->getStyle('A'.($indice+43).':B'.($indice+43))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+43), ( $row['P2_C_2LocE_6_Int'] == 1) ? 'TIENE' : 'NO TIENE' );
			


			////////////////////////////////
			// Logo page 2
			////////////////////////////////
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setWorksheet($sheet);
			$objDrawing->setName("inei");
			$objDrawing->setDescription("Inei");
			$objDrawing->setPath("assets/img/inei.jpeg");
			$objDrawing->setCoordinates('A'.($indice+44));
			$objDrawing->setHeight(75);
			$objDrawing->setOffsetX(15);
			$objDrawing->setOffsetY(5);

			////////////////////////////////
			// Cabecera General page 2
			////////////////////////////////
			$sheet->setCellValue('C'.($indice+45),'INSTITUTO NACIONAL DE ESTADÍSTICA E INFORMÁTICA');
				$sheet->mergeCells('C'.($indice+45).':G'.($indice+45));
			$sheet->setCellValue('C'.($indice+46),'CENSO DE INFRAESTRUCTURA EDUCATIVA 2013');
				$sheet->mergeCells('C'.($indice+46).':G'.($indice+46));
				$sheet->getStyle('C'.($indice+45).':G'.($indice+46))->applyFromArray($style_cabecera_general);


			////////////////////////////////////////////
			// Información de la Infraestructura page 2
			///////////////////////////////////////////

			$sheet->setCellValue('A'.($indice+49),'INFORMACIÓN DE LA INFRAESTRUCTURA DE LA '.$nombre_ie);
				$sheet->mergeCells('A'.($indice+49).':G'.($indice+50));
				$sheet->getStyle('A'.($indice+49).':G'.($indice+50))->applyFromArray($style_tabs);

			$sheet->setCellValue('A'.($indice+51),'ESPACIOS EDUCATIVOS QUE FUNCIONAN EN LAS EDIFICACIONES');
				$sheet->mergeCells('A'.($indice+51).':G'.($indice+51));
				$sheet->getStyle('A'.($indice+51).':G'.($indice+51))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+52),'Aula Común:');
				$sheet->mergeCells('A'.($indice+52).':B'.($indice+52));
				$sheet->getStyle('A'.($indice+52).':B'.($indice+52))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+52),$row['e_1']);
			$sheet->setCellValue('D'.($indice+52),'aula(s)');
				$sheet->mergeCells('D'.($indice+52).':E'.($indice+52));
				$sheet->getStyle('D'.($indice+52).':E'.($indice+52))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+53),'Pedagógico:');
				$sheet->mergeCells('A'.($indice+53).':B'.($indice+53));
				$sheet->getStyle('A'.($indice+53).':B'.($indice+53))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+53),$row['e_2']);
			$sheet->setCellValue('D'.($indice+53),'espacio(s) pedagógico(s)');
				$sheet->mergeCells('D'.($indice+53).':E'.($indice+53));
				$sheet->getStyle('D'.($indice+53).':E'.($indice+53))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+54),'Administrativo:');
				$sheet->mergeCells('A'.($indice+54).':B'.($indice+54));
				$sheet->getStyle('A'.($indice+54).':B'.($indice+54))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+54),$row['e_3']);
			$sheet->setCellValue('D'.($indice+54),'espacio(s) administrativo(s)');
				$sheet->mergeCells('D'.($indice+54).':E'.($indice+54));
				$sheet->getStyle('D'.($indice+54).':E'.($indice+54))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+55),'Complementario:');
				$sheet->mergeCells('A'.($indice+55).':B'.($indice+55));
				$sheet->getStyle('A'.($indice+55).':B'.($indice+55))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+55),$row['e_4']);
			$sheet->setCellValue('D'.($indice+55),'espacio(s) complementario(s)');
				$sheet->mergeCells('D'.($indice+55).':E'.($indice+55));
				$sheet->getStyle('D'.($indice+55).':E'.($indice+55))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+56),'Servicios:');
				$sheet->mergeCells('A'.($indice+56).':B'.($indice+56));
				$sheet->getStyle('A'.($indice+56).':B'.($indice+56))->applyFromArray($style_indicador);
			$sheet->setCellValue('C'.($indice+56),$row['e_5']);
			$sheet->setCellValue('D'.($indice+56),'servicio(s)');
				$sheet->mergeCells('D'.($indice+56).':E'.($indice+56));
				$sheet->getStyle('D'.($indice+56).':E'.($indice+56))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+58),'CARACTERÍSTICAS DE LAS EDIFACIONES');
				$sheet->mergeCells('A'.($indice+58).':G'.($indice+58));
				$sheet->getStyle('A'.($indice+58).':G'.($indice+58))->applyFromArray($style_subtitulo);

			$sheet->setCellValue('A'.($indice+59),'EDIFICACIONES POR EJECUTOR DE LA OBRA');
				$sheet->mergeCells('A'.($indice+59).':D'.($indice+59));
				$sheet->getStyle('A'.($indice+59).':D'.($indice+59))->applyFromArray($style_subitem);

			$sheet->setCellValue('A'.($indice+60),'Gobierno Nacional / Proyecto Especial:');
				$sheet->mergeCells('A'.($indice+60).':D'.($indice+60));
				$sheet->getStyle('A'.($indice+60).':D'.($indice+60))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+60),$row['eo_1']);
			$sheet->setCellValue('F'.($indice+60),'edificación(es)');
				$sheet->mergeCells('F'.($indice+60).':G'.($indice+60));
				$sheet->getStyle('F'.($indice+60).':G'.($indice+60))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+61),'APAFA / Autoconstrucción:');
				$sheet->mergeCells('A'.($indice+61).':D'.($indice+61));
				$sheet->getStyle('A'.($indice+61).':D'.($indice+61))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+61),$row['eo_3']);
			$sheet->setCellValue('F'.($indice+61),'edificación(es)');
				$sheet->mergeCells('F'.($indice+61).':G'.($indice+61));
				$sheet->getStyle('F'.($indice+61).':G'.($indice+61))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+63),'EDIFICACIONES SEGÚN AÑO DE CONSTRUCCIÓN');
				$sheet->mergeCells('A'.($indice+63).':D'.($indice+63));
				$sheet->getStyle('A'.($indice+63).':D'.($indice+63))->applyFromArray($style_subitem);

			$sheet->setCellValue('A'.($indice+64),'Entre 1978 Y 1998:');
				$sheet->mergeCells('A'.($indice+64).':D'.($indice+64));
				$sheet->getStyle('A'.($indice+64).':D'.($indice+64))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+64),$row['a_2']);
			$sheet->setCellValue('F'.($indice+64),'edificación(es)');
				$sheet->mergeCells('F'.($indice+64).':G'.($indice+64));
				$sheet->getStyle('F'.($indice+64).':G'.($indice+64))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+65),'Después de 1998:');
				$sheet->mergeCells('A'.($indice+65).':D'.($indice+65));
				$sheet->getStyle('A'.($indice+65).':D'.($indice+65))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+65),$row['a_3']);
			$sheet->setCellValue('F'.($indice+65),'edificación(es)');
				$sheet->mergeCells('F'.($indice+65).':G'.($indice+65));
				$sheet->getStyle('F'.($indice+65).':G'.($indice+65))->applyFromArray($style_contenido);


			$sheet->setCellValue('A'.($indice+67),'INTERVENCIÓN A REALIZAR');
				$sheet->mergeCells('A'.($indice+67).':D'.($indice+67));
				$sheet->getStyle('A'.($indice+67).':D'.($indice+67))->applyFromArray($style_subitem);

			$sheet->setCellValue('A'.($indice+68),'Número de Edificaciones para Mantenimiento::');
				$sheet->mergeCells('A'.($indice+68).':D'.($indice+68));
				$sheet->getStyle('A'.($indice+68).':D'.($indice+68))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+68),$row['eman']);
			$sheet->setCellValue('F'.($indice+68),'edificación(es)');
				$sheet->mergeCells('F'.($indice+68).':G'.($indice+68));
				$sheet->getStyle('F'.($indice+68).':G'.($indice+68))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+69),'Número de Edificaciones para Reforzamiento Estructural:');
				$sheet->mergeCells('A'.($indice+69).':D'.($indice+69));
				$sheet->getStyle('A'.($indice+69).':D'.($indice+69))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+69),$row['ereh']);
			$sheet->setCellValue('F'.($indice+69),'edificación(es)');
				$sheet->mergeCells('F'.($indice+69).':G'.($indice+69));
				$sheet->getStyle('F'.($indice+69).':G'.($indice+69))->applyFromArray($style_contenido);

			$sheet->setCellValue('A'.($indice+70),'Número de Edificaciones para Demolición:');
				$sheet->mergeCells('A'.($indice+70).':D'.($indice+70));
				$sheet->getStyle('A'.($indice+70).':D'.($indice+70))->applyFromArray($style_indicador);
			$sheet->setCellValue('E'.($indice+70),$row['edem']);
			$sheet->setCellValue('F'.($indice+70),'edificación(es)');
				$sheet->mergeCells('F'.($indice+70).':G'.($indice+70));
				$sheet->getStyle('F'.($indice+70).':G'.($indice+70))->applyFromArray($style_contenido);


			$indice = $indice + 23;

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

}

?>