<?php
// Extend the TCPDF class to create custom MultiRow
class RAutoPIV extends  ReportePDF {
    var $cabecera;
    var $detalleCbte;
    var $ancho_hoja;
    var $gerencia;
    var $numeracion;
    var $ancho_sin_totales;
    var $cantidad_columnas_estaticas;
    var $total;
    var $with_col;
    var $datos_sol_vehiculo;
    var $datos_nomina_persona ;
    var $ddatos_asig_vehiculo ;
    var $datos_elemento_seg_equipo;
    var $datos_asig_incidencia;
    function datosHeader ( $detalle) {

        $this->datos_sol_vehiculo = $detalle->getParametro('datos_sol_vehiculo');
        $this->datos_nomina_persona = $detalle->getParametro('datos_nomina_persona');
        $this->datos_asig_vehiculo = $detalle->getParametro('datos_asig_vehiculo');
        $this->datos_elemento_seg_equipo = $detalle->getParametro('datos_elemento_seg_equipo');
        $this->datos_asig_incidencia = $detalle->getParametro('datos_asig_incidencia');

        //var_dump('aui',$this->datos_elemento_seg_equipo);exit;
        $this->SetHeaderMargin(15); //margen top header
        $this->SetMargins(15, 40, 15);
        //$this->SetFooterMargin(0);

    }

    function Header() {
        $this->SetHeaderMargin(12);
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetMargins(15, 38, 15);
        $newDate = date("d/m/Y", strtotime( $this->cabecera[0]['fecha']));
        $dataSource = $this->datos_detalle;
        ob_start();
        include(dirname(__FILE__).'/../reportes/tpl/auto_PIV/cabecera.php');
        $content = ob_get_clean();
        $this->writeHTML($content, false, false, true, false, '');

    }

    function generarReporte1() {

        $this->AddPage();


        $with_col = $this->with_col;
        //adiciona glosa
        ob_start();
        include(dirname(__FILE__).'/../reportes/tpl/auto_PIV/cuerpo.php');
        $content = ob_get_clean();

        ob_start();
        include(dirname(__FILE__).'/../reportes/tpl/auto_PIV/detalle.php');
        $content2 = ob_get_clean();
        $this->writeHTML($content.$content2);

        $this->SetFont ('helvetica', '', 5 , '', 'default', true );

        //$this->Ln(2);
        $this->revisarfinPagina($content);

        $this->Ln(2);

    }

    function revisarfinPagina($content){
        $dimensions = $this->getPageDimensions();
        $hasBorder = false; //flag for fringe case

        $startY = $this->GetY();
        $test = $this->getNumLines($content, 80);

        //if (($startY + 10 * 6) + $dimensions['bm'] > ($dimensions['hk'])) {

        //if ($startY +  $test > 250) {
        $auxiliar = 250;
        //if($this->page==1){
        //	$auxiliar = 250;
        //}
        //var_dump('variable',$startY,$test,$auxiliar);
        if ($startY +  $test > $auxiliar) {
            //$this->Ln();
            //$this->subtotales('Pasa a la siguiente página. '.$startY);
            //$this->subtotales('Pasa a la siguiente página');
            $startY = $this->GetY();
            if($startY > 250){
                $this->AddPage();
            }
            else{
                //$this->AddPage();
            }
            //$this->writeHTML('<p>text'.$startY.'</p>', false, false, true, false, '');
        }
    }
}
?>