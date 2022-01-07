<?php
header("Content-type: text/html; charset=utf-8");
 
    $dsn = 'mysql:dbname=haisya_info;host=120.51.223.55;port=59371';
    $user = 'user';
    $password = 'Daiseilog7151';

try{
	//Mysql
    $link = new PDO($dsn, $user, $password);
    if (!$link) {
        die('DataBaseError,Please Wait...'.mysql_error());
    }

    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());

	if(!$_POST['check_stock']){
	    # POST
	}else{
		if($_POST['stock_order']){
		    # POST
				if($_POST['stock_suryo']){
						   # POST
						 $sql = "UPDATE stock set flg='1' WHERE tenban='".$_POST['check_stock']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

						 $result = $link->query($sql);
						 $sql = "UPDATE stock set suryo=".$_POST['stock_suryo']." WHERE tenban='".$_POST['check_stock']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

						 $result = $link->query($sql);
						 $sql = "UPDATE stock set order_time='".date('Y/m/d H:i:s', $datetime[0])."' WHERE tenban='".$_POST['check_stock']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

						 $result = $link->query($sql);
				}
		}

		if($_POST['stock_kanryo']){
				if($_POST['stock_suryo'] < $_POST['stock_suryo_kakutei']){
					$alert = "<script type='text/javascript'>alert('予定数より多く回収する場合は差分の回収依頼をお願いいたします。');</script>";
					echo $alert;
				}else{
				 //backup
				 $sql = "INSERT INTO stock_backup(order_time,tenban,tenmei,yotei_suryo,suryo,kanryo_time) SELECT order_time,tenban,tenmei,suryo,'".$_POST['stock_suryo_kakutei']."','".date('Y/m/d H:i:s', $datetime[0])."' FROM stock WHERE tenban='".$_POST['check_stock']."' AND flg='1'";

				 $result = $link->query($sql);

				 $sql = "UPDATE stock set flg='0' WHERE tenban='".$_POST['check_stock']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);

				 $sql = "UPDATE stock set suryo=0 WHERE tenban='".$_POST['check_stock']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);

				 $sql = "UPDATE stock set order_time='' WHERE tenban='".$_POST['check_stock']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);

			}
		}
	}

	if(!$_POST['check_husoku']){
	    # POST
	}else{

	     $sql = "SELECT husoku_flg FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND kanri_no='".$_POST['check_husoku']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
		 $result = $link->query($sql);

	    if (!$result) {
	        print('<p>error?B</p>');
	    }else{

			foreach ( $result as $row) {
			}
	
			if ($row['husoku_flg']==0){
				 $sql = "UPDATE nohin_fr_backup set husoku_flg='1' WHERE date='".$nouhinbi."' AND kanri_no='".$_POST['check_husoku']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);
			}else{
				 $sql = "UPDATE nohin_fr_backup set husoku_flg='0' WHERE date='".$nouhinbi."' AND kanri_no='".$_POST['check_husoku']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);
			}
		}	
	}

	if(!isset($_POST['check_juryo'])){

	}else{

	     $sql = "SELECT juryo_flg FROM juryo_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$_POST['check_juryo']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
		 $result = $link->query($sql);

	    if (!$result) {
	        print('<p>error</p>');
	    }else{

			foreach ( $result as $row) {
			}
			if ($row['juryo_flg']==0||$row['juryo_flg']==2){
				 $sql = "UPDATE juryo_fr_backup set juryo_flg='1' WHERE date='".$nouhinbi."' AND tenban2='".$_POST['check_juryo']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);
				 $sql = "UPDATE juryo_fr_backup set juryo_time ='".date('Y/m/d H:i:s', $datetime[0])."' WHERE date='".$nouhinbi."' AND tenban2='".$_POST['check_juryo']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);
				 $sql = "UPDATE juryo_fr_backup set husoku_su ='".$_POST['husokusu']."' WHERE date='".$nouhinbi."' AND tenban2='".$_POST['check_juryo']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);
				 $sql = "UPDATE juryo_fr_backup set nohin_su ='".$_POST['nohinsu']."' WHERE date='".$nouhinbi."' AND tenban2='".$_POST['check_juryo']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);
			}
		}
	//	echo "<script>alert('Upload...');</script>";	
	}

	if(!isset($_POST['check_kari_juryo'])){
	    # POST
	}else{

	     $sql = "SELECT juryo_flg FROM juryo_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$_POST['check_juryo']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
		 $result = $link->query($sql);

	    if (!$result) {
	        print('<p>error</p>');
	    }else{

			foreach ( $result as $row) {
			}
			if ($row['juryo_flg']==0){
				 $sql = "UPDATE juryo_fr_backup set juryo_flg='2' WHERE date='".$nouhinbi."' AND tenban2='".$_POST['check_kari_juryo']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);
			}
		}
	//	echo "<script>alert('Upload...');</script>";	
	}


	if(!isset($_POST['check_kari_husoku'])){

	}else{
	     $sql = "SELECT kari_husoku FROM juryo_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$_POST['check_kari_husoku']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;
		 $result = $link->query($sql);

	    if (!$result) {
	        print('<p>error</p>');
	    }else{

			foreach ( $result as $row) {
			}
				 $sql = "UPDATE juryo_fr_backup set kari_husoku='".$_POST['kari_husoku']."' WHERE date='".$nouhinbi."' AND tenban2='".$_POST['check_kari_husoku']."'";//"' AND haisoubi='".date('Y/m/d', $datetime[0])."'" ;

				 $result = $link->query($sql);
		}
	//	echo "<script>alert('Upload...');</script>";	
	}


	$sql = "SELECT * FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."'";
	$statement = $link -> query($sql);

	$row_count = $statement->rowCount();
	
	while($row0 = $statement->fetch()){
		$rows0[] = $row0;
	}


	$sql = "SELECT Count(kanri_no) AS total_su,tenban2,tenmei2,date,sum(husoku_flg) as total_husoku FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."' GROUP BY tenban2,tenmei2,date";
	$statement = $link -> query($sql);

	$row_count1 = $statement->rowCount();
	
	while($row1 = $statement->fetch()){
		$rows1[] = $row1;
	}


	$sql = "SELECT Count(kanri_no) AS total_su,bumon,tenban2,sum(husoku_flg) as total_husoku FROM nohin_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."' GROUP BY bumon,tenban2";
	$statement = $link -> query($sql);

	$row_count2 = $statement->rowCount();
	
	while($row2 = $statement->fetch()){
		$rows2[] = $row2;
	}   


	$sql = "SELECT * FROM juryo_fr_backup WHERE date='".$nouhinbi."' AND tenban2='".$tenban."'";
	$statement = $link -> query($sql);

	$row_count3 = $statement->rowCount();
	
	while($row3 = $statement->fetch()){
		$rows3[] = $row3;
	}


	$sql = "SELECT * FROM stock WHERE tenban='".$tenban."'";
	$statement = $link -> query($sql);

	$row_count4 = $statement->rowCount();
	
	while($row4 = $statement->fetch()){
		$rows4[] = $row4;
	}


	$dbh = null;
 
}catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
}

?>