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

	if(!$_POST['check_husoku']){
	    # POST�f�[�^�����M����Ă�����ȉ��̏���
	}else{
	    //exec���\�b�h�ŃN�G�������s�Binsert�������s�����ꍇ�}���������߂�l�Ƃ��ĕԂ�
		//    $count = $link->exec("insert into haisya_info(haisoubi,driver,todoke,kanryo,time) values('2018/07/05','".$_POST['driver']."','".$_POST['nou']."','".$_POST['test']."','".date('Y/m/d H:i:s', $datetime[0])."')");
	     $sql = "SELECT husoku_flg FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND kanri_no='".$_POST['check_husoku']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
		 $result = $link->query($sql);

	    if (!$result) {
	        print('<p>�������ݎ��s���܂����B�ēx�{�^���������Ă��������B</p>');
	    }else{
			// foreach���ŌJ��Ԃ��z��̒��g����s���o��
			foreach ( $result as $row) {
			}
	
			if ($row['husoku_flg']==0){
				 $sql = "UPDATE nohin_fr_backup set husoku_flg='1' WHERE date='".$nouhinbi."' AND kanri_no='".$_POST['check_husoku']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
				 // �N�G�����s�i�f�[�^���擾�j
				 $result = $link->query($sql);
			}else{
				 $sql = "UPDATE nohin_fr_backup set husoku_flg='0' WHERE date='".$nouhinbi."' AND kanri_no='".$_POST['check_husoku']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
				 // �N�G�����s�i�f�[�^���擾�j
				 $result = $link->query($sql);
			}
		}
	//	echo "<script>alert('Upload...');</script>";	
	}

	//���׏��擾
	$sql = "SELECT * FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."'";
	$statement = $link -> query($sql);
	//���R�[�h�����擾
	$row_count = $statement->rowCount();
	
	while($row0 = $statement->fetch()){
		$rows0[] = $row0;
	}

	//�X�ܕʍ��v�擾
	$sql = "SELECT area,Count(kanri_no) AS total_su,tenban2,tenmei2,date,sum(husoku_flg) as total_husoku FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."' GROUP BY tenban2,tenmei2,date";
	$statement = $link -> query($sql);
	//���R�[�h�����擾
	$row_count1 = $statement->rowCount();
	
	while($row1 = $statement->fetch()){
		$rows1[] = $row1;
	}

	//�X�ܕʕ���ʍ��v�擾
	$sql = "SELECT Count(kanri_no) AS total_su,bumon,tenban2,sum(husoku_flg) as total_husoku FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."' GROUP BY bumon,tenban2";
	$statement = $link -> query($sql);
	//���R�[�h�����擾
	$row_count2 = $statement->rowCount();
	
	while($row2 = $statement->fetch()){
		$rows2[] = $row2;
	}   

	//��̃t���O�擾
	$sql = "SELECT * FROM juryo_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."'";
	$statement = $link -> query($sql);
	//���R�[�h�����擾
	$row_count3 = $statement->rowCount();
	
	while($row3 = $statement->fetch()){
		$rows3[] = $row3;
	}

	//�f�[�^�x�[�X�ڑ��ؒf
	$dbh = null;
 
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

?>