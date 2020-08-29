<?php
	session_start();
	require_once('conn.php');
	require_once('utlis.php');

	if (empty($_POST['content'])) {
		header('Location: index.php?errCode=1');
		die('請輸入完整資料');
	}

	$username = $_SESSION['username'];

	$content = $_POST['content'];

	$sql = "insert into comments(username, content) values(?,?)";
	$stm = $conn->prepare($sql);
	$stm->bind_param('ss',$username, $content);
	$result = $stm->execute();

	if(!$result){
		die($conn->error);
	}

	header("Location: index.php");
?>
