<?php require_once('Connections/cnxrenovacion.php'); ?>
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

$codigo_Rsencontrado = "-1";
if (isset($_POST['txtbusca'])) {
  $codigo_Rsencontrado = $_POST['txtbusca'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_Rsencontrado = sprintf("SELECT * FROM equiposold WHERE activoold = %s", GetSQLValueString($codigo_Rsencontrado, "text"));
$Rsencontrado = mysql_query($query_Rsencontrado, $cnxrenovacion) or die(mysql_error());
$row_Rsencontrado = mysql_fetch_assoc($Rsencontrado);
$totalRows_Rsencontrado = mysql_num_rows($Rsencontrado);

mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_Rslocalidad = "select * from localidades order by localidad";
$Rslocalidad = mysql_query($query_Rslocalidad, $cnxrenovacion) or die(mysql_error());
$row_Rslocalidad = mysql_fetch_assoc($Rslocalidad);
$totalRows_Rslocalidad = mysql_num_rows($Rslocalidad);

$reg_RsYaRealizado = "-1";
if (isset($_POST['txtbusca'])) {
  $reg_RsYaRealizado = $_POST['txtbusca'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_RsYaRealizado = sprintf("select * from renovaciones where activoold = %s", GetSQLValueString($reg_RsYaRealizado, "text"));
$RsYaRealizado = mysql_query($query_RsYaRealizado, $cnxrenovacion) or die(mysql_error());
$row_RsYaRealizado = mysql_fetch_assoc($RsYaRealizado);
$totalRows_RsYaRealizado = mysql_num_rows($RsYaRealizado);
?>

<?php
  if($totalRows_RsYaRealizado == 0){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>RENOVACION TECNOLOGICA PETROPERU 2017</title>
</head>
<script>
function inicio(){
 document.getElementById("txtregistro").focus();
}
function salir(){
 document.location = "salir.php";
}
function retornar(){
 document.location = "renovacion.php";
}
</script>
<body onload="inicio()">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
  <tr>
    <td align="center" valign="middle" class="body" colspan="3"><img src="images/encabezado.png" width="100%" height="250" /></td>
  </tr>
  <tr>
    <td height="50" colspan="3">&nbsp;</td>
  </tr>
  <tr>
  <td width="15%">&nbsp;</td>
    <td width="70%">
    <form name="frmasignag" action="asignar.php" method="post">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body_sistema">
      <tr>
        <td height="40" align="center" valign="middle"><strong>REGISTRO / SERIE </strong></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle">
        <input name="txtencontrado" type="text" id="txtencontrado" value="<?php echo $row_Rsencontrado['activoold']; ?>" size="10" readonly="readonly" /> /
    <input name="txtseriefind" type="text" id="txtseriefind" value="<?php echo $row_Rsencontrado['serie']; ?>" size="10" readonly="readonly" /></td>
      </tr>
      <tr>
        <td height="40" align="center" valign="middle"><strong>APLICAR RENOVACION</strong></td>
        </tr>
      <tr>
        <td height="40" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="20%" height="20">&nbsp;</td>
            <td width="40%" height="20">REGISTRO</td>
            <td width="40%" height="20">USUARIO</td>
            <td width="20%" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td width="20%" height="20">&nbsp;</td>
            <td width="40%" height="20"><input name="txtregistro" type="text" id="txtregistro" size="20" /></td>
            <td width="40%" height="20"><input name="txtusuario" type="text" id="txtusuario" size="30" /></td>
            <td width="20%" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td width="20%" height="20">&nbsp;</td>
            <td width="40%" height="20">PISO</td>
            <td width="40%" height="20">UBICACION</td>
            <td width="20%" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td height="20">&nbsp;</td>
            <td height="20"><input name="txtpiso" type="text" id="txtpiso" size="20" /></td>
            <td height="20"><input name="txtubicacion" type="text" id="txtubicacion" size="30" /></td>
            <td height="20">&nbsp;</td>
          </tr>
          <tr>
            <td width="20%" height="20">&nbsp;</td>
            <td width="40%" height="20">LOCALIDAD</td>
            <td width="40%" height="20">&nbsp;</td>
            <td width="20%" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td height="20">&nbsp;</td>
            <td height="20"><select name="cmblocalidad" id="cmblocalidad">
              <?php
do {  
?>
              <option value="<?php echo $row_Rslocalidad['idlocalidad']?>"><?php echo $row_Rslocalidad['localidad']?></option>
              <?php
} while ($row_Rslocalidad = mysql_fetch_assoc($Rslocalidad));
  $rows = mysql_num_rows($Rslocalidad);
  if($rows > 0) {
      mysql_data_seek($Rslocalidad, 0);
	  $row_Rslocalidad = mysql_fetch_assoc($Rslocalidad);
  }
?>
            </select></td>
            <td height="20">&nbsp;</td>
            <td height="20">&nbsp;</td>
          </tr>
          <tr>
            <td height="20">&nbsp;</td>
            <td height="20">SOFTWARE ADICIONAL (Separado por comas)</td>
            <td height="20">&nbsp;</td>
            <td height="20">&nbsp;</td>
          </tr>
          <tr>
            <td width="20%" height="20">&nbsp;</td>
            <td width="40%" height="20">
              <input name="txtsoftware" type="text" id="txtsoftware" size="40" />
           </td>
            <td width="40%" height="20"><label for="txtsoftware"></label></td>
            <td width="20%" height="20">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="45" align="center" valign="middle"><input name="btnasignar" type="submit" class="boton" id="btnasignar" value="     ASIGNAR    " /></td>
        </tr>
      <tr>
        <td height="45" align="center" valign="middle"><input name="bntretornar" type="button" class="boton" id="bntretornar" value="RETORNAR" onclick="retornar()"/></td>
      </tr>
      <tr>
        <td height="45" align="center" valign="middle"><input name="btnsalir" type="button" class="boton" id="btnsalir" value="       SALIR      " onclick="salir()" /></td>
      </tr>
      <tr>
        <td height="40">&nbsp;</td>
        </tr>
    </table>
    </form>
    </td>
    <td width="15%">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Rsencontrado);
mysql_free_result($Rslocalidad);
mysql_free_result($RsYaRealizado);
}else{
	  echo"<script>alert('REGISTRO YA FUE RENOVADO...'); window.location='renovacion.php'</script>";
	}
?>
