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
	$sql = 'SELECT * FROM m_driver';
	$statement = $link -> query($sql);
	//レコード件数取得
	$row_count = $statement->rowCount();
	
	while($row0 = $statement->fetch()){
		$rows0[] = $row0;
	}


	//届け先別グルーピング
	$sql = 'SELECT haisoubi,TodokeCd,todoke,driver,driver_nm,trip,nin_no FROM haisya_info GROUP BY haisoubi,TodokeCd,todoke,driver,nin_no';
	$statement = $link -> query($sql);
	
	//レコード件数取得
	$row_count = $statement->rowCount();
	
	while($row = $statement->fetch()){
		$rows[] = $row;
	}
	
	//届け先別グルーピング
	$sql = 'SELECT haisoubi,todoke,kanryo,time FROM haisya_info group by todoke order by time DESC,todoke,line_no';
	$statement = $link -> query($sql);

	//レコード件数取得
	$row_count2 = $statement->rowCount();
	
	while($row2 = $statement->fetch()){
		$rows2[] = $row2;
	}

	//全データ抽出
	$sql = 'SELECT * FROM haisya_info order by driver,line_no,nin_no';
	$statement = $link -> query($sql);

	//レコード件数取得
	$row_count3 = $statement->rowCount();
	
	while($row3 = $statement->fetch()){
		$rows3[] = $row3;
	}

	//ドライバー別届け先別グルーピング
	
	$sql = 'SELECT haisoubi, driver, driver_nm, trip, line_no, todoke, kanryo, time, CenterCd, nin_no FROM haisya_info INNER JOIN m_driver ON haisya_info.driver = m_driver.DirName WHERE (((haisya_info.time)>0)) GROUP BY haisya_info.haisoubi, haisya_info.driver, haisya_info.driver_nm, haisya_info.trip, haisya_info.line_no, haisya_info.todoke, haisya_info.kanryo, haisya_info.time, m_driver.CenterCd, haisya_info.driver, haisya_info.line_no ORDER BY haisya_info.time DESC , haisya_info.driver, haisya_info.line_no';
	$statement = $link -> query($sql);

	//レコード件数取得
	$row_count4 = $statement->rowCount();
	
	while($row4 = $statement->fetch()){
		$rows4[] = $row4;
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