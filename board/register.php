
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
        <a class="board-btn" href="login.php">會員登入</a>
        <h1 class="board_title">註冊</h1>
        <?php
            if(!empty($_GET['errCode'])){
                $code = $_GET['errCode'];
                $msg = 'Error';
                if( $code=== '1'){
                    $msg = '資料不齊全';
                }elseif ($code==='2') {
                    $msg = '帳號已被註冊';
                }
                echo '<h3 class="error">錯誤: ' . $msg . '</h3>';
            }
        ?>
        <form class="new-comment-form" method="POST" action="handle-register.php">
            <div class="board-nickname">
                <span>暱稱 : </span>
                <input type="text" name="nickname">
            </div>
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