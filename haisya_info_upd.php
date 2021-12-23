<?php
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

    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());

	////納品先到着判定////
	//未完了情報取得//
	$sql = 'SELECT * FROM haisya_info WHERE kanryo="0" AND Lat Is Not Null AND Lat<>"" AND haisoubi="'.date('Y/m/d', $datetime[0]).'"';
	$statement = $link -> query($sql);
	while($row6 = $statement->fetch()){
		$rows6[] = $row6;
	}
	//比較用現在地//
	$sql = 'SELECT * FROM now_backup';
	$statement = $link -> query($sql);	
	while($row7 = $statement->fetch()){
		$rows7[] = $row7;
	}

	//照合処理
	foreach((array)$rows6 as $row6){
		//最小値・最大値の格納
		$lat_nou = intval(round(strval($row6['Lat'])*1000));
		$lng_nou = intval(round(strval($row6['Lng'])*1000));
//		$lat_min = intval(round((strval($row6['Lat'])-0.005)*100));
//		$lat_max = intval(round((strval($row6['Lat'])+0.005)*100));
//		$lng_min = intval(round((strval($row6['Lng'])-0.005)*100));
//		$lng_max = intval(round((strval($row6['Lng'])+0.005)*100));

		foreach((array)$rows7 as $row7){

		$lat_now = intval(round($row7['lat']*1000));
		$lng_now = intval(round($row7['lng']*1000));

		//位置情報の照合
		if ($row6['driver']==$row7['driver']){
		if ($row6['kanryo']=='0'){
			if ($lat_nou==$lat_now||$lat_nou+1==$lat_now||$lat_nou+2==$lat_now||$lat_nou+3==$lat_now||$lat_nou+4==$lat_now||$lat_nou+5==$lat_now||$lat_nou-1==$lat_now||$lat_nou-2==$lat_now||$lat_nou-3==$lat_now||$lat_nou-4==$lat_now||$lat_nou-5==$lat_now){
				if ($lng_nou==$lng_now||$lng_nou+1==$lng_now||$lng_nou+2==$lng_now||$lng_nou+3==$lng_now||$lng_nou+4==$lng_now||$lng_nou+5==$lng_now||$lng_nou-1==$lng_now||$lng_nou-2==$lng_now||$lng_nou-3==$lng_now||$lng_nou-4==$lng_now||$lng_nou-5==$lng_now){

			   		     //完了フラグ2 
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);

						//前の納品先の完了フラグチェック
						if ($row6['line_no']!='1'){
			   		     //完了フラグ1
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND line_no<'".$row6['line_no']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
						}else{}
				}else{}
			}else{}
		}else{
			if ($row6['kanryo']=='2'){
			if ($lat_nou==$lat_now||$lat_nou+1==$lat_now||$lat_nou+2==$lat_now||$lat_nou+3==$lat_now||$lat_nou+4==$lat_now||$lat_nou+5==$lat_now||$lat_nou-1==$lat_now||$lat_nou-2==$lat_now||$lat_nou-3==$lat_now||$lat_nou-4==$lat_now||$lat_nou-5==$lat_now){
				if ($lng_nou==$lng_now||$lng_nou+1==$lng_now||$lng_nou+2==$lng_now||$lng_nou+3==$lng_now||$lng_nou+4==$lng_now||$lng_nou+5==$lng_now||$lng_nou-1==$lng_now||$lng_nou-2==$lng_now||$lng_nou-3==$lng_now||$lng_nou-4==$lng_now||$lng_nou-5==$lng_now){

			   		     //完了フラグ2 
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);

				}else{
			   		     //完了フラグ
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			}
			}else{
			   		     //完了フラグ
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			}
			}else{}
		}
		}else{}
		} 
	}
	//データベース接続切断
	$dbh = null;
    
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

?>