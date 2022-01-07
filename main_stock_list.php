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
	<p>ストック品回収管理</p>
  <div class="box1">
		<div class="table_line" style="height:40px">
		<div class="block1" style="background-color : lightyellow">回収依頼日</div>
		<div class="block2" style="background-color : lightyellow">店番</div>
		<div class="block1" style="background-color : lightyellow">店舗名</div>
		<div class="block2" style="background-color : lightyellow">予定数</div>
		<div class="block3" style="background-color : lightyellow">回収</div>
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


	if($_POST['stock_kanryo']){
			 //backup
			 $sql = "INSERT INTO stock_backup(order_time,tenban,tenmei,yotei_suryo,suryo,kanryo_time) SELECT order_time,tenban,tenmei,suryo,'".$_POST['stock_suryo_kakutei']."','".date('Y/m/d H:i:s', $datetime[0])."' FROM stock WHERE tenban='".$_POST['check_stock']."' AND flg='1'";
			 $result = $link->query($sql);

			 $sql = "UPDATE stock set flg='0' WHERE tenban='".$_POST['check_stock']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
			 $result = $link->query($sql);

			 $sql = "UPDATE stock set suryo=0 WHERE tenban='".$_POST['check_stock']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
			 $result = $link->query($sql);

			 $sql = "UPDATE stock set order_time='' WHERE tenban='".$_POST['check_stock']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
			 $result = $link->query($sql);
	}


	$sql = "SELECT * FROM stock WHERE left(order_time,10)='".$nouhinbi."' and flg = 1";

	$statement = $link -> query($sql);
	while($row0 = $statement->fetch()){$rows0[] = $row0;
?>
		<div class="table_line">
			<div class="block1" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['order_time'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['tenban'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block1" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['tenmei'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2" style="background-color : lightyellow"><?php echo htmlspecialchars($row0['suryo'],ENT_QUOTES,'UTF-8'); ?>c/s</div>
			<div class="block3" style="background-color : lightyellow">
				<form action="" id="form1" method="post"onSubmit="return check()">
				<input type="text" name="stock_suryo_kakutei" style="text-align: right; width:100px;" value="<?php echo htmlspecialchars($row0['suryo'],ENT_QUOTES,'UTF-8'); ?>">c/s<input type="submit" name="stock_kanryo" style="margin-left:10px" value="回収完了" />
				<input type="hidden" name="check_stock" value="<?php echo htmlspecialchars($row0['tenban'],ENT_QUOTES,'UTF-8'); ?>">
				<input type="hidden" name="check_yotei" value="<?php echo htmlspecialchars($row0['suryo'],ENT_QUOTES,'UTF-8'); ?>">
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
