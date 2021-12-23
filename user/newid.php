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
        $errorMessage = "ユーザーIDが未入力です。"."\n";
    }
    if (empty($_POST["username"])) {  // emptyは値が空のとき
        $errorMessage = $errorMessage."ドライバー名が未入力です。"."\n";
    }
    if (empty($_POST["usercenter"])) {  // emptyは値が空のとき
        $errorMessage = $errorMessage."管理コードが未入力です。"."\n";
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

            $stmt = $pdo->prepare('SELECT * FROM m_driver WHERE DirName = ?');
            $stmt->execute(array($userid));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    session_regenerate_id(true);
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'このIDは既に使用されています。';
            } else {

   				if (empty($errorMessage)) {

		            $stmt = $pdo->prepare('SELECT * FROM m_user WHERE CenterCd = ?');
		            $stmt->execute(array($usercenter));

		            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		                    session_regenerate_id(true);
		                // 4. 認証成功なら、セッションIDを新規に発行する
					//データベースに登録
					 $sql = "INSERT INTO m_driver(CenterCd, DriverName, DirName, URL)VALUES('".$_POST[usercenter]."', '".$_POST[username]."', '".$_POST[userid]."', 'http://120.51.223.55/haisya/99999/haisya.html')";
					 // クエリ実行（データを取得）
					 $result = $pdo->query($sql);
	 					if (!$result) {
		 			       print('<p>登録に失敗しました。再度登録を行ってください。</p>');
					    }
					//確認画面へ遷移
	                header("Location: newid_ok.php");  // 完了画面へ遷移
	                exit();  // 処理終了
		            } else {
		                // 該当データなし
		                $errorMessage = '存在しない管理コードです。';
					}
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
    <title>新規ドライバー登録</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="all" />
</head>
<body>
<div id="form">
    <p class="form-title">ドライバー登録<BR><BR></p>
<div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
    <form id="loginForm" name="loginForm" action="" method="POST">
        <p>ID　※5桁半角英数</p>
        <p class="ID"><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>"></p>
        <p>ドライバー名</p>
        <p class="Name"><input type="text" id="username" name="username" placeholder="ドライバー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>"></p>
        <p>管理コードを入力…ユーザー登録時に入力した番号です。</p>
        <p class="center"><input type="text" id="usercenter" name="usercenter" placeholder="管理コードを入力" value="<?php if (!empty($_POST["usercenter"])) {echo htmlspecialchars($_POST["usercenter"], ENT_QUOTES);} ?>"></p>
        <p class="submit"><input type="submit" id="login" name="login" value="新規登録"></p>
    </form>
</div>
</body>
</html>