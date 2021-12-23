<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>店舗納品書</title>
  <style>
	@page {
	  size: A4;
	  margin: 10mm;
	}
	@media print {
	  body {
	    width: 190mm; /* needed for Chrome */
	  }
	}
	body {
	  counter-reset: sheet; /* カウンタの初期化 */
	}
	.sheet {
	  width: 210mm;
	  height: 290mm; /* 1mm余裕をもたせる */
	  page-break-after: always;
	}

	/* プレビュー用のスタイル */
	@media screen {
	  body {
	    background: #eee;
	  }
	  .sheet {
	    background: white; /* 背景を白く */
	    box-shadow: 0 .5mm 2mm rgba(0,0,0,.3); /* ドロップシャドウ */
	    margin: 5mm;
	  }
	}
	table{
    margin-left: 30px;
	}
	tbody{
    text-align:right;
	}

    h1 { border-bottom: 1px; margin-left: 30px;line-height: 10mm;}
    h2 { border-bottom: 5px; text-align:center;line-height: 2mm;}
    th, td { border: solid 1px black; width:30mm;}
	.pagebreak {
	  break-after: page;
	}

	.hanko
	{
	   width              :150px;
	   height             :150px;
	   margin: 0 auto;
	   border-radius      :50px;
	   font-family        :sans-serif; 
	   color              :rgba(217,51,63,0.9); 
	   border             :5px solid rgba(217,51,63,0.9);
	   text-shadow        :#a22041 1px 1px 1px ;
	   text-align         :center;
	   text-top			  :50px;
	   line-height        :15px;
	   border             :5px solid rgba(217,51,63,0.9);
	   border-radius      :0px;
	   position           :relative;
	   overflow           :hidden; 
	}

	.hanko:before,.hanko:after
	{
	   width              :150px;
	   height             :33px;
	   text-align         :center;
	   position           :absolute;
	   left               :50%;
	   margin-left        :-75px;
	   font-size          :30px;
	   line-height        :normal;
	}
	.hanko:before
	{
	   content            :'受';
	   top                :2px;
	   border-bottom      :3px solid rgba(217,51,63,0.9);
	}
	.hanko:after
	{
	   content            :'領';
	   top                :100px;
	   border-top         :3px solid rgba(217,51,63,0.9);
	}
  </style>
<?php
	session_start(); 
    date_default_timezone_set('Asia/Tokyo');
    $datetime = getdate(time());
	$tenban = $_SESSION["NinushiCd"];
	if(!isset($_GET['date'])){
	$nouhinbi = date("Y/m/d");
	}else{
	$nouhinbi = $_GET['date'];
	}
	include('./haisya_info_sql_meisai.php'); 
?>
</head>

<body>
<section class="sheet">
  <h1>店舗納品書</h1>
<?php foreach($rows1 as $row1){ ?> 
  <h2><?php echo htmlspecialchars($row1['area'],ENT_QUOTES,'UTF-8'); ?></h2>
  <p style="text-align: right; padding-right:10mm;line-height: 2mm;">店番：<?php echo htmlspecialchars($row1['tenban2'],ENT_QUOTES,'UTF-8'); ?></p>
  <table>
  <thead>
    <tr>
      <th>納品日</th>
      <th><?php echo htmlspecialchars($row1['date'],ENT_QUOTES,'UTF-8'); ?></th>
      <th style="border:0;width:10mm;"></th>
      <th>お届け先</th>
      <th style="width:90mm;"><?php echo htmlspecialchars($row1['tenmei2'],ENT_QUOTES,'UTF-8'); ?> 様</th>
    </tr>
  </thead>
  </table>
  <BR>
<?php } ?>
  <table>
  <thead>
    <tr style="line-height:5mm;">
      <th>部門</th>
      <th>納品数</th>
      <th>不足数</th>
      <th>納品予定数</th>
      <th>チェック欄</th>
    </tr>
  </thead>
  <tbody>
