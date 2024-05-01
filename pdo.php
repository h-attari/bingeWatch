<?php
	$env = parse_ini_file('.env');

	$databaseHost = $env['DATABASE_HOST'];
	$databasePort = $env['DATABASE_PORT'];
	$databaseUser = $env['DATABASE_USER'];
	$databasePassword = $env['DATABASE_PASSWORD'];
	$databaseName = $env['DATABASE_NAME'];

	$pdo = new PDO(
		'mysql:host='.$databaseHost.';port='.$databasePort.';dbname='.$databaseName,
		$databaseUser, $databasePassword
	);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>