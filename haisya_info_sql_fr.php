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

	//�ʒu���e�[�u��������
	$sql = 'DELETE FROM driver_now';
	$statement = $link -> query($sql);

	//CSV��荞��
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
	
	//���s�R�[�h�̍폜
	$sql = 'UPDATE haisya_info SET Lng=REPLACE (Lng,Char(13),"")';
	$statement = $link -> query($sql);
	$sql = 'UPDATE haisya_info SET Lng=REPLACE (Lng,Char(10),"")';
	$statement = $link -> query($sql);
	//���s�R�[�h�̍폜
	$sql = 'UPDATE now SET lng=REPLACE (lng,Char(13),"")';
	$statement = $link -> query($sql);
	$sql = 'UPDATE now SET lng=REPLACE (lng,Char(10),"")';
	$statement = $link -> query($sql);

	//�ŐV�̈ʒu�����h���C�o�[���ɕR�t��
	$sql = 'INSERT INTO driver_now SELECT * FROM now AS T1 WHERE (((Exists (SELECT * FROM now T2 WHERE T1.driver = T2.driver AND T1.date < T2.date))=False))';
	$statement = $link -> query($sql);
	//NULL�폜
	$sql = 'DELETE FROM driver_now WHERE date is null';
	$statement = $link -> query($sql);
	$sql = 'UPDATE m_driver INNER JOIN driver_now ON m_driver.DirName = driver_now.driver SET m_driver.JusyoNow = driver_now.address, m_driver.Datetime = driver_now.date, m_driver.Lat = driver_now.lat, m_driver.Lng = driver_now.lng';
	$statement = $link -> query($sql);

	$sql = 'INSERT INTO now_backup select * from now;';
	$statement = $link -> query($sql);

	$sql = 'DELETE FROM now';
	$statement = $link -> query($sql);

	//CSV�������E�E�E�ʏ���

	//M�h���C�o�[�ʒu���擾
	$sql = 'SELECT * FROM m_driver order by DriverName';
	$statement = $link -> query($sql);
	//���R�[�h�����擾
	$row_count = $statement->rowCount();
	
	while($row0 = $statement->fetch()){
		$rows0[] = $row0;
	}

	//�h���C�o�[�ʃO���[�s���O
	$sql = 'SELECT haisya_info.haisoubi, m_driver.StaffCode, haisya_info.driver, haisya_info.TodokeCd, haisya_info.todoke, haisya_info.driver_nm, haisya_info.trip, m_driver.CenterCd,Sum(haisya_info.kanryo) AS kanryo_su, Count(haisya_info.driver) AS total_su, m_driver.YousyaCd, Max(haisya_info.time) AS total_time, m_driver.Lng,Sum(haisya_info.Late_FLG) AS total_FLG FROM haisya_info INNER JOIN m_driver ON haisya_info.driver = m_driver.DirName GROUP BY haisya_info.haisoubi, m_driver.StaffCode, haisya_info.driver, haisya_info.TodokeCd,haisya_info.todoke,haisya_info.driver_nm, haisya_info.trip, m_driver.CenterCd, m_driver.YousyaCd ORDER BY MAX(haisya_info.suryo) ASC';
	$statement = $link -> query($sql);
	
	//���R�[�h�����擾
	$row_count = $statement->rowCount();
	
	while($row = $statement->fetch()){
		$rows[] = $row;
	}
	
	//�h���C�o�[�ʓ͂���ʃO���[�s���O
	$sql = 'SELECT haisoubi,driver,driver_nm,trip,line_no,todoke,kanryo,time,Yotei_time FROM haisya_info group by haisoubi,driver,driver_nm,trip,line_no,Yotei_time order by driver,line_no';
	$statement = $link -> query($sql);

	//���R�[�h�����擾
	$row_count2 = $statement->rowCount();
	
	while($row2 = $statement->fetch()){
		$rows2[] = $row2;
	}

	//�S�f�[�^���o
	$sql = 'SELECT * FROM haisya_info order by driver,line_no,nin_no';
	$statement = $link -> query($sql);

	//���R�[�h�����擾
	$row_count3 = $statement->rowCount();
	
	while($row3 = $statement->fetch()){
		$rows3[] = $row3;
	}

	//�h���C�o�[�ʓ͂���ʃO���[�s���O
	
	$sql = 'SELECT haisya_info.haisoubi, haisya_info.driver, haisya_info.driver_nm, haisya_info.trip, haisya_info.line_no, haisya_info.TodokeCd, haisya_info.todoke, haisya_info.kanryo, haisya_info.time, m_driver.CenterCd FROM haisya_info INNER JOIN m_driver ON haisya_info.driver = m_driver.DirName WHERE (((haisya_info.time)>0)) GROUP BY haisya_info.haisoubi, haisya_info.driver, haisya_info.driver_nm, haisya_info.trip, haisya_info.line_no, haisya_info.TodokeCd, haisya_info.todoke, haisya_info.kanryo, haisya_info.time, m_driver.CenterCd, haisya_info.driver, haisya_info.line_no ORDER BY haisya_info.time DESC , haisya_info.driver, haisya_info.line_no';
	$statement = $link -> query($sql);

	//���R�[�h�����擾
	$row_count4 = $statement->rowCount();
	
	while($row4 = $statement->fetch()){
		$rows4[] = $row4;
	}

	//�h���C�o�[�ʓ͂���ʃO���[�s���O
	$sql = 'SELECT * FROM m_address';
	$statement = $link -> query($sql);

	//���R�[�h�����擾
	$row_count5 = $statement->rowCount();
	
	while($row5 = $statement->fetch()){
		$rows5[] = $row5;
	}

	//�͐�ʃh���C�o�[�R�[�h���o
	
	$sql = 'SELECT haisya_info.TodokeCd, haisya_info.todoke,haisya_info.driver, haisya_info.suryo,max(haisya_info.Lat) as Lat_max,max(haisya_info.Lng) as Lng_max FROM haisya_info GROUP BY haisya_info.TodokeCd, haisya_info.driver, haisya_info.suryo HAVING (((haisya_info.TodokeCd) Is Not Null) AND ((haisya_info.suryo)<>"���["))';
	$statement = $link -> query($sql);

	//���R�[�h�����擾
	$row_count8 = $statement->rowCount();
	
	while($row8 = $statement->fetch()){
		$rows8[] = $row8;
	}

	//���s���t���O
	$sql = 'SELECT m_driver.StaffCode, haisya_info.driver, haisya_info.trip, m_driver.CenterCd, Max(haisya_info.kanryo) AS kanryo_max, Min(haisya_info.line_no) AS line_no_min, Sum(haisya_info.Late_FLG) AS total_FLG FROM haisya_info INNER JOIN m_driver ON haisya_info.driver = m_driver.DirName WHERE (((haisya_info.kanryo)<>"1") AND ((m_driver.Lng) Is Not Null And (m_driver.Lng)<>"")) GROUP BY m_driver.StaffCode, haisya_info.driver, haisya_info.trip, m_driver.CenterCd HAVING (((m_driver.CenterCd)="3440") AND ((Max(haisya_info.kanryo))<>"2"))';
	$statement = $link -> query($sql);
	
	//���R�[�h�����擾
	$row_count9 = $statement->rowCount();
	
	while($row9 = $statement->fetch()){
		$rows9[] = $row9;
	}

	//�f�[�^�x�[�X�ڑ��ؒf
	$dbh = null;
    
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

// �t�@�C���N���[�Y
fclose($fp);

//CSV�̍폜
$file = '../haisya/haisya_info/now.csv';

chmod($file, 0755);
//�t�@�C�����폜����
if (unlink($file)){
	// �t�@�C���쐬
	$fp = fopen("../haisya/haisya_info/now.csv", "w");
	// �t�@�C���N���[�Y
	fclose($fp);
}
?>