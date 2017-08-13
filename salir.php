<?php
//include("generar_backup.php");
session_start();
session_unset();
session_destroy();
header ("location:index.php"); 
?>