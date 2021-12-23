<?php
session_start();

$errorMessage = "登録しました。";


// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();
?>

<!doctype html>
<html>
<head>
  <title>登録完了</title>
  <link rel="stylesheet" href="main.css" />
<meta http-equiv="refresh" content="60" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
    </body>
</html>

