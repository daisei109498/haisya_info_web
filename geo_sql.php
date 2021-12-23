<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="360" >
</head>
<body>
<div class="box2" id="map" style="width: 50%; height: 900px; float: left">GoogleMap</div>
<?php
ini_set('max_execution_time', '-1');
header("Content-type: text/html; charset=utf-8");
 
    $dsn = 'mysql:dbname=haisya_info;host=120.51.223.55;port=59371';
    $user = 'user';
    $password = 'Daiseilog7151';

try{
	//Mysql接続
    $link = new PDO($dsn, $user, $password);
    if (!$link) {
        die('DataBaseError,Please Wait...'.mysql_error());
    }

	//m_addressを反映
	$sql = 'UPDATE m_address INNER JOIN haisya_info ON m_address.jusyo = haisya_info.jusyo SET haisya_info.Lat = m_address.lat, haisya_info.Lng = m_address.lng';
	$statement = $link -> query($sql);

	//全件チェック(緯度経度のないもの)
	$sql = 'SELECT haisya_info.* FROM haisya_info WHERE (((haisya_info.Lat) Is Null Or (haisya_info.Lat)="") AND ((haisya_info.Lng) Is Null Or (haisya_info.Lng)=""))';
	$statement = $link -> query($sql);

	//レコード件数取得
	$row_count = $statement->rowCount();
	
	while($row = $statement->fetch()){
		$rows[] = $row;
	}
	//ジオコーディングする住所配列作成
	foreach($rows as $row){
		if (trim($row['jusyo']) !== ""){
		if (empty($row['lat'])){
			$add[] = "'".trim($row['jusyo'])."'";
		 }else{}
		 }else{}
	}
?>
	<script type="text/javascript">
	setTimeout(function(){
	    //ジオコーディング開始
		initMap(<?=implode( ',', $add)?>);
	}, 1000);
	</script>
<?php
	//データベース接続切断
	$dbh = null;
    
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}
?>
<script>
	var map;
　　var geocoder;
	var marker = [];
	var infoWindow = [];
    var latlng = []; //緯度経度の値をセット
	var location;
	var lat;
	var lng;

function initMap(address1<?php
$count=2;
foreach($add as $pref){
echo ",address".$count;
$count=$count+1;
 }
?>){
    var myLatLng = {lat: 35.658581, lng: 139.745433};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: myLatLng
    });
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map
    });

	var count = 1;

	var timer = setInterval(function(){
	  //do something
	  console.log("do something");
      geo = new google.maps.Geocoder();
	  add = eval("address"+count);
	　setTimeout(geocodeAddress(geo, map, add, Results),5000);

	  if(count > <?=$count?>){
	        clearInterval(timer);
	  }
	  count++;
	},1000);

function geocodeAddress(geo, resultsMap, add, callback) 
{
      var req = {
        address: add ,
      };
       //geo.geocode(req, geoResultCallback);
		geo.geocode(req,function(result,status){
			if(status == google.maps.GeocoderStatus.OK) {
				 callback(result[0].geometry.location.lat(), result[0].geometry.location.lng(),add);
			}
		});
　　  }
}

function Results(lat,lng,add)
{
    // ジオコーディング結果を用いた処理
	//alert(add +" "+ lat+" "+lng);
    //var address = result[0].formatted_address.replace(/^日本、/, '');
    //var location = result[0].geometry.location;
    //lat = location.lat();
    //lng = location.lng();
	//phpに緯度経度送信・登録

	add = add.replace(/\u200B/g, "");  

	var data = new FormData();
	data.append("lat" , lat);
	data.append("lng" , lng);
	data.append("jusyo" , add);
	var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
	xhr.open( 'post', './getlatlng.php', true );
	xhr.send(data);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD17RgvDK17qgnNB5Jhx1V1hnr9A_aX0yA&callback=initMap"></script>
</body>
</html>