<?php 
$count = 0;
foreach($rows2 as $row2){
?>
    <tr style="line-height:5mm;">
      <td><?php echo htmlspecialchars($row2['bumon'],ENT_QUOTES,'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($row2['total_su']-$row2['total_husoku'],ENT_QUOTES,'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($row2['total_husoku'],ENT_QUOTES,'UTF-8'); ?></td>
      <td><?php echo htmlspecialchars($row2['total_su'],ENT_QUOTES,'UTF-8'); ?></td>
      <td></td>
    </tr>
<?php 
}
?>
  </tbody>
  </table>
  <BR>
<?php foreach($rows1 as $row1){ ?> 
  <table style="font-size:4mm;">
    <tr style="line-height:5mm;">
      <td style=" border: solid 2px black;width:40mm;">納品数</td>
      <td style=" border: solid 2px black;width:40mm;"><?php echo $row1['total_su']-$row1['total_husoku']; ?></td>
      <td style="border:0;text-align:left;">c/s</td>
    </tr>
  </table>
  <table style="font-size:4mm;">
    <tr style="line-height:5mm;">
      <td style=" border: solid 2px black;width:40mm;">不足数</td>
      <td style=" border: solid 2px black;width:40mm;"><?php echo $row1['total_husoku']; ?></td>
      <td style="border:0;text-align:left;">c/s</td>
    </tr>
  </table>
  <table style="font-size:4mm;">
    <tr style="line-height:5mm;">
      <td style=" border: solid 2px black;width:40mm;">納品予定数</td>
      <td style=" border: solid 2px black;width:40mm;"><?php echo $row1['total_su']; ?></td>
      <td style="border:0;text-align:left;">c/s</td>
    </tr>
  </table> 
<?php if(strpos($row1['area'],'14.') !== false||strpos($row1['area'],'64.') !== false){ ?>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">◆◆◆お問合せ先◆◆◆</p>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">Tel:048-872-6851 Fax:048-872-6852</p>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">ダイセーロジスティクス株式会社  春日部ハブセンター</p>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">〒344-0122  埼玉県春日部市下柳1400番地</p>
<?php }else{ ?>
<?php if(strpos($row1['area'],'17.') !== false||strpos($row1['area'],'65.') !== false){ ?>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">◆◆◆お問合せ先◆◆◆</p>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">Tel: 048-872-6851 Fax: 048-872-6852</p>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">ダイセーロジスティクス株式会社 春日部第二号棟</p>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">〒344-0122  埼玉県春日部市下柳1400番地</p>
<?php }else{ ?>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">◆◆◆お問合せ先◆◆◆</p>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">TEL: 0280-47-4000 FAX: 0280-47-4001</p>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">ダイセーロジスティクス株式会社　アセット茨城ハブセンター</p>
  <p style="text-align: left; padding-left:10mm;line-height: 2mm;">〒306-0051　茨城県古河市茶屋新田２２番地４</p>
<?php }}} ?>
  <div class="box_bottom">
	  <div class="box_juryo" style="padding-right:5mm;transform: scale(0.8);">
		<div class="block1" style="float: right; border: solid 1px black;height: 200px;padding:2mm;">店舗 商品受領印
			<?php 
			foreach($rows3 as $row3){
			if ($row3['juryo_flg']=="1"){
			?>
		  <div class="hanko">
			<BR><BR><BR><span><?php echo htmlspecialchars($row3['juryo_time'],ENT_QUOTES,'UTF-8'); ?></span>
			<BR><?php echo $_SESSION["NAME"]; ?>
		  </div>
			<?php 
			}}
			?>
	　</div>
	</div>
  </div>
</section>

<section class="sheet">
<?php foreach($rows1 as $row1){ ?> 
  <h1>店舗納品書 - 明細 - </h1>
  <h2><?php echo htmlspecialchars($row1['area'],ENT_QUOTES,'UTF-8'); ?></h2>
  <p style="text-align: right; padding-right:10mm;line-height: 2mm;">店番：<?php echo htmlspecialchars($row1['tenban2'],ENT_QUOTES,'UTF-8'); ?></p>
  <table>
  <thead>
    <tr>
      <th>納品日</th>
      <th><?php echo htmlspecialchars($row1['date'],ENT_QUOTES,'UTF-8'); ?></th>
      <th style="border:0;width:10mm;"></th>
      <th>お届け先</th>
      <th style="width:90mm;"><?php echo htmlspecialchars($row1['tenmei2'],ENT_QUOTES,'UTF-8'); ?> 様</th>
    </tr>
  </thead>
  </table>
  <table>
  <thead>
    <tr>
      <th>納品数</th>
      <th><?php echo $row1['total_su']-$row1['total_husoku']; ?></th>
      <th style="border:0;width:10mm;">c/s</th>
      <th>不足数</th>
      <th><?php echo $row1['total_husoku']; ?></th>
      <th style="border:0;width:10mm;">c/s</th>
      <th>予定数</th>
      <th><?php echo $row1['total_su']; ?></th>
      <th style="border:0;width:10mm;">c/s</th>
    </tr>
  </thead>
  </table>
<?php } ?>
  <table>
  <thead>
    <tr style="line-height:5mm;">
      <th style="width:40mm;">管理NO</th>
      <th style="width:11mm;">部門</th>
      <th style="width:35mm;">代表商品</th>
      <th style="width:60mm;">代表商品名</th>
      <th style="width:35mm;">振出店名</th>
      <th style="width:11mm;">不足</th>
    </tr>
  </thead>
  <tbody>
<?php 
$count = 0;
foreach($rows0 as $row0){
	$kanri_no = str_replace("-","",$row0['kanri_no']);
	if ($row0['husoku_flg']==1){
	?>
    <tr style="color:red;font-size: 4mm;text-align:center;line-height:5mm;">
      <td style="width:40mm;text-align:left;"><?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:11mm;"><?php echo htmlspecialchars($row0['bumon'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:35mm;font-size: 3mm;"><?php echo htmlspecialchars($row0['shohin'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:60mm;text-align:left;"><?php echo htmlspecialchars($row0['shohin_nm'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:35mm;font-size: 3mm;"><?php echo htmlspecialchars($row0['huridashi'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:11mm;">レ</td>
    </tr>
<?php
$count = $count+1;
}else{
?>
    <tr style="font-size: 4mm;text-align:center;line-height:5mm;">
      <td style="width:40mm;text-align:left;"><?php echo htmlspecialchars($row0['kanri_no'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:11mm;"><?php echo htmlspecialchars($row0['bumon'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:35mm;font-size: 3mm;"><?php echo htmlspecialchars($row0['shohin'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:60mm;text-align:left;"><?php echo htmlspecialchars($row0['shohin_nm'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:35mm;font-size:3mm;"><?php echo htmlspecialchars($row0['huridashi'],ENT_QUOTES,'UTF-8'); ?></td>
      <td style="width:11mm;"></td>
    </tr>
<?php 
$count = $count+1;
}
if ($count > 34){ //35件まで来たら次のページへ
$count=0;
?>
</tbody>
</table>
</section>

<section class="sheet">
<?php foreach($rows1 as $row1){ ?> 
  <h1>店舗納品書 - 明細 - </h1>
  <h2><?php echo htmlspecialchars($row1['area'],ENT_QUOTES,'UTF-8'); ?></h2>
  <p style="text-align: right; padding-right:10mm;line-height: 2mm;">店番：51</p>
  <table>
  <thead>
    <tr>
      <th>納品日</th>
      <th><?php echo htmlspecialchars($row1['date'],ENT_QUOTES,'UTF-8'); ?></th>
      <th style="border:0;width:10mm;"></th>
      <th>お届け先</th>
      <th style="width:90mm;"><?php echo htmlspecialchars($row1['tenmei2'],ENT_QUOTES,'UTF-8'); ?> 様</th>
    </tr>
    <tr>
      <th>個口</th>
      <th><?php echo $row1['total_su']; ?></th>
      <th style="border:0;width:10mm;">c/s</th>
    </tr>
  </thead>
  </table>
<?php } ?>
<BR>
  <table>
  <thead>
    <tr style="line-height:5mm;">
      <th style="width:40mm;">管理NO</th>
      <th style="width:11mm;">部門</th>
      <th style="width:35mm;">代表商品</th>
      <th style="width:52mm;">代表商品名</th>
      <th style="width:32mm;">振出店名</th>
      <th style="width:11mm;">不足</th>
    </tr>
  </thead>
  <tbody>
<?php
}
}
?>
  </tbody>
  </table>
</section>
</body>

</html>