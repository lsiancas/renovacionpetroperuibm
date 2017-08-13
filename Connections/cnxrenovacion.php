<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnxrenovacion = "us-cdbr-sl-dfw-01.cleardb.net";
$database_cnxrenovacion = "ibmx_2b007a5fdcd35e5";
$username_cnxrenovacion = "bd8942ac845bbb";
$password_cnxrenovacion = "f53a99b3";
$cnxrenovacion = mysql_pconnect($hostname_cnxrenovacion, $username_cnxrenovacion, $password_cnxrenovacion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
