<?php
// セッション開始
session_start();

$db['host'] = "120.51.223.55;port=59371";  // DBサーバのURL
$db['user'] = "user";  // ユーザー名
$db['pass'] = "Daiseilog7151";  // ユーザー名のパスワード
$db['dbname'] = "haisya_info";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// 新規登録ボタンが押された場合
if (isset($_POST["login"])) {
    // 1. 入力チェック
    if (empty($_POST["userid"])) {  // emptyは値が空のとき
        $errorMessage = "管理コードが未入力です。"."\n";
    }
    if (empty($_POST["userpass"])) {  // emptyは値が空のとき
        $errorMessage = "パスワードが未入力です。"."\n";
    }
    if (empty($_POST["username"])) {  // emptyは値が空のとき
        $errorMessage = $errorMessage."会社名が未入力です。"."\n";
    }
    if (empty($_POST["usermail"])) {  // emptyは値が空のとき
        $errorMessage = $errorMessage."店舗コードが未入力です。"."\n";
    }

    if (!empty($_POST["userid"])) {
        // 入力したユーザIDを格納
        $userid = $_POST["userid"];
        $usercenter = $_POST["usercenter"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare('SELECT * FROM m_user WHERE CenterCd = ?');
            $stmt->execute(array($userid));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    session_regenerate_id(true);
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'このIDは既に使用されています。';
            } else {
   				if (empty($errorMessage)) {
				//データベースに登録
				 $sql = "INSERT INTO m_user(user_id, password, name, CenterCd, NinushiCd, NinushiNM)VALUES('".$_POST[userid]."', '".password_hash($_POST[userpass], PASSWORD_DEFAULT)."', '".$_POST[username]."', '3440', '".$_POST[usermail]."','ファーストリテイリング様')";
				 // クエリ実行（データを取得）
				 $result = $pdo->query($sql);
 					if (!$result) {
	 			       print('<p>登録に失敗しました。再度登録を行ってください。</p>');
				    }
				//確認画面へ遷移
                header("Location: newid_ok.php");  // 完了画面へ遷移
                exit();  // 処理終了
				}
			}
        } catch (PDOException $e) {
         		$errorMessage = "データベースエラー";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="Shift-JIS">
    <title>新規管理登録</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="all" />
</head>
<body>
<div id="form">
    <p class="form-title">FR店舗新規管理登録<BR><BR></p>
<div><font color="#ff0000"><?php echo htmlspecialchars($_SERVER[ "REMOTE_ADDR" ]); ?></font></div>
<div><font color="#ff0000"><?php echo htmlspecialchars(password_hash("210.169.200.243ukCS5", PASSWORD_DEFAULT)); ?></font></div>
    <form id="loginForm" name="loginForm" action="" method="POST">
        <p>管理コード…任意の数字</p>
        <p class="ID"><input type="text" id="userid" name="userid" placeholder="管理コードを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>"></p>
        <p>パスワード…任意の英数字</p>
        <p class="Password"><input type="password" id="userpass" name="userpass" placeholder="パスワードを入力" value="<?php if (!empty($_POST["userpass"])) {echo htmlspecialchars($_POST["userpass"], ENT_QUOTES);} ?>"></p>
        <p>ユーザー名…英数字</p>
        <p class="Name"><input type="text" id="username" name="username" placeholder="会社名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>"></p>
        <p>店舗コード</p>
        <p class="Mail"><input type="text" id="usermail" name="usermail" placeholder="店舗コードを入力" value="<?php if (!empty($_POST["usermail"])) {echo htmlspecialchars($_POST["usermail"], ENT_QUOTES);} ?>"></p>
        <p class="submit"><input type="submit" id="login" name="login" value="新規登録"></p>
    </form>
</div>
</body>
</html>