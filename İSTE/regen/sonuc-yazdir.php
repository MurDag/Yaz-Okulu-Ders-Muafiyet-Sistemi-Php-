<?php
session_start();
error_reporting(0);
include "../nedmin/netting/baglan.php";
	

		$tc=$_SESSION['kullanici_tc'];
		$kbilgisor=$db->prepare("SELECT * FROM ogrenci WHERE kullanici_tc=:kullanici_tc  ");
	$kbilgisor->execute(array(
		'kullanici_tc' => $tc
		));


	$kbilgicek=$kbilgisor->fetch(PDO::FETCH_ASSOC);

	$kullanici_id=$kbilgicek['id'];

			$kderslersor=$db->prepare("SELECT * FROM kdersler WHERE basvuru_yid=:basvuru_yid  ");
	$kderslersor->execute(array(
		'basvuru_yid' => $kullanici_id
		));
	


			$bid=$kbilgicek['kullanici_bolum_id'];
		$fsor=$db->prepare("select fakulte_yid from bolumler where id=:id");
	$fsor->execute(array(
		'id' => $bid
		));


	$fcek=$fsor->fetch(PDO::FETCH_ASSOC);





	

	$fid=$fcek['fakulte_yid'];
		$fadsor=$db->prepare("select fakulte_ad from fakulteler where id=:id");
	$fadsor->execute(array(
		'id' => $fid
		));


	$fadcek=$fadsor->fetch(PDO::FETCH_ASSOC);

?>




<html>
<head>


</head>


<body>
  


</body>
</html>