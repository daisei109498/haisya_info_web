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
<BR>
<a style="font-size: 24px;">◆最新の納品完了情報◆　<?php echo date('Y/m/d H:i:s', $datetime[0]) ?>現在　　</a>

  <div class="inlineframe">
	<ul>
	<?php 
	$count_col = 1;
	$count_gyo = 0;
	foreach((array)$rows4 as $row4){
	//センターコード照合　ログのコードはすべて参照OK
	if ($row4['CenterCd']==$_GET["CenterCd"]||$_GET["CenterCd"]=="9999"){
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
		<?php 
		$count_gyo = $count_gyo + 1;
		}?>
	<?php
	}else{}
	?>
		<?php 
		} 
	if ($count_gyo==0){
		?>
		現在、納品完了情報はありません
		<?php 
	}else{}
		?>
	</ul>
  </div>
<BR>
<BR>
<a name="END"></a>
</body>
</html>
