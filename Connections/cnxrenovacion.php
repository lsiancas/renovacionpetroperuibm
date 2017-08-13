<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnxrenovacion = "localhost";
$database_cnxrenovacion = "renovacion";
$username_cnxrenovacion = "root";
$password_cnxrenovacion = "201504";
$cnxrenovacion = mysql_pconnect($hostname_cnxrenovacion, $username_cnxrenovacion, $password_cnxrenovacion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>