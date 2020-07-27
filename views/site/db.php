<?php
	define("DB_HOST", "localhost");
	define("DB_LOGIN", "root");
	define("DB_PASSWORD", "");
	define("DB_NAME", "dbtesttask");
	#define('ORDERS_LOG', "orders.log");
	$count = 0;
	$mysql = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_error($mysql));
?>