<?php
  require_once('Connections/cnxrenovacion.php'); 
  $clavenew = $_POST['txtuno'];
  $idusuario = $_POST['txtid'];
  
  mysql_select_db($database_cnxrenovacion, $cnxrenovacion);
  $update  = "update usuarios set clave = '$clavenew', permitido = '2' where idusuario = '$idusuario'";
  $rsupdate = mysql_query($update, $cnxrenovacion) or die(mysql_error());
  header("location:index.php")
?>