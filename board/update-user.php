<?php
	session_start();
	require_once('conn.php');
	require_once('utlis.php');

	if (empty($_POST['nickname'])) {
		header('Location: index.php?errCode=1');
		die('請輸入完整資料');
	}

	$username =  $_SESSION['username'];

	$nickname = $_POST['nickname'];

	$sql = "update user set nickname=? where username =?";
	$stm = $conn->prepare($sql);
	$stm->bind_param('ss',$nickname, $username);
	$result = $stm->execute();

	if(!$result){
		die($conn->error);
	}

	header("Location: index.php");
?>
