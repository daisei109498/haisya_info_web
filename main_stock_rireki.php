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
		width: 200px;
	}
	.block2 {
		display: table-cell;
		border: solid 1px #999;
		width: 100px;
	}
	.block3 {
		display: table-cell;
		border: solid 1px #999;
		width: 300px;
	}
</style>
</head>
<body>
<section>
<a href="main.php" class="btn_02"><< 戻る</a>
</section>
	<p>ストック品回収履歴</p>
	<form action="" method="GET">
		<input type="date" name="date"><input type="submit" value="更新"><BR>
	</form><BR>
		<button onclick="location.href='download_stock.php?date=<?php echo htmlspecialchars($_GET['date'],ENT_QUOTES,'UTF-8'); ?>'">ダウンロード</button>
  <div class="box1">
		<div class="table_line" style="height:40px">
		<div class="block1" style="background-color : lightyellow">回収依頼日</div>
		<div class="block2" style="background-color : lightyellow">店番</div>
		<div class="block1" style="background-color : lightyellow">店舗名</div>
		<div class="block2" style="background-color : lightyellow">予定数</div>
		<div class="block2" style="background-color : lightyellow">回収数</div>
		<div class="block1" style="background-color : lightyellow">完了時間</div>
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

	$sql = "SELECT * FROM stock_backup WHERE left(order_time,10)='".$nouhinbi."'";

	$statement = $link -> query($sql);
	while($row0 = $statement->fetch()){$rows0[] = $row0;
?>
		<div class="table_line">
			<div class="block1" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['order_time'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['tenban'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block1" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['tenmei'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['yotei_suryo'],ENT_QUOTES,'UTF-8'); ?>c/s</div>
			<div class="block2" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['suryo'],ENT_QUOTES,'UTF-8'); ?>c/s</div>
			<div class="block1" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['kanryo_time'],ENT_QUOTES,'UTF-8'); ?></div>
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
