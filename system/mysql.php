<?php
	$dsn = 'mysql:host=localhost;dbname=roi';
	$username = 'roi';
	$password = 'bDefYZ5nJdEt2hXT';
	$options = array();

	$dbc = new PDO($dsn, $username, $password, $options);
	$dbc->setAttribute(
		PDO::ATTR_ERRMODE,
		PDO::ERRMODE_EXCEPTION
	);