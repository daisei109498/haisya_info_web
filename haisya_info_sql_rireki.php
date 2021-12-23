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

	//明細情報取得
	$sql = "SELECT * FROM juryo_fr_backup WHERE tenban2='".$tenban."' ORDER BY date DESC";
	$statement = $link -> query($sql); 
	//レコード件数取得
	$row_count = $statement->rowCount();
	
	while($row0 = $statement->fetch()){
		$rows0[] = $row0;
	}

	//店舗別合計取得
	$sql = "SELECT Count(kanri_no) AS total_su,tenban2,tenmei2,date,sum(husoku_flg) as total_husoku FROM nohin_fr_backup WHERE  date='".$nouhinbi."' AND tenban2='".$tenban."' GROUP BY tenban2,tenmei2,date";
	$statement = $link -> query($sql);
	//レコード件数取得
	$row_count1 = $statement->rowCount();
	
	while($row1 = $statement->fetch()){
		$rows1[] = $row1;
	}

	//店舗別部門別合計取得
	$sql = "SELECT Count(kanri_no) AS total_su,bumon,tenban2 FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."' GROUP BY bumon,tenban2";
	$statement = $link -> query($sql);
	//レコード件数取得
	$row_count2 = $statement->rowCount();
	
	while($row2 = $statement->fetch()){
		$rows2[] = $row2;
	}
	//データベース接続切断
	$dbh = null;
    
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

?>