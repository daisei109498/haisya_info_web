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

    include('./haisya_info_sql_rireki.php'); 
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
		<h1>受領履歴</h1>
			<form action="" method="post">
			<p style="float:right;">※直近 30件まで表示されます<BR>
			日付検索<input name="search" type="date" cmanCLDat="USE:ON" style="width:150px;">
			<input type="submit" name="submit" value="検  索">
			<input type="submit" name="submit" value="クリア">
			</form>
			</p>
	  <div class="box1">
			<div class="table_line">
			<div class="block1">納品日</div>
			<div class="block2"></div>
			<div class="block3">納品予定数</div>
			<div class="block4">納品数</div>
			<div class="block5">不足数</div>
			<div class="block6">ステータス</div>
			<div class="block7">完了時間</div>
			<div class="block8"></div>
	  		</div>
		<hr class="cp_hr03" />
		<?php 
		$count = 0;
		foreach($rows0 as $row0){
		if(!empty($_POST["search"])){
			$search = $_POST["search"];
			$search = str_replace("-","/",$search);
			if(strpos($row0['date'],$search) !== false){
			?>
			<div class="table_line">
			<div class="block1"><?php echo htmlspecialchars($row0['date'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2"><?php echo htmlspecialchars($row0['driver_nm'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block3"><?php echo htmlspecialchars($row0['nohin_yotei'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block4"><?php echo htmlspecialchars($row0['nohin_su'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block5"><?php echo htmlspecialchars($row0['husoku_su'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block6">
			<?php if($row0['juryo_flg']==1){ ?>
			受領済
			<?php }else{ ?>
				<?php if($row0['juryo_flg']==2){ ?>
				仮受領
				<?php }else{ ?>
				未
				<?php } ?>
			<?php } ?>
			</div>
			<div class="block7"><?php echo htmlspecialchars($row0['juryo_time'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block8">
			<section>
	  		<a href="nohin_fr.php?date=<?php echo $row0['date']; ?>" class="btn_02">納品明細</a>
			</section></div>
			<BR>
			</div></div>
			<hr class="cp_hr03" />
			<?php 
			$count = $count + 1;
			}}else{
			?>
			<div class="table_line">
			<div class="block1"><?php echo htmlspecialchars($row0['date'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2"><?php echo htmlspecialchars($row0['driver_nm'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block3"><?php echo htmlspecialchars($row0['nohin_yotei'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block4"><?php echo htmlspecialchars($row0['nohin_su'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block5"><?php echo htmlspecialchars($row0['husoku_su'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block6">
			<?php if($row0['juryo_flg']==1){ ?>
			受領済
			<?php }else{ ?>
				<?php if($row0['juryo_flg']==2){ ?>
				仮受領
				<?php }else{ ?>
				未
				<?php } ?>
			<?php } ?>
			</div>
			<div class="block7"><?php echo htmlspecialchars($row0['juryo_time'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block8">
			<section>
	  		<a href="nohin_fr.php?date=<?php echo $row0['date']; ?>" class="btn_02">納品明細</a>
			</section></div>
			<BR>
			</div></div>
			<BR>
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
