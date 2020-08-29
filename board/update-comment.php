<?php
    session_start();
    require_once("conn.php");
    require_once('utlis.php');

    $id = $_GET['id'];

    $username = NULL;
    $user = NULL;
    if(!empty($_SESSION['username'])){
        $username = $_SESSION['username'];
        $user = getUserFromUsername($username);
    }

    $stm = $conn->prepare(
        'select * from comments where id = ? and username =?'
    );
    $stm->bind_param("is",$id,$username);
    $result = $stm->execute();

    if (!$result) {
        die('Error' . $conn->error);
    }
    $result = $stm->get_result();
    $row = $result->fetch_assoc();


    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="warning">
        <strong>注意! 本站為練習用網站，註冊時請勿使用任何真實的帳號或密碼。</strong>
    </header>
    <main class="board">
        

        <h1 class="board_title">編輯留言</h1>
        <?php
            if(!empty($_GET['errCode'])){
                $code = $_GET['errCode'];
                $msg = 'Error';
                if( $code=== '1'){
                    $msg = '資料不齊全';
                }
                echo '<h3 class="error">錯誤: ' . $msg . '</h3>';
            }
        ?>

       
        <form class="new-comment-form" method="POST" action="handle-update-comment.php">
            <textarea name="content"rows="5" placeholder="請輸入留言"><?php echo $row['content'] ?></textarea>
            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            <input class="submit-btn" type="submit" value="提交">
        
    </main>
    <script>
        var btn = document.querySelector('.update-nickname');
        btn.addEventListener('click', function(){
            var form = document.querySelector('.board-nickname-form');
            form.classList.toggle('hide');
        })
    </script>
</body>
</html>