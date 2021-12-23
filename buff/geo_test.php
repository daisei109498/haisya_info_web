<!DOCTYPE html>
<html>
<head>
  <title>DAISEI LOG 動態管理Web</title>
  <link rel="stylesheet" href="main.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
		//map = new google.maps.Map(document.getElementById('box2'), { // #box2に地図を埋め込む
		//	center: { // 地図の中心を指定
		//		lat: 36.004588, // 緯度
		//		lng: 139.754986 // 経度
		//	},
		//	zoom: 12 // 地図のズームを指定
	//	});
		/* ジオコードオブジェクト */
     // ジオコードリクエストを送信するGeocoderの作成
      geo = new google.maps.Geocoder();
      // GeocoderRequest
      var req = {
        address: "新宿三丁目駅",
      };
      geo.geocode(req, geoResultCallback);
	}

    function geoResultCallback(result, status) {

      if (status != google.maps.GeocoderStatus.OK) {
        //alert(status);
        return;
      }
      var location = result[0].geometry.location;
      var lat = location.lat();
      var lng = location.lng();
      //map.setCenter(latlng);
      //new google.maps.Marker({position:latlng, map:map});
    }
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLFTUVeCjWxTGZu5AoNM7ftLN_Nsh25Fs&callback=initMap"></script>
</body>
</html>