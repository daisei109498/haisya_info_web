<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="meisai_fr.css" />
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
	include('./haisya_info_sql_meisai.php'); 
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
		<h1>店舗納品書--明細--</h1>
		<p style="text-align: right"><a href="download.php?date=<?php echo $nouhinbi; ?>">CSVダウンロード</a>  <a href="print.php?date=<?php echo $nouhinbi; ?>" target="_blank">印刷</a></p>
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
		<?php } 
			foreach($rows3 as $row3){
        ?>
		<div class="nohin" style="background-color : white"><u>納品予定数</u></div>
		<div class="nohin"><?php echo $row1['total_su']; ?>c/s</div>
		<BR>
		<div class="nohin" style="background-color : white"><u>仮不足数</u></div>
		<div class="nohin"><?php echo $row3['kari_husoku']; ?>c/s</div>
		<?php } ?>
		<BR>
		<div style="float: right">
		<form action="" method="post">
		<input type="search" name="search" style="font-size: 25px; width: 500px" placeholder="管理Noを入力してください">
		<input type="submit" name="submit" value="検  索" style="font-size: 20px">
		<input type="submit" name="submit" value="クリア" style="font-size: 20px">
		</form>
		</div>
		<BR><BR>
	  <div class="box1">
			<div class="table_line">
			<div class="block1" style="background-color : white">管理NO</div>
			<div class="block2" style="background-color : white">部門</div>
			<div class="block3" style="background-color : white">代表商品</div>
			<div class="block4" style="background-color : white">代表商品名</div>
			<div class="block5" style="background-color : white">振出店名</div>
			<div class="block6" style="background-color : white">不足チェック</div>
	  		</div>
		<hr class="cp_hr03"/>
		<?php 
		$count = 0;
		foreach($rows0 as $row0){
		if(!empty($_POST["search"])){
			$kanri_no = str_replace("-","",$row0['kanri_no']);
			$search = mb_convert_kana($_POST["search"],"n");
			if(strpos($kanri_no,$search) !== false){
			if ($row0['husoku_flg']==1){
			?>
			<div class="table_line" style="color:red;">
			<div class="block1"><?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2"><?php echo htmlspecialchars($row0['bumon'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block3"><?php echo htmlspecialchars($row0['shohin'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block4"><?php echo htmlspecialchars($row0['shohin_nm'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block5"><?php echo htmlspecialchars($row0['huridashi'],ENT_QUOTES,'UTF-8'); ?></div>
				<?php 
				foreach($rows3 as $row3){
				if ($row3['juryo_flg']=="1"){
				?>
				<div class="block6"><form action="" method="post"><input disabled="disabled" type="checkbox" onClick="this.form.submit();" id="checkbox" name="checkbox" <?= $row0['husoku_flg']==1 ? 'checked' : '' ?>>
				<input type="hidden" name="check_husoku" value="<?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?>">
				</form>
				<?php }else{ ?>
				<div class="block6"><form action="" method="post"><input type="checkbox" onClick="this.form.submit();" id="checkbox" name="checkbox" <?= $row0['husoku_flg']==1 ? 'checked' : '' ?>>
				<input type="hidden" name="check_husoku" value="<?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?>">
				</form>
				<?php }} ?>
			</div></div>
			<hr class="cp_hr03" />
			<?php
			}else{
			?>
			<div class="table_line">
			<div class="block1"><?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2"><?php echo htmlspecialchars($row0['bumon'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block3"><?php echo htmlspecialchars($row0['shohin'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block4"><?php echo htmlspecialchars($row0['shohin_nm'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block5"><?php echo htmlspecialchars($row0['huridashi'],ENT_QUOTES,'UTF-8'); ?></div>
				<?php 
				foreach($rows3 as $row3){
				if ($row3['juryo_flg']=="1"){
				?>
				<div class="block6"><form action="" method="post"><input disabled="disabled" type="checkbox" onClick="this.form.submit();" id="checkbox" name="checkbox" <?= $row0['husoku_flg']==1 ? 'checked' : '' ?>>
				<input type="hidden" name="check_husoku" value="<?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?>">
				</form>
				<?php }else{ ?>
				<div class="block6"><form action="" method="post"><input type="checkbox" onClick="this.form.submit();" id="checkbox" name="checkbox" <?= $row0['husoku_flg']==1 ? 'checked' : '' ?>>
				<input type="hidden" name="check_husoku" value="<?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?>">
				</form>
				<?php }} ?>
			</div>
			</div>
			<hr class="cp_hr03" />
			<?php 
			}}
			}else{
			if ($row0['husoku_flg']==1){
			?>
			<div class="table_line" style="color:red;">
			<div class="block1"><?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2"><?php echo htmlspecialchars($row0['bumon'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block3"><?php echo htmlspecialchars($row0['shohin'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block4"><?php echo htmlspecialchars($row0['shohin_nm'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block5"><?php echo htmlspecialchars($row0['huridashi'],ENT_QUOTES,'UTF-8'); ?></div>
				<?php 
				foreach($rows3 as $row3){
				if ($row3['juryo_flg']=="1"){
				?>
				<div class="block6"><form action="" method="post"><input disabled="disabled" type="checkbox" onClick="this.form.submit();" id="checkbox" name="checkbox" <?= $row0['husoku_flg']==1 ? 'checked' : '' ?>>
				<input type="hidden" name="check_husoku" value="<?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?>">
				</form>
				<?php }else{ ?>
				<div class="block6"><form action="" method="post"><input type="checkbox" onClick="this.form.submit();" id="checkbox" name="checkbox" <?= $row0['husoku_flg']==1 ? 'checked' : '' ?>>
				<input type="hidden" name="check_husoku" value="<?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?>">
				</form>
				<?php }} ?>			</div></div>
			<hr class="cp_hr03" />
			<?php
			}else{
			?>
			<div class="table_line">
			<div class="block1"><?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block2"><?php echo htmlspecialchars($row0['bumon'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block3"><?php echo htmlspecialchars($row0['shohin'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block4"><?php echo htmlspecialchars($row0['shohin_nm'],ENT_QUOTES,'UTF-8'); ?></div>
			<div class="block5"><?php echo htmlspecialchars($row0['huridashi'],ENT_QUOTES,'UTF-8'); ?></div>
				<?php 
				foreach($rows3 as $row3){
				if ($row3['juryo_flg']=="1"){
				?>
				<div class="block6"><form action="" method="post"><input disabled="disabled" type="checkbox" onClick="this.form.submit();" id="checkbox" name="checkbox" <?= $row0['husoku_flg']==1 ? 'checked' : '' ?>>
				<input type="hidden" name="check_husoku" value="<?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?>">
				</form>
				<?php }else{ ?>
				<div class="block6"><form action="" method="post"><input type="checkbox" onClick="this.form.submit();" id="checkbox" name="checkbox" <?= $row0['husoku_flg']==1 ? 'checked' : '' ?>>
				<input type="hidden" name="check_husoku" value="<?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?>">
				</form>
				<?php }} ?>			</div>
			</div>
			<hr class="cp_hr03" />
			<?php 
			}
		}}
		?>
		</div>
<BR><BR>
	      <div>
			<section>
	  		<a href="nohin_fr.php?date=<?php echo $nouhinbi; ?>" class="btn_02">納品情報へ</a>
			</section>
		  </div>
</body>
</html>
