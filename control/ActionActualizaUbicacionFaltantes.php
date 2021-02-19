<?php
    /***

     */
    include_once(dirname(__FILE__)."/../../lib/lib_control/CTSesion.php");
    session_start();
    $_SESSION["_SESION"]= new CTSesion();

    include(dirname(__FILE__).'/../../lib/DatosGenerales.php');
    include_once(dirname(__FILE__).'/../../lib/lib_general/Errores.php');
    include_once(dirname(__FILE__).'/../../lib/rest/PxpRestClient.php');
    include_once(dirname(__FILE__).'/../../lib/FirePHPCore-0.3.2/lib/FirePHPCore/FirePHP.class.php');


    ob_start();
    $fb=FirePHP::getInstance(true);

    //estable aprametros ce la cookie de sesion
    $_SESSION["_CANTIDAD_ERRORES"]=0;//inicia control


    include_once(dirname(__FILE__).'/../../lib/lib_control/CTincludes.php');
    include_once(dirname(__FILE__).'/../../sis_rastreo/modelo/MODPositions.php');


    $objPostData = new CTPostData();
    $arr_unlink = array();
    $aPostData = $objPostData->getData();


    $_SESSION["_PETICION"]=serialize($aPostData);
    $objParam = new CTParametro($aPostData['p'],null,$aPostFiles);

    $objFunc=new MODPositions($objParam);
    $res2=$objFunc->listarDireccionesFaltantes();
    if($res2->getTipo()=='ERROR'){
        echo 'Se ha producido un error-> Mensaje Técnico:'.$res2->getMensajeTec();
        exit;
    }

    foreach ($res2->datos as $d) {

        $addr = getDireccion($d['latitude'],$d['longitude']);
        //echo $addr;
        $objParam->addParametro('id_position', (int)$d['id']);
        $objParam->addParametro('ubicacion', $addr);
        postDireccion($objParam);

        //var_dump($d['latitude']);
        //var_dump($d['longitude']);
        //var_dump($d['id']);
        //sleep(10);
    }


    function getDireccion($RG_Lat,$RG_Lon)
    {
        $json = "https://nominatim.openstreetmap.org/reverse?format=json&lat=".$RG_Lat."&lon=".$RG_Lon."&zoom=27&addressdetails=1";
        $ch = curl_init($json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0");
        $jsonfile = curl_exec($ch);
        curl_close($ch);
        $RG_array = json_decode($jsonfile,true);
        //var_dump($RG_array["display_name"]);
        return $RG_array['display_name'];
        // $RG_array['address']['city'];
        // $RG_array['address']['country'];
    }
    function postDireccion($objParam){

        $objFunc=new MODPositions($objParam);
        $insertar=$objFunc->InsertarDireccionesFaltantes();

        if($insertar->getTipo()=='ERROR'){
            echo 'Se ha producido un error-> Mensaje Técnico:'.$insertar->getMensajeTec();
            exit;
        }
        echo "exito->";
        //var_dump($insertar);
    }
?>