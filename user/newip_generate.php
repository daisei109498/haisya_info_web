<?php
 print(password_hash($_SERVER[ "REMOTE_ADDR" ], PASSWORD_DEFAULT));
 print($_SERVER[ "REMOTE_ADDR" ]);
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
<div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
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