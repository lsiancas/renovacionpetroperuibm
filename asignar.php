<?php require_once('Connections/cnxrenovacion.php'); ?>
<?php 
session_start(); 
require_once('Connections/cnxrenovacion.php'); 
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

$reg_Rsequiponew = "-1";
if (isset($_POST['txtregistro'])) {
  $reg_Rsequiponew = $_POST['txtregistro'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_Rsequiponew = sprintf("select en.*, fn.funcion from equiposnew en join funciones fn on en.idfuncion = fn.idfuncion where en.activonew = %s", GetSQLValueString($reg_Rsequiponew, "text"));
$Rsequiponew = mysql_query($query_Rsequiponew, $cnxrenovacion) or die(mysql_error());
$row_Rsequiponew = mysql_fetch_assoc($Rsequiponew);
$totalRows_Rsequiponew = mysql_num_rows($Rsequiponew);

$reg_Rsmonitor = "-1";
if (isset($_POST['txtregistro'])) {
  $reg_Rsmonitor = $_POST['txtregistro'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_Rsmonitor = sprintf("SELECT mo.idmonitor, mo.detmonitor, mo.semonitor, en.marca FROM equiposnew en join monitores mo on en.activonew = mo.activonew WHERE en.activonew = %s", GetSQLValueString($reg_Rsmonitor, "text"));
$Rsmonitor = mysql_query($query_Rsmonitor, $cnxrenovacion) or die(mysql_error());
$row_Rsmonitor = mysql_fetch_assoc($Rsmonitor);
$totalRows_Rsmonitor = mysql_num_rows($Rsmonitor);

$reg_Rsteclado = "-1";
if (isset($_POST['txtregistro'])) {
  $reg_Rsteclado = $_POST['txtregistro'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_Rsteclado = sprintf("SELECT te.idteclado, te.detteclado, te.seteclado, en.marca FROM equiposnew en join teclados te on en.activonew = te.activonew WHERE en.activonew = %s", GetSQLValueString($reg_Rsteclado, "text"));
$Rsteclado = mysql_query($query_Rsteclado, $cnxrenovacion) or die(mysql_error());
$row_Rsteclado = mysql_fetch_assoc($Rsteclado);
$totalRows_Rsteclado = mysql_num_rows($Rsteclado);

$reg_Rsmouse = "-1";
if (isset($_POST['txtregistro'])) {
  $reg_Rsmouse = $_POST['txtregistro'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_Rsmouse = sprintf("select mu.idmouse, mu.detmouse, mu.semouse, en.marca from equiposnew en join mouses mu on en.activonew = mu.activonew where en.activonew = %s", GetSQLValueString($reg_Rsmouse, "text"));
$Rsmouse = mysql_query($query_Rsmouse, $cnxrenovacion) or die(mysql_error());
$row_Rsmouse = mysql_fetch_assoc($Rsmouse);
$totalRows_Rsmouse = mysql_num_rows($Rsmouse);

$person_Rspersona = "-1";
if (isset($_POST['txtusuario'])) {
  $person_Rspersona = $_POST['txtusuario'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_Rspersona = sprintf("SELECT * FROM personas WHERE idpersona = %s", GetSQLValueString($person_Rspersona, "text"));
$Rspersona = mysql_query($query_Rspersona, $cnxrenovacion) or die(mysql_error());
$row_Rspersona = mysql_fetch_assoc($Rspersona);
$totalRows_Rspersona = mysql_num_rows($Rspersona);

$local_Rssede = "-1";
if (isset($_POST['cmblocalidad'])) {
  $local_Rssede = $_POST['cmblocalidad'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_Rssede = sprintf("SELECT lo.*, se.sede FROM localidades lo join sedes se on lo.idsede = se.idsede WHERE lo.idlocalidad = %s", GetSQLValueString($local_Rssede, "text"));
$Rssede = mysql_query($query_Rssede, $cnxrenovacion) or die(mysql_error());
$row_Rssede = mysql_fetch_assoc($Rssede);
$totalRows_Rssede = mysql_num_rows($Rssede);

mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_RsUsuario = "select *  from usuarios where usuario = '$user'";
$RsUsuario = mysql_query($query_RsUsuario, $cnxrenovacion) or die(mysql_error());
$row_RsUsuario = mysql_fetch_assoc($RsUsuario);
$totalRows_RsUsuario = mysql_num_rows($RsUsuario);

/*Registras la Renovacion*/
//Recibir Variables
$fecha = date('d/m/Y');
$encontrado = $_POST['txtencontrado'];
$registro = $_POST['txtregistro'];
$usuario = $_POST['txtusuario'];
$piso = "PISO - ".$_POST['txtpiso'];
$ubicacion = $_POST['txtubicacion'];
$local = $_POST['cmblocalidad'];
$software = $_POST['txtsoftware'];
$hoy = date('Y-m-d');


mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_Rsequipoold = "select v.*,  l.localidad, s.sede, f.funcion from equiposold v join localidades l on v.idlocalidad = l.idlocalidad join funciones f on v.idfuncion = f.idfuncion join sedes s on l.idsede = s.idsede where v.activoold = '$encontrado'";
$Rsequipoold = mysql_query($query_Rsequipoold, $cnxrenovacion) or die(mysql_error());
$row_Rsequipoold = mysql_fetch_assoc($Rsequipoold);
$totalRows_Rsequipoold = mysql_num_rows($Rsequipoold);

//Insertar Registro
$insertar = "insert into renovaciones values ('$hoy', '$piso', '$ubicacion', '$software', '$row_Rsmonitor[idmonitor]', '$row_Rsteclado[idteclado]', '$row_Rsmouse[idmouse]', '$row_Rspersona[idpersona]', '$encontrado', '$registro', '$local', '$row_RsUsuario[idusuario]')";
mysql_query($insertar, $cnxrenovacion) or die ("Error $insertar".mysql_error());

//Updae Registro
$update = "update equiposold set cambio = 'REALIZADO' where activoold = '$encontrado'";
mysql_query($update, $cnxrenovacion) or die ("Error $update".mysql_error());		 

//Obtener Variables por registro
$serienew = $row_Rsequiponew['serie'];
$describe = $row_Rsequiponew['descripcion'];
$marca = $row_Rsequiponew['marca'];
$procesador = $row_Rsequiponew['procesador']; 
$hdd = $row_Rsequiponew['disco'];
$ram = $row_Rsequiponew['memoria'];
$funcion = $row_Rsequiponew['funcion'];

//Obtener Componentes por Registro
$monitor = $row_Rsmonitor['idmonitor'];
$det_monitor = $row_Rsmonitor['detmonitor'];
$serie_monitor = $row_Rsmonitor['semonitor'];

$teclado = $row_Rsteclado['idteclado'];
$det_teclado = $row_Rsteclado['detteclado'];
$serie_teclado = $row_Rsteclado['seteclado'];

$mouse = $row_Rsmouse['idmouse'];
$det_mouse = $row_Rsmouse['detmouse'];
$serie_mouse = $row_Rsmouse['semouse'];

//Obtener Persona
$persona = $row_Rspersona['persona'];

//Obtener Sede
$sede = $row_Rssede['sede'];
$localidad = $row_Rssede['localidad'];

//Valores Devolucion
$serieold = $row_Rsequipoold['serie'];
$lold = $row_Rsequipoold['localidad'];
$sold = $row_Rsequipoold['sede'];
$fold = $row_Rsequipoold['funcion'];
$dold = $row_Rsequipoold['descripcion'];

/*Seccion Creacion Plantilla*/
require_once dirname(__FILE__).'/PHPWord-master/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\TemplateProcessor;

$templateWord = new TemplateProcessor('plantilla.doc');
 
// --- Asignamos valores a la plantilla
$templateWord->setValue('fecha',$fecha);
$templateWord->setValue('persona',$persona);
$templateWord->setValue('usuario',$usuario);
$templateWord->setValue('piso',$piso);
$templateWord->setValue('ubicacion',$ubicacion);
$templateWord->setValue('localidad',$localidad);
$templateWord->setValue('sede',$sede);
$templateWord->setValue('registro',$registro);
$templateWord->setValue('marca',$marca);
$templateWord->setValue('funcion',$funcion);
$templateWord->setValue('describe',$describe);
$templateWord->setValue('procesador',$procesador);
$templateWord->setValue('hdd',$hdd);
$templateWord->setValue('ram',$ram);
$templateWord->setValue('serie',$serienew);
$templateWord->setValue('monitor',$monitor);
$templateWord->setValue('detallem',$det_monitor);
$templateWord->setValue('seriem',$serie_monitor);
$templateWord->setValue('teclado',$teclado);
$templateWord->setValue('detallet',$det_teclado);
$templateWord->setValue('seriet',$serie_teclado);
$templateWord->setValue('mouse',$mouse);
$templateWord->setValue('detaller',$det_mouse);
$templateWord->setValue('serier',$serie_mouse);
$templateWord->setValue('software',$software);
$templateWord->setValue('regold',$encontrado);
$templateWord->setValue('serieold',$serieold);
$templateWord->setValue('lold',$lold);
$templateWord->setValue('sold',$sold);
$templateWord->setValue('fold',$fold);
$templateWord->setValue('dold',$dold);


// --- Guardamos el documento
$templateWord->saveAs('$registro.docx');

header("Content-Disposition: attachment; filename=$registro.doc; charset=iso-8859-1");
echo file_get_contents('$registro.doc');
header("location:renovacion.php");        

mysql_free_result($Rsequiponew);

mysql_free_result($Rsmonitor);

mysql_free_result($Rsteclado);

mysql_free_result($Rsmouse);

mysql_free_result($Rspersona);

mysql_free_result($Rssede);

mysql_free_result($RsUsuario);

mysql_free_result($Rsequipoold);

?>
