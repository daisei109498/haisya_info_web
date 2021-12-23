<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="main.css" />
<meta http-equiv="refresh" content="60" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include('./haisya_info_sql.php'); 
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
</head>
<body>
	<div class="exContainer">
	<BR>
	</div>
　  <div class="box2" id="box2" style="width: 50%; height: 900px; float: left">GoogleMap</div>
	<script>
	var map;
　　var geocoder;
	var marker = [];
	var infoWindow = [];
    var latlng = []; //緯度経度の値をセット

	function initMap() {
		map = new google.maps.Map(document.getElementById('box2'), { // #box2に地図を埋め込む
			center: { // 地図の中心を指定
				lat: 36.004588, // 緯度
				lng: 139.754986 // 経度
			},
			zoom: 12 // 地図のズームを指定
		});

		var markerData = [ // マーカーを立てる場所名・緯度・経度
		<?php 
		foreach($rows0 as $row0){
		?> 
			<?php
			if ($row0['DirName']==$_GET['driver']){
			?>
			  {
			       name:<?="'".$row0['DriverName']."'"?>,
					//位置情報なければ営業所に表示
					<?php
					if (doubleval($row0['Lat'])==0){
					?>
					lat: 36.004588, // 緯度
					lng: 139.754986, // 経度
					add: '位置情報を取得できません',
					<?php
					}else{
					?>
					lat: <?=doubleval($row0['Lat'])?>, // 緯度
					lng: <?=doubleval($row0['Lng'])?>,
					add: <?="'".$row0['JusyoNow']."'"?>,
					<?php 
					} 
					?>
			        icon: './images/track.png' 
			 },
			<?php 
			} 
			?>
		<?php 
		} 
		?>
		];

		 // マーカー毎の処理
		 for (var i = 0; i < markerData.length; i++) {
	        markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']}); // 緯度経度のデータ作成
	        marker[i] = new google.maps.Marker({ // マーカーの追加
	         position: markerLatLng, // マーカーを立てる位置を指定
	         map: map // マーカーを立てる地図を指定
	       });
		 
		     infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
		         content: '<div class="sample">' + markerData[i]['name'] + '<BR>' + markerData[i]['add'] + markerLatLng +'</div>' // 吹き出しに表示する内容
		       });
		 
		     markerEvent(i); // マーカーにクリックイベントを追加

		     marker[i].setOptions({
		        icon: {
		         url: markerData[i]['icon']// マーカーの画像を変更
		       }
		   });
		      infoWindow[i].open(map, marker[i]); // 吹き出しの表示
		 }
		}
		// マーカーにクリックイベントを追加
		function markerEvent(i) {
		    marker[i].addListener('click', function() { // マーカーをクリックしたとき
		      infoWindow[i].open(map, marker[i]); // 吹き出しの表示
		  });
	}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD17RgvDK17qgnNB5Jhx1V1hnr9A_aX0yA&callback=initMap"></script>

  <div class="box1">
	<?php 
	$count_col = 1;
	foreach($rows as $row){
	
	if ($row['driver']==$_GET['driver']){

	//センターコード照合　ログのコードはすべて参照OK
	if ($row['CenterCd']==$_SESSION["CenterCd"]||$_SESSION["CenterCd"]=="3040"){

			if ($count_col==2){
			?>
			<BR>
			<?php
				$count_col = 2;
			}else{
				$count_col = $count_col+1;
			}
		?>
	  <div class="driver_pop" onclick="to<?=$row['driver']?>()">
		<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　trip:<?php echo htmlspecialchars($row['trip'],ENT_QUOTES,'UTF-8'); ?>

			<?php 
			foreach($rows0 as $row0){
			?> 
				<?php
				//位置情報
				if ($row0['DirName']==$row['driver']){
				?>
				<BR><font size="2">現在地：<?php echo htmlspecialchars($row0['JusyoNow'],ENT_QUOTES,'UTF-8'); ?>
				<BR>更新日時:<?php echo htmlspecialchars($row0['Datetime'],ENT_QUOTES,'UTF-8'); ?></font>
				<script>
				function to<?=$row['driver']?>() {
				<?php
				if (doubleval($row0['Lat'])==0){
				?>
				  map.panTo(new google.maps.LatLng(36.004588,139.754986));
				<?php
				}else{
				?>
				  map.panTo(new google.maps.LatLng(<?=doubleval($row0['Lat'])?>,<?=doubleval($row0['Lng'])?>));
				<?php
				}
				?>
				}
				</script>
				<?php
				}else{}
				?>
			<?php 
			} 
			?>
			<!-- 折り畳み展開ポインタ -->
			<!--<div onclick="obj=document.getElementById('<?=$row['driver']?>').style; obj.display=(obj.display=='none')?'block':'none';">-->
			<BR><a style="cursor:pointer;">▼納品状況</a>
			</div>
			<!--// 折り畳み展開ポインタ -->
			<!-- 折り畳まれ部分 -->
			<div id="<?=$row['driver']?>">
			<?php 
			foreach($rows2 as $row2){
			?> 
				<?php
				if ($row2['driver']==$row['driver']){
					if ($row2['driver_nm']==$row['driver_nm']){
						if ($row2['trip']==$row['trip']){
				?>
				<div class="dtable_tr">
					<div class="dtable_c_line_no">
					<!--<?php echo htmlspecialchars($row2['line_no'],ENT_QUOTES,'UTF-8'); ?>-->
					</div>
					<div class="dtable_c_todoke">
					<b><font><?php echo htmlspecialchars($row2['todoke'],ENT_QUOTES,'UTF-8'); ?></font></b><BR><font size="2">予定納品時間:<?php echo htmlspecialchars($row2['Yotei_time'],ENT_QUOTES,'UTF-8'); ?></font>
					<br><font size="2">
						<?php 
						foreach($rows3 as $row3){
						?> 
							<?php
							if ($row3['driver']==$row['driver']){
								if ($row3['driver_nm']==$row['driver_nm']){
									if ($row3['trip']==$row['trip']){
										if ($row3['line_no']==$row2['line_no']){
											if ($row3['todoke']==$row2['todoke']){
							?>
													<?php
		if ($_SESSION["CenterCd"]=="3440"||$_SESSION["CenterCd"]=="8000"){
			if (substr($row['driver'],0,1)=="d"){
			if (substr($row['trip'],0,1)=="1"){
		?>埼玉
		<?php
		}else{	
			if (substr($row['trip'],0,1)=="2"){
		?>
		千葉
		<?php
		}else{	
			if (substr($row['trip'],0,1)=="3"){
		?>
		新潟
		<?php
		}else{	
		?>
		<?php 
		} } }
		?>
		<?php
		}else{	
		?>店配
		<?php
		}
		}else{ 
		?>
		<?php echo htmlspecialchars($row3['nin_no'],ENT_QUOTES,'UTF-8'); ?>
		<?php
		}
		?>
											
											<?php echo htmlspecialchars($row3['suryo'],ENT_QUOTES,'UTF-8'); ?>/
							<?php
											}else{}
										}else{}
									}else{}
								}else{}
							}else{}
							?>
						<?php }?>
					</FONT>
					</div>
					<?php 
					if ($row2['kanryo']==1){
					?>
					<div class="dtable_c_kanryo1">
					<?php echo htmlspecialchars("完了",ENT_QUOTES,'UTF-8'); ?>
					<?php }else{ ?>
					<?php 
					if ($row2['kanryo']==2){
					?>
					<div class="dtable_c_kanryo2">
					<?php echo htmlspecialchars("作業中",ENT_QUOTES,'UTF-8'); ?>
					<?php }else{ ?>
					<div class="dtable_c_kanryo0">
					<?php echo htmlspecialchars("未完了",ENT_QUOTES,'UTF-8'); ?>
					<?php }?>
					<?php }?>
					</div>
					<div class="dtable_c_time">
					更新日時：<?php echo htmlspecialchars($row2['time'],ENT_QUOTES,'UTF-8'); ?>
					</div>
				</div>
				<?php
				}else{}
				}else{}
				}else{}
				?>
			<?php 
			} 
			?>
			</div>
			<!--// 折り畳まれ部分 -->
	　</DIV>
	<?php
	}else{}
	?>
	<?php
	}else{}
	?>
		<?php 
		} 
		?>
  </div>
  <div class="clear"></div>
</body>
</html>
