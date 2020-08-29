
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
        <strong>注意! 本站為練習用網站。</strong>
    </header>
    <main class="board">
        <a class="board-btn" href="index.php">返回留言板</a>
        <a class="board-btn" href="register.php">註冊</a>
        <h1 class="board_title">會員登入</h1>
        <?php
            if(!empty($_GET['errCode'])){
                $code = $_GET['errCode'];
                $msg = 'Error';
                if( $code=== '1'){
                    $msg = '資料不齊全';
                }else if($code === '2'){
                    $msg = '帳號或是密碼輸入錯誤';
                }
                echo '<h3 class="error">錯誤: ' . $msg . '</h3>';
            }
        ?>
        <form class="new-comment-form" method="POST" action="handle-login.php">
            <div class="board-nickname">
                <span>帳號 : </span>
                <input type="text" name="username">
            </div>
            <div class="board-nickname">
                <span>密碼 : </span>
                <input type="password" name="password" minlength ="6">
            </div>
            <input class="submit-btn" type="submit" value="確認">
        </form>
    </main>

</body>
</html>