<?php
    session_start();
    require_once("conn.php");
    require_once('utlis.php');

    $username = NULL;
    $user = NULL;
    if(!empty($_SESSION['username'])){
        $username = $_SESSION['username'];
        $user = getUserFromUsername($username);
    }

    $page = 1;
    if (!empty($_GET['page'])) {
        $page = intval($_GET['page']);
    }
    $items = 10;
    $offset = ($page - 1) * $items;


    $stm = $conn->prepare(
        'select '.
        'C.id as id, C.content as content, '.
        'C.created_at as created_at, U.nickname as nickname, U.username as username '.
        'from comments as C ' .
        'left join user as U on C.username = U.username '.
        'where C.is_deleted IS NULL '. 
        'order by C.id desc ' .
        'limit ? offset ?'
    );
    $stm->bind_param('ii', $items, $offset);
    $result = $stm->execute();
    if (!$result) {
        die('Error' . $conn->error);
    }
    $result = $stm->get_result();


    
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
        <div>
            <?php if(!$username){ ?>
            <div>
                <a class="board-btn" href="register.php">新會員註冊</a>
                <a class="board-btn" href="login.php">會員登入</a>
            </div>
            <?php } else { ?>
                <a class="board-btn" href="logout.php">會員登出</a>
                <span class="board-btn update-nickname">編輯暱稱</span>
                <h3>你好!<?php echo $user['nickname']; ?></h3>
                <form class="hide board-nickname-form" method="POST" action="update-user.php">
                    <div class="board-nickname">
                        <span>新的暱稱 : </span>
                        <input type="text" name="nickname">
                    </div>
                    <input class="submit-btn" type="submit">
                </form>
            <?php }?>
        </div>

        <h1 class="board_title">Comments</h1>
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

       
        <form class="new-comment-form" method="POST" action="handle-add-comment.php">
            <textarea name="content"rows="5" placeholder="請輸入留言"></textarea>
            <?php if($username){ ?>
                <input class="submit-btn" type="submit" value="提交">
            <?php } else{ ?>
                <h3>請登入發布留言</h3>
            <?php } ?>
        </form>
        


        <div class="board-hr"></div>

        <section>
            <?php
                while($row = $result->fetch_assoc()){
            ?>
                <div class="card">
                    <div class="card-avatar"></div>
                    <div class="card-body">
                        <div class="card-info">
                            <sapn class="card-author">
                                <?= escape($row['nickname']); ?>
                                (@<?= escape($row['username']); ?>)
                            </sapn>
                            <span class="card-time">
                                <?php echo escape($row['created_at']); ?>
                            </span>
                            <?php if ($row['username'] === $username) { ?>
                                <a href="update-comment.php?id=<?php echo $row['id'] ?>">編輯</a>
                                <a href="delete-comment.php?id=<?php echo $row['id'] ?>">刪除</a>
                            <?php } ?>
                        </div>
                        <p class="card-content">
                            <?php echo escape($row['content']); ?>
                        </p>
                    </div>
                </div>
            <?php } ?>
        </section>
        <div class="board__hr"></div>
        <?php
            $stmt = $conn->prepare(
            'select count(id) as count from comments where is_deleted IS NULL'
            );
            $result = $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count = $row['count'];
            $total_page = ceil($count / $items);
        ?>
        <div class="page-info">
            <span>總共有 <?php echo $count ?> 筆留言，頁數：</span>
            <span><?php echo $page ?> / <?php echo $total_page ?></span>
        </div>
        <div class="paginator">
            <?php if ($page != 1) { ?> 
            <a href="index.php?page=1">首頁</a>
            <a href="index.php?page=<?php echo $page - 1 ?>">上一頁</a>
            <?php } ?>
            <?php if ($page != $total_page) { ?>
            <a href="index.php?page=<?php echo $page + 1 ?>">下一頁</a>
            <a href="index.php?page=<?php echo $total_page ?>">最後一頁</a> 
            <?php } ?>
        </div>
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