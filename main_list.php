<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="main.css" />
<meta http-equiv="refresh" content="120" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include('./haisya_info_sql_list.php'); 
    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());
?>
<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
?>

<style>
	.table_line {
		display: table;
		width: 600px;
	}
	
	.block1 {
		display: table-cell;
		border: solid 1px #999;
		width: 100px;
	}
	.block2 {
		display: table-cell;
		border: solid 1px #999;
		width: 200px;
	}
	.block3 {
		display: table-cell;
		border: solid 1px #999;
		width: 50px;
	}
</style>

</head>
<body>
	<p>端末稼働情報</p>
  <div class="box1">
		<div class="table_line">
		<div class="block1" style="background-color : lightyellow">運送会社</div>
		<div class="block2" style="background-color : lightyellow">ドライバー名</div>
		<div class="block3" style="background-color : lightyellow">合計</div>
		</div>
	<?php 
	$count = 0;
	foreach($rows0 as $row0){
	//センターコード照合　ログのコードはすべて参照OK
	if ($row0['CenterCd']==$_SESSION["CenterCd"]){
	if ($row0['Lat']!=""){
	?>
	<?php
		$group_name = $row0['DriverName'];
		if($group_backup != mb_substr($group_name,0,4,'utf8') && $count != 0){
		?>
		<div class="table_line">
		<div class="block1" style="background-color : lightyellow"></div>
		<div class="block2" style="background-color : lightyellow"></div>
		<div class="block3" style="background-color : lightyellow">合計　<?php echo htmlspecialchars($count,ENT_QUOTES,'UTF-8'); ?>台</div>
		</div>
		<?php
			$group_backup = mb_substr($group_name,0,4,'utf8');
			$count = 1;
			}else{
			$count = $count + 1;
			}
		?>
	<div class="table_line">
	<div class="block1"><?php echo htmlspecialchars(mb_substr($group_name,0,4,'utf8'),ENT_QUOTES,'UTF-8'); ?></div>
	<div class="block2"><?php echo htmlspecialchars($row0['DriverName'],ENT_QUOTES,'UTF-8'); ?></div>
	<div class="block3"></div>
	</div>
	<?php 
	}}}
	?>
	<div class="table_line">
	<div class="block1" style="background-color : lightyellow"></div>
	<div class="block2" style="background-color : lightyellow"></div>
	<div class="block3" style="background-color : lightyellow">合計　<?php echo htmlspecialchars($count,ENT_QUOTES,'UTF-8'); ?>台</div>
	</div>
  </div>
</body>
</html>
