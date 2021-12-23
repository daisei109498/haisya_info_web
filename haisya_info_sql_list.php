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

	//位置情報テーブル初期化
	$sql = 'DELETE FROM driver_now';
	$statement = $link -> query($sql);

	//CSV取り込み
	$fp = fopen("../haisya/haisya_info/now.csv", "r");

	while( ! feof($fp) ) {
	 $csv = fgets($fp);
	 $csv = trim($csv,'"');
	 $csv = mb_convert_encoding($csv,"UTF-8", "utf-8");

	 $csv = str_replace('"','', $csv);
	 $csv_array = explode(",",$csv);

	 $stmt = $link -> prepare("INSERT INTO now (driver,address,lat,lng,date) VALUES (:b_rem1,:b_rem2,:b_rem3,:b_rem4,:b_rem5)");
	 $stmt->bindParam(':b_rem1', $csv_array[0], PDO::PARAM_STR);
	 $stmt->bindParam(':b_rem2', $csv_array[1], PDO::PARAM_STR);
	 $stmt->bindParam(':b_rem3', $csv_array[2], PDO::PARAM_STR);
	 $stmt->bindParam(':b_rem4', $csv_array[3], PDO::PARAM_STR);
	 $stmt->bindParam(':b_rem5', $csv_array[4], PDO::PARAM_STR);
	 $stmt->execute();
	}
	
	//改行コードの削除
	$sql = 'UPDATE haisya_info SET Lng=REPLACE (Lng,Char(13),"")';
	$statement = $link -> query($sql);
	$sql = 'UPDATE haisya_info SET Lng=REPLACE (Lng,Char(10),"")';
	$statement = $link -> query($sql);
	//改行コードの削除
	$sql = 'UPDATE now SET lng=REPLACE (lng,Char(13),"")';
	$statement = $link -> query($sql);
	$sql = 'UPDATE now SET lng=REPLACE (lng,Char(10),"")';
	$statement = $link -> query($sql);

	////納品先到着判定////
	//未完了情報取得//
	$sql = 'SELECT * FROM haisya_info WHERE kanryo<>"1" AND Lat Is Not Null And Lat<>""';
	$statement = $link -> query($sql);
	while($row6 = $statement->fetch()){
		$rows6[] = $row6;
	}
	//比較用現在地//
	$sql = 'SELECT * FROM now';
	$statement = $link -> query($sql);	
	while($row7 = $statement->fetch()){
		$rows7[] = $row7;
	}

    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());

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

			   		     //完了フラグ2 待機フラグ
						 $sql = "UPDATE haisya_info set kanryo ='2' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d H:i:s', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
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

			   		     //完了フラグ2 待機フラグ
						 $sql = "UPDATE haisya_info set kanryo ='2' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d H:i:s', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);

				}else{
			   		     //完了フラグ
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d H:i:s', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			}
			}else{
			   		     //完了フラグ
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d H:i:s', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // クエリ実行（データを取得）
						 $result = $link->query($sql);
			}
			}else{}
		}
		}else{}
		} 
	} 

	//最新の位置情報をドライバー情報に紐付け
	$sql = 'INSERT INTO driver_now SELECT * FROM now AS T1 WHERE (((Exists (SELECT * FROM now T2 WHERE T1.driver = T2.driver AND T1.date < T2.date))=False))';
	$statement = $link -> query($sql);
	//NULL削除
	$sql = 'DELETE FROM driver_now WHERE date is null';
	$statement = $link -> query($sql);
	$sql = 'UPDATE m_driver INNER JOIN driver_now ON m_driver.DirName = driver_now.driver SET m_driver.JusyoNow = driver_now.address, m_driver.Datetime = driver_now.date, m_driver.Lat = driver_now.lat, m_driver.Lng = driver_now.lng';
	$statement = $link -> query($sql);

	$sql = 'INSERT INTO now_backup select * from now;';
	$statement = $link -> query($sql);

	$sql = 'DELETE FROM now';
	$statement = $link -> query($sql);

	//CSV初期化・・・別処理

	//Mドライバー位置情報取得
	$sql = 'SELECT DriverName,CenterCd,Lat FROM m_driver where CenterCd="3440" group by DriverName order by DriverName';
	$statement = $link -> query($sql);
	//レコード件数取得
	$row_count = $statement->rowCount();
	
	while($row0 = $statement->fetch()){
		$rows0[] = $row0;
	}

	//データベース接続切断
	$dbh = null;
    
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

// ファイルクローズ
fclose($fp);

//CSVの削除
$file = '../haisya/haisya_info/now.csv';

chmod($file, 0755);
//ファイルを削除する
if (unlink($file)){
	// ファイル作成
	$fp = fopen("../haisya/haisya_info/now.csv", "w");
	// ファイルクローズ
	fclose($fp);
}
?>