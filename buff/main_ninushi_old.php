<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web 荷主様向け</title>
  <link rel="stylesheet" href="main.css" />
<meta http-equiv="refresh" content="60" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include('./haisya_ninushi_sql.php'); 
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
<script>
    function popup(driver) {
        window.open('popup_nin.php?driver='+ driver, null, 'width=1200px,toolbar=no,menubar=no,scrollbars=no');
    }
</script>

</head>
<body>
	<div class="exContainer">
	<p style="text-align: right">ログイン名：<u><?php echo htmlspecialchars($_SESSION["CenterCd"], ENT_QUOTES); ?> <?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>　<BR><button onclick="location.href='logout.php'">ログアウト</button>　</u></p>  <!-- ユーザー名をechoで表示 -->
	</div>
　  <img src="Logo.png" width="80px" HEIGHT="80px">
	動態管理Web　<?php echo date('Y/m/d H:i:s', $datetime[0]) ?>現在　　
<BR>
<BR>
	最新情報
  <div class="inlineframe">
	<ul>
	<?php 
	$count_col = 1;
	foreach($rows4 as $row4){
	//センターコード照合　ログのコードはすべて参照OK
	if ($row4['CenterCd']==$_SESSION["CenterCd"]||$_SESSION["CenterCd"]=="3040"){
	if ($row4['nin_no']==$_SESSION["NinushiNM"]){
		?>
					<?php 
					if ($row4['kanryo']==1){
					?>
					<li>
						<?php echo htmlspecialchars($row4['driver_nm'],ENT_QUOTES,'UTF-8'); ?>
						<?php echo htmlspecialchars($row4['todoke'],ENT_QUOTES,'UTF-8'); ?>
						<?php echo htmlspecialchars("完了",ENT_QUOTES,'UTF-8'); ?>
						更新日時：<?php echo htmlspecialchars($row4['time'],ENT_QUOTES,'UTF-8'); ?>
					</li>
					<?php }?>
	<?php
	}else{}
	}else{}
	?>
		<?php 
		} 
		?>
	</ul>
  </div>
<BR>
<BR>
  納品先一覧
  <div class="box1">
	<?php 
	$count_col = 1;
	foreach($rows as $row){
	//センターコード照合　ログのコードはすべて参照OK
	if ($row['CenterCd']==$_SESSION["CenterCd"]||$_SESSION["CenterCd"]=="3040"){
	if ($row['nin_no']==$_SESSION["NinushiNM"]){
			if ($count_col==8){
			?>
			<?php
				$count_col = 2;
			}else{
				$count_col = $count_col+1;
			}
		?>
		<?php 
		$count_kanryo = 0;
		foreach($rows2 as $row2){
		?> 
			<?php
			if ($row2['todoke']==$row['todoke']){
					$count_kanryo = $count_kanryo + $row2['kanryo'];
			}else{}
			?>
		<?php }?>
	  <div class="driver" onclick="popup(<?="'".$row['driver']."'"?>)">
		<?php echo htmlspecialchars($row['todoke'],ENT_QUOTES,'UTF-8'); ?>　<!--進捗<?="".round($count_kanryo/$row['total_su']*100,1).""?>%-->
		<BR>
		<progress value="<?="".$count_kanryo.""?>" max="<?="".$row['total_su'].""?>" style="width: 280px; height: 10px;"><?="".round(($count_kanryo/$row['total_su'])*100,1).""?></progress>
	　</DIV>
	<?php
	}else{}
	?>
		<?php 
		} 
		} 
		?>
  </div>
</body>
</html>
