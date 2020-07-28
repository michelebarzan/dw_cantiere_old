<?php
$serverName = 'sql-dew-gpc1-srv1.database.windows.net';
$connectionInfo=array("Database"=>"dw_dati", "UID"=>"sysadmin", "PWD"=>"P@ssw0rdSQLGpC1");

$conn = sqlsrv_connect($serverName,$connectionInfo);

if(!$conn)
{
	echo "<b style='color:red'>Connection with the database failed</b><br><br>";
	die(print_r(sqlsrv_errors(),TRUE));
}

?>