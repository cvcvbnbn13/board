<?php

	$server_name = 'localhost';
	$username = 'shau';
	$password = 'shau';
	$dbname = 'shau';

	$conn = new mysqli($server_name ,$username, $password, $dbname);
	
	if(!empty($conn->connect_error)) {
		die('資料庫連線錯誤:' . $conn->connect_error);
	}

	$conn->query('SET NAMES UTF8');
	$conn->query('SET time_zone = "+8:00"');