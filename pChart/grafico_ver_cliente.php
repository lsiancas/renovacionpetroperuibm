<?php error_reporting (E_ALL ^ E_NOTICE); ?>
<?php  
 // Standard inclusions     
 include("pChart/pData.class");  
 include("pChart/pChart.class"); 
 $cliente = $_GET['id'];
 
 //Cantidad Segun Estado
 $sql = "select sum(total) as total, date_format(fechaventa, '%b') as fecha, date_format(fechaventa, '%m') as mes from ventas where idcliente = '$cliente' group by fecha order by mes asc";
 
 
 $rsql = mysql_query($sql, $link) or die ("Error $sql".mysql_error());
   $total = array();
   $meses = array(); 
  
  $reg = mysql_num_rows($rsql);
  
  while($fila = mysql_fetch_array($rsql))
  {
	$total[] = $fila['total'];
	$meses[] = $fila['fecha'];

  }
  
 // Dataset definition   
 $DataSet = new pData;  
 $DataSet->AddPoint($total,"Total");
 $DataSet->AddPoint($meses,"Meses");  
 $DataSet->AddAllSeries();  
 $DataSet->SetAbsciseLabelSerie("Meses");  
 //$DataSet->SetSerieName();  

  
 // Initialise the graph  
 $Test = new pChart(700,230);  
 $Test->setFontProperties("../sic/pChart/Fonts/tahoma.ttf",10);  
 $Test->setGraphArea(50,30,585,200);  
 $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);  
 $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);  
 $Test->drawGraphArea(255,255,255,TRUE);  
 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);     
 $Test->drawGrid(4,TRUE,230,230,230,50);  
  
 // Draw the 0 line  
 $Test->setFontProperties("Fonts/tahoma.ttf",10);  
 $Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
  
 // Draw the bar graph  
 $Test->drawOverlayBarGraph($DataSet->GetData(),$DataSet->GetDataDescription());  
  
 // Finish the graph  
 $Test->setFontProperties("../sic/pChart/Fonts/tahoma.ttf",10);  
 $Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);  
 $Test->setFontProperties("../sic/pChart/Fonts/tahoma.ttf",10);  
 $Test->drawTitle(50,22,"Informacion Ventas por Cliente",50,50,50,585);  
 $Test->Render("pChart/grafico_ver_cliente.png");  
?>  