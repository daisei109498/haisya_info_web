<!DOCTYPE html>
<html>
<head>
<title>配車情報</title>
  <style>
.simple_square_btn {
	display: block;
	position: relative;
	padding: 0.8em;
	text-align: center;
	text-decoration: none;
	background: #1B1B1B;
    color: #fff;
	border:1px solid #1B1B1B;
	font-size: 15px;
	width:	200px;
}
.simple_square_btn:hover {
	 background: #1B1B1B;
         color: #fff;
	 cursor: pointer;
	 text-decoration: none;
}

.simple_square_btn2 {
	text-align:center;
	display: block;
	position: relative;
	padding: 0.4em;
	text-align: center;
	text-decoration: none;
	color: #1B1B1B;
	background: #fff;
	border:1px solid #1B1B1B;
	font-size: 15px;
	width:	100px;
	height:	15px;
	float: right;
}
.simple_square_btn2:hover {
	 background: #1B1B1B;
         color: #fff;
	 cursor: pointer;
	 text-decoration: none;
}

h1 {color:blue; 
line-height:1.5;
	}

.dtable_tr{ 
padding: 5px;
display: table;
width:350px; /* ブロックレベル要素全体の幅 */
border-top: 1px dotted black;
 } 

.dtable_tr_h{ 
display: table;
font-size: 15pt;
width:350px; /* ブロックレベル要素全体の幅 */
 } 

.dtable_c_line_no{  
display: table-cell;
text-align:left;
width: 10px;
 } 

.dtable_c_todoke{  
display: table-cell;
text-align:left;
width: 350px;
 } 

.dtable_c_kanryo1{  
display: table-cell;
text-align:center;
width: 350px;
HEIGHT: 30px;
font-size: 15px;
background-color: skyblue;
padding-top:5px;
 }

.dtable_c_kanryo0{  
display: table-cell;
text-align:center;
width: 350px;
HEIGHT: 30px;
font-size: 15px;
background-color: #aaa;
padding-top:5px;
 }

.dtable_c_time{  
border: none;
display: table-cell;
text-align:left;
width: 300px;
 } 

  </style>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scale=yes, initial-scale=1.0, maximum-scale=5.0" />
<?php 
	//デバイス判定
	function ua_smt (){
	//ユーザーエージェントを取得
	$ua = $_SERVER['HTTP_USER_AGENT'];
	//スマホと判定する文字リスト
	$ua_list = array('iPhone','iPad','iPod');
	 foreach ($ua_list as $ua_smt) {
	//ユーザーエージェントに文字リストの単語を含む場合はTRUE、それ以外はFALSE
	  if (strpos($ua, $ua_smt) !== false) {
	   return true;
	  }
	 } return false;
	}

	$get_dir = __FILE__; // ①
	$get_dir_path =  dirname($get_dir); // ③
	$thisdir = dirname($_SERVER["SCRIPT_NAME"]);		
	$thisdirname = substr($thisdir, -5);

	$_GET['conditions'] = $thisdirname;

	include('../haisya_sql.php'); 
    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());
?>
</head>
<body>
    <script>
    function OnButtonClick(msg_tdk){
          window.webkit.messageHandlers.callbackHandler.postMessage(msg_tdk);
	}
    </script>
<?php 
$count_no = 1;
$count_col = 1;
foreach($rows as $row){
	if ($count_col==4){
	?>
	<BR>
	<?php
		$count_col = 2;
	}else{
		$count_col = $count_col+1;
	}
?>
	<div class="dtable_tr_h"><?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?><BR><?php echo htmlspecialchars($row['haisoubi'],ENT_QUOTES,'UTF-8'); ?>　trip:<?php echo htmlspecialchars($row['trip'],ENT_QUOTES,'UTF-8'); ?></div>
	<?php 
	foreach($rows2 as $row2){
	?> 
		<?php
		if ($row2['driver']==$row['driver']){
			if ($row2['trip']==$row['trip']){
		?>
		<div class="dtable_tr">
			<div class="dtable_c_line_no">
			<b><font color ="darkblue" size ="4"><?php echo htmlspecialchars($count_no,ENT_QUOTES,'UTF-8'); ?>.</font></b>
			</div>
	    	<form action="" method="post">
			<div class="dtable_c_todoke">
			<?php 
				if (ua_smt() == true) { 
					 //iosの場合の処理
			?>
					<input class="simple_square_btn2" type="button" value="受領書送信" onclick="OnButtonClick('<?php echo htmlspecialchars($row2['todoke'],ENT_QUOTES,'UTF-8'); ?>');" style="height:25px;">
			<?php				} else {
					//それ以外の場合の処理
					$url　= 'http://localhost/';
					$mailer = "";
					$mailer = $mailer . '<a class="simple_square_btn2" href="';
					$mailer = $mailer . 'mailto:daisei-sugito@daiseilog.co.jp';
					$mailer = $mailer . '?subject='.$row2['todoke'];
					$mailer = $mailer . '&amp;body='.urlencode(mb_convert_encoding($url,"sjis")).'"';
					$mailer = $mailer . '>受領書送信';
					$mailer = $mailer . '</a>';
					print ($mailer);
				}
			?>
				<input type="hidden" name="nou" value="<?php echo htmlspecialchars($row2['todoke'],ENT_QUOTES,'UTF-8'); ?>">
				<b><font color ="darkblue" size ="4"><?php echo htmlspecialchars($row2['todoke'],ENT_QUOTES,'UTF-8'); ?></font></b>
				<br>
					<?php 
					foreach($rows3 as $row3){
					?> 
						<?php
						if ($row3['driver']==$row['driver']){
							if ($row3['trip']==$row['trip']){
								if ($row3['line_no']==$row2['line_no']){
									if ($row3['todoke']==$row2['todoke']){
						?>
						<?php echo htmlspecialchars($row3['nin_no'],ENT_QUOTES,'UTF-8'); ?>
						<?php echo htmlspecialchars($row3['suryo'],ENT_QUOTES,'UTF-8'); ?>/
						<?php
									}else{}
								}else{}
							}else{}
						}else{}
						?>
					<?php }?>
				<BR>
				<input type="hidden" name="kanryo" value="<?php echo htmlspecialchars($row2['kanryo'],ENT_QUOTES,'UTF-8'); ?>">
				<?php 
				if ($row2['kanryo']==1){
				?>
				<div class="dtable_c_kanryo1">
				<?php echo htmlspecialchars("完了",ENT_QUOTES,'UTF-8'); ?>
				<?php }else{ ?>
				<div class="dtable_c_kanryo0">
				<?php echo htmlspecialchars("未完了",ENT_QUOTES,'UTF-8'); ?>
				<?php }?>
				</div>
				<div class="dtable_c_time" style="float:left;">
				更新日時：<?php echo htmlspecialchars($row2['time'],ENT_QUOTES,'UTF-8'); ?>
				</div>
				<input class="simple_square_btn" type="submit" name="nouhin" value="配送完了">
				<br>
			</div>
			</form>
		</div>
		<?php
		$count_no=$count_no+1;
		}else{}
		}else{}
		?>
	<?php 
	} 
	?>
<?php 
} 
?>
</body>
</html>
