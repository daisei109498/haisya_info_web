<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="main.css" />
<meta http-equiv="refresh" content="120" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include('./haisya_info_sql_other.php'); 
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
        window.open('popup.php?driver='+ driver, null, 'width=1200px,height=900px,toolbar=no,menubar=no,scrollbars=no');
    }

	function jump(flg) { location.href = "main.php?s3="+flg; }

</script>

</head>
<body>
	<div class="exContainer">
	<p style="text-align: right">ログイン名：<u><?php echo htmlspecialchars($_SESSION["NinushiCd"], ENT_QUOTES); ?> <?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>　<BR><button onclick="location.href='logout.php'">ログアウト</button>　</u></p>  <!-- ユーザー名をechoで表示 -->
	</div>
　  <img src="images/Logo.png" width="80px" HEIGHT="80px">
	動態管理Web　<?php echo date('Y/m/d H:i:s', $datetime[0]) ?>現在　　
<BR>
<BR>
	最新情報
  <div class="inlineframe">
	<ul>
	<?php 
	$count_col = 1;
	foreach((array)$rows4 as $row4){
	//センターコード照合　ログのコードはすべて参照OK
	if ($row4['CenterCd']==$_SESSION["CenterCd"]||$_SESSION["CenterCd"]=="9999"){
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
	?>
		<?php 
		} 
		?>
	</ul>
  </div>
<form action="main_other.php" method="post" name="form1">
検索したい店舗名を入力してください。<input type="search" name="search" placeholder="店舗名を入力">
<input type="submit" name="submit" value="検索"><input type="submit" name="reset" value="リセット">
</form>
  <div class="box1">
	<?php 
	$count_col = 1;
	foreach($rows as $row){
	//センターコード照合　ログのコードはすべて参照OK
	if ($row['CenterCd']==$_SESSION["CenterCd"]||$_SESSION["CenterCd"]=="9999"){
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
				if ($row2['driver']==$row['driver']){
					if ($row2['trip']==$row['trip']){
						if ($row2['kanryo']=='1'){
						$count_kanryo = $count_kanryo + 1;
						}else{}
					}else{}
				}else{}
			?>
		<?php }?>
		<?php
		if(!empty($_POST["search"])){
			if(strpos($row['todoke'],$_POST["search"]) !== false){
				if ($row['YousyaCd']=='0'){
		?>
				  <div class="driver" onclick="popup(<?="'".$row['driver']."'"?>)">
				<?php
				}else{
				?>
				  <div class="driver_y" onclick="popup(<?="'".$row['driver']."'"?>)">
				<?php
				}
				?>
			<?php echo htmlspecialchars($row['todoke'],ENT_QUOTES,'UTF-8'); ?>		
		<?php
		if ($_SESSION["CenterCd"]=="3440"){
			if (substr($row['driver'],0,1)=="d"){
				switch(substr($row['trip'],0,1)){
				case "1":
			?>
				(埼玉)
			<?php
				break;
				case "2":
			?>
				(千葉)
			<?php
				break;
				case "3":
			?>
				(新潟)
			<?php
				break;
				case "4":
			?>
				(北関東)
			<?php
				break;
				default:
			}
		}else{	
		?>
		<?php
		}
		}else{
?>
<?php
}
?>
<!--進捗<?="".round($count_kanryo/$row['total_su']*100,1).""?>%-->
			<BR>
					<progress value="<?="".$row['kanryo_su'].""?>" max="<?="".$row['total_su'].""?>" style="width: 280px; height: 10px;"><?="".round(($count_kanryo/$row['total_su'])*100,1).""?></progress>
					<BR>配達担当者:<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　
		　</DIV>
		<?php
			}else{}
		}else{//検索バー未入力の場合//
			if ($s3=='2'||$s3=='3'){
			switch($s3){
				case "2":
					if (substr($row['driver'],0,1)=="d"){
						if ($row['YousyaCd']=='0'){
					?>
						  <div class="driver" onclick="popup(<?="'".$row['driver']."'"?>)">
						<?php
						}else{
						?>
						  <div class="driver_y" onclick="popup(<?="'".$row['driver']."'"?>)">
						<?php
						}
						?>
					<?php echo htmlspecialchars($row['todoke'],ENT_QUOTES,'UTF-8'); ?>		<?php
		if ($_SESSION["CenterCd"]=="3440"){
			if (substr($row['driver'],0,1)=="d"){
				switch(substr($row['trip'],0,1)){
				case "1":
			?>
				(埼玉)
			<?php
				break;
				case "2":
			?>
				(千葉)
			<?php
				break;
				case "3":
			?>
				(新潟)
			<?php
				break;
				case "4":
			?>
				(北関東)
			<?php
				break;
				default:
			}
		}else{	
		?>
		<?php
		}
		}else{
		?>
		<?php
		}
		?>
					<BR>
					<progress value="<?="".$row['kanryo_su'].""?>" max="<?="".$row['total_su'].""?>" style="width: 280px; height: 10px;"><?="".round(($count_kanryo/$row['total_su'])*100,1).""?></progress>
					<BR>配達担当者:<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　
<?php
					}else{}
				break;
				case "3":
					if (substr($row['driver'],0,1)!="d"){
						if ($row['YousyaCd']=='0'){
					?>
						  <div class="driver" onclick="popup(<?="'".$row['driver']."'"?>)">
						<?php
						}else{
						?>
						  <div class="driver_y" onclick="popup(<?="'".$row['driver']."'"?>)">
						<?php
						}
						?>
					<?php echo htmlspecialchars($row['todoke'],ENT_QUOTES,'UTF-8'); ?>		
					<?php
					if ($_SESSION["CenterCd"]=="3440"){
						if (substr($row['driver'],0,1)=="d"){
							switch(substr($row['trip'],0,1)){
							case "1":
						?>
							(埼玉)
						<?php
							break;
							case "2":
						?>
							(千葉)
						<?php
							break;
							case "3":
						?>
							(新潟)
						<?php
							break;
							case "4":
						?>
							(北関東)
						<?php
							break;
							default:
						}
					}else{	
					?>

					<?php
					}
					}else{
			?>

			<?php
			}
			?>					<BR>
					<progress value="<?="".$row['kanryo_su'].""?>" max="<?="".$row['total_su'].""?>" style="width: 280px; height: 10px;"><?="".round(($count_kanryo/$row['total_su'])*100,1).""?></progress>
					<BR>配達担当者:<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　
					<?php
					}else{}
				break;
				default:
			}
					?>
			　</DIV>
		<?php 
			}else{ //すべて表示
				if ($row['YousyaCd']=='0'){
			?>
				  <div class="driver" onclick="popup(<?="'".$row['driver']."'"?>)">
				<?php
				}else{
				?>
				  <div class="driver_y" onclick="popup(<?="'".$row['driver']."'"?>)">
				<?php
				}
				?>
			<?php echo htmlspecialchars($row['todoke'],ENT_QUOTES,'UTF-8'); ?>					<?php
					if ($_SESSION["CenterCd"]=="3440"){
						if (substr($row['driver'],0,1)=="d"){
							switch(substr($row['trip'],0,1)){
							case "1":
						?>
							(埼玉)
						<?php
							break;
							case "2":
						?>
							(千葉)
						<?php
							break;
							case "3":
						?>
							(新潟)
						<?php
							break;
							case "4":
						?>
							(北関東)
						<?php
							break;
							default:
						}
					}else{	
					?>

					<?php
					}
					}else{
			?>
			<?php
			}
			?>
			<BR>
					<progress value="<?="".$row['kanryo_su'].""?>" max="<?="".$row['total_su'].""?>" style="width: 280px; height: 10px;"><?="".round(($count_kanryo/$row['total_su'])*100,1).""?></progress>

			<BR>配達担当者:<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　

		　</DIV>
		<?php 
		} }
		?>
	<?php
	}else{}
	?>
		<?php 
		} 
		?>
  </div>
</body>
</html>
