<?php 
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>RENOVACION TECNOLOGICA PETROPERU 2017</title>
</head>
<script>
function salir(){
 document.location = "salir.php";
}
function retornar(){
 document.location = "renovacion.php";
}

</script>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
  <tr>
    <td align="center" valign="middle" class="body" colspan="3">
    <img src="images/encabezado.png" width="100%" height="250" />
    </td>
  </tr>
  <tr>
    <td height="50" colspan="3">&nbsp;</td>
  </tr>
  <tr>
  <td width="20%" align="center" valign="middle">&nbsp;</td>
    <td width="60%" align="center">
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body_sistema">
      <tr>
        <td height="50" align="center" valign="middle"><strong>AVANCE DE LA RENOVACION</strong></td>
        </tr>
      <tr>
        <td height="45" align="center" valign="middle">
		<?php include("pChart/grafica.php"); ?>
        <img src='pChart/grafica.png' width='400' height='200'/>
        </td>
        </tr>
      <tr>
        <td height="45" align="center" valign="middle">
        <input name="bntretornar" type="button" class="boton" id="bntretornar" value="RETORNAR" onclick="retornar()"/>
        </td>
      </tr>
      <tr>
        <td height="45" align="center" valign="middle">
        <input name="btnsalir" type="button" class="boton" id="btnsalir" value="       SALIR      " onclick="salir()" />
        </td>
      </tr>
      <tr>
        <td height="35">&nbsp;</td>
        </tr>
    </table>
 
    </td>
    <td width="20%" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>