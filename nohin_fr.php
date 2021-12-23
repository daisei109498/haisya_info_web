<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="nohin_fr.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	session_start(); 
    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());
	$tenban = $_SESSION["NinushiCd"];
	if(!isset($_GET['date'])){
	$nouhinbi = date("Y/m/d");
	}else{
	$nouhinbi = $_GET['date'];
	}
	include('./haisya_info_sql_nohin.php'); 
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
		<h1>店舗納品書</h1>
		<?php foreach($rows1 as $row1){ 
		?>
		<div class="nohin" style="background-color : white"><u>納品日</u></div>
		<div class="nohin"><?php echo htmlspecialchars($row1['date'],ENT_QUOTES,'UTF-8'); ?></div>
		<div class="nohin" style="background-color : white"><u>店番</u>　<?php echo htmlspecialchars($row1['tenban2'],ENT_QUOTES,'UTF-8'); ?></div>
		<div class="nohin" style="background-color : white"><u>お届け先</u></div>
		<div class="nohin_nm"><?php echo htmlspecialchars($row1['tenmei2'],ENT_QUOTES,'UTF-8'); ?> 様</div>
	  <BR>
		<div class="nohin" style="background-color : white"><u>納品数</u></div>
		<?php $nohin_su=$row1['total_su']-$row1['total_husoku'];?>
		<div class="nohin"><?php echo $nohin_su; ?>c/s</div>
		<div class="nohin" style="background-color : white"><u>不足数</u></div>
		<div class="nohin"><?php echo $row1['total_husoku']; ?>c/s</div>
		<div class="nohin" style="background-color : white"><u>納品予定数</u></div>
		<div class="nohin"><?php echo $row1['total_su']; ?>c/s</div>
	  <BR>
		<?php } 
			  foreach($rows3 as $row3){
        ?>
		<form action="" method="post">
		<div class="kari" style="width:150px;"><u>仮不足数</u></div>
		<div class="kari"><?php echo $row3['kari_husoku']; ?>c/s  →<input type="text" name="kari_husoku" style="text-align: right; width:50px;" value="<?php echo $row3['kari_husoku']; ?>">c/s<button style="width: 50px; padding: 1px;" onclick="this.form.submit();">変更</button></div>
		<input type="hidden" name="check_kari_husoku" value="<?php echo htmlspecialchars($_SESSION["NinushiCd"],ENT_QUOTES,'UTF-8'); ?>">
		</form>
	  <div class="box_bottom">
	      <div class="box_juryo" style="">
			<div class="block1" style="float: right; border: solid 1px black;height: 200px;">店舗 商品受領印
			<?php 
			if ($row3['juryo_flg']!=="1"){
			?>
			<?php 
			if ($row3['juryo_flg']=="0"){
			?>				
				<form action="" method="post">
				<BR><div class="button_juryo"><button style="width: 100px; padding: 10px;" onclick="this.form.submit();">仮受領</button></div>
				<input type="hidden" name="check_kari_juryo" value="<?php echo htmlspecialchars($_SESSION["NinushiCd"],ENT_QUOTES,'UTF-8'); ?>">
				</form>
				<form action="" method="post">
				<BR><div class="button_juryo"><button style="width: 100px; padding: 10px;" onclick="this.form.submit();">受領確定</button></div>
				<input type="hidden" name="check_juryo" value="<?php echo htmlspecialchars($_SESSION["NinushiCd"],ENT_QUOTES,'UTF-8'); ?>">
				<input type="hidden" name="husokusu" value="<?php echo htmlspecialchars($row1['total_husoku'],ENT_QUOTES,'UTF-8'); ?>">
				<input type="hidden" name="nohinsu" value="<?php echo htmlspecialchars($nohin_su,ENT_QUOTES,'UTF-8'); ?>">
				</form>
			<?php }else{ ?>
				<div class="hanko2">
				<form action="" method="post">
				<BR><BR><BR><span><button class="kari-kaku" onclick="this.form.submit();" >受領確定する場合は<BR>こちらを<BR>押してください</button></span>
				<input type="hidden" name="check_juryo" value="<?php echo htmlspecialchars($_SESSION["NinushiCd"],ENT_QUOTES,'UTF-8'); ?>">
				<input type="hidden" name="husokusu" value="<?php echo htmlspecialchars($row1['total_husoku'],ENT_QUOTES,'UTF-8'); ?>">
				<input type="hidden" name="nohinsu" value="<?php echo htmlspecialchars($nohin_su,ENT_QUOTES,'UTF-8'); ?>">
				</form>
				</div>				
			<?php } ?>
			<?php }else{ ?>
				<label for="trigger">
				<div class="hanko">
				<BR><BR><BR><span><?php echo htmlspecialchars($row3['juryo_time'],ENT_QUOTES,'UTF-8'); ?></span>
				<BR><?php echo $_SESSION["NAME"]; ?>
				</div>
				</label>
				<div class="popup_wrap">
					<input id="trigger" type="checkbox">
				    <div class="popup_overlay">
				        <label for="trigger" class="popup_trigger"></label>
				        <div class="popup_content">
							<div class="center_img">
				            <label for="trigger" class="close_btn">×</label>
							受領サイン<BR>
							<img src="<?php echo htmlspecialchars($row3['juryo_img'],ENT_QUOTES,'UTF-8'); ?>" width="350px">
							</div>
				        </div>
				    </div>
				</div>
			<?php 
			}}
			?>
		　</div>
	  </div>
<BR>
	  <div class="box1">
			<div class="table_line">
			<div class="block1" style="background-color : white">部門</div>
			<div class="block2" style="background-color : white">納品数</div>
			<div class="block3" style="background-color : white">不足数</div>
			<div class="block4" style="background-color : white">納品予定数</div>
			<div class="block5" style="background-color : white">チェック欄</div>
	  		</div>
		<hr class="cp_hr03" />
		<?php 
		$count = 0;
		foreach($rows2 as $row2){
		?>
		<div class="table_line">
		<div class="block1"><?php echo htmlspecialchars($row2['bumon'],ENT_QUOTES,'UTF-8'); ?></div>
		<div class="block2"><?php echo htmlspecialchars($row2['total_su']-$row2['total_husoku'],ENT_QUOTES,'UTF-8'); ?></div>
		<div class="block3"><?php echo htmlspecialchars($row2['total_husoku'],ENT_QUOTES,'UTF-8'); ?></div>
		<div class="block4"><?php echo htmlspecialchars($row2['total_su'],ENT_QUOTES,'UTF-8'); ?></div>
		<div class="block5"></div>
		</div>
		<hr class="cp_hr03" />
		<?php 
		}
		?>
		</div>
	 </DIV>
		  <div class="clear"></div>
	<BR><BR>
	      <div>
			<section>
	  		<a href="meisai_fr.php?date=<?php echo $nouhinbi; ?>" class="btn_02">納品明細へ</a>
			</section>
		  </div>
	<BR><BR>
	      <div>
			<section>
	  		<a href="main_fr.php" class="btn_02">戻る</a>
			</section>
		  </div>
	</div>
</body>
</html>
