<?php
	header("Content-type: text/html; charset=utf-8");
 
    $dsn = 'mysql:dbname=haisya_info;host=120.51.223.55;port=59371';
    $user = 'user';
    $password = 'Daiseilog7151';

	session_start(); 
	$tenban = $_SESSION["NinushiCd"];
	if(!isset($_GET['date'])){
	$nouhinbi = date("Y/m/d");
	}else{
	$nouhinbi = $_GET['date'];
	}

	$filename="./download/download_".$tenban."_".str_replace("/", "", $nouhinbi).".csv";

	if (!$fp = fopen($filename, 'w')) {
	    echo "Cannot open file ($filename)";
	    exit;
	}

	$head = "日付,エリア,店番,店名,管理番号,部門,代表商品,代表商品名,振出店名,不足フラグ";
	// ヘッダ
	fwrite($fp, mb_convert_encoding($head . "\n", "SJIS"));

try{
	//Mysql接続
    $link = new PDO($dsn, $user, $password);
    if (!$link) {
        die('DataBaseError,Please Wait...'.mysql_error());
    }

    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());

	$sql = "SELECT * FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."'";

	$statement = $link -> query($sql);
	
	while($row0 = $statement->fetch()){
		$rows0[] = $row0;

		$output_text = $row0['date'].",".$row0['area'].",".$row0['tenban2'].",".$row0['tenmei2'].",".$row0['kanri_no'].",".$row0['bumon'].",".$row0['shohin'].",".$row0['shohin_nm'].",".$row0['huridashi'].",".$row0['husoku_flg']."\n";
 
        if (fwrite($fp, mb_convert_encoding($output_text, "SJIS")) === FALSE) {
            break;
        }
    }
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}


download_file($filename);
 
function download_file($path_file)
{

    if (!file_exists($path_file)) {
        die("Error: File(".$path_file.") does not exist");
    }
 

    if (!($fp = fopen($path_file, "r"))) {
        die("Error: Cannot open the file(".$path_file.")");
    }
    fclose($fp);

    if (($content_length = filesize($path_file)) == 0) {
        die("Error: File size is 0.(".$path_file.")");
    }
 

    header("Cache-Control: private");
    header("Pragma: private");
    header('Content-Description: File Transfer');
    header("Content-Disposition: inline; filename=\"".basename($path_file)."\"");
    header("Content-Length: ".$content_length);
    header("Content-Type: application/octet-stream");
    header('Content-Transfer-Encoding: binary');
 

    if (!readfile($path_file)) {
        die("Cannot read the file(".$path_file.")");
    }
}

?>
