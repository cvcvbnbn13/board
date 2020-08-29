<?php
  require_once("conn.php");

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

  


  $comments = array();


  while($row = $result->fetch_assoc()){
    array_push($comments, array(
      "id"=>$row['id'],
      "username" =>$row['username'],
      "nickname" =>$row['nickname'],
      "content" =>$row['content'],
      "created_at" => $row['created_at']
    ));
  }

  $json = array(
    "comments" => $comments
  );

  $response = json_encode($json);
  header('Content-type:application/json;charset=utf-8');
  echo $response;
?>