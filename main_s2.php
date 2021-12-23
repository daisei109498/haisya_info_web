<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="main_s.css" />
<meta http-equiv="refresh" content="120" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include('./haisya_info_sql_s.php'); 
    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());
?>
<script>
    function popup(driver) {
        window.open('popup.php?driver='+ driver, null, 'width=1200px,height=900px,toolbar=no,menubar=no,scrollbars=no');
    }

	function jump(flg) { location.href = "main.php?s3="+flg; }

</script>

</head>
<body>
<a name="TOP"></a>
	<div class="exContainer">
	<p style="text-align: right"><BR></p>  <!-- ユーザー名をechoで表示 -->
	</div>
　  <img src="Logo.png" width="80px" HEIGHT="80px">
	<b style="font-size: 30px;">
	<?php 
	switch($_GET["CenterCd"]){
		case "3040":
	?>
		杉戸第４ハブセンター
	<?php
		break;
		case "8035":
	?>
	関西ハブセンター
	<?php
		break;
		case "3440":
	?>
	春日部ハブセンター
	<?php
		break;
		default:
	}
	?>  リアルタイム動態管理Web　
	</b>
<BR><a style="font-size: 24px;">◆◆最新の納品進捗状況◆◆　<?php echo date('Y/m/d H:i:s', $datetime[0]) ?>現在　　</a>

  <div class="box1">
	<?php 
	$count_col = 1;
	foreach($rows as $row){
	//センターコード照合　ログのコードはすべて参照OK
	if ($row['CenterCd']==$_GET["CenterCd"]||$_GET["CenterCd"]=="9999"){
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
			if(strpos($row['driver_nm'],$_POST["search"]) !== false){
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
			<?php echo htmlspecialchars($row['driver'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　trip:<?php echo htmlspecialchars($row['trip'],ENT_QUOTES,'UTF-8'); ?>　<!--進捗<?="".round($count_kanryo/$row['total_su']*100,1).""?>%-->
			<BR>
			<progress value="<?="".$row['kanryo_su'].""?>" max="<?="".$row['total_su'].""?>" style="width: 220px; height: 10px;"><?="".round(($count_kanryo/$row['total_su'])*100,1).""?></progress>
		<?php
		if ($_GET["CenterCd"]=="3440"){
			if (substr($row['driver'],0,1)=="d"){
				switch(substr($row['trip'],0,1)){
				case "1":
			?>
				集荷　埼玉
			<?php
				break;
				case "2":
			?>
				集荷　千葉
			<?php
				break;
				case "3":
			?>
				集荷　新潟
			<?php
				break;
				default:
			}
		}else{	
		?>
		店配
		<?php
		}
		}else{}
		?>
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
					<?php echo htmlspecialchars($row['driver'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　trip:<?php echo htmlspecialchars($row['trip'],ENT_QUOTES,'UTF-8'); ?>　<!--進捗<?="".round($count_kanryo/$row['total_su']*100,1).""?>%-->
					<BR>
					<progress value="<?="".$row['kanryo_su'].""?>" max="<?="".$row['total_su'].""?>" style="width: 220px; height: 10px;"><?="".round(($count_kanryo/$row['total_su'])*100,1).""?></progress>
						<?php
						if ($_GET["CenterCd"]=="3440"){
								switch(substr($row['trip'],0,1)){
								case "1":
							?>
								集荷　埼玉
							<?php
								break;
								case "2":
							?>
								集荷　千葉
							<?php
								break;
								case "3":
							?>
								集荷　新潟
							<?php
								break;
								default:
							}
						}else{}
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
					<?php echo htmlspecialchars($row['driver'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　trip:<?php echo htmlspecialchars($row['trip'],ENT_QUOTES,'UTF-8'); ?>　<!--進捗<?="".round($count_kanryo/$row['total_su']*100,1).""?>%-->
					<BR>
					<progress value="<?="".$row['kanryo_su'].""?>" max="<?="".$row['total_su'].""?>" style="width: 220px; height: 10px;"><?="".round(($count_kanryo/$row['total_su'])*100,1).""?></progress>
						<?php
						if ($_GET["CenterCd"]=="3440"){
								switch(substr($row['trip'],0,1)){
								case "1":
							?>
								集荷　埼玉
							<?php
								break;
								case "2":
							?>
								集荷　千葉
							<?php
								break;
								case "3":
							?>
								集荷　新潟
							<?php
								break;
								default:
							}
						}else{}
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
			<?php echo htmlspecialchars($row['driver'],ENT_QUOTES,'UTF-8'); ?>　<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　trip:<?php echo htmlspecialchars($row['trip'],ENT_QUOTES,'UTF-8'); ?>　<!--進捗<?="".round($count_kanryo/$row['total_su']*100,1).""?>%-->
			<BR>
			<progress value="<?="".$row['kanryo_su'].""?>" max="<?="".$row['total_su'].""?>" style="width: 220px; height: 10px;"><?="".round(($count_kanryo/$row['total_su'])*100,1).""?></progress>
			<?php
			$nou_kanryo = round(($row['kanryo_su']/$row['total_su']),1);
			if ($row['Lng']=='運行終了'|| $nou_kanryo >=1){
			?>
			<a style="font-size: 18px;">納品完了</a>
			<?php
			}else{
				if ($row['Lng']=='運行開始'||$row['Lng']>'1'){
				?>
				<a style="font-size: 18px;">運行中</a>
				<?php
				}else{//何もしない
				}
			}
			?>
		<?php
		if ($_GET["CenterCd"]=="3440"){
			if (substr($row['driver'],0,1)=="d"){
				switch(substr($row['trip'],0,1)){
				case "1":
			?>
				集荷　埼玉
			<?php
				break;
				case "2":
			?>
				集荷　千葉
			<?php
				break;
				case "3":
			?>
				集荷　新潟
			<?php
				break;
				default:
			}
		}else{	
		?>店配
		<?php
		}
		}else{}
		?>
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
<a name="END"></a>
</body>
</html>
