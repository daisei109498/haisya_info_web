<!DOCTYPE html>
<html>
<head>
<title>**配送状況管理Web**</title>
<meta charset="utf-8">
<meta http-equiv="refresh" content="15" >
<link rel="stylesheet" type="text/css" href="haisya_info.css">
<?php include('./haisya_info_sql.php'); 
    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());
?>
</head>
<body>
ドライバー数：<?php echo $row_count; ?>名◆データ数：<?php echo $row_count2; ?>件
<br>
<?php 
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
<div class="parent">
	<div class="dtable">
		<div class="dtable_tr_h"><?php echo htmlspecialchars($row['driver_nm'],ENT_QUOTES,'UTF-8'); ?>  <?php echo htmlspecialchars($row['haisoubi'],ENT_QUOTES,'UTF-8'); ?>　trip:<?php echo htmlspecialchars($row['trip'],ENT_QUOTES,'UTF-8'); ?></div>
		<?php 
		foreach($rows2 as $row2){
		?> 
			<?php
			if ($row2['driver']==$row['driver']){
				if ($row2['trip']==$row['trip']){
			?>
			<div class="dtable_tr">
				<div class="dtable_c_line_no">
				<?php echo htmlspecialchars($row2['line_no'],ENT_QUOTES,'UTF-8'); ?>
				</div>
				<div class="dtable_c_todoke">
				<b><font color ="darkblue" size ="5"><?php echo htmlspecialchars($row2['todoke'],ENT_QUOTES,'UTF-8'); ?></font></b>
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
				</div>
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
				<div class="dtable_c_time">
				更新日時：<?php echo htmlspecialchars($row2['time'],ENT_QUOTES,'UTF-8'); ?>
				</div>
			</div>
			<?php
			}else{}
			}else{}
			?>
		<?php 
		} 
		?>
	</div>
</div>
<?php 
} 
?>
</body>
</html>

 
 

 
