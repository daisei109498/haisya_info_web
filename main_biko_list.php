<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
<meta http-equiv="refresh" content="120" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());
    $dsn = 'mysql:dbname=haisya_info;host=120.51.223.55;port=59371';
    $user = 'user';
    $password = 'Daiseilog7151';
?>
<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
	$tenban = $_SESSION["NinushiCd"];

	if(!isset($_GET['date'])){
	$nouhinbi = str_replace('/', '-', date("Y/m/d"));
	}else{
	$nouhinbi = str_replace('/', '-', $_GET['date']);
	}
?>

<style>
	.table_line {
		display: table;
		width: 1200px;
	}
	
	.block1 {
		display: table-cell;
		border: solid 1px #999;
		width: 250px;
	}
	.block2 {
		display: table-cell;
		border: solid 1px #999;
		width: 100px;
	}
	.block3 {
		display: table-cell;
		border: solid 1px #999;
		width: 500px;
	}
</style>
<script type="text/javascript"> 
<!-- 

function check(){

	if(window.confirm('店舗のみの操作です。本当に実行しますか?')){ // 確認ダイアログを表示

		return true; // 「OK」時は送信を実行

	}
	else{ // 「キャンセル」時の処理

		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false; // 送信を中止

	}

}

// -->
</script>
</head>
<body>
<section>
<a href="main.php" class="btn_02"><< 戻る</a>
</section>
	<p>店舗別メッセージ</p>
	<form action="" method="post">
		<input type="text" name="tenmei"><input name="search" type="submit" value="店舗検索"><BR><BR> 
	</form>
  <div class="box1">
		<div class="table_line" style="height:40px">
		<div class="block2" style="background-color : lightyellow">店番</div>
		<div class="block1" style="background-color : lightyellow">店舗名</div>
		<div class="block3" style="background-color : lightyellow">備考欄</div>
		</div>

<?php 


try{
	//Mysql接続 //日付,店番,店舗名,受領フラグ,受領時間,ドライバー名,完了時間,納品予定数,納品数,不足数
    $link = new PDO($dsn, $user, $password);
    if (!$link) {
        die('DataBaseError,Please Wait...'.mysql_error());
    }

    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());


	if($_POST['check_biko']){

			 $sql = "UPDATE stock set messege='".$_POST['biko_kakutei']."' WHERE tenban='".$_POST['check_biko_tenban']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
			 $result = $link->query($sql);
	}

	if($_POST['search']){
		$sql = "SELECT * FROM stock WHERE tenmei like '%".$_POST['tenmei']."%'";
	}else{
		$sql = "SELECT * FROM stock";
	}
	$statement = $link -> query($sql);
	while($row0 = $statement->fetch()){$rows0[] = $row0;
?>
		<div class="table_line">
			<div class="block2" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['tenban'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block1" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['tenmei'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block3" style="background-color : lightyellow">
				<form action="" id="form1" method="post">
				<input type="text" name="biko_kakutei" style="text-align: right; width:300px;" value="<?php echo htmlspecialchars($row0['messege'],ENT_QUOTES,'UTF-8'); ?>"><input type="submit" name="check_biko" style="margin-left:10px" value="送信" />
				<input type="hidden" name="check_biko_tenban" value="<?php echo htmlspecialchars($row0['tenban'],ENT_QUOTES,'UTF-8'); ?>">
				</form>
			</div>
		</div>
<?php
}
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}
	?>

  </div>
</body>
</html>
