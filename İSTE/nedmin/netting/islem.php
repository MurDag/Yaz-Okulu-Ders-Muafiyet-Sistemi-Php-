<?php
ob_start();
session_start();
error_reporting(0);

include 'baglan.php';

if (isset($_POST['kullanici_ekle'])) 
{	

	$password=md5($_POST['kullanici_sifre']);

	$kayitsor=$db->prepare("SELECT * FROM ogrenci WHERE kullanici_tc=:kullanici_tc or kullanici_no=:kullanici_no ");
  $kayitsor->execute(array(
    'kullanici_tc' => $_POST['kullanici_tc'],
    'kullanici_no' => $_POST['kullanici_no']
    ));

$kayitsayisi=$kayitsor->rowCount();

if ($kayitsayisi==0) {
	$oneriderskaydet=$db->prepare("INSERT INTO ogrenci SET
					kullanici_bolum_id=:kullanici_bolum_id,
					kullanici_ad=:kullanici_ad,
					kullanici_soyad=:kullanici_soyad,
					kullanici_no=:kullanici_no,
					kullanici_tc=:kullanici_tc,
					kullanici_mail=:kullanici_mail,
					kullanici_tel=:kullanici_tel,
					kullanici_yetki=:kullanici_yetki,
					kullanici_sifre=:kullanici_sifre
					");

				$insert=$oneriderskaydet->execute(array(
					'kullanici_bolum_id' => $_POST['kullanici_bolum'],
					'kullanici_ad' => $_POST['kullanici_ad'],
					'kullanici_soyad' => $_POST['kullanici_soyad'],
					'kullanici_no' => $_POST['kullanici_no'],
					'kullanici_tc' => $_POST['kullanici_tc'],
					'kullanici_mail' => $_POST['kullanici_mail'],
					'kullanici_tel' => $_POST['kullanici_tel'],
					'kullanici_yetki' => $_POST['kullanici_yetki'],
					'kullanici_sifre' => $password
					));


		

				if ($insert) {


					  header("Location:../production/kullanici?durum=ok");
					
				}
				else
				{

					header("Location:../production/kullanici_ekle?durum=no");
				}
	
}
else
{
	header("Location:../production/kullanici_ekle?durum=kayitmevcut");

}




	

}	





if (isset($_POST['red_sebebi_guncelle'])) 
{


	$rid=$_POST['k_red_id'];
	$rsebep=$_POST['red_sebep'];
	 $oneriderskaydet=$db->prepare("UPDATE klasik_red_sebepleri SET
					red_sebebi=:red_sebebi


					WHERE id='$rid'");

				$update=$oneriderskaydet->execute(array(
					'red_sebebi' => $rsebep
					));

		if ($update) {
		
		header("Location:../production/y_ayarlari?durum=ok");

	} else {
		header("Location:../production/y_ayarlari?durum=no");

	} 

}




if (isset($_GET['red_sebebi_sil'])) 
{
	$rid=$_GET['red_sebebi_sil'];

		$sil=$db->prepare("DELETE from klasik_red_sebepleri where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $rid
		));
	if ($kontrol) {
		
		header("Location:../production/y_ayarlari?durum=ok");

	} else {
		header("Location:../production/y_ayarlari?durum=no");

	} 


}





if (isset($_POST['k_redsebep_ekle'])) 
{
$red_sebebi=$_POST['k_red_sebep'];

	$oneriderskaydet=$db->prepare("INSERT INTO klasik_red_sebepleri SET
					red_sebebi=:red_sebebi
					");

				$insert=$oneriderskaydet->execute(array(
					'red_sebebi' => $red_sebebi
					));


		

				if ($insert) {


					  header("Location:../production/y_ayarlari?durum=ok");
					
				}
				else
				{

					header("Location:../production/y_ayarlari?durum=no");
				}



}







if (isset($_POST['onayli_yazokuluders_ekle'])) 
{

$universiteler=$_POST['universiteler'];
$fakulteler=$_POST['fakulteler'];
$bolumler=$_POST['bolumler'];

$drskredi=$_POST['ders_kredi'];
$drstul=$_POST['ders_tul'];
$drsakts=$_POST['ders_akts'];
$drskod=$_POST['ders_kodu'];
$drsad=$_POST['ders_ad'];

$bfakulteler=$_POST['bfakulteler'];
$bbolumler=$_POST['bbolumler'];
$bdersler=$_POST['bdersler'];
$o_derslink=$_POST['ders_link'];

date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$tip="application/pdf";

$temp=explode(".",$_FILES['dosya']['name']);
$extension=end($temp);
$upload_file=$_FILES['dosya']['name'];
$type=$_FILES['dosya']['type'];
$kaynak=$_FILES['dosya']['tmp_name'];
$hedef="../../uploads/onerilendersicerikleri/";
$pdf_ad=$_SESSION['kullanici_tc']."_".$yil."_".$universiteler."_".$fakulteler."_".$bolumler."_".$drsad.".pdf";
$kullanici_tc=$_SESSION['kullanici_tc'];

$onerenkisi_id=$_SESSION['kullanici_idno'];

if(strstr($o_derslink, "edu.tr") && strstr($o_derslink, "https")){	
if ($type==$tip) {




 $oneriderskaydet=$db->prepare("INSERT INTO yazokulu_onayli_dersler SET
					k_universite=:k_universite,
					k_fakulte=:k_fakulte,
					k_bolum=:k_bolum,
					k_ders_ad=:k_ders_ad,
					k_ders_kodu=:k_ders_kodu,
					k_ders_kredi=:k_ders_kredi,
					k_ders_tul=:k_ders_tul,
					k_ders_akts=:k_ders_akts,
					k_ders_icerik=:k_ders_icerik,
					k_ders_link=:k_ders_link,
					b_fakulte=:b_fakulte,
					b_bolum=:b_bolum,
					b_ders_ad=:b_ders_ad,
					kayit_yil=:kayit_yil
					");

				$insert=$oneriderskaydet->execute(array(
					'k_universite' => $universiteler,
					'k_fakulte' => $fakulteler,
					'k_bolum' => $bolumler,
					'k_ders_ad' => $drsad,
					'k_ders_kodu' => $drskod,
					'k_ders_kredi' => $drskredi,
					'k_ders_tul' => $drstul,
					'k_ders_akts' => $drsakts,
					'k_ders_icerik' => $pdf_ad,
					'k_ders_link' => $o_derslink,
					'b_fakulte' => $bfakulteler,
					'b_bolum' => $bbolumler,
					'b_ders_ad' => $bdersler,
					'kayit_yil' => $yil
					));


		

				if ($insert && move_uploaded_file($kaynak,$hedef.$pdf_ad)) {


					  header("Location:../production/onayli_dersler?durum=ok");
					
				}
				else
				{

					header("Location:../production/yodekle?durum=no");
				}




}
else
{	
 header("Location:../production/yodekle?durum=yanlisformat");
}
}
else
{
	 header("Location:../production/yodekle?durum=yanlisuzantı");
}


}


if (isset($_POST['onayli_yazokuluders_duzenle'])) 
{
$universiteler=$_POST['universiteler'];
$fakulteler=$_POST['fakulteler'];
$bolumler=$_POST['bolumler'];

$drskredi=$_POST['ders_kredi'];
$drstul=$_POST['ders_tul'];
$drsakts=$_POST['ders_akts'];
$drskod=$_POST['ders_kodu'];
$drsad=$_POST['ders_ad'];

$bfakulteler=$_POST['bfakulteler'];
$bbolumler=$_POST['bbolumler'];
$bdersler=$_POST['bdersler'];

$y_ders_duzenle_id=$_POST['y_ders_duzenle_id'];



$o_derslink=$_POST['ders_link'];

date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$tip="application/pdf";

$temp=explode(".",$_FILES['dosya']['name']);
$extension=end($temp);
$upload_file=$_FILES['dosya']['name'];
$type=$_FILES['dosya']['type'];
$kaynak=$_FILES['dosya']['tmp_name'];
$hedef="../../uploads/onayli_dersicerikleri/";
$pdf_ad=$_SESSION['kullanici_tc']."_".$yil."_".$universiteler."_".$fakulteler."_".$bolumler."_".$drsad.".pdf";
$kullanici_tc=$_SESSION['kullanici_tc'];

$onerenkisi_id=$_SESSION['kullanici_idno'];


$d_kiceriksor=$db->prepare("SELECT k_ders_icerik FROM yazokulu_onayli_dersler WHERE id=:id ");
  $d_kiceriksor->execute(array(
    'id' => $y_ders_duzenle_id
    ));

$d_kicerikcek=$d_kiceriksor->fetch(PDO::FETCH_ASSOC);


$pdf_eski_ad=$d_kicerikcek['k_ders_icerik'];

if ($_FILES['dosya']['name']!=null) {

	if(strstr($o_derslink, "edu.tr") && strstr($o_derslink, "https")){	
if ($type==$tip) {


			    

	

					
			unlink('../../uploads/onayli_dersicerikleri/'.$pdf_eski_ad);


 $oneriderskaydet=$db->prepare("UPDATE yazokulu_onayli_dersler SET
					k_universite=:k_universite,
					k_fakulte=:k_fakulte,
					k_bolum=:k_bolum,
					k_ders_ad=:k_ders_ad,
					k_ders_kodu=:k_ders_kodu,
					k_ders_kredi=:k_ders_kredi,
					k_ders_tul=:k_ders_tul,
					k_ders_akts=:k_ders_akts,
					k_ders_icerik=:k_ders_icerik,
					k_ders_link=:k_ders_link,
					b_fakulte=:b_fakulte,
					b_bolum=:b_bolum,
					b_ders_ad=:b_ders_ad,
					kayit_yil=:kayit_yil


					WHERE id='$y_ders_duzenle_id'");

				$update=$oneriderskaydet->execute(array(
					'k_universite' => $universiteler,
					'k_fakulte' => $fakulteler,
					'k_bolum' => $bolumler,
					'k_ders_ad' => $drsad,
					'k_ders_kodu' => $drskod,
					'k_ders_kredi' => $drskredi,
					'k_ders_tul' => $drstul,
					'k_ders_akts' => $drsakts,
					'k_ders_icerik' => $pdf_ad,
					'k_ders_link' => $o_derslink,
					'b_fakulte' => $bfakulteler,
					'b_bolum' => $bbolumler,
					'b_ders_ad' => $bdersler,
					'kayit_yil' => $yil
					));


		

				if ($update && move_uploaded_file($kaynak,$hedef.$pdf_ad)) {

					   header("Location:../production/onayli_dersler?durum=ok");
					
				}
				else
				{
					 header("Location:../production/onayli_dersler?durum=no");
				}




}
else
{	
  	header("Location:../production/onayli_dersler?durum=yanlisformat");
}
}
else
{
	header("Location:../production/onayli_dersler?durum=yanlisuzanti");
}
		



}
else
{
		if(strstr($o_derslink, "edu.tr") && strstr($o_derslink, "https")){


$dgs=rename('../../uploads/onayli_dersicerikleri/'.$pdf_eski_ad,'../../uploads/onayli_dersicerikleri/'.$pdf_ad);



 $oneriderskaydet=$db->prepare("UPDATE yazokulu_onayli_dersler SET
					k_universite=:k_universite,
					k_fakulte=:k_fakulte,
					k_bolum=:k_bolum,
					k_ders_ad=:k_ders_ad,
					k_ders_kodu=:k_ders_kodu,
					k_ders_kredi=:k_ders_kredi,
					k_ders_tul=:k_ders_tul,
					k_ders_akts=:k_ders_akts,
					k_ders_icerik=:k_ders_icerik,
					k_ders_link=:k_ders_link,
					b_fakulte=:b_fakulte,
					b_bolum=:b_bolum,
					b_ders_ad=:b_ders_ad,
					kayit_yil=:kayit_yil


					WHERE id='$y_ders_duzenle_id'");

				$update=$oneriderskaydet->execute(array(
					'k_universite' => $universiteler,
					'k_fakulte' => $fakulteler,
					'k_bolum' => $bolumler,
					'k_ders_ad' => $drsad,
					'k_ders_kodu' => $drskod,
					'k_ders_kredi' => $drskredi,
					'k_ders_tul' => $drstul,
					'k_ders_akts' => $drsakts,
					'k_ders_icerik' => $pdf_ad,
					'k_ders_link' => $o_derslink,
					'b_fakulte' => $bfakulteler,
					'b_bolum' => $bbolumler,
					'b_ders_ad' => $bdersler,
					'kayit_yil' => $yil
					));


		

				if ($update) {

					   header("Location:../production/onayli_dersler?durum=ok");
					
				}
				else
				{
					 header("Location:../production/onayli_dersler?durum=no");
				}







		}
		else
		{
			header("Location:../production/onayli_dersler?durum=yanlisuzanti");
		}

}


}





if (isset($_POST['y_dilekce_yukle'])) 
{


 
date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$kullanici_tc=$_SESSION['kullanici_tc'];
$tip="application/pdf";
$temp=explode(".",$_FILES['dosya']['name']);
$extension=end($temp);
$upload_file=$_FILES['dosya']['name'];
$type=$_FILES['dosya']['type'];
$kaynak=$_FILES['dosya']['tmp_name'];
$hedef="../../uploads/yazokuluimzalibasvurular/";
$pdf_ad=$kullanici_tc.'_'.$yil.'.pdf';

$o_id=$_SESSION['kullanici_idno'];


  $y_ilerlemesor=$db->prepare("SELECT * FROM yazokulu_ilerleme_kontrol WHERE y_basvuru_yil=:y_basvuru_yil and  y_kul_id=:y_kul_id ");
  $y_ilerlemesor->execute(array(
    'y_basvuru_yil' => $yil,
    'y_kul_id' => $o_id
    ));


$y_ilerlemecek=$y_ilerlemesor->rowCount();








if ($type==$tip) {




	$oneri_guncelle=$db->prepare("UPDATE yazokulu_basvuru SET
		basvuru_imza=:basvuru_imza

		WHERE basvuru_kul_id='$o_id'  and basvuru_yil='$yil' ");

	$update=$oneri_guncelle->execute(array(
		'basvuru_imza' => 1
	));

				if ($update && move_uploaded_file($kaynak,$hedef.$pdf_ad)) {

					if ($y_ilerlemecek==0) {
						$basvuru_ilerleme=$db->prepare("INSERT INTO yazokulu_ilerleme_kontrol SET
					y_basvuru_yil=:y_basvuru_yil,
					y_kul_id=:y_kul_id,
					y_ilerleme_durum=:y_ilerleme_durum	
					
					");

				$ilerlemekaydet=$basvuru_ilerleme->execute(array(
					'y_basvuru_yil' => $yil,
					'y_kul_id' => $o_id,
					'y_ilerleme_durum' => 1
					
					));
					}

					else
					{
						$oneri_kesin=$db->prepare("UPDATE yazokulu_ilerleme_kontrol SET
						y_ilerleme_durum=:y_ilerleme_durum
						

						WHERE y_kul_id='$o_id' and y_basvuru_yil='$yil'");

						$update=$oneri_kesin->execute(array(
							'y_ilerleme_durum' => 1
						));

					}

					
					  header("Location:../../regen/y_basvurular?basvuru_durum=successful");
				}
				else
				{

					header("Location:../../regen/y_basvurular?basvuru_durum=error");
				}

}
else
{	
header("Location:../../regen/y_dilekce_yukle?basvuru_durum=yanlisformat");
}





}




if (isset($_POST['y_okul_basvur_guncelle'])) 
{


$ssor=$db->prepare("SELECT * FROM yazokulu_basvuru  where id=:id ");
    $ssor->execute(array( 'id' => $_POST['y_okul_basvur_guncelle_id'] )); 
$scek=$ssor->fetch(PDO::FETCH_ASSOC);

if ($scek['basvuru_sonuc']==0) {




	$max_kredi=0;


$ders=$_POST['dersler'];
$universiteler=$_POST['universiteler'];
$fakulteler=$_POST['fakulteler'];
$bolumler=$_POST['bolumler'];
$id=$_POST['y_okul_basvur_guncelle_id'];

date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");

$y_ayarsor=$db->prepare("SELECT * from y_ayar");
  $y_ayarsor->execute(array());
 $y_ayarcek=$y_ayarsor->fetch(PDO::FETCH_ASSOC);

 $kid=$_SESSION['kullanici_idno'];
    $y_ilerlemesor=$db->prepare("SELECT * FROM yazokulu_ilerleme_kontrol WHERE y_basvuru_yil=:y_basvuru_yil and  y_kul_id=:y_kul_id ");
  $y_ilerlemesor->execute(array(
    'y_basvuru_yil' => $yil,
    'y_kul_id' => $kid
    ));

$y_ilerlemecek=$y_ilerlemesor->fetch(PDO::FETCH_ASSOC);


$sderskredisor=$db->prepare("SELECT ders_kredi FROM dersler  where id=:id");
     $sderskredisor->execute(array( 
      'id' => $ders
));
     $sderskredicek=$sderskredisor->fetch(PDO::FETCH_ASSOC);

     $s_kredi=$sderskredicek['ders_kredi'];










if ($y_ilerlemecek['y_ilerleme_durum']==2) 
{






	

  $m_sor=$db->prepare("SELECT * FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil and basvuru_sonuc=:basvuru_sonuc");
     $m_sor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil,
      'basvuru_sonuc' => 1
       ));

  }
    else
    {

    $m_sor=$db->prepare("SELECT * FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil");
     $m_sor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil
       ));


    }


     while ($m_cek=$m_sor->fetch(PDO::FETCH_ASSOC)) {


        $kredisor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $kredisor->execute(array( 'id' => $m_cek['b_ders_ad'] )); 
    $kredicek=$kredisor->fetch(PDO::FETCH_ASSOC);

        $max_ders++;
        $max_kredi=$max_kredi+$kredicek['ders_kredi'];
     
     }


$toplamkredi=$max_kredi+$s_kredi;
		$kid=$_SESSION['kullanici_idno'];
		    $y_ilerlemesor=$db->prepare("SELECT * FROM yazokulu_ilerleme_kontrol WHERE y_basvuru_yil=:y_basvuru_yil and  y_kul_id=:y_kul_id ");
  $y_ilerlemesor->execute(array(
    'y_basvuru_yil' => $yil,
    'y_kul_id' => $kid
    ));

$y_ilerlemecek=$y_ilerlemesor->fetch(PDO::FETCH_ASSOC);




	    $ybderssor=$db->prepare("SELECT * FROM yazokulu_basvuru WHERE basvuru_yil=:basvuru_yil and  basvuru_kul_id=:basvuru_kul_id and id=:id");
  $ybderssor->execute(array(
    'basvuru_yil' => $yil,
    'basvuru_kul_id' => $kid,
    'id' => $id
    ));

 $ybderssor2=$db->prepare("SELECT * FROM yazokulu_basvuru WHERE basvuru_yil=:basvuru_yil and  basvuru_kul_id=:basvuru_kul_id and b_ders_ad=:b_ders_ad and  basvuru_sonuc!=:basvuru_sonuc and id!=:id");
  $ybderssor2->execute(array(
    'basvuru_yil' => $yil,
    'basvuru_kul_id' => $kid,
    'b_ders_ad' => $ders,
    'basvuru_sonuc' => 2,
    'id' => $id
    ));




$ybderscek2=$ybderssor2->rowCount();


$ybderscek=$ybderssor->fetch(PDO::FETCH_ASSOC);



if ($ybderscek['basvuru_sonuc']==0 && $ybderscek2==0) {

if ($toplamkredi<=$y_ayarcek['max_kredi']) {

		$oneri_kesin=$db->prepare("UPDATE yazokulu_basvuru SET
		b_ders_ad=:b_ders_ad,
		k_universite=:k_universite,
		k_fakulte=:k_fakulte,
		k_bolum=:k_bolum
		

		WHERE id='$id'");

		$update=$oneri_kesin->execute(array(
			'b_ders_ad' => $ders,
			'k_universite' => $universiteler,
			'k_fakulte' => $fakulteler,
			'k_bolum' => $bolumler
		));	


		if ($update) {

					  header("Location:../../regen/y_basvurular?y_basvuru_guncelle=ok");
					
				}
				else
				{
					header("Location:../../regen/y_basvurular?y_basvuru_guncelle=error");
				}

	
}
else
{
 header("Location:../../regen/y_basvurular?y_basvuru_durum=krediasildi");	
}



}
	else
{	
 header("Location:../../regen/y_basvurular?y_basvuru_durum=tekrarlibasvuru");
}


	
}
else
{
header("Location:../../regen/y_basvuru_guncelle?y_basvuru_durum=i_g");
}




}


if (isset($_POST['y_okul_basvur_ekle'])) 
{
	$max_kredi=0;

$id=$_SESSION['kullanici_idno'];

$ders=$_POST['dersler'];
$universiteler=$_POST['universiteler'];
$fakulteler=$_POST['fakulteler'];
$bolumler=$_POST['bolumler'];

date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");

$y_ayarsor=$db->prepare("SELECT * from y_ayar");
  $y_ayarsor->execute(array());
 $y_ayarcek=$y_ayarsor->fetch(PDO::FETCH_ASSOC);

 $kid=$_SESSION['kullanici_idno'];
    $y_ilerlemesor=$db->prepare("SELECT * FROM yazokulu_ilerleme_kontrol WHERE y_basvuru_yil=:y_basvuru_yil and  y_kul_id=:y_kul_id ");
  $y_ilerlemesor->execute(array(
    'y_basvuru_yil' => $yil,
    'y_kul_id' => $kid
    ));

$y_ilerlemecek=$y_ilerlemesor->fetch(PDO::FETCH_ASSOC);


$sderskredisor=$db->prepare("SELECT ders_kredi FROM dersler  where id=:id");
     $sderskredisor->execute(array( 
      'id' => $ders
));
     $sderskredicek=$sderskredisor->fetch(PDO::FETCH_ASSOC);

     $s_kredi=$sderskredicek['ders_kredi'];



if ($y_ilerlemecek['y_ilerleme_durum']==2) 
{
	

  $m_sor=$db->prepare("SELECT distinct k_universite,b_ders_ad FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil and basvuru_sonuc=:basvuru_sonuc");
     $m_sor->execute(array( 
      'basvuru_kul_id' => $id,
      'basvuru_yil' => $yil,
      'basvuru_sonuc' => 1
       ));

    }
    else
    {

    $m_sor=$db->prepare("SELECT distinct k_universite,b_ders_ad FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil");
     $m_sor->execute(array( 
      'basvuru_kul_id' => $id,
      'basvuru_yil' => $yil
       ));


    }


     while ($m_cek=$m_sor->fetch(PDO::FETCH_ASSOC)) {


        $kredisor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $kredisor->execute(array( 'id' => $m_cek['b_ders_ad'] )); 
    $kredicek=$kredisor->fetch(PDO::FETCH_ASSOC);

        $max_ders++;
        $max_kredi=$max_kredi+$kredicek['ders_kredi'];
     
     }


$toplamkredi=$max_kredi+$s_kredi;
		$kid=$_SESSION['kullanici_idno'];
		    $y_ilerlemesor=$db->prepare("SELECT * FROM yazokulu_ilerleme_kontrol WHERE y_basvuru_yil=:y_basvuru_yil and  y_kul_id=:y_kul_id ");
  $y_ilerlemesor->execute(array(
    'y_basvuru_yil' => $yil,
    'y_kul_id' => $kid
    ));

$y_ilerlemecek=$y_ilerlemesor->fetch(PDO::FETCH_ASSOC);

if ($y_ilerlemecek['y_ilerleme_durum']==2) 
{
	
    $ybderssor=$db->prepare("SELECT * FROM yazokulu_basvuru WHERE basvuru_yil=:basvuru_yil and  basvuru_kul_id=:basvuru_kul_id and b_ders_ad=:b_ders_ad and  basvuru_sonuc!=:basvuru_sonuc");
  $ybderssor->execute(array(
    'basvuru_yil' => $yil,
    'basvuru_kul_id' => $id,
    'b_ders_ad' => $ders,
    'basvuru_sonuc' => 2
    ));
}
else
{

	    $ybderssor=$db->prepare("SELECT * FROM yazokulu_basvuru WHERE basvuru_yil=:basvuru_yil and  basvuru_kul_id=:basvuru_kul_id and b_ders_ad=:b_ders_ad");
  $ybderssor->execute(array(
    'basvuru_yil' => $yil,
    'basvuru_kul_id' => $id,
    'b_ders_ad' => $ders
    ));
}








$ybderscek=$ybderssor->rowCount();

if ($ybderscek==0) {

if ($toplamkredi<=$y_ayarcek['max_kredi']) {
	 $y_basvuru=$db->prepare("INSERT INTO yazokulu_basvuru SET
					b_ders_ad=:b_ders_ad,
					k_universite=:k_universite,
					k_fakulte=:k_fakulte,
					k_bolum=:k_bolum,
					basvuru_yil=:basvuru_yil,
					basvuru_kul_id=:basvuru_kul_id
					");

				$insert=$y_basvuru->execute(array(
					'b_ders_ad' => $ders,
					'k_universite' => $universiteler,
					'k_fakulte' => $fakulteler,
					'k_bolum' => $bolumler,
					'basvuru_yil' => $yil,
					'basvuru_kul_id' => $id
					));

				if ($insert) {

					  header("Location:../../regen/y_basvurular?y_basvuru_durum=imzalanmadi");
					
				}
				else
				{
					header("Location:../../regen/y_basvuruyap?y_basvuru_durum=error");
				}
	
}
else
{
 header("Location:../../regen/y_basvurular?y_basvuru_durum=krediasildi");	
}



}
	else
{	
 header("Location:../../regen/y_basvurular?y_basvuru_durum=tekrarlibasvuru");
}



}




if (isset($_POST['y_okul_basvur'])) 
{

$id=$_SESSION['kullanici_idno'];

$ders=$_POST['dersler'];
$universiteler=$_POST['universiteler'];
$fakulteler=$_POST['fakulteler'];
$bolumler=$_POST['bolumler'];

date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");

 $y_basvuru=$db->prepare("INSERT INTO yazokulu_basvuru SET
					b_ders_ad=:b_ders_ad,
					k_universite=:k_universite,
					k_fakulte=:k_fakulte,
					k_bolum=:k_bolum,
					basvuru_yil=:basvuru_yil,
					basvuru_kul_id=:basvuru_kul_id
					");

				$insert=$y_basvuru->execute(array(
					'b_ders_ad' => $ders,
					'k_universite' => $universiteler,
					'k_fakulte' => $fakulteler,
					'k_bolum' => $bolumler,
					'basvuru_yil' => $yil,
					'basvuru_kul_id' => $id
					));

				if ($insert) {

					  header("Location:../../regen/y_basvurular?y_basvuru_durum=imzalanmadi");
					
				}
				else
				{
					header("Location:../../regen/yazokulu?y_basvuru_durum=error");
				}


}




if (isset($_GET['oneri_kesinlestir'])) 
{

	$o_kul_id=$_GET['oneri_kesinlestir'];

		date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");

			$oneri_kesin=$db->prepare("UPDATE oneri_ilerleme_kontrol SET
		oneri_ilerleme_durum=:oneri_ilerleme_durum
		

		WHERE oneri_kul_id='$o_kul_id' and oneri_yil='$yil'");

	$update=$oneri_kesin->execute(array(
		'oneri_ilerleme_durum' => 2
	));


	
	if (isset($_GET['degisme'])) {

 $onerisor=$db->prepare("SELECT * FROM onerilen_dersler  where onerenkisi_id=:onerenkisi_id and oneri_sonuc=:oneri_sonuc and kayit_degisme_durum=:kayit_degisme_durum ");
    $onerisor->execute(array( 
      'onerenkisi_id' => $o_kul_id,
      'oneri_sonuc' => 1,
      'kayit_degisme_durum' => 1

     )); 
		
	}
	else
	{
			 $onerisor=$db->prepare("SELECT * FROM onerilen_dersler  where onerenkisi_id=:onerenkisi_id and oneri_sonuc=:oneri_sonuc");
    $onerisor->execute(array( 
      'onerenkisi_id' => $o_kul_id,
      'oneri_sonuc' => 1

     )); 
	}



 
$ekle;
$onerisayi=$onerisor->rowCount();
$sayac=0;
if ($update) {
 while ($onericek=$onerisor->fetch(PDO::FETCH_ASSOC)) {

 	$kdguncelle=$onericek['id'];

 				$k_d_guncelle=$db->prepare("UPDATE onerilen_dersler SET
		kayit_degisme_durum=:kayit_degisme_durum

		WHERE id='$kdguncelle'");

	$update=$k_d_guncelle->execute(array(
		'kayit_degisme_durum' => 0
	));  


	copy("../../uploads/onerilendersicerikleri/".$onericek['ders_kicerik'],"../../uploads/onayli_dersicerikleri/".$onericek['ders_kicerik']);

					$oneri_kaydet=$db->prepare("INSERT INTO yazokulu_onayli_dersler SET
					k_universite=:k_universite,
					k_fakulte=:k_fakulte,
					k_bolum=:k_bolum,
					k_ders_ad=:k_ders_ad,
					k_ders_kodu=:k_ders_kodu,
					k_ders_kredi=:k_ders_kredi,
					k_ders_tul=:k_ders_tul,
					k_ders_akts=:k_ders_akts,
					k_ders_icerik=:k_ders_icerik,
					k_ders_link=:k_ders_link,
					b_fakulte=:b_fakulte,
					b_bolum=:b_bolum,
					b_ders_ad=:b_ders_ad,
					kayit_yil=:kayit_yil,
					oneri_yid=:oneri_yid
					");

				$insert=$oneri_kaydet->execute(array(
					'k_universite' => $onericek['ders_kuniversite'],
					'k_fakulte' => $onericek['ders_kfakulte'],
					'k_bolum' => $onericek['ders_kbolum'],
					'k_ders_ad' => $onericek['ders_ad'],
					'k_ders_kodu' => $onericek['ders_kkodu'],
					'k_ders_kredi' => $onericek['ders_kkredi'],
					'k_ders_tul' => $onericek['ders_ktul'],
					'k_ders_akts' => $onericek['ders_kakts'],
					'k_ders_icerik' => $onericek['ders_kicerik'],
					'k_ders_link' => $onericek['ders_klink'],
					'b_fakulte' => $onericek['ders_bfakulte'],
					'b_bolum' => $onericek['ders_bbolum'],
					'b_ders_ad' => $onericek['ders_bders'],
					'kayit_yil' => $yil,
					'oneri_yid' => $onericek['id']
				));

				$sayac++;

 }


	

		if ($onerisayi==$sayac) {

				header("Location:../production/ders_onerileri?islemler=ok");
			}
			
		else
		{

			header("Location:../production/ders_onerileri?islemler=sayiuyusmadi");

		}
		
	}
	else
	{	
	 header("Location:../production/ders_onerileri?update=no");
	}





}




if (isset($_POST['y_ayar_duzenle'])) 
{


	$max_ders=$_POST['max_ders'];
	$max_kredi=$_POST['max_kredi'];
	$max_uni=$_POST['max_uni'];
	$max_oneri=$_POST['max_oneri'];
	$ayar_id=$_POST['ayar_id'];	


			$y_ayar_guncelle=$db->prepare("UPDATE y_ayar SET
		max_ders=:max_ders,
		max_kredi=:max_kredi,
		max_universite=:max_universite,
		max_oneri=:max_oneri

		WHERE id='$ayar_id'");

	$update=$y_ayar_guncelle->execute(array(
		'max_ders' => $max_ders,
		'max_kredi' => $max_kredi,
		'max_universite' => $max_uni,
		'max_oneri' => $max_oneri
	));

	if ($update) {
		header("Location:../production/y_ayarlari?guncelle=ok");
	}
	else
	{	
	 header("Location:../production/y_ayarlari?guncelle=no");
	}


}

if (isset($_GET['kurul_yosil'])) 
{	

$oid=$_GET['kurul_yosil'];
	
	unlink('../../uploads/onayli_dersicerikleri/'.$_GET['ders_icerik']);

	 $oneri_idsor=$db->prepare("SELECT * FROM yazokulu_onayli_dersler  where id=:id");
    $oneri_idsor->execute(array( 
      'id' => $oid

     )); 
 $oneri_idcek=$oneri_idsor->fetch(PDO::FETCH_ASSOC);
 $oneri_id=$oneri_idcek['oneri_yid'];


	 $kul_idsor=$db->prepare("SELECT * FROM onerilen_dersler  where id=:id");
    $kul_idsor->execute(array( 
      'id' => $oneri_id

     )); 
 $kul_idcek=$kul_idsor->fetch(PDO::FETCH_ASSOC);
 $kul_id=$kul_idcek['onerenkisi_id'];

 date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");


	$o_ders_guncelle=$db->prepare("UPDATE onerilen_dersler SET
		oneri_sonuc=:oneri_sonuc,
		oneri_red_sebep=:oneri_red_sebep,
		kayit_degisme_durum=:kayit_degisme_durum

		WHERE id='$oneri_id'");

	$update=$o_ders_guncelle->execute(array(
		'oneri_sonuc' => 0,
		'oneri_red_sebep' => "",
		'kayit_degisme_durum' => 1
	));





		$o_ders_guncelle=$db->prepare("UPDATE oneri_ilerleme_kontrol SET
		oneri_ilerleme_durum=:oneri_ilerleme_durum

		WHERE oneri_kul_id='$kul_id' and oneri_yil='$yil' ");

	$update=$o_ders_guncelle->execute(array(
		'oneri_ilerleme_durum' => 3
	));






			
		$sil=$db->prepare("DELETE from yazokulu_onayli_dersler where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['kurul_yosil']
		));
	if ($kontrol) {
		
		header("Location:../production/onayli_dersler?durum=ok");

	} else {
		header("Location:../production/onayli_dersler?durum=no");

	} 
	 

}






if (isset($_GET['y_basvurusil_id'])) 
{	
	
			
		$sil=$db->prepare("DELETE from yazokulu_basvuru where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['y_basvurusil_id']
		));
	if ($kontrol) {
		
		header("Location:../../regen/y_basvurular?o-s=ok");

	} else {
		header("Location:../../regen/y_basvurular?o-s=no");

	}

}



if (isset($_GET['onerisil_id'])) 
{		
	$oid=$_GET['onerisil_id'];
			$o_guncelle=$db->prepare("UPDATE onerilen_dersler SET
		oneri_imza=:oneri_imza

		WHERE id='$oid'");

	$update=$o_guncelle->execute(array(
		'oneri_imza' => 0
	));


	date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$ktc=$_SESSION['kullanici_tc'];
	    $oneribelgesor=$db->prepare("SELECT * FROM onerilen_dersler  where id=:id");
    $oneribelgesor->execute(array( 
      'id' => $_GET['onerisil_id']

     )); 
 $oneribelgecek=$oneribelgesor->fetch(PDO::FETCH_ASSOC);

 $icerikyol='../../uploads/onerilendersicerikleri/'.$oneribelgecek['ders_kicerik'];

	unlink('../../uploads/onerilendersicerikleri/'.$oneribelgecek['ders_kicerik']);
	



		$sil=$db->prepare("DELETE from onerilen_dersler where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['onerisil_id']
		));
	if ($kontrol) {
		
		header("Location:../../regen/oneriler?o-s=ok");

	} else {
		header("Location:../../regen/oneriler?o-s=no");

	}

}






if (isset($_POST['onerilen_dilekce_yukle'])) 
{	
$yil=date("Y");
	$o_id=$_SESSION['kullanici_idno'];

	$odsor=$db->prepare("SELECT * from oneri_ilerleme_kontrol where oneri_kul_id=:oneri_kul_id and oneri_yil=:oneri_yil");
	$odsor->execute(array(
		'oneri_kul_id' => $o_id,
		'oneri_yil' => $yil
		));


	$odcek=$odsor->fetch(PDO::FETCH_ASSOC);

	if ($odcek==0) {






 
	date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$kullanici_tc=$_SESSION['kullanici_tc'];
$tip="application/pdf";
$temp=explode(".",$_FILES['dosya']['name']);
$extension=end($temp);
$upload_file=$_FILES['dosya']['name'];
$type=$_FILES['dosya']['type'];
$kaynak=$_FILES['dosya']['tmp_name'];
$hedef="../../uploads/imzalioneriler/";
$pdf_ad=$kullanici_tc.'_'.$yil.'.pdf';

$o_id=$_SESSION['kullanici_idno'];




if ($type==$tip) {




	$oneri_guncelle=$db->prepare("UPDATE onerilen_dersler SET
		oneri_imza=:oneri_imza

		WHERE onerenkisi_id='$o_id'");

	$update=$oneri_guncelle->execute(array(
		'oneri_imza' => 1
	));

				if ($update && move_uploaded_file($kaynak,$hedef.$pdf_ad)) {


					$oneri_ilerleme=$db->prepare("INSERT INTO oneri_ilerleme_kontrol SET
					oneri_yil=:oneri_yil,
					oneri_kul_id=:oneri_kul_id,
					oneri_ilerleme_durum=:oneri_ilerleme_durum
					
					");

				$ilerlemekaydet=$oneri_ilerleme->execute(array(
					'oneri_yil' => $yil,
					'oneri_kul_id' => $o_id,
					'oneri_ilerleme_durum' => 1
					
					));
					  header("Location:../../regen/oneriler?oneri_durum=successful");
				}
				else
				{

					header("Location:../../regen/oneriler?oneri_durum=error");
				}

}
else
{	
header("Location:../../regen/dilekce_yukle?oneri_durum=yanlisformat");
}

		
	}
	else
	{






 
	date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$kullanici_tc=$_SESSION['kullanici_tc'];
$tip="application/pdf";
$temp=explode(".",$_FILES['dosya']['name']);
$extension=end($temp);
$upload_file=$_FILES['dosya']['name'];
$type=$_FILES['dosya']['type'];
$kaynak=$_FILES['dosya']['tmp_name'];
$hedef="../../uploads/imzalioneriler/";
$pdf_ad=$kullanici_tc.'_'.$yil.'.pdf';

$o_id=$_SESSION['kullanici_idno'];




if ($type==$tip) {




	$oneri_guncelle=$db->prepare("UPDATE onerilen_dersler SET
		oneri_imza=:oneri_imza

		WHERE onerenkisi_id='$o_id' and oneri_yil='$yil'");

	$update=$oneri_guncelle->execute(array(
		'oneri_imza' => 1
	));

				if ($update && move_uploaded_file($kaynak,$hedef.$pdf_ad)) {


						$oneri_ilerleme_guncelle=$db->prepare("UPDATE oneri_ilerleme_kontrol SET
		oneri_ilerleme_durum=:oneri_ilerleme_durum

		WHERE oneri_kul_id='$o_id' and oneri_yil='$yil'");

	$guncelle=$oneri_ilerleme_guncelle->execute(array(
		'oneri_ilerleme_durum' => 1
	));

			 header("Location:../../regen/oneriler?oneri_durum=successful");
				}
				else
				{

					header("Location:../../regen/oneriler?oneri_durum=error");
				}

}
else
{	
header("Location:../../regen/dilekce_yukle?oneri_durum=yanlisformat");
}




	}


}

if (isset($_GET['y_basvuru_kesinlestir'])) 
{
	$id=$_GET['y_basvuru_kesinlestir'];

	$ilerlemeguncelle=$db->prepare("UPDATE yazokulu_ilerleme_kontrol SET
		y_ilerleme_durum=:y_ilerleme_durum

		WHERE y_kul_id='$id'");

	$update=$ilerlemeguncelle->execute(array(
		'y_ilerleme_durum' => 2
	));

	if ($update) {

		header("Location:../production/y_basvurular?durum=ok");
	}
	else
	{	
	 header("Location:../production/y_basvurular?durum=no");
	}


}






if (isset($_GET['y_basvuru_onay'])) 
{
	$id=$_GET['y_basvuru_onay'];

	$idsor=$db->prepare("SELECT basvuru_kul_id from yazokulu_basvuru where id=:id");
	$idsor->execute(array(
		'id' => $id
		));


	$idcek=$idsor->fetch(PDO::FETCH_ASSOC);
$basvuru_yid=$idcek['basvuru_kul_id'];

	$basvuru_onayla=$db->prepare("UPDATE yazokulu_basvuru SET
		basvuru_sonuc=:basvuru_sonuc,
		red_sebep=:red_sebep

		WHERE id='$id'");

	$update=$basvuru_onayla->execute(array(
		'basvuru_sonuc' => 1,
		'red_sebep' => ""
	));

	if ($update) {
		header("Location:../production/y_basvuru_incele?onayla=basarili&basvuru_kul_id=".$basvuru_yid);
	}
	else
	{	
	 header("Location:../production/y_basvuru_incele?onayla=basarisiz&basvuru_kul_id=".$basvuru_yid);
	}





}









if (isset($_GET['oneri_onay'])) 
{
	$id=$_GET['oneri_onay'];

	$idsor=$db->prepare("select onerenkisi_id from onerilen_dersler where id=:id");
	$idsor->execute(array(
		'id' => $id
		));


	$idcek=$idsor->fetch(PDO::FETCH_ASSOC);
$basvuru_yid=$idcek['onerenkisi_id'];

	$oneri_onayla=$db->prepare("UPDATE onerilen_dersler SET
		oneri_sonuc=:oneri_sonuc,
		oneri_red_sebep=:oneri_red_sebep


		WHERE id='$id'");

	$update=$oneri_onayla->execute(array(
		'oneri_sonuc' => 1,
		'oneri_red_sebep' => ""
	));

	if ($update) {

		if (isset($_GET['degisme'])) {
			header("Location:../production/oneri_incele?o_i_d=degisti&oneri_kul_id=".$basvuru_yid);
		}
		else
		{
			header("Location:../production/oneri_incele?oneri_kul_id=".$basvuru_yid);
		}


	}
	else
	{	
		if (isset($_GET['degisme'])) {
			header("Location:../production/oneri_incele?o_i_d=degisti&oneri_kul_id=".$basvuru_yid);
		}
		else
		{
			header("Location:../production/oneri_incele?oneri_kul_id=".$basvuru_yid);
		}
	 
	}

}

if (isset($_POST['basvuru_red_idm'])) 
{

if ($_POST['nedenler']==0) {
	$sebep=$_POST['red_sebep'];
}
else
{	
	 $kredsebepsor=$db->prepare("SELECT * FROM klasik_red_sebepleri where id=:id");
              $kredsebepsor->execute(array(
              	'id'=>$_POST['nedenler']
              ));
              $kredsebepcek=$kredsebepsor->fetch(PDO::FETCH_ASSOC);


	$sebep=$kredsebepcek['red_sebebi'];
}




$reddet_id=$_POST['r_id'];
	
		$idsor=$db->prepare("SELECT basvuru_kul_id from yazokulu_basvuru where id=:id");
	$idsor->execute(array(
		'id' => $reddet_id
		));


	$idcek=$idsor->fetch(PDO::FETCH_ASSOC);
	$basvuru_yid=$idcek['basvuru_kul_id'];


	$ders_red=$db->prepare("UPDATE yazokulu_basvuru SET
		basvuru_sonuc=:basvuru_sonuc,
		red_sebep=:red_sebep

		WHERE id='$reddet_id'");

	$update=$ders_red->execute(array(
		'basvuru_sonuc' => 2,
		'red_sebep' => $sebep
	));

	if ($update) {
		
		 header("Location:../production/y_basvuru_incele?basvuru_kul_id=".$basvuru_yid."&sonuc=basarili");
	}
	else 
	{ 		

 header("Location:../production/y_basvuru_incele?basvuru_kul_id=".$basvuru_yid."&sonuc=hata");
	}

 

}

if (isset($_GET['oneri_reddet'])) 
{
	$id=$_GET['oneri_reddet'];


	
		$idsor=$db->prepare("select onerenkisi_id from onerilen_dersler where id=:id");
	$idsor->execute(array(
		'id' => $id
		));


	$idcek=$idsor->fetch(PDO::FETCH_ASSOC);



	$basvuru_yid=$idcek['onerenkisi_id'];


	$oneri_onayla=$db->prepare("UPDATE onerilen_dersler SET
		oneri_sonuc=:oneri_sonuc

		WHERE id=$id");

	$update=$oneri_onayla->execute(array(
		'oneri_sonuc' => 2
	));

	if ($update) {  
		header("Location:../production/oneri_incele?basvuru_id=".$basvuru_yid);
	}
	else
	{
		header("Location:../production/oneri_incele?basvuru_id=".$basvuru_yid);
	}

}


if (isset($_GET['kesinlestir_id'])) 
{	
	$kesinlestir=$_GET['kesinlestir_id'];

	$ders_kesinlestir=$db->prepare("UPDATE basvuru SET
		basvuru_sonuc=:basvuru_sonuc

		WHERE basvuru_yid=$kesinlestir");

	$update=$ders_kesinlestir->execute(array(
		'basvuru_sonuc' => 1
	));

	if ($update) {
		header("Location:../production/basvuru?kesinlestir=ok");
	}
	else
	{
		header("Location:../production/basvuru?kesinlestir=no");
	}



}

if (isset($_POST['ders_oneri_guncelle'])) 
{
	    $ssor=$db->prepare("SELECT * FROM onerilen_dersler  where id=:id ");
    $ssor->execute(array( 'id' => $_POST['oneri_id'] )); 
$scek=$ssor->fetch(PDO::FETCH_ASSOC);

if ($scek['oneri_sonuc']==0) {



$universiteler=$_POST['universiteler'];
$fakulteler=$_POST['fakulteler'];
$bolumler=$_POST['bolumler'];
$drs=$_POST['drs'];


		$dsor=$db->prepare("SELECT * from dersler where id=:id");
	$dsor->execute(array(
		'id' => $drs
		));


	$dcek=$dsor->fetch(PDO::FETCH_ASSOC);

$blm=$dcek['ders_bolum'];

		$fklsor=$db->prepare("SELECT * from bolumler where id=:id");
	$fklsor->execute(array(
		'id' => $blm
		));


	$fklcek=$fklsor->fetch(PDO::FETCH_ASSOC);

$bf=$fklcek['fakulte_yid'];











$drskredi=htmlspecialchars($_POST['o_derskredi']);
$drstul=htmlspecialchars($_POST['o_derstul']);
$drsakts=htmlspecialchars($_POST['o_dersakts']);
$drskod=htmlspecialchars($_POST['o_derskodu']);

$o_dersadi=htmlspecialchars($_POST['o_dersadi']);
$o_derslink=htmlspecialchars($_POST['o_derslink']);
$o_gid=$_POST['oneri_id'];

date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$tip="application/pdf";

$temp=explode(".",$_FILES['dosya']['name']);
$extension=end($temp);
$upload_file=$_FILES['dosya']['name'];
$type=$_FILES['dosya']['type'];
$kaynak=$_FILES['dosya']['tmp_name'];
$hedef="../../uploads/onerilendersicerikleri/";
$pdf_ad=$_SESSION['kullanici_tc']."_".$yil."_".$universiteler."_".$fakulteler."_".$bolumler."_".$o_dersadi.".pdf";
$kullanici_tc=$_SESSION['kullanici_tc'];
$sifirla=0;
$onerenkisi_id=$_SESSION['kullanici_idno'];

if ($_FILES['dosya']['name']!=null) {

	if(strstr($o_derslink, "edu.tr") && strstr($o_derslink, "https")){	
if ($type==$tip) {


			    $d_kiceriksor=$db->prepare("SELECT ders_kicerik FROM onerilen_dersler WHERE id=:id ");
  $d_kiceriksor->execute(array(
    'id' => $o_gid
    ));

$d_kicerikcek=$d_kiceriksor->fetch(PDO::FETCH_ASSOC);

	$pdf_eski_ad=$d_kicerikcek['ders_kicerik'];

					
			unlink('../../uploads/onerilendersicerikleri/'.$pdf_eski_ad);


 $oneriderskaydet=$db->prepare("UPDATE onerilen_dersler SET
					ders_kuniversite=:ders_kuniversite,
					ders_kfakulte=:ders_kfakulte,
					ders_kbolum=:ders_kbolum,
					ders_ad=:ders_ad,
					ders_kkodu=:ders_kkodu,
					ders_kkredi=:ders_kkredi,
					ders_ktul=:ders_ktul,
					ders_kakts=:ders_kakts,
					ders_kicerik=:ders_kicerik,
					ders_klink=:ders_klink,
					ders_bfakulte=:ders_bfakulte,
					ders_bbolum=:ders_bbolum,
					ders_bders=:ders_bders,
					oneri_imza=:oneri_imza


					WHERE id='$o_gid'");

				$update=$oneriderskaydet->execute(array(
					'ders_kuniversite' => $universiteler,
					'ders_kfakulte' => $fakulteler,
					'ders_kbolum' => $bolumler,
					'ders_ad' => $o_dersadi,
					'ders_kkodu' => $drskod,
					'ders_kkredi' => $drskredi,
					'ders_ktul' => $drstul,
					'ders_kakts' => $drsakts,
					'ders_kicerik' => $pdf_ad,
					'ders_klink' => $o_derslink,
					'ders_bfakulte' => $bf,
					'ders_bbolum' => $blm,
					'ders_bders' => $drs,
					'oneri_imza' => $sifirla
					
					
					));


		

				if ($update && move_uploaded_file($kaynak,$hedef.$pdf_ad)) {

					 $ilerlemekaydet=$db->prepare("UPDATE oneri_ilerleme_kontrol SET
					oneri_ilerleme_durum=:oneri_ilerleme_durum
					WHERE oneri_kul_id='$onerenkisi_id'");

				$ilerlemekaydet_kontrol=$ilerlemekaydet->execute(array(
					'oneri_ilerleme_durum' => 0
					));

					   header("Location:../../regen/oneriler?ognclm_durum=successful");
					
				}
				else
				{
					 header("Location:../../regen/oneriler?ognclm_durum=error");
				}




}
else
{	
 header("Location:../../regen/oneri_guncelle?oneri_durum=yanlisformat");
}
}
else
{
	header("Location:../../regen/oneri_guncelle?oneri_durum=yanlisderslinki");
}
		



}
else
{
		if(strstr($o_derslink, "edu.tr") && strstr($o_derslink, "https")){


			    $d_kiceriksor=$db->prepare("SELECT ders_kicerik FROM onerilen_dersler WHERE id=:id ");
  $d_kiceriksor->execute(array(
    'id' => $o_gid
    ));

$d_kicerikcek=$d_kiceriksor->fetch(PDO::FETCH_ASSOC);

	$pdf_eski_ad=$d_kicerikcek['ders_kicerik'];

					
			$pdf_ad_guncelle = rename('../../uploads/onerilendersicerikleri/'.$pdf_eski_ad,'../../uploads/onerilendersicerikleri/'.$pdf_ad);


 $oneriderskaydet=$db->prepare("UPDATE onerilen_dersler SET
					ders_kuniversite=:ders_kuniversite,
					ders_kfakulte=:ders_kfakulte,
					ders_kbolum=:ders_kbolum,
					ders_ad=:ders_ad,
					ders_kkodu=:ders_kkodu,
					ders_kkredi=:ders_kkredi,
					ders_ktul=:ders_ktul,
					ders_kakts=:ders_kakts,
					ders_kicerik=:ders_kicerik,
					ders_klink=:ders_klink,
					ders_bfakulte=:ders_bfakulte,
					ders_bbolum=:ders_bbolum,
					ders_bders=:ders_bders,
					oneri_imza=:oneri_imza


					WHERE id='$o_gid'");

				$update=$oneriderskaydet->execute(array(
					'ders_kuniversite' => $universiteler,
					'ders_kfakulte' => $fakulteler,
					'ders_kbolum' => $bolumler,
					'ders_ad' => $o_dersadi,
					'ders_kkodu' => $drskod,
					'ders_kkredi' => $drskredi,
					'ders_ktul' => $drstul,
					'ders_kakts' => $drsakts,
					'ders_kicerik' => $pdf_ad,
					'ders_klink' => $o_derslink,
					'ders_bfakulte' => $bf,
					'ders_bbolum' => $blm,
					'ders_bders' => $drs,
					'oneri_imza' => $sifirla
					
					
					));



				if ($update ) {

					  header("Location:../../regen/oneriler?ognclm_durum=successful");
					
				}
				else
				{	
				header("Location:../../regen/oneriler?ognclm_durum=error");
				}
		}
		else
		{
			header("Location:../../regen/oneri_guncelle?oneri_durum=yanlisderslinki");
		}

}
	
}
else
{
	header("Location:../../regen/oneri_guncelle?oneri_durum=y_g");
}







}
 

if ($_POST['ders_oner']) {

$universiteler=$_POST['universiteler'];
$fakulteler=$_POST['fakulteler'];
$bolumler=$_POST['bolumler'];

$drs=$_POST['drs'];

		$dsor=$db->prepare("SELECT * from dersler where id=:id");
	$dsor->execute(array(
		'id' => $drs
		));


	$dcek=$dsor->fetch(PDO::FETCH_ASSOC);

$blm=$dcek['ders_bolum'];

		$fklsor=$db->prepare("SELECT * from bolumler where id=:id");
	$fklsor->execute(array(
		'id' => $blm
		));


	$fklcek=$fklsor->fetch(PDO::FETCH_ASSOC);

$bf=$fklcek['fakulte_yid'];








$drskredi=htmlspecialchars($_POST['o_derskredi']);
$drstul=htmlspecialchars($_POST['o_derstul']);
$drsakts=htmlspecialchars($_POST['o_dersakts']);
$drskod=htmlspecialchars($_POST['o_derskodu']);

$o_dersadi=htmlspecialchars($_POST['o_dersadi']);
$o_derslink=htmlspecialchars($_POST['o_derslink']);

date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$tip="application/pdf";

$temp=explode(".",$_FILES['dosya']['name']);
$extension=end($temp);
$upload_file=$_FILES['dosya']['name'];
$type=$_FILES['dosya']['type'];
$kaynak=$_FILES['dosya']['tmp_name'];
$hedef="../../uploads/onerilendersicerikleri/";
$pdf_ad=$_SESSION['kullanici_tc']."_".$yil."_".$universiteler."_".$fakulteler."_".$bolumler."_".$o_dersadi.".pdf";
$kullanici_tc=$_SESSION['kullanici_tc'];

$onerenkisi_id=$_SESSION['kullanici_idno'];

if(strstr($o_derslink, "edu.tr") && strstr($o_derslink, "https")){	
if ($type==$tip) {




 $oneriderskaydet=$db->prepare("INSERT INTO onerilen_dersler SET
					ders_kuniversite=:ders_kuniversite,
					ders_kfakulte=:ders_kfakulte,
					ders_kbolum=:ders_kbolum,
					ders_ad=:ders_ad,
					ders_kkodu=:ders_kkodu,
					ders_kkredi=:ders_kkredi,
					ders_ktul=:ders_ktul,
					ders_kakts=:ders_kakts,
					ders_kicerik=:ders_kicerik,
					ders_klink=:ders_klink,
					ders_bfakulte=:ders_bfakulte,
					ders_bbolum=:ders_bbolum,
					ders_bders=:ders_bders,
					onerenkisi_id=:onerenkisi_id,
					oneri_yil=:oneri_yil
					");

				$insert=$oneriderskaydet->execute(array(
					'ders_kuniversite' => $universiteler,
					'ders_kfakulte' => $fakulteler,
					'ders_kbolum' => $bolumler,
					'ders_ad' => $o_dersadi,
					'ders_kkodu' => $drskod,
					'ders_kkredi' => $drskredi,
					'ders_ktul' => $drstul,
					'ders_kakts' => $drsakts,
					'ders_kicerik' => $pdf_ad,
					'ders_klink' => $o_derslink,
					'ders_bfakulte' => $bf,
					'ders_bbolum' => $blm,
					'ders_bders' => $drs,
					'onerenkisi_id' => $onerenkisi_id,
					'oneri_yil' => $yil
					));


		

				if ($insert && move_uploaded_file($kaynak,$hedef.$pdf_ad)) {


					  header("Location:../../regen/oneriler?oneri_durum=imzalanmadi");
					
				}
				else
				{

					header("Location:../../regen/ders_oner?oneri_durum=error");
				}




}
else
{	
 header("Location:../../regen/ders_oner?oneri_durum=yanlisformat");
}
}
else
{
	header("Location:../../regen/ders_oner?oneri_durum=yanlisderslinki");
}





}

if (isset($_GET['kderssil-id'])) {

		$sil=$db->prepare("DELETE from kdersler where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['kderssil-id']
		));
	if ($kontrol) {

		Header("Location:../../regen/b-guncelle?durum=s-ok");

	} else {

		Header("Location:../../regen/b-guncelle?durum=s-no");

	}



	}

if (isset($_POST['hesap_guncelle'])) {

	$kullanici_id=$_SESSION['kullanici_idno'];

	
	
	
	
	



	$ayarkaydet=$db->prepare("UPDATE ogrenci SET
		kullanici_ad=:kullanici_ad,
		kullanici_soyad=:kullanici_soyad,
		kullanici_tc=:kullanici_tc,
		kullanici_no=:kullanici_no,
		kullanici_tel=:kullanici_tel,
		kullanici_mail=:kullanici_mail


		WHERE id='$kullanici_id'");

	$update=$ayarkaydet->execute(array(
		'kullanici_ad' => htmlspecialchars($_POST['kullanici_ad']),
		'kullanici_soyad' => htmlspecialchars($_POST['kullanici_soyad']),
		'kullanici_tc' => htmlspecialchars($_POST['kullanici_tc']),
		'kullanici_no' => htmlspecialchars($_POST['kullanici_no']),
		'kullanici_tel' => htmlspecialchars($_POST['kullanici_tel']),
		'kullanici_mail' => htmlspecialchars($_POST['kullanici_mail'])



		));


	if ($update) {

		header("Location:../../regen/hesabim?durum=updateok");

	} else {

		header("Location:../../regen/hesabim?durum=updateno");
	}

}



if (isset($_GET['onayla_id'])) {

$onay_id=$_GET['onayla_id'];
	
		$idsor=$db->prepare("select basvuru_yid from kdersler where id=:id");
	$idsor->execute(array(
		'id' => $onay_id
		));


	$idcek=$idsor->fetch(PDO::FETCH_ASSOC);

	$basvuru_yid=$idcek['basvuru_yid'];



	$ders_onay=$db->prepare("UPDATE kdersler SET
		ders_onay=:ders_onay,
		red_sebep=:red_sebep

		WHERE id=$onay_id");

	$update=$ders_onay->execute(array(
		'ders_onay' => 2,
		'red_sebep' => ""
	));

	if ($update) {
		header("Location:../production/basvuru_karar?basvuru_id=".$basvuru_yid);
	}

}
if (isset($_POST['donem-sec'])) {

		


		$donem_sec=$db->prepare("UPDATE syfayar SET
		ayar_basvuru_donem=:ayar_basvuru_donem

		WHERE ayar_id=1");

	$update=$donem_sec->execute(array(
		'ayar_basvuru_donem' => $_POST['basvuru_donem']
	));

	if ($update) {
		header("Location:../production/duyuru?durum=ok");
	}
	else 
	{
		header("Location:../production/duyuru?durum=no");
	}

	}

if (isset($_POST['oneri_reddet'])) {


if ($_POST['nedenler']==0) {
	$sebep=$_POST['red_sebep'];
}
else
{	
	 $kredsebepsor=$db->prepare("SELECT * FROM klasik_red_sebepleri where id=:id");
              $kredsebepsor->execute(array(
              	'id'=>$_POST['nedenler']
              ));
              $kredsebepcek=$kredsebepsor->fetch(PDO::FETCH_ASSOC);


	$sebep=$kredsebepcek['red_sebebi'];
}





$reddet_id=$_POST['oneri_red_id'];
	
		$idsor=$db->prepare("select onerenkisi_id from onerilen_dersler where id=:id");
	$idsor->execute(array(
		'id' => $reddet_id
		));


	$idcek=$idsor->fetch(PDO::FETCH_ASSOC);

	$basvuru_yid=$idcek['onerenkisi_id'];



	$ders_red=$db->prepare("UPDATE onerilen_dersler SET
		oneri_sonuc=:oneri_sonuc,
		oneri_red_sebep=:oneri_red_sebep

		WHERE id=$reddet_id");

	$update=$ders_red->execute(array(
		'oneri_sonuc' => 2,
		'oneri_red_sebep' => $sebep
	));

	if ($update) {
		if (isset($_POST['dgsm'])) {
			header("Location:../production/oneri_incele?o_i_d=degisti&oneri_kul_id=".$basvuru_yid."&o_i_d=degisti");
		}
		else
		{
			header("Location:../production/oneri_incele?oneri_kul_id=".$basvuru_yid."&islem=ok");
		}
	}
	else 
	{
		if (isset($_POST['dgsm'])) {
			header("Location:../production/oneri_incele?o_i_d=degisti&oneri_kul_id=".$basvuru_yid."&islem=no");
		}
		else
		{
			header("Location:../production/oneri_incele?oneri_kul_id=".$basvuru_yid."&islem=no");
		}
	}


}







if (isset($_POST['ders_reddet'])) {

$reddet_id=$_SESSION['red_id'];
	
		$idsor=$db->prepare("select basvuru_yid from kdersler where id=:id");
	$idsor->execute(array(
		'id' => $reddet_id
		));


	$idcek=$idsor->fetch(PDO::FETCH_ASSOC);

	$basvuru_yid=$idcek['basvuru_yid'];



	$ders_red=$db->prepare("UPDATE kdersler SET
		ders_onay=:ders_onay,
		red_sebep=:red_sebep

		WHERE id=$reddet_id");

	$update=$ders_red->execute(array(
		'ders_onay' => 1,
		'red_sebep' => $_POST['red_sebep']
	));

	if ($update) {
		header("Location:../production/basvuru_karar?basvuru_id=".$basvuru_yid);
	}
	else 
	{
		echo "Error";
	}


}


if (isset($_POST['btamamla'])) {


		$bassor=$db->prepare("SELECT * from basvuru where basvuru_yid=:basvuru_yid");
			$bassor->execute(array(
				'basvuru_yid' => $_SESSION['kullanici_idno']
				));

$bascek=$bassor->rowCount();

		$_SESSION['dosyadurum']="";
		$e=0;
		$g=0;

$ktc=$_SESSION['kullanici_tc'];

 $b_ilerleme=$db->prepare("UPDATE ogrenci SET
    b_ilerleme=:b_ilerleme

    WHERE kullanici_tc=$ktc");

  $update=$b_ilerleme->execute(array(
    'b_ilerleme' => 3
  ));




		if ($_SESSION['r']==0) {

			
			$dsayisor=$db->prepare("SELECT id from kdersler where basvuru_yid=:basvuru_yid");
			$dsayisor->execute(array(
				'basvuru_yid' => $_SESSION['kullanici_idno']
				));

			$dsor=$db->prepare("SELECT id from dersler where ders_bolum=:ders_bolum");
			$dsor->execute(array(
				'ders_bolum' => $_SESSION['kullanici_bolum_id']
				));
			$dizi=array();
			
			while ($dcek=$dsor->fetch(PDO::FETCH_ASSOC)) {
				$dizi[$e]=$dcek['id'];
				$e++; 
			}

			$ee=0;
			while ($dsayicek=$dsayisor->fetch(PDO::FETCH_ASSOC)) {
				
				$kdid=$dsayicek['id'];
				
					$mg=$db->prepare("UPDATE kdersler SET
		muaf_ders=:muaf_ders
		

		WHERE id='$kdid'");

	$update=$mg->execute(array(
		'muaf_ders' => $dizi[$ee]
		
		));

				
				$ee++;
				$g++;

			}	
		}


		if ($bascek==0) {

			date_default_timezone_set('Etc/GMT-3');
		$yil=date("Y");
		$donem=1;


		$pdf_ad=$_SESSION['kullanici_tc']."_".$yil."_1.pdf";

			$kullanicikaydet=$db->prepare("INSERT INTO basvuru SET
					basvuru_ad=:basvuru_ad,
					basvuru_soyad=:basvuru_soyad,
					basvuru_bolum_id=:basvuru_bolum_id,
					basvuru_yid=:basvuru_yid,
					basvuru_yil=:basvuru_yil,
					basvuru_donem=:basvuru_donem,
					basvuru_belge=:basvuru_belge
					");
				$insert=$kullanicikaydet->execute(array(
					'basvuru_ad' => $_SESSION['kullanici_ad'],
					'basvuru_soyad' => $_SESSION['kullanici_soyad'],
					'basvuru_bolum_id' => $_SESSION['kullanici_bolum_id'],
					'basvuru_yid' => $_SESSION['yid'],
					'basvuru_yil' => $yil,
					'basvuru_donem' => $donem,
					'basvuru_belge' => $pdf_ad
					));


		

				if ($insert) {
					  header("Location:../../regen/index?basvuru_durum=yes");
					
				}
				else
				{
					header("Location:../../regen/index?basvuru_durum=no");
				}

		}
		else
		{

			header("Location:../../regen/index?basvuru_durum=hata");

		}

	



	}

if (isset($_POST['pdf_guncelle'])) {
date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$tip="application/pdf";

$temp=explode(".",$_FILES['dosya']['name']);
$extension=end($temp);
$upload_file=$_FILES['dosya']['name'];
$type=$_FILES['dosya']['type'];
$kaynak=$_FILES['dosya']['tmp_name'];
$hedef="../../uploads/transkript/";
$pdf_ad=$_SESSION['kullanici_tc']."_".$yil."_1.pdf";
$kullanici_tc=$_SESSION['kullanici_tc'];


$temp2=explode(".",$_FILES['dosya2']['name']);
$extension2=end($temp2);
$upload_file2=$_FILES['dosya2']['name'];
$type2=$_FILES['dosya2']['type'];
$kaynak2=$_FILES['dosya2']['tmp_name'];
$hedef2="../../uploads/dersicerik/";
$pdf_ad2=$_SESSION['kullanici_tc']."_1.pdf";



if ($type==$tip && $type2==$tip) {


if(move_uploaded_file($kaynak,$hedef.$pdf_ad) && move_uploaded_file($kaynak2,$hedef2.$pdf_ad2))
{
	$_SESSION['dosyadurum']="ok";
  header("Location:../../regen/b-guncelle");
}
else 
{
  header("Location:../../regen/b-guncelle?dosyadurum=no");
}

  
}
else
{

header("Location:../../regen/b-guncelle?dosyatip=no");

}

}





if (isset($_POST['pdf_yukle'])) {
date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");
$tip="application/pdf";

$temp=explode(".",$_FILES['dosya']['name']);
$extension=end($temp);
$upload_file=$_FILES['dosya']['name'];
$type=$_FILES['dosya']['type'];
$kaynak=$_FILES['dosya']['tmp_name'];
$hedef="../../uploads/transkript/";
$pdf_ad=$_SESSION['kullanici_tc']."_".$yil."_1.pdf";
$kullanici_tc=$_SESSION['kullanici_tc'];


$temp2=explode(".",$_FILES['dosya2']['name']);
$extension2=end($temp2);
$upload_file2=$_FILES['dosya2']['name'];
$type2=$_FILES['dosya2']['type'];
$kaynak2=$_FILES['dosya2']['tmp_name'];
$hedef2="../../uploads/dersicerik/";
$pdf_ad2=$_SESSION['kullanici_tc']."_".$yil."_1.pdf";



if ($type==$tip && $type2==$tip) {
	

if(move_uploaded_file($kaynak,$hedef.$pdf_ad) && move_uploaded_file($kaynak2,$hedef2.$pdf_ad2))
{
	$_SESSION['dosyadurum']="ok";
  header("Location:../../regen/derscek");
}
else 
{
  header("Location:../../regen/dosyayukle?dosyadurum=no");
}

  
}
else
{

header("Location:../../regen/dosyayukle?dosyatip=no");

}

}




if (isset($_POST['kders-ekle'])) {



$i=1;
$sonsirasor=$db->prepare("SELECT ders_sira from kdersler where basvuru_yid=:basvuru_yid order by ders_sira desc");
			$sonsirasor->execute(array(
				'basvuru_yid' => $_SESSION['kullanici_idno']
				));

$siracek=$sonsirasor->fetch(PDO::FETCH_ASSOC);
$n=$siracek['ders_sira']+$_SESSION['b'];



for($h=$siracek['ders_sira']+1;$h<=$n;$h++)
        {  ?> 
              

 <?php 
               

               

                

                  
                   $kderskaydet=$db->prepare("INSERT INTO kdersler SET
                      ders_sira=:ders_sira,
                      ders_ad=:ders_ad,
                      ders_kredi=:ders_kredi,
                      ders_tul=:ders_tul,
                      ders_akts=:ders_akts,
                      basvuru_yid=:basvuru_yid,
                      basvuru_bolum_id=:basvuru_bolum_id

                    ");
                    $insert=$kderskaydet->execute(array(
                      'ders_sira' => $h,
                      'ders_ad' => $_POST['ders'.$i],
                      'ders_kredi' => $_POST['derskredi'.$i],
                      'ders_tul' => $_POST['derstul'.$i],
                      'ders_akts' => $_POST['dersakts'.$i],
                      'basvuru_yid' => $_SESSION['kullanici_idno'],
                      'basvuru_bolum_id' => $_SESSION['kullanici_bolum_id']
                    ));


                    




                     
                                         $bharf=$db->prepare("UPDATE kdersler set ders_ad = UPPER(ders_ad)");
        $bharf->execute(); 

              $i++;  
               
           }


           if ($insert) {
				header("Location:../../regen/b-guncelle");
				} 
				else {
					header("Location:../../regen/b-guncelle");
				}

}





if (isset($_POST['kullanicikaydet'])) {

	$kullanici_bolum_id=$_POST['bolumler'];


	echo $kullanici_ad=htmlspecialchars($_POST['kullanici_ad']); echo "<br>";
	echo $kullanici_soyad=htmlspecialchars($_POST['kullanici_soyad']); echo "<br>";
	echo $kullanici_tel=htmlspecialchars($_POST['kullanici_tel']); echo "<br>";
	echo $kullanici_no=htmlspecialchars($_POST['kullanici_no']); echo "<br>";
	echo $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']); echo "<br>";
	echo $kullanici_tc=htmlspecialchars($_POST['kullanici_tc']); echo "<br>";
	echo $kullanici_password=md5($_POST['kullanici_password']); echo "<br>";


	echo $kullanici_passwordone=trim($_POST['kullanici_passwordone']); echo "<br>";
	echo $kullanici_passwordtwo=trim($_POST['kullanici_passwordtwo']); echo "<br>";



	if ($kullanici_passwordone==$kullanici_passwordtwo) {


		if (strlen($kullanici_passwordone)>=6) {




			$kullanicisor=$db->prepare("SELECT * from ogrenci where kullanici_tc=:kullanici_tc or kullanici_no=:kullanici_no ");
			$kullanicisor->execute(array(
				'kullanici_tc' => $kullanici_tc,
				'kullanici_no' => $kullanici_idno
				));

		
			$say=$kullanicisor->rowCount();


			if ($say==0) {

				
				$password=md5($kullanici_passwordone);
				$kullanici_yetki=1;


			
				$kullanicikaydet=$db->prepare("INSERT INTO ogrenci SET
					kullanici_ad=:kullanici_ad,
					kullanici_soyad=:kullanici_soyad,
					kullanici_sifre=:kullanici_password,
					kullanici_yetki=:kullanici_yetki,
					kullanici_tel=:kullanici_tel,
					kullanici_no=:kullanici_no,
					kullanici_mail=:kullanici_mail,
					kullanici_bolum_id=:kullanici_bolum_id,
					kullanici_tc=:kullanici_tc

					");
				$insert=$kullanicikaydet->execute(array(
					'kullanici_ad' => $kullanici_ad,
					'kullanici_soyad' => $kullanici_soyad,
					'kullanici_password' => $password,
					'kullanici_yetki' => $kullanici_yetki,
					'kullanici_tel' => $kullanici_tel,
					'kullanici_no' => $kullanici_no,
					'kullanici_mail' => $kullanici_mail,
					'kullanici_bolum_id' => $kullanici_bolum_id,
					'kullanici_tc' => $kullanici_tc
					));

				if ($insert) {


					header("Location:../production/login?durum=loginbasarili");


				

				} else {


					header("Location:../production/kayit?durum=basarisiz");
				}

			}
			 else {

				header("Location:../production/kayit?durum=benzerkayit");
			}
		} else {
			header("Location:../production/kayit?durum=eksiksifre");
		}
	} else {
		header("Location:../production/kayit?durum=farklisifre");
	}
}




if (isset($_POST['kullanicigiris'])) {


	
	 $kullanici_tc=htmlspecialchars($_POST['kullanici_tc']); 
	 $kullanici_no=htmlspecialchars($_POST['kullanici_no']); 
	 $kullanici_password=md5($_POST['kullanici_password']); 



	$kullanicisor=$db->prepare("select * from ogrenci where kullanici_tc=:tc and kullanici_no=:no and kullanici_sifre=:password");
	$kullanicisor->execute(array(
		'tc' => $kullanici_tc,
		'no' => $kullanici_no,
		'password' => $kullanici_password,
		));


	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);






	if ($kullanicicek) {

		if ($kullanicicek['kullanici_yetki']==1) 
		{	
			$_SESSION['g1']=0;
			$_SESSION['g2']=0;
			$_SESSION['kullanici_tc']=$kullanicicek['kullanici_tc'];
			$_SESSION['kullanici_bolum_id']=$kullanicicek['kullanici_bolum_id'];
			$_SESSION['insertkders']=0;
			$_SESSION['eslestir']=0;
			$_SESSION['kullanici_ad']=$kullanicicek['kullanici_ad'];
			$_SESSION['kullanici_idno']=$kullanicicek['id'];
			$_SESSION['kullanici_soyad']=$kullanicicek['kullanici_soyad'];
			header("Location:../../regen/index?durum=loginbasarili");
		}
		else if ($kullanicicek['kullanici_yetki']==2)
		{
			header("Location:../production/index?durum=loginbasarili");
		}

		echo $_SESSION['kullanici_tc']=$kullanici_tc;

		

		exit;

	} else {


		header("Location:../production/login?durum=no");
	}
}

if (isset($_POST['genelayarkaydet'])) {
	
	//Tablo güncelleme işlemi kodları...
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_title=:ayar_title,
		ayar_description=:ayar_description,
		ayar_keywords=:ayar_keywords,
		ayar_author=:ayar_author
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(
		'ayar_title' => $_POST['ayar_title'],
		'ayar_description' => $_POST['ayar_description'],
		'ayar_keywords' => $_POST['ayar_keywords'],
		'ayar_author' => $_POST['ayar_author']
		));


	if ($update) {

		header("Location:../production/genel-ayar?durum=ok");

	} else {

		header("Location:../production/genel-ayar?durum=no");
	}
	
}



if (isset($_POST['iletisimayarkaydet'])) {
	
	//Tablo güncelleme işlemi kodları...
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_tel=:ayar_tel,
		ayar_gsm=:ayar_gsm,
		ayar_faks=:ayar_faks,
		ayar_mail=:ayar_mail,
		ayar_ilce=:ayar_ilce,
		ayar_il=:ayar_il,
		ayar_adres=:ayar_adres,
		ayar_mesai=:ayar_mesai
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(
		'ayar_tel' => $_POST['ayar_tel'],
		'ayar_gsm' => $_POST['ayar_gsm'],
		'ayar_faks' => $_POST['ayar_faks'],
		'ayar_mail' => $_POST['ayar_mail'],
		'ayar_ilce' => $_POST['ayar_ilce'],
		'ayar_il' => $_POST['ayar_il'],
		'ayar_adres' => $_POST['ayar_adres'],
		'ayar_mesai' => $_POST['ayar_mesai']
		));


	if ($update) {

		header("Location:../production/iletisim-ayarlar?durum=ok");

	} else {

		header("Location:../production/iletisim-ayarlar?durum=no");
	}
	
}





if (isset($_POST['hakkimizdakaydet'])) {
	
	//Tablo güncelleme işlemi kodları...

	/*

	copy paste işlemlerinde tablo ve işaretli satır isminin değiştirildiğinden emin olun!!!

	*/
	$ayarkaydet=$db->prepare("UPDATE hakkimizda SET
		hakkimizda_baslik=:hakkimizda_baslik,
		hakkimizda_icerik=:hakkimizda_icerik,
		hakkimizda_video=:hakkimizda_video,
		hakkimizda_vizyon=:hakkimizda_vizyon,
		hakkimizda_misyon=:hakkimizda_misyon
		WHERE hakkimizda_id=0");

	$update=$ayarkaydet->execute(array(
		'hakkimizda_baslik' => $_POST['hakkimizda_baslik'],
		'hakkimizda_icerik' => $_POST['hakkimizda_icerik'],
		'hakkimizda_video' => $_POST['hakkimizda_video'],
		'hakkimizda_vizyon' => $_POST['hakkimizda_vizyon'],
		'hakkimizda_misyon' => $_POST['hakkimizda_misyon']
		));


	if ($update) {

		header("Location:../production/hakkimizda?durum=ok");

	} else {

		header("Location:../production/hakkimizda?durum=no");
	}
	
}
if (isset($_POST['duyuruduzenle'])) {

	$dyr_id=$_SESSION['dyr_id'];

	$bguncelle=$db->prepare("UPDATE duyuru SET
		madde=:madde,
		madde_sira=:madde_sira
		WHERE id='$dyr_id'");

	$update=$bguncelle->execute(array(
		'madde' => $_POST['madde'],
		'madde_sira' => $_POST['madde_sira']
		));


	if ($update) {

		Header("Location:../production/duyuru?durum=d-ok");

	} else {
		Header("Location:../production/duyuru?durum=d-no");
		
	}



	}


if (isset($_POST['fakulteduzenle'])) {


	$fklt_id=$_SESSION['fklt_id'];

	$bguncelle=$db->prepare("UPDATE fakulteler SET
		fakulte_ad=:fakulte_ad,
		fakulte_dekan=:fakulte_dekan
		WHERE id='$fklt_id'");

	$update=$bguncelle->execute(array(
		'fakulte_ad' => $_POST['fakulte_ad'],
		'fakulte_dekan' => $_POST['fakulte_dekan']
		));


	if ($update) {

		Header("Location:../production/fakulteler?kullanici_id=$kullanici_id&durum=ok");

	} else {
		Header("Location:../production/fakulteler?kullanici_id=$kullanici_id&durum=no");
		
	}



}



if (isset($_POST['bolumduzenle'])) {

	$b_id=$_SESSION['blm_id'];

	$bguncelle=$db->prepare("UPDATE bolumler SET
		bolum_ad=:bolum_ad
		WHERE id='$b_id'");

	$update=$bguncelle->execute(array(
		'bolum_ad' => $_POST['bolum_ad']
		));


	if ($update) {

		Header("Location:../production/bolumler?kullanici_id=$kullanici_id&durum=ok");

	} else {
		Header("Location:../production/bolumler?kullanici_id=$kullanici_id&durum=no");
		
	}


	}

if (isset($_POST['dyr-ekle'])) {


		$kullanicikaydet=$db->prepare("INSERT INTO duyuru SET
					madde=:madde,
					madde_sira=:madde_sira
					");
				$insert=$kullanicikaydet->execute(array(
					'madde' => $_POST['madde'],
					'madde_sira' => $_POST['madde_sira']
					));

				if ($insert) {

		Header("Location:../production/duyuru?durum=e-ok");

	} else {
		Header("Location:../production/duyuru?durum=e-no");
		
	}




}


if (isset($_POST['fakulteekle'])) {

			$fakulte_ad=$_POST['fakulte_ad'];
			$fakulte_dekan=$_POST['fakulte_dekan'];
		$kullanicikaydet=$db->prepare("INSERT INTO fakulteler SET
					fakulte_ad=:fakulte_ad,
					fakulte_dekan=:fakulte_dekan
					");
				$insert=$kullanicikaydet->execute(array(
					'fakulte_ad' => $fakulte_ad,
					'fakulte_dekan' => $fakulte_dekan
					));

				if ($insert) {

		Header("Location:../production/fakulteler?durum=e-ok");

	} else {
		Header("Location:../production/fakulteler?durum=e-no");
		
	}




}


if (isset($_POST['bolumekle'])) {

			$bolumad=$_POST['bolum_ad'];
			$fakulte_yid=$_POST['bf'];
		$kullanicikaydet=$db->prepare("INSERT INTO bolumler SET
					bolum_ad=:bolum_ad,
					fakulte_yid=:fakulte_yid
					");
				$insert=$kullanicikaydet->execute(array(
					'bolum_ad' => $bolumad,
					'fakulte_yid' => $fakulte_yid
					));

				if ($insert) {

		Header("Location:../production/bolumler?durum=e-ok");

	} else {
		Header("Location:../production/bolumler?durum=e-no");
		
	}




}


if (isset($_POST['drs-ekle'])) {

	$dersekle=$db->prepare("INSERT INTO dersler SET
					ders_kodu=:ders_kodu,
					ders_ad=:ders_ad,
					ders_tul=:ders_tul,
					ders_turu=:ders_turu,
					ders_akts=:ders_akts,
					ders_kredi=:ders_kredi,
					ders_yil=:ders_yil,
					ders_donem=:ders_donem,
					ders_bolum=:ders_bolum
					");
				$insert=$dersekle->execute(array(
					'ders_kodu' => $_POST['ders_kodu'],
					'ders_ad' => $_POST['ders_ad'],
					'ders_tul' => $_POST['ders_tul'],
					'ders_turu' => $_POST['ders_turu'],
					'ders_akts' => $_POST['ders_akts'],
					'ders_kredi' => $_POST['ders_kredi'],
					'ders_yil' => $_POST['ders_yil'],
					'ders_donem' => $_POST['ders_donem'],
					'ders_bolum' => $_POST['ders_bolum']
					));

				if ($insert) {

					  Header("Location:../production/dersler?durum=e-ok");
					
				}
				else
				{
					Header("Location:../production/dersler?durum=e-no");
				}

}




if (isset($_POST['drs-duzenle'])) {

	$drs_id=$_SESSION['drs-duzenle'];


	$kguncelle=$db->prepare("UPDATE dersler SET
		ders_kodu=:ders_kodu,
		ders_ad=:ders_ad,
		ders_tul=:ders_tul,
		ders_akts=:ders_akts,
		ders_kredi=:ders_kredi,
		ders_turu=:ders_turu,
		ders_yil=:ders_yil,
		ders_donem=:ders_donem,
		ders_bolum=:ders_bolum
		WHERE id='$drs_id'");

	$update=$kguncelle->execute(array(
		'ders_kodu' => $_POST['ders_kodu'],
		'ders_ad' => $_POST['ders_ad'],
		'ders_tul' => $_POST['ders_tul'],
		'ders_akts' => $_POST['ders_akts'],
		'ders_kredi' => $_POST['ders_kredi'],
		'ders_turu' => $_POST['ders_turu'],
		'ders_yil' => $_POST['ders_yil'],
		'ders_donem' => $_POST['ders_donem'],
		'ders_bolum' => $_POST['ders_bolum']
		));


	if ($update) {

		Header("Location:../production/dersler?durum=g-ok");

	} else {
		Header("Location:../production/dersler?durum=g-no");
		
	}


}




if (isset($_POST['kullaniciduzenle'])) {

	$kullanici_id=$_SESSION['k_id'];


	$kguncelle=$db->prepare("UPDATE ogrenci SET
		kullanici_ad=:kullanici_ad,
		kullanici_soyad=:kullanici_soyad,
		kullanici_no=:kullanici_no,
		kullanici_mail=:kullanici_mail,
		kullanici_tel=:kullanici_tel,
		kullanici_tc=:kullanici_tc,
		kullanici_yetki=:kullanici_yetki
		WHERE id='$kullanici_id'");

	$update=$kguncelle->execute(array(
		'kullanici_ad' => $_POST['kullanici_ad'],
		'kullanici_soyad' => $_POST['kullanici_soyad'],
		'kullanici_no' => $_POST['kullanici_no'],
		'kullanici_mail' => $_POST['kullanici_mail'],
		'kullanici_tel' => $_POST['kullanici_tel'],
		'kullanici_tc' => $_POST['kullanici_tc'],
		'kullanici_yetki' => $_POST['kullanici_yetki']
		));


	if ($update) {

		Header("Location:../production/kullanici-duzenle?kullanici_id=$kullanici_id&durum=ok");

	} else {
		Header("Location:../production/kullanici-duzenle?kullanici_id=$kullanici_id&durum=no");
		
	}

}

if ($_GET['duyurusil']=="ok") {

	$sil=$db->prepare("DELETE from duyuru where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['duyuru_id']
		));
	if ($kontrol) {

		Header("Location:../production/duyuru?durum=s-ok");

	} else {

		Header("Location:../production/duyuru?durum=s-no");

	}

}

if ($_GET['drssil']=="ok") {

	$sil=$db->prepare("DELETE from dersler where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['ders_id']
		));
	if ($kontrol) {

		Header("Location:../production/dersler?durum=s-ok");

	} else {

		Header("Location:../production/dersler?durum=s-no");

	}

}

if ($_GET['fakultesil']=="ok") {

$sil=$db->prepare("DELETE from fakulteler where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['fakulte_id']
		));
	if ($kontrol) {

		Header("Location:../production/fakulteler?durum=s-ok");

	} else {

		Header("Location:../production/fakulteler?durum=s-no");

	}



}

if ($_GET['bolumsil']=="ok") {

$sil=$db->prepare("DELETE from bolumler where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['bolum_id']
		));
	if ($kontrol) {

		Header("Location:../production/bolumler?durum=s-ok");

	} else {

		Header("Location:../production/bolumler?durum=s-no");

	}

}

if ($_GET['kullanicisil']=="ok") {

	$sil=$db->prepare("DELETE from ogrenci where id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['kullanici_id']
		));
	if ($kontrol) {

		header("location:../production/kullanici?sil=ok");

	} else {

		header("location:../production/kullanici?sil=no");

	}
}




if (isset($_POST['menuduzenle'])) {

	$menu_id=$_POST['menu_id'];

	$menu_seourl=seo($_POST['menu_ad']);

	$ayarkaydet=$db->prepare("UPDATE menu SET
		menu_ad=:menu_ad,
		menu_detay=:menu_detay,
		menu_url=:menu_url,
		menu_sira=:menu_sira,
		menu_seourl=:menu_seourl,
		menu_durum=:menu_durum
		WHERE menu_id={$_POST['menu_id']}");

	$update=$ayarkaydet->execute(array(
		'menu_ad' => $_POST['menu_ad'],
		'menu_detay' => $_POST['menu_detay'],
		'menu_url' => $_POST['menu_url'],
		'menu_sira' => $_POST['menu_sira'],
		'menu_seourl' => $menu_seourl,
		'menu_durum' => $_POST['menu_durum']
		));


	if ($update) {

		Header("Location:../production/menu-duzenle?menu_id=$menu_id&durum=ok");

	} else {

		Header("Location:../production/menu-duzenle?menu_id=$menu_id&durum=no");
	}
}

if ($_GET['menusil']=="ok") {

	$sil=$db->prepare("DELETE from menu where menu_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['menu_id']
		));


	if ($kontrol) {


		header("location:../production/menu?sil=ok");


	} else {

		header("location:../production/menu?sil=no");
	}
}


if (isset($_POST['kullanicisifreguncelle'])) {

	
	



	 $kullanici_eskipassword=htmlspecialchars(trim($_POST['kullanici_eskipassword']));
	 $kullanici_passwordone=htmlspecialchars(trim($_POST['kullanici_passwordone'])); 
	 $kullanici_passwordtwo=htmlspecialchars(trim($_POST['kullanici_passwordtwo'])); 

	$kullanici_password=md5($kullanici_eskipassword);


	$kullanicisor=$db->prepare("select * from ogrenci where kullanici_sifre=:password");
	$kullanicisor->execute(array(
		'password' => $kullanici_password
		));

			//dönen satır sayısını belirtir
	$say=$kullanicisor->rowCount();



	if ($say==0) {

		header("Location:../../regen/sifreguncelle?durum=yanlissifre");



	} else {



	//eski şifre doğruysa başla


		if ($kullanici_passwordone==$kullanici_passwordtwo) {


			if (strlen($kullanici_passwordone)>=6) {
				$kulllanici_tc=$_SESSION['kullanici_tc'];


				//md5 fonksiyonu şifreyi md5 şifreli hale getirir.
				$password=md5($kullanici_passwordone);

					$kullanici_tc=$_SESSION['kullanici_tc'];

					$sifre_guncelle=$db->prepare("UPDATE ogrenci SET
		kullanici_sifre=:kullanici_sifre


		WHERE kullanici_tc='$kullanici_tc'");

	$update=$sifre_guncelle->execute(array(
		'kullanici_sifre' => $password



		));

				
				

				if ($update) {


					header("Location:../../regen/sifreguncelle?durum=sifredegisti");


				//Header("Location:../production/genel-ayarlar?durum=ok");

				} else {


					header("Location:../../regen/sifreguncelle?durum=no");
				}





		// Bitiş



			} else {


				header("Location:../../regen/sifreguncelle?durum=eksiksifre");


			}



		} else {

			header("Location:../../regen/sifreguncelle?durum=sifreleruyusmuyor");

			exit;


		}


	}


}


?>