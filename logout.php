<?php
session_start();

$errorMessage = "ログアウトしました。";


// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();
?>

<!doctype html>
<html>
<head>
  <title>ログアウト</title>
  <link rel="stylesheet" href="main.css" />
<meta http-equiv="refresh" content="60" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
        <ul>
            <li><a href="index.php">ログイン画面に戻る</a></li>
        </ul>
    </body>
</html>

