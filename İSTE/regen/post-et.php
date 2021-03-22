<?php
error_reporting(0);
session_start();
include "../nedmin/netting/baglan.php";
$n=$_SESSION['dsayi'];

$a=0;
      $ogrencisor=$db->prepare("SELECT * from ogrenci where kullanici_tc=:kullanici_tc");
      $ogrencisor->execute(array(
        'kullanici_tc' => $_SESSION['kullanici_tc']
        ));
      $ogrencicek=$ogrencisor->fetch(PDO::FETCH_ASSOC);
      $yid=$ogrencicek['id'];
      $bolum=$ogrencicek['kullanici_bolum_id'];

$kderslersor=$db->prepare("SELECT distinct basvuru_yid from kdersler where basvuru_yid=:basvuru_yid");
      $kderslersor->execute(array(
        'basvuru_yid' => $yid
        ));
    $kderslercek=$kderslersor->rowCount();
    $_SESSION['ders_sayisi']=$kderslercek;
      for($i=1;$i<=$n;$i++)
        { $a++;  
              


               if ($kderslercek==0) {

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
                      'ders_sira' => $i,
                      'ders_ad' => $_POST['ders'.$i],
                      'ders_kredi' => $_POST['derskredi'.$i],
                      'ders_tul' => $_POST['derstul'.$i],
                      'ders_akts' => $_POST['dersakts'.$i],
                      'basvuru_yid' => $yid,
                      'basvuru_bolum_id' => $bolum
                    ));


                    

                      $bharf=$db->prepare("UPDATE kdersler set ders_ad = UPPER(ders_ad)");
        $bharf->execute();

    }
}
        if ($insert) {
        	 
        	 header("Location:eslestir?kd=yes");
        }
        else
        {
        	
        	header("Location:index?kd=no");
        }

                     
                  

                
            

  ?>