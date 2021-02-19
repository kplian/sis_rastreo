<?php
// #RAS-3          19/02/2021      JJA         Nuevo reporte de historial de movimientos de vehículos
class RHistorialVehiculoPDF extends  ReportePDF {
    var $datos_titulo;
    var $datos_detalle;
    var $ancho_hoja;
    var $gerencia;
    var $numeracion;
    var $ancho_sin_totales;
    var $cantidad_columnas_estaticas;
    var $s1;
    var $s2;
    var $s3;
    var $s4;
    var $s5;
    var $s6;

    var $s7;
    var $s8;
    var $s9;
    var $s10;
    var $s11;
    var $s12;
    var $s13;
    var $s14;

    var $t1;
    var $t2;
    var $t3;
    var $t4;
    var $t5;
    var $t6;
    var $total;
    var $datos_entidad;
    var $datos_periodo;
    var $param;



    function datosHeader ( $detalle,$par) {
        $this->SetHeaderMargin(8);
        $this->SetAutoPageBreak(TRUE, 10);
        $this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
        $this->datos_detalle = $detalle;
        //$this->datos_titulo = $totales;
        //$this->datos_entidad = $entidad;
        //$this->datos_periodo = $periodo;
        $this->param=$par;
        //var_dump($this->param->getParametro("ceco"));
        $this->subtotal = 0;
        $this->SetMargins(4.8, 59, 4);

    }

    function Header() {

        $white = array('LTRB' =>array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 255, 255)));
        $black = array('T' =>array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));


        $this->Ln(3);
        //formato de fecha

        //cabecera del reporte
        $this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg', 10,5,40,20);
        $this->ln(5);


        $this->SetFont('','B',12);
        $this->Cell(0,5,'HISTORIAL',0,1,'C');
        $this->Ln(1);
        $this->SetFont('','B',11);
        $this->Cell(0,5,"GENERADO DESDE EL ".$this->param->getParametro("fecha_ini")." "." HASTA EL ".$this->param->getParametro("fecha_fin"),0,1,'C');
        $this->Ln(2);



        $this->SetFont('','',10);

        $height = 5;
        $width1 = 5;
        $esp_width = 10;
        $width_c1= 25;
        $width_c2= 112;
        $width3 = 40;
        $width4 = 75;

        $this->SetFont('', 'B');
        $this->Cell($width1, $height, '', 0, 0, 'L', false, '', 0, false, 'T', 'C');
        $this->Cell($width_c1, $height, 'VEHÍCULO:', 0, 0, 'L', false, '', 0, false, 'T', 'C');
        $this->SetFont('', '');
        $this->SetFillColor(192,192,192, true);
        $this->Cell($width_c2, $height, $this->param->getParametro("vehiculo"), 0, 0, 'L', false, '', 0, false, 'T', 'C');



        $this->SetFont('','B',5);
        $this->generarCabecera();


    }

    function Footer() {

        $this->setY(-15);
        $ormargins = $this->getOriginalMargins();
        $this->SetTextColor(0, 0, 0);

        $line_width = 0.85 / $this->getScaleFactor();
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        $ancho = round(($this->getPageWidth() - $ormargins['left'] - $ormargins['right']) / 3);
        $this->Ln(2);
        $cur_y = $this->GetY();

        $this->Cell($ancho, 0, '', '', 0, 'L');
        $pagenumtxt = 'Página'.' '.$this->getAliasNumPage().' de '.$this->getAliasNbPages();
        $this->Cell($ancho, 0, $pagenumtxt, '', 0, 'C');
        $this->Cell($ancho, 0, '', '', 0, 'R');
        $this->Ln();
        $fecha_rep = date("d-m-Y H:i:s");
        $this->Cell($ancho, 0, '', '', 0, 'L');
        $this->Ln($line_width);

    }


    function generarReporte() {
        $this->setFontSubsetting(false);
        $this->AddPage();

        $sw = false;
        $concepto = '';

        $this->generarCuerpo($this->datos_detalle);

    }

    function generarCabecera(){
        $this->Ln(10);
        $conf_par_tablewidths=array(70,20,20,25,25,20,25,25,25,15);
        $conf_par_tablealigns=array('C','C','C','C','C','C','C','C','C','C');
        $conf_par_tablenumbers=array(0,0,0,0,0,0,0,0,0,0);

        $conf_tableborders=array();
        $conf_tabletextcolor=array(array(255, 255, 255),array(255, 255, 255),array(255, 255, 255),array(255, 255, 255),array(255, 255, 255),array(255, 255, 255),array(255, 255, 255),array(255, 255, 255),array(255, 255, 255),array(255, 255, 255));

        $this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;


        $this->SetFillColor(54, 96, 146);
        $this->SetTextColor(255,255,255);
        $this->SetFont('','B',8);

        $RowArray = array(
            's0' => 'UBICACIÓN',
            's1' => 'LATITUD',
            's2' => "LONGITUD",
            's3' => 'FECHA Y HORA',
            's4' => 'VELOCIDAD',
            's5' => 'PLACA',
            's6' => "DISTANCIA",
            's7' => "VOLT. BATERIA",
            's8' => "ODOMETRO",
            's9' => "ESTADO"
        );

        $this->MultiRow($RowArray, true, 1);
    }

    function generarCuerpo($detalle){
        $this->Ln(-16);
        $count = 1;
        $sw = 0;
        $ult_region = '';
        $fill = 0;

        $this->total = count($detalle);
        $this->s1 = "";
        $this->s2 = 0;
        $this->s3 = 0;
        $this->s4 = 0;
        $this->s5 = 0;
        $this->s6 = 0;
        $this->s7 = 0;
        $this->s8 = 0;
        $this->s9 = 0;
        $this->s10 = 0;
        $this->s11 = 0;
        $this->s12 = 0;
        $this->s13 = 0;
        $this->s14 = 0;
       // var_dump($detalle);
        foreach ($detalle as $val) {

            $this->imprimirLinea($val,$count,$fill);
            $count = $count + 1;
            $this->total = $this->total -1;
            $this->revisarfinPagina();
        }
    }

    function imprimirLinea($val,$count,$fill){

        $fill = !$fill;
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('','',8);


        $conf_par_tablewidths=array(70,20,20,25,25,20,25,25,25,15);
        $conf_par_tablealigns=array('L','L','R','R','R','R','R','R','R','R');
        $conf_par_tablenumbers=array(0,0,2,2,0,2,0,0,0,0);
        $conf_tableborders=array('LRB','LRB','LRB','LRB','LRB','LRB','LRB','LRB' ,'LRB','LRB');

        $this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;


        $RowArray = array(
            's0'  => trim($val['ubicacion']),
            's1' => trim($val['latitude']),
            's2' => $val['longitude'],
            's3' => $val['fecha_hora'],
            's4' => $val['velocidad'],
            's5' => $val['placa'],
            's6' => $val['distancia'],
            's7' => $val['volt_bateria'],
            's8' => $val['odometro'],
            's9' => $val['estado']
        );

        $this-> MultiRow($RowArray,$fill,1);
    }

    function revisarfinPagina(){
        $dimensions = $this->getPageDimensions();
        $hasBorder = false; //flag for fringe case

        $startY = $this->GetY();
        $this->getNumLines($row['cell1data'], 80);

        if ($startY > 190) {

            //$this->cerrarCuadroTotal();

            if($this->total!= 0){
                $this->AddPage();
            }

        }

    }


}
?>