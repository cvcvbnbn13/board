<?php
  session_start();
  require_once('conn.php');
  require_once('utlis.php');

  if (
    empty($_POST['username']) ||
    empty($_POST['password']) 
  ) {
    header('Location: login.php?errCode=1');
    die();
  }

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql ="select * from user where username=?";
  $stm = $conn->prepare($sql);
  $stm->bind_param("s",$username);
  $result = $stm->execute();

  if (!$result) {
    die($conn->error);
  }

  $result = $stm->get_result();
  if($result->num_rows === 0){
    header("Location: login.php?errCode=2");
    exit();
  }

  // 有查到使用者
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])){
    $_SESSION['username'] = $username;
	  header('Location: index.php');
  } else {
    header("Location: login.php?errCode=2");
  }

?>