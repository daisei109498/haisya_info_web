<meta http-equiv="refresh" content="360" >
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

	//CSV取り込み
	$fp = fopen("./log_address.txt", "r");

	while( ! feof($fp) ) {
	 $csv = fgets($fp);
	 $csv = trim($csv,'"');
	 $csv = mb_convert_encoding($csv,"UTF-8", "utf-8");

	 $csv = str_replace('"','', $csv);
	 $csv_array = explode(",",$csv);
	 $csv_array[0] = preg_replace('/[[:cntrl:]]/', '', $csv_array[0]);

	 $stmt = $link -> prepare("INSERT INTO m_address (jusyo,lat,lng) VALUES (:b_rem1,:b_rem2,:b_rem3)");
	 $stmt->bindParam(':b_rem1', $csv_array[0], PDO::PARAM_STR);
	 $stmt->bindParam(':b_rem2', $csv_array[1], PDO::PARAM_STR);
	 $stmt->bindParam(':b_rem3', $csv_array[2], PDO::PARAM_STR);
	 $stmt->execute();
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
$file = 'log_address.txt';

chmod($file, 0755);
//ファイルを削除する
if (unlink($file)){
	// ファイル作成
	$fp = fopen("log_address.txt", "w");
	// ファイルクローズ
	fclose($fp);
}
?>