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

	////�[�i�擞������////
	//���������擾//
	$sql = 'SELECT * FROM haisya_info WHERE kanryo<>"1" AND Lat Is Not Null And Lat<>""';
	$statement = $link -> query($sql);
	while($row6 = $statement->fetch()){
		$rows6[] = $row6;
	}
	//��r�p���ݒn//
	$sql = 'SELECT * FROM now';
	$statement = $link -> query($sql);	
	while($row7 = $statement->fetch()){
		$rows7[] = $row7;
	}

    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());

	//�ƍ�����
	foreach((array)$rows6 as $row6){
		//�ŏ��l�E�ő�l�̊i�[
		$lat_nou = intval(round(strval($row6['Lat'])*1000));
		$lng_nou = intval(round(strval($row6['Lng'])*1000));
//		$lat_min = intval(round((strval($row6['Lat'])-0.005)*100));
//		$lat_max = intval(round((strval($row6['Lat'])+0.005)*100));
//		$lng_min = intval(round((strval($row6['Lng'])-0.005)*100));
//		$lng_max = intval(round((strval($row6['Lng'])+0.005)*100));

		foreach((array)$rows7 as $row7){

		$lat_now = intval(round($row7['lat']*1000));
		$lng_now = intval(round($row7['lng']*1000));

		//�ʒu���̏ƍ�
		if ($row6['driver']==$row7['driver']){
		if ($row6['kanryo']=='0'){
			if ($lat_nou==$lat_now||$lat_nou+1==$lat_now||$lat_nou+2==$lat_now||$lat_nou+3==$lat_now||$lat_nou+4==$lat_now||$lat_nou+5==$lat_now||$lat_nou-1==$lat_now||$lat_nou-2==$lat_now||$lat_nou-3==$lat_now||$lat_nou-4==$lat_now||$lat_nou-5==$lat_now){
				if ($lng_nou==$lng_now||$lng_nou+1==$lng_now||$lng_nou+2==$lng_now||$lng_nou+3==$lng_now||$lng_nou+4==$lng_now||$lng_nou+5==$lng_now||$lng_nou-1==$lng_now||$lng_nou-2==$lng_now||$lng_nou-3==$lng_now||$lng_nou-4==$lng_now||$lng_nou-5==$lng_now){

			   		     //�����t���O2 �ҋ@�t���O
						 $sql = "UPDATE haisya_info set kanryo ='2' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // �N�G�����s�i�f�[�^���擾�j
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d H:i:s', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // �N�G�����s�i�f�[�^���擾�j
						 $result = $link->query($sql);

						//�O�̔[�i��̊����t���O�`�F�b�N
						if ($row6['line_no']!='1'){
			   		     //�����t���O1
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND line_no<'".$row6['line_no']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // �N�G�����s�i�f�[�^���擾�j
						 $result = $link->query($sql);
						}else{}
				}else{}
			}else{}
		}else{
			if ($row6['kanryo']=='2'){
			if ($lat_nou==$lat_now||$lat_nou+1==$lat_now||$lat_nou+2==$lat_now||$lat_nou+3==$lat_now||$lat_nou+4==$lat_now||$lat_nou+5==$lat_now||$lat_nou-1==$lat_now||$lat_nou-2==$lat_now||$lat_nou-3==$lat_now||$lat_nou-4==$lat_now||$lat_nou-5==$lat_now){
				if ($lng_nou==$lng_now||$lng_nou+1==$lng_now||$lng_nou+2==$lng_now||$lng_nou+3==$lng_now||$lng_nou+4==$lng_now||$lng_nou+5==$lng_now||$lng_nou-1==$lng_now||$lng_nou-2==$lng_now||$lng_nou-3==$lng_now||$lng_nou-4==$lng_now||$lng_nou-5==$lng_now){

			   		     //�����t���O2 �ҋ@�t���O
						 $sql = "UPDATE haisya_info set kanryo ='2' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // �N�G�����s�i�f�[�^���擾�j
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d H:i:s', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // �N�G�����s�i�f�[�^���擾�j
						 $result = $link->query($sql);

				}else{
			   		     //�����t���O
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // �N�G�����s�i�f�[�^���擾�j
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d H:i:s', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // �N�G�����s�i�f�[�^���擾�j
						 $result = $link->query($sql);
			}
			}else{
			   		     //�����t���O
						 $sql = "UPDATE haisya_info set kanryo ='1' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
						 // �N�G�����s�i�f�[�^���擾�j
						 $result = $link->query($sql);
			   		     //time
						 $sql = "UPDATE haisya_info set time ='".date('Y/m/d H:i:s', $datetime[0])."' WHERE driver='".$row6['driver']."' AND todoke='".$row6['todoke']."'";
						 // �N�G�����s�i�f�[�^���擾�j
						 $result = $link->query($sql);
			}
			}else{}
		}
		}else{}
		} 
	} 

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
	$sql = 'SELECT DriverName,CenterCd,Lat FROM m_driver where CenterCd="3440" group by DriverName order by DriverName';
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