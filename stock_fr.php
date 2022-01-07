<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="history_fr.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	session_start(); 
    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());
	if(!isset($_GET['date'])){
	$nouhinbi = date("Y/m/d");
	}else{
	$nouhinbi = $_GET['date'];
	}
	$tenban = $_SESSION["NinushiCd"];

    include('./haisya_info_sql_stock_rireki.php'); 
?>
<?php
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
?>
</head>
<body>
	<div class="exContainer">
	<p style="color: white; font-size: 20px">DAISEI LOG Web		<BR><?php echo htmlspecialchars($_SESSION["NinushiCd"], ENT_QUOTES); ?> <?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>様　配送状況　<?php echo date('Y/m/d H:i:s', $datetime[0]) ?>現在</p>
	<p style="text-align: right"><button onclick="location.href='logout.php'">ログアウト</button> </P>
	</div>
	<div class="box_nohin">
		<h1>ストック品回収履歴</h1>
			<form action="" method="post">
			<p style="float:right;">※直近 30件まで表示されます<BR>
			依頼日付検索<input name="search" type="date" cmanCLDat="USE:ON" style="width:150px;">
			<input type="submit" name="submit" value="検  索">
			<input type="submit" name="submit" value="クリア">
			</form>
			</p>
	  <div class="box1">
			<div class="table_line">
			<div class="block1">回収依頼日</div>
			<div class="block2">予定数</div>
			<div class="block3">回収数</div>
			<div class="block4">ステータス</div>
			<div class="block5">完了時間</div>
			<div class="block6"></div>
			<div class="block7"></div>
			<div class="block8"></div>
	  		</div>
		<hr class="cp_hr03" />
		<?php 
		$count = 0;
		foreach($rows0 as $row0){
		if(!empty($_POST["search"])){
			$search = $_POST["search"];
			$ordertime = mb_substr($row0['order_time'], 0, 10);
			if(strpos($ordertime,$search) !== false){
			?>
			<div class="table_line">
			<div class="block1"><?php echo htmlspecialchars($row0['order_time'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2"><?php echo htmlspecialchars($row0['yotei_suryo'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block3"><?php echo htmlspecialchars($row0['suryo'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block4">
			<?php if($row0['suryo']==0){ ?>
			キャンセル
			<?php }else{ ?>
			回収済
			<?php } ?>
			</div>
			<div class="block5"><?php echo htmlspecialchars($row0['kanryo_time'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block6"></div>
			<div class="block7"></div>
			<div class="block8"></div>
			<BR>
			</div></div>
			<hr class="cp_hr03" />
			<?php 
			$count = $count + 1;
			}}else{
			?>
			<div class="table_line">
			<div class="block1"><?php echo htmlspecialchars($row0['order_time'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2"><?php echo htmlspecialchars($row0['yotei_suryo'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block3"><?php echo htmlspecialchars($row0['suryo'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block4">
			<?php if($row0['suryo']==0){ ?>
			キャンセル
			<?php }else{ ?>
			回収済
			<?php } ?>
			</div>
			<div class="block5"><?php echo htmlspecialchars($row0['kanryo_time'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block6"></div>
			<div class="block7"></div>
			<div class="block8"></div>
			<BR>
			</div></div>

			<hr class="cp_hr03" />
			<?php 
			$count = $count + 1;
		}
			  if ($count > 29){ //30件まで表示
			    break;
			  }
		}
		?>
		</div>
	<BR><BR><BR><BR>
	 </DIV>
		  <div class="clear"></div>
	<BR><BR>
	      <div>
			<section>
	  		<a href="main_fr.php" class="btn_02">戻る</a>
			</section>
		  </div>
	</div>
</body>
</html>
