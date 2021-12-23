<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="main_fr.css" />
	<meta http-equiv="refresh" content="120" >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php   include('./haisya_info_sql_fr.php'); 
		    date_default_timezone_set('Asia/Tokyo');
		    $datetime = getdate(time());
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
		<p style="color: white; font-size: 20px">DAISEI LOG Web		<BR><?php echo htmlspecialchars($_SESSION["NinushiCd"], ENT_QUOTES); ?> <?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?>様　配送状況　<?php echo date('Y/m/d H:i:s', $datetime[0]) ?>現在</p>
		<p style="text-align: right"><button onclick="location.href='history_fr.php'">受領履歴検索</button><button onclick="location.href='logout.php'">ログアウト</button> </P>
	</div>
		最新情報<BR> 
	　  <div class="box2" id="box2" style="margin-right:50%; Width : 50%; height: 900px; position:absolute; top:170px; z-index: 1;">GoogleMap</div>
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
			foreach($rows8 as $row8){
			?> 
				<?php
				if ($row8['TodokeCd']==$_SESSION["NinushiCd"]){
				?>
				<?php 
				foreach($rows0 as $row0){
				?> 
				<?php
				if ($row0['DirName']==$row8['driver'] && $row8['suryo']!='分納'){
				?>
				  {
				       name:"ドライバー1便",
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
						$Lat = $row0['Lat'];
						$Lng = $row0['Lng'];
						} 
						?>
				        icon: 'images/track.png' 
				 },
				<?php 
				} 
				?>
				<?php 
				} 
				?>
				<?php 
				} 
				?>
			<?php 
			} 
			?>
			];

		    var service = new google.maps.DistanceMatrixService;
		    //出発地点の名称と緯度経度情報を設定 （必須）
		    var originName = "現在地";
		    var originPos = new google.maps.LatLng(<?=doubleval($Lat)?>, <?=doubleval($Lng)?>);
		    //目的地の名称と緯度経度情報を設定（必須）
			<?php 
			foreach($rows8 as $row8){
			if ($row8['TodokeCd']==$_SESSION["NinushiCd"]){
			?> 
		    var destinationName = <?="'".$row8['todoke']."'"?>;
		    var destinationPos = new google.maps.LatLng(<?=doubleval($row8['Lat_max'])?>, <?=doubleval($row8['Lng_max'])?>);
			<?php
			break;  
			}}?>
		    service.getDistanceMatrix({
		        origins: [originPos, originName],
		        destinations: [destinationName, destinationPos],
		        travelMode: 'DRIVING',
		        unitSystem: google.maps.UnitSystem.METRIC,
		        avoidHighways: false,
		        avoidTolls: false
		      }, function(response, status) {
		        //リクエウスの結果が返されます。
		        if (status !== 'OK') {
		          alert('Error was: ' + status);
		        } else {
					var i=0;
					var j=0;
		            var results = response.rows[i].elements;
		              var distance = results[j].distance.value;
		              var duration = results[j].duration.value;
		              var min = Math.floor(duration/60);
		              var sec = duration%60;
		              innerHTML.innerHTML='約'+min+'分後';
				}
		      });

			 // マーカー毎の処理
			 for (var i = 0; i < markerData.length; i++) {
		        markerLatLng = new google.maps.LatLng({lat: markerData[i]['lat'], lng: markerData[i]['lng']}); // 緯度経度のデータ作成
		        marker[i] = new google.maps.Marker({ // マーカーの追加
		         position: markerLatLng, // マーカーを立てる位置を指定
		         map: map // マーカーを立てる地図を指定
		       });
			 
			     infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
			         content: '<div class="sample">' + markerData[i]['name'] + '<BR>' + markerData[i]['add'] + '</div>' // 吹き出しに表示する内容
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
		<div class="driver_list"  top:170px;>
		<?php 
		$driver_count = 1;
		$count_col = 1;
		$driver_flg = 0;
		foreach($rows as $row){
		
		if ($row['TodokeCd']==$_SESSION["NinushiCd"]){

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
		  <div class="driver_pop" onclick="to<?=$row['driver']?>()" style="Width:500px margin-right:30px;">
				<?php 
				foreach($rows0 as $row0){
				?> 
					<?php
					//位置情報
					if ($row0['DirName']==$row['driver']){
					$driver_flg = 1;
					?>
					ドライバー<?=$driver_count?>便
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
					$driver_count = $driver_count +1;
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
												総納品数:<?php echo htmlspecialchars($row3['suryo'],ENT_QUOTES,'UTF-8'); ?>
												<?php
												}else{}
											}else{}
										}else{}
									}else{}
								}else{}
							}?>
						</FONT>
						<?php 
						foreach($rows9 as $row9){
							if ($row9['driver']==$row['driver']){
										if ($row9['trip']==$row['trip']){
											if ($row9['line_no_min']==$row2['line_no']){
						?> 
						<BR>
						<img src ="./images/走行中.gif" align="right">
						<?php }}}}?>
						<BR>
						<?php
						if ($_SESSION["NAME"]==$row2['todoke']){
						?>
						<button style="width:100px" onclick="location.href='nohin_fr.php?date=<?php echo $row2['haisoubi']; ?>'">納品情報</button>
						<?php } ?>
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
		<?php
		}else{}
		?>
		<?php
		}else{}
		?>
			<?php 
			} 
			?>
		<?php
		if ($driver_flg == 0){
		?> 
		<BR><BR>
		本日の配送情報はありません
		<?php
		}else{
		?>
		<BR><font size="5pt" align="center">現在地からの1便到着予想は<BR><font id="innerHTML" color="red">--分後</font>です。</font>
		<BR>※複数店舗の場合のルートや作業時間は考慮されておりません。
		<?php
		}
		?>	
		</DIV>
		<div class="clear"></div>

</body>
</html>
