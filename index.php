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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['txtusuario'])) {
  $loginUsername=$_POST['txtusuario'];
  $password=$_POST['txtclave'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "sistema.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
  
  $LoginRS__query=sprintf("SELECT usuario, clave, permitido FROM usuarios WHERE usuario=%s AND clave=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $cnxrenovacion) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $row_LoginRS = mysql_fetch_assoc($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	 if($row_LoginRS['permitido'] == 2){
     header("Location: " . $MM_redirectLoginSuccess );
	 }else{
		    header("Location: credenciales.php");
		 }
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
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
  <td width="20%">&nbsp;</td>
    <td width="60%">
    <form name="frmlogin" action="<?php echo $loginFormAction; ?>" method="POST">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body_sis">
      <tr>
        <td width="57%" height="35" align="center" valign="middle"><strong>FORMULARIO DE INGRESO</strong></td>
        <td width="43%" rowspan="6" align="center" valign="middle" class="leftHalf"><img src="images/login.png" width="128" height="128" /></td>
      </tr>
      <tr>
        <td height="20" align="right" valign="middle">USUARIO</td>
        </tr>
      <tr>
        <td height="35" align="right" valign="middle">
         
            <input type="text" name="txtusuario" id="txtusuario" />
          </td>
        </tr>
      <tr>
        <td height="20" align="right" valign="middle">CLAVE</td>
        </tr>
      <tr>
        <td height="35" align="right" valign="middle">
          <input type="password" name="txtclave" id="txtclave" />
        </td>
        </tr>
      <tr>
        <td height="35" align="right" valign="middle">
          
            <input name="btnlogin" type="submit" class="boton" id="btnlogin" value="INGRESAR" />
          </td>
        </tr>
    </table>
    </form>
    </td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>