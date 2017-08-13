<?php 
error_reporting (E_ALL ^ E_NOTICE);
error_reporting(0);
require_once('Connections/cnxrenovacion.php'); 

?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
  
?>
<?php
 /* Example13: A 2D exploded pie graph */

 // Standard inclusions   
 include_once("pChart/pData.class");
 include_once("pChart/pChart.class");
 
 //Cantidad Segun Estado
  mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
 $sql = "SELECT count(activoold), cambio FROM equiposold GROUP BY cambio ORDER BY cambio asc";
  $rsql = mysql_query($sql, $cnxrenovacion) or die ("Error $sql".mysql_error());
  
  /*mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
  $query_RsGrafica = "SELECT count(activoold), cambio FROM equiposold GROUP BY cambio ORDER BY cambio asc";
  $RsGrafica = mysql_query($query_RsGrafica, $cnxrenovacion) or die(mysql_error());
  $row_RsGrafica = mysql_fetch_assoc($RsGrafica);
  $totalRows_RsGrafica = mysql_num_rows($RsGrafica);*/
  
   $total = array();
   $estado = array(); 
   $i = 0;
  
  $reg = mysql_num_rows($rsql);
  
  //while($fila = mysql_fetch_array($RsGrafica))
  while($fila = mysql_fetch_array($rsql))
  {
	$total[$i] = $fila[0];
	$estado[$i] = $fila[1];
	$i = $i + 1;
  }
  
  // Dataset definition 
 $DataSet = new pData;
 //$DataSet->AddPoint(array(10,2,3),"Serie1");
 //$DataSet->AddPoint(array("Jan","Feb",$idp),"Serie2");
 
 //switch($totalRows_RsGrafica){
 switch($reg){	 
	 case 1:
			$DataSet->AddPoint(array($total[0]),"Serie1");
 			$DataSet->AddPoint(array($estado[0]),"Estados");
 		 	break;
	 case 2:
			$DataSet->AddPoint(array($total[0], $total[1]),"Serie1");
 			$DataSet->AddPoint(array($estado[0], $estado[1]),"Estados");
 	        break;
}
 
 
 //$DataSet->AddPoint(array($total[0], $total[1], $total[2], $total[3]),"Serie1");
 //$DataSet->AddPoint(array($estado[0], $estado[1], $estado[2], $estado[3]),"Estados");
 $DataSet->AddAllSeries();
 
 $DataSet->SetAbsciseLabelSerie("Serie1");
 $DataSet->SetAbsciseLabelSerie("Estados");

 // Initialise the graph
 $Test = new pChart(340,230);
 $Test->setFontProperties("pChart/Fonts/tahoma.ttf",9);
 $Test->drawFilledRoundedRectangle(7,7,350,220,5,240,240,240);
 $Test->drawRoundedRectangle(5,5,340,215,5,230,230,230);

 // Draw the pie chart
 $Test->AntialiasQuality = 0;
 $Test->setShadowProperties(2,2,200,200,200);
 $Test->drawFlatPieGraphWithShadow($DataSet->GetData(),$DataSet->GetDataDescription(),125,100,75,PIE_PERCENTAGE,7);
 $Test->clearShadow();
 $Test->drawPieLegend(210,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);
 //Archivo .png debe tener permisos 1656
 $Test->Render("pChart/grafica.png");


mysql_free_result($RsGrafica);
?>