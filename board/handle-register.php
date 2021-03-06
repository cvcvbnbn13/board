<?php
	session_start();
	require_once('conn.php');

	if (empty($_POST['nickname']) || 
		empty($_POST['username']) ||
		empty($_POST['password'])) 
	{
		header('Location: register.php?errCode=1');
		die('請輸入完整資料');
	}

	$nickname = $_POST['nickname'];
	$username = $_POST['username'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	$sql = "insert into user(nickname, username , password) values(?,?,?)";
	$stm = $conn->prepare($sql);
	$stm->bind_param('sss',$nickname,$username,$password);
	$result = $stm->execute();

  	if (!$result) {
		$code = $conn->errno;
		if ($code === 1062) {
		header('Location: register.php?errCode=2');
		}
		die($conn->error);
  	}
  	$_SESSION['username'] = $username;
	header("Location: index.php");
?>
