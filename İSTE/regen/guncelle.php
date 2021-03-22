<?php  session_start();

   include "../nedmin/netting/baglan.php";

	$dizi=$_POST['sıra'];
	 $bolum=$_SESSION['bolum'];
	 $d_sira=$_SESSION['ders_sayisi'];
	 $yid=$_SESSION['yid'];
	if ($_POST) {
		
		if ($_POST['update']=="update") {
			
		$_SESSION['r']=1;

		$say=1;
 		
		for ($j=0; $j <$d_sira ; $j++) 
		{  
			$query=$db->prepare("UPDATE kdersler set muaf_ders = ? where  ders_sira= ? and basvuru_yid= ? ");
			$ekle=$query->execute(array($dizi[$j],$say,$yid));
			$say++;
			$_SESSION['r']=1;
		}
		echo "Eşleşme Başarılı";
		}
	}

	
 

?>