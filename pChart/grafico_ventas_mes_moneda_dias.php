<?php error_reporting (E_ALL ^ E_NOTICE); ?>

<?php  

 // Standard inclusions     

 include("pChart/pData.class");  

 include("pChart/pChart.class"); 

 $mes = $_GET['cmbmes'];

 $moneda = $_GET['cmbmoneda'];

 

 //Cantidad Segun Estado

 $sql = "select sum(v.total) as total, date_format(v.fechaventa, '%d') as dia, m.moneda,  e.estado,v.idmoneda from 

ventas v join clientes cl on v.idcliente=cl.idcliente join monedas m on v.idmoneda=m.idmoneda join estados e on v.idestado=e.idestado

join tipocomprobantes tc on v.idtipocomprobante=tc.idtipocomprobante where v.idestado= '1' and v.idmoneda='$moneda' and v.fechaventa like '%-$mes-%' group by dia order by dia asc";

 

 

 $rsql = mysql_query($sql, $link) or die ("Error $sql".mysql_error());

   $total = array();

   $dias = array(); 

  

  $reg = mysql_num_rows($rsql);

  

  while($fila = mysql_fetch_array($rsql))

  {

	$total[] = $fila['total'];

	$dias[] = $fila['dia'];



  }

  

 // Dataset definition   

 $DataSet = new pData;  

 $DataSet->AddPoint($total,"Total");

 $DataSet->AddPoint($dias,"Dias");  

 $DataSet->AddAllSeries();  

 $DataSet->SetAbsciseLabelSerie("Dias");  

 //$DataSet->SetSerieName();  



  

 // Initialise the graph  

 $Test = new pChart(700,230);  

 $Test->setFontProperties("/pChart/Fonts/tahoma.ttf",10);  

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

 $Test->setFontProperties("/pChart/Fonts/tahoma.ttf",10);  

 $Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);  

 $Test->setFontProperties("../sic/pChart/Fonts/tahoma.ttf",10);  

 $Test->drawTitle(50,22,"Canceladas Segun Mes & Moneda por Dias",50,50,50,585);  

 $Test->Render("pChart/grafico_ventas_mes_moneda_dias.png");  

?>  