<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="main.css" />
<meta http-equiv="refresh" content="60" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include('./haisya_info_sql_fr.php'); 
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
<?php 
foreach($rows8 as $row8){
?> 
	<?php
	//位置情報
	if ($row8['TodokeCd']==$SESSION['CenterCd']){
		$driver = $row8['driver'];
	}else{}
	?>
<?php 
} 
?>
</head>
<body>
	<div class="exContainer">
	DAISEI LOG 動態管理Web　<?php echo date('Y/m/d H:i:s', $datetime[0]) ?>現在　　
	<p style="text-align: right">ログイン名：<u><?php echo htmlspecialchars($_SESSION["CenterCd"], ENT_QUOTES); ?> <?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>　<button onclick="location.href='logout.php'">ログアウト</button>　</u></p>  <!-- ユーザー名をechoで表示 -->
	</div>
　  <div class="box2" id="box2" style="width: 70%; height: 1000px; float: left">GoogleMap</div>
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
			//センターコード照合　ログのコードはすべて参照OK
			if ($row0['CenterCd']==$_SESSION["CenterCd"]||$_SESSION["CenterCd"]=="3040"){
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
		        icon: 'track.png' 
		 },
			<?php
				}
			?>
		<?php 
		} 
		?>
		  {
		       name: 'ダイセーログ杉戸',
				lat: 36.004588, // 緯度
				lng: 139.754986, // 経度
				add: '埼玉県北葛飾郡杉戸町本郷528-1'
		 }
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
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLFTUVeCjWxTGZu5AoNM7ftLN_Nsh25Fs&callback=initMap"></script>

  <div class="box1">
	<?php 
	$count_col = 1;
	foreach($rows as $row){

	//センターコード照合　ログのコードはすべて参照OK
	if ($row['TodokeCd']==$_SESSION["CenterCd"]||$_SESSION["CenterCd"]=="3040"){

			if ($count_col==2){
			?>
			<BR>
			<?php
				$count_col = 2;
			}else{
				$count_col = $count_col+1;
			}
		?>
	  <div class="driver" onclick="to<?=$row['driver']?>()">
		<?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>　trip:<?php echo htmlspecialchars($row['trip'],ENT_QUOTES,'UTF-8'); ?>
			<?php 
			foreach($rows0 as $row0){
			?> 
				<?php
				//位置情報
				if ($row0['DirName']==$row['driver']){
				?>
				<BR><font size="2">現在地：<?php echo htmlspecialchars($row0['JusyoNow'],ENT_QUOTES,'UTF-8'); ?></font>
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
			<div onclick="obj=document.getElementById('<?=$row['driver']?>').style; obj.display=(obj.display=='none')?'block':'none';">
			<a style="cursor:pointer;">▼納品状況</a>
			</div>
			<!--// 折り畳み展開ポインタ -->
			<!-- 折り畳まれ部分 -->
			<div id="<?=$row['driver']?>" style="display:none;clear:both;">
			<?php 
			foreach($rows2 as $row2){
			?> 
				<?php
				if ($row2['driver']==$row['driver']){
					if ($row2['trip']==$row['trip']){
				?>
				<div class="dtable_tr">
					<div class="dtable_c_line_no">
					<!--<?php echo htmlspecialchars($row2['line_no'],ENT_QUOTES,'UTF-8'); ?>-->
					</div>
					<div class="dtable_c_todoke">
					<b><font><?php echo htmlspecialchars($row2['todoke'],ENT_QUOTES,'UTF-8'); ?></font></b>
					<br><font size="2">
						<?php 
						foreach($rows3 as $row3){
						?> 
							<?php
							if ($row3['driver']==$row['driver']){
								if ($row3['trip']==$row['trip']){
									if ($row3['line_no']==$row2['line_no']){
										if ($row3['todoke']==$row2['todoke']){
							?>
											
											<?php echo htmlspecialchars($row3['nin_no'],ENT_QUOTES,'UTF-8'); ?>
											<?php echo htmlspecialchars($row3['suryo'],ENT_QUOTES,'UTF-8'); ?>/
							<?php
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
					<div class="dtable_c_kanryo0">
					<?php echo htmlspecialchars("未完了",ENT_QUOTES,'UTF-8'); ?>
					<?php }?>
					</div>
					<div class="dtable_c_time">
					更新日時：<?php echo htmlspecialchars($row2['time'],ENT_QUOTES,'UTF-8'); ?>
					</div>
				</div>
				<?php
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
		} 
		?>
  </div>
  <div class="clear"></div>
  <img src="Logo.png" width="60px" HEIGHT="60PT">
</body>
</html>
