<?php  session_start();

   include "../nedmin/netting/baglan.php";

$sonsirasor=$db->prepare("SELECT ders_sira from kdersler where basvuru_yid=:basvuru_yid");
			$sonsirasor->execute(array(
				'basvuru_yid' => $_SESSION['kullanici_idno']
				));

$siracek=$sonsirasor->rowCount();
	


	$dizi=$_POST['sıra'];
	 $bolum=$_SESSION['bolum'];
	 $d_sira=$siracek;
	 $yid=$_SESSION['yid'];
	if ($_POST) {
		
		if ($_POST['update']=="update") {
			
		

		$say=1;
 		
		for ($j=0; $j <$d_sira ; $j++) 
		{  
			$query=$db->prepare("UPDATE kdersler set muaf_ders = ? where  ders_sira= ? and basvuru_yid= ? ");
			$ekle=$query->execute(array($dizi[$j],$say,$yid));
			$say++;
		}
		echo "Güncelleme Başarılı";
		$_SESSION['r2']=1;
		}
	}

	
 

?>