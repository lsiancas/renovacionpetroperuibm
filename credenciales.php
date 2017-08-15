<?php 
require_once('Connections/cnxrenovacion.php'); 
session_start(); 
$user = $_SESSION['MM_Username'];
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

mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_RsUpdate = "select * from usuarios where usuario = '$user'";
$RsUpdate = mysql_query($query_RsUpdate, $cnxrenovacion) or die(mysql_error());
$row_RsUpdate = mysql_fetch_assoc($RsUpdate);
$totalRows_RsUpdate = mysql_num_rows($RsUpdate);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css"/>
<title>RENOVACION TECNOLOGICA PETROPERU 2017</title>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
  <tr>
    <td align="center" valign="middle" class="body" colspan="3"><img src="images/encabezado.png" width="100%" height="250" /></td>
  </tr>
  <tr>
    <td height="50" colspan="3">&nbsp;</td>
  </tr>
  <tr>
  <td width="25%">&nbsp;</td>
    <td width="50%">
    <form name="frmupdate" action="update_clave.php" method="POST">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body_sistema">
      <tr class="body_sis">
        <td width="57%" height="35" align="center" valign="middle"><strong>FORMULARIO CAMBIOS CREDENCIALES</strong></td>
        <td width="43%" align="center" valign="middle" class="leftHalf">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" align="right" valign="middle">&nbsp;</td>
        <td width="43%" rowspan="6" align="center" valign="middle" class="leftHalf"><img src="images/login.png" width="128" height="128" /></td>
      </tr>
      <tr>
        <td height="10" align="right" valign="middle">NUEVA CLAVE</td>
        </tr>
      <tr>
        <td height="35" align="right" valign="middle">
          
          <input type="password" name="txtuno" id="txtuno" />
        </td>
        </tr>
      <tr>
        <td height="10" align="right" valign="middle">CONFIRMAR CLAVE</td>
        </tr>
      <tr>
        <td height="35" align="right" valign="middle">
          <input type="password" name="txtdos" id="txtdos" />
        </td>
        </tr>
      <tr>
        <td height="50" align="right" valign="middle">
          <input name="txtid" type="hidden" id="txtid" value="<?php echo $row_RsUpdate['idusuario']; ?>" />
          <input name="btnlogin" type="submit" class="boton" id="btnlogin" value="ACTUALIZAR" />
        </td>
        </tr>
    </table>
    </form>
    </td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RsUpdate);
?>
