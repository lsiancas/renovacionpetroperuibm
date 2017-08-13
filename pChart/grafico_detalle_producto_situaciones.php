<?php error_reporting (E_ALL ^ E_NOTICE); ?>

<?php

 /* Example13: A 2D exploded pie graph */

 

 // Standard inclusions   

 include_once("pChart/pData.class");

 include_once("pChart/pChart.class");

 $producto = $_GET['id'];



 //Cantidad Segun Estado

 $sql = "select count(dp.idserie), s.situacion from detalleproductos dp join situaciones s on dp.idsituacion = s.idsituacion join productos p on dp.idproducto = p.idproducto 

where p.idproducto = '$producto' group by s.situacion";

 

 $rsql = mysql_query($sql, $link) or die ("Error $sql".mysql_error());

   $total = array();

   $situacion = array(); 

   $i = 0;

  

  $reg = mysql_num_rows($rsql);

  

  while($fila = mysql_fetch_array($rsql))

  {

	$total[$i] = $fila[0];

	$situacion[$i] = $fila[1];

	$i = $i + 1;

  }

  

  // Dataset definition 

 $DataSet = new pData;

 //$DataSet->AddPoint(array(10,2,3),"Serie1");

 //$DataSet->AddPoint(array("Jan","Feb",$idp),"Serie2");

 

 switch($reg){

	 case 1:

			$DataSet->AddPoint(array($total[0]),"Serie1");

 			$DataSet->AddPoint(array($situacion[0]),"Situaciones");

 		 	break;

	 case 2:

			$DataSet->AddPoint(array($total[0], $total[1]),"Serie1");

 			$DataSet->AddPoint(array($situacion[0], $situacion[1]),"Situaciones");

 	        break;

	 case 3:

	 		$DataSet->AddPoint(array($total[0], $total[1], $total[2]),"Serie1");

            $DataSet->AddPoint(array($situacion[0], $situacion[1], $situacion[2]),"Situaciones");

			break;

	 case 4:

			$DataSet->AddPoint(array($total[0], $total[1], $total[2], $total[3]),"Serie1");

 			$DataSet->AddPoint(array($situacion[0], $situacion[1], $situacion[2], $situacion[3]),"Situaciones");

 	        break;

	 case 5:

	 		$DataSet->AddPoint(array($total[0], $total[1], $total[2], $total[3], $total[4]),"Serie1");

 			$DataSet->AddPoint(array($situacion[0], $situacion[1], $situacion[2], $situacion[3], $situacion[4]),"Situaciones");

			break;		

			

  }

 

 

 //$DataSet->AddPoint(array($total[0], $total[1], $total[2], $total[3]),"Serie1");

 //$DataSet->AddPoint(array($situacion[0], $situacion[1], $situacion[2], $situacion[3]),"Estados");

 $DataSet->AddAllSeries();

 

 $DataSet->SetAbsciseLabelSerie("Serie1");

 $DataSet->SetAbsciseLabelSerie("Situaciones");



 // Initialise the graph

 $Test = new pChart(320,180);

 $Test->setFontProperties("/pChart/Fonts/tahoma.ttf",9);

 $Test->drawFilledRoundedRectangle(7,7,350,220,5,240,240,240);

 $Test->drawRoundedRectangle(5,5,340,215,5,230,230,230);



 // Draw the pie chart

 $Test->AntialiasQuality = 0;

 $Test->setShadowProperties(2,2,200,200,200);

 $Test->drawFlatPieGraphWithShadow($DataSet->GetData(),$DataSet->GetDataDescription(),120,100,60,PIE_PERCENTAGE,8);

 $Test->clearShadow();

 $Test->drawPieLegend(210,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

 $Test->Render("pChart/grafico_detalle_producto_situaciones.png");



?>