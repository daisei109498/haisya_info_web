<?php
header("Content-type: text/html; charset=utf-8");
 
    $dsn = 'mysql:dbname=haisya_info;host=120.51.223.55;port=59371';
    $user = 'user';
    $password = 'Daiseilog7151';

try{
	//Mysql�ڑ�
    $link = new PDO($dsn, $user, $password);
    if (!$link) {
        die('DataBaseError,Please Wait...'.mysql_error());
    }

    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());

	//���׏��擾
	$sql = "SELECT * FROM stock_backup WHERE tenban='".$tenban."' ORDER BY order_time DESC";
	$statement = $link -> query($sql); 
	//���R�[�h�����擾
	$row_count = $statement->rowCount();
	
	while($row0 = $statement->fetch()){
		$rows0[] = $row0;
	}

	//�f�[�^�x�[�X�ڑ��ؒf
	$dbh = null;
    
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

?>