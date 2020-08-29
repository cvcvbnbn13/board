<?php
	session_start();
	require_once('conn.php');
	require_once('utlis.php');

	if (empty($_POST['content'])) {
		header('Location: update-comment.php?errCode=1&id=' . $_POST['id']);
		die('請輸入完整資料');
	}

	$username =  $_SESSION['username'];
	$id = $_POST['id'];
	$content = $_POST['Content'];

	$sql = "update comments set content=? where id=? and username =?";
	$stm = $conn->prepare($sql);
	$stm->bind_param('sis',$content, $id, $username);
	$result = $stm->execute();

	if(!$result){
		die($conn->error);
	}

	header("Location: index.php");
?>
