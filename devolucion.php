<?php require_once('Connections/cnxrenovacion.php'); ?>
<?php require_once('Connections/cnxrenovacion.php'); ?>
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

$regd_RsDevolver = "-1";
if (isset($_GET['rd'])) {
  $regd_RsDevolver = $_GET['rd'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_RsDevolver = sprintf("select o.*, lo.localidad, f.funcion  from equiposold o join localidades lo on o.idlocalidad = lo.idlocalidad join funciones f on o.idfuncion = f.idfuncion WHERE o.activoold = %s", GetSQLValueString($regd_RsDevolver, "text"));
$RsDevolver = mysql_query($query_RsDevolver, $cnxrenovacion) or die(mysql_error());
$row_RsDevolver = mysql_fetch_assoc($RsDevolver);
$totalRows_RsDevolver = mysql_num_rows($RsDevolver);

$per_RsPersona = "-1";
if (isset($_GET['us'])) {
  $per_RsPersona = $_GET['us'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_RsPersona = sprintf("select * from personas where idpersona = %s", GetSQLValueString($per_RsPersona, "text"));
$RsPersona = mysql_query($query_RsPersona, $cnxrenovacion) or die(mysql_error());
$row_RsPersona = mysql_fetch_assoc($RsPersona);
$totalRows_RsPersona = mysql_num_rows($RsPersona);

$loc_RsLocalidad = "-1";
if (isset($_GET['lo'])) {
  $loc_RsLocalidad = $_GET['lo'];
}
mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_RsLocalidad = sprintf("select lo.*, se.sede from localidades lo join sedes se on lo.idsede = se.idsede where lo.idlocalidad = %s", GetSQLValueString($loc_RsLocalidad, "text"));
$RsLocalidad = mysql_query($query_RsLocalidad, $cnxrenovacion) or die(mysql_error());
$row_RsLocalidad = mysql_fetch_assoc($RsLocalidad);
$totalRows_RsLocalidad = mysql_num_rows($RsLocalidad);

mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
$query_RsUsuario = "select * from usuarios where usuario = '$user'";
$RsUsuario = mysql_query($query_RsUsuario, $cnxrenovacion) or die(mysql_error());
$row_RsUsuario = mysql_fetch_assoc($RsUsuario);
$totalRows_RsUsuario = mysql_num_rows($RsUsuario);
 
 //Recibir otras Variables
 $fecha = date('d/m/Y');
 $registro = $row_RsDevolver['activoold'];
 $describe = $row_RsDevolver['descripcion'];
 $piso = "PISO ".$_GET['pi'];
 $ubicacion = $_GET['ar'];
 $usuario = $row_RsPersona['idpersona'];
 $persona = $row_RsPersona['persona'];
 $software = $_GET['so'];
 $serieold = $row_RsDevolver['serie'];
 $localidad = $row_RsLocalidad['localidad'];
 $funcion = $row_RsDevolver['funcion'];
 $sede = $row_RsLocalidad['sede'];
 $hoy = date('Y-m-d');
 
 //Insertar Registro
$insertar = "insert into devoluciones values ('$hoy', '$software', '$registro', '$usuario', '$row_RsLocalidad[idlocalidad]', '$row_RsUsuario[idusuario]')";
mysql_query($insertar, $cnxrenovacion) or die ("Error $insertar".mysql_error());

//Updae Registro
$update = "update equiposold set cambio = 'REALIZADO' where activoold = '$registro'";
mysql_query($update, $cnxrenovacion) or die ("Error $update".mysql_error());
 
 /*Seccion Creacion Plantilla*/
require_once dirname(__FILE__).'/PHPWord-master/src/PhpWord/Autoloader.php';
\PhpOffice\PhpWord\Autoloader::register();

use PhpOffice\PhpWord\TemplateProcessor;

$templateWord = new TemplateProcessor('devolucion.doc');
 
// --- Asignamos valores a la plantilla
$templateWord->setValue('fecha',$fecha);
$templateWord->setValue('persona',$persona);
$templateWord->setValue('usuario',$usuario);
$templateWord->setValue('piso',$piso);
$templateWord->setValue('ubicacion',$ubicacion);
$templateWord->setValue('localidad',$localidad);
$templateWord->setValue('sede',$sede);
$templateWord->setValue('registro',$registro);
//$templateWord->setValue('marca',$marca);
$templateWord->setValue('funcion',$funcion);
$templateWord->setValue('describe',$describe);
//$templateWord->setValue('procesador',$procesador);
//$templateWord->setValue('hdd',$hdd);
//$templateWord->setValue('ram',$ram);
$templateWord->setValue('serie',$serieold);
//$templateWord->setValue('monitor',$monitor);
//$templateWord->setValue('detallem',$det_monitor);
//$templateWord->setValue('seriem',$serie_monitor);
//$templateWord->setValue('teclado',$teclado);
//$templateWord->setValue('detallet',$det_teclado);
//$templateWord->setValue('seriet',$serie_teclado);
//$templateWord->setValue('mouse',$mouse);
//$templateWord->setValue('detaller',$det_mouse);
//$templateWord->setValue('serier',$serie_mouse);
$templateWord->setValue('software',$software);
//$templateWord->setValue('regold',$encontrado);

// --- Guardamos el documento
$templateWord->saveAs('$registro.doc');

header("Content-Disposition: attachment; filename=$registro.docx; charset=iso-8859-1");
echo file_get_contents('$registro.doc');
header("location:renovacion.php");      

?>
<?php
        

mysql_free_result($RsDevolver);

mysql_free_result($RsPersona);

mysql_free_result($RsLocalidad);

mysql_free_result($RsUsuario);
?>
