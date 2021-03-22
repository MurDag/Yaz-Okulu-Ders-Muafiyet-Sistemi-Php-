 <?php

include "header.php";
include "../nedmin/netting/baglan.php";
error_reporting(0);

	   $kid=$_SESSION['kullanici_idno'];

	   	date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");

    $y_ilerlemesor=$db->prepare("SELECT * FROM yazokulu_ilerleme_kontrol WHERE y_basvuru_yil=:y_basvuru_yil and  y_kul_id=:y_kul_id ");
  $y_ilerlemesor->execute(array(
    'y_basvuru_yil' => $yil,
    'y_kul_id' => $kid
    ));

$y_ilerlemecek=$y_ilerlemesor->fetch(PDO::FETCH_ASSOC);





 
    $kbilgisor=$db->prepare("SELECT * FROM ogrenci WHERE id=:id  ");
  $kbilgisor->execute(array(
    'id' => $kid
    ));


  $kbilgicek=$kbilgisor->fetch(PDO::FETCH_ASSOC);

  $kullanici_id=$kbilgicek['id'];

  	   	date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");

if ($y_ilerlemecek['y_ilerleme_durum']==2)
{
  $yderslersor=$db->prepare("SELECT * FROM yazokulu_basvuru WHERE basvuru_kul_id=:basvuru_kul_id  and  basvuru_yil=:basvuru_yil and  basvuru_sonuc!=:basvuru_sonuc");
  $yderslersor->execute(array(
    'basvuru_kul_id' => $kid,
    'basvuru_yil' => $yil,
    'basvuru_sonuc' => 2
    ));
}
else
{

  $yderslersor=$db->prepare("SELECT * FROM yazokulu_basvuru WHERE basvuru_kul_id=:basvuru_kul_id  and  basvuru_yil=:basvuru_yil ");
  $yderslersor->execute(array(
    'basvuru_kul_id' => $kid,
    'basvuru_yil' => $yil
    ));
}





      
  


 date_default_timezone_set('Etc/GMT-3');
		$yil=date("Y");
		$yill=$yil-1;



?>

<!DOCTYPE html>
<html>
<head>
	<title></title>



</head>
<body>
	<center>
			<?php 

			if ($_GET['basvuru_durum']=="yanlisformat") {
  
  echo '      <div id="dv1" class="alert alert-success" role="alert"><font color="black"><strong>
       Lütfen .pdf formatında bir dosya yükleyiniz !</strong></font>
       
      </div>';
}





			if ($y_ilerlemecek['y_ilerleme_durum']==1) {

				  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Ders başvurunuzu zaten imzaladınız ! 
       Bu işlemi tekrar edemezsiniz. <br> Ders başvurunuz sonuçlandığında anasayfanıza düşecektir.
        
      </div>';

   ?>
<input type="button" class="btn px-5 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='oneriler';" value="Geri Dön" />
   <?php

			}
			else {
				 echo '      <div id="dv1" class="alert alert-info" role="alert"> Başvurularınız İmzalamak Üzeresiniz.<br>Bu adımdan sonra yeni başvuru ekleyemez ve başvurularınızda değişiklik yapamazsınız !
        
      </div>';
 ?>

		 		




	<br><br>
       <input type="submit" onclick="PrintElem('#sd')" class="btn btn-danger btn-xs" value="Dilekçeyi İndir" />
       <br><br>


      
        <div class="col-md-3">
<div class="konteynir">
	<form enctype="multipart/form-data" action="../nedmin/netting/islem.php" method="POST">
       <table>
				<tr>
						<td colspan="2">
							<font color="black" >   Lütfen ders içeriğini .pdf formatında yükleyiniz.    </font>
						</td>
					</tr>
					<tr>
						<td bgcolor="	#E53935">
							<div style="color: black;"> 

  						<input color="red" type="FILE" name="dosya" id="dosya" required="true"> </div>
						</td>
						<td>
							<input onclick="return 
							window.confirm(' Devam etmek istiyor musunuz ?')" 
							type="submit" id="y_dilekce_yukle" name="y_dilekce_yukle" class="btn btn-danger btn-xs" value="Yükle"/>

						</td>

					</tr>	


				</table>
				<input type='hidden' name='kcrk' value='<?php echo $kicerik; ?>'>

	</form>
</div></div>



      

			

	</center>


</body>
</html>



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<Div id="sd" style="display: none;" >
    <form >
    	<br><br>

      <img src="../images/yazokulu_dilekce.png" alt="Başlık"/ width="900" height="200">
  
  <br> <br>
  <center>  
<font face="tahoma" size="3" color="black"><?php 
 $bolumsor=$db->prepare("SELECT * FROM bolumler WHERE id=:id  ");
  $bolumsor->execute(array(
    'id' => $kbilgicek['kullanici_bolum_id']
    ));

  $bolumcek=$bolumsor->fetch(PDO::FETCH_ASSOC);
  

 echo $bolumcek['bolum_ad'];  ?> Bölüm Başkanlığına </font>
  </center>
  
  <br>
  <br>
  <font face="tahoma" size="3" color="black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; İskenderun Teknik Üniversitesi (İSTE) <?php 
  $fakultesor=$db->prepare("SELECT * FROM fakulteler WHERE id=:id  ");
  $fakultesor->execute(array(
    'id' => $bolumcek['fakulte_yid']
    ));

  $fakultecek=$fakultesor->fetch(PDO::FETCH_ASSOC);



   echo $fakultecek['fakulte_ad'];  ?> Enstitü/ Fakültesi / <br> &nbsp;&nbsp;&nbsp;Yüksekokulu <?php echo $kbilgicek['kullanici_no']; ?> numaralı öğrencisiyim  <?php echo "$yill"." / ".($yil); ?> Öğretim Yılı yaz okulunda aşağıda belirtilen dersleri almak istiyorum.
   <br> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
   Üniversitemizin <?php echo "($yill)"." / ".($yil); ?> Eğitim -Öğretim Yılı Yaz Öğretimi Usul ve Esaslarına tabi olduğumu kabul eder, gereğini saygılarımla arz ederim.

 
  <br>
  <br><br>
  Öğrenci Bilgileri;
  <table border="1" cellpadding="0" cellspacing="0" style="width:100%" >

    <tr> <td> TC Kimlik NO    </td> <td> &nbsp;&nbsp;&nbsp; <?php echo  $kbilgicek['kullanici_tc']; ?>  </td>  </tr>
    <tr> <td> Okul NO    </td> <td> &nbsp;&nbsp;&nbsp; <?php echo  $kbilgicek['kullanici_no']; ?>   </td>  </tr>
    <tr> <td> Adı Soyadı    </td> <td> &nbsp;&nbsp;&nbsp; <?php 

    $kadsoyad=$kbilgicek['kullanici_ad'].' '.$kbilgicek['kullanici_soyad'];
    echo  $kbilgicek['kullanici_ad'].' '.$kbilgicek['kullanici_soyad']; ?>  </td>  </tr>
    <tr> <td> Bölüm    </td> <td>  &nbsp;&nbsp;&nbsp; 
      <?php   

      $bolum_id=$kbilgicek['kullanici_bolum_id'];
    $kbolumsor=$db->prepare("SELECT * FROM bolumler WHERE id=:id  ");
  $kbolumsor->execute(array(
    'id' => $bolum_id ));

  $kbolumcek=$kbolumsor->fetch(PDO::FETCH_ASSOC);
  echo $kbolumcek['bolum_ad'];

      
       ?>  </td>  </tr>
    <tr> <td> İletişim Cep/TlfNo    </td> <td> &nbsp;&nbsp;&nbsp;  <?php echo  $kbilgicek['kullanici_tel']; ?>  </td>  </tr>

  </table>
  <br>
  Yaz Okulu için Başvurulan Dersin/Derslerin Bilgileri;

  <table border="1" cellpadding="0" cellspacing="0" style="width:100%">
  	<tr>
  			<td colspan="5">
  				<center>
  				Başvurulan Ders Bilgileri
  				</center>
  			</td>
  			<td colspan="3">
  				<center>
  				Eşleştirilmek İstenen Ders Bilgileri
  				</center>
  			</td>

  	</tr>
    <tr><td><u>Kodu</u></td><td><u>Üniversite</u></td><td><u>Fakülte</u></td><td><u>Bölüm</u></td><td><u>Ders Adı</u></td>
    	<td><u>Kodu</u></td><td><u>Bölümü</u></td><td><u>Ders Adı</u></td>

     </tr>
    <?php
    while ($yderslercek=$yderslersor->fetch(PDO::FETCH_ASSOC)) {

   $y_ders_sor=$db->prepare("SELECT * FROM yazokulu_onayli_dersler WHERE k_universite=:k_universite and  k_fakulte=:k_fakulte and  k_bolum=:k_bolum and  b_ders_ad=:b_ders_ad");
  $y_ders_sor->execute(array(
    'k_universite' => $yderslercek['k_universite'],
    'k_fakulte' => $yderslercek['k_fakulte'],
    'k_bolum' => $yderslercek['k_bolum'],
    'b_ders_ad' => $yderslercek['b_ders_ad']
    ));

$y_ders_cek=$y_ders_sor->fetch(PDO::FETCH_ASSOC);



      echo '<tr> <td>'.$y_ders_cek['k_ders_kodu']    .'</td>';

       $kunisor=$db->prepare("select * from universite where universite_id=:universite_id");
  $kunisor->execute(array(
    'universite_id' => $y_ders_cek['k_universite']
    ));
  $kunicek=$kunisor->fetch(PDO::FETCH_ASSOC);

  echo ' <td>'.$kunicek['name']    .'</td>';

    $kfakultesor=$db->prepare("select * from universite_fakulte where fakulte_id=:fakulte_id");
  $kfakultesor->execute(array(
    'fakulte_id' => $y_ders_cek['k_fakulte']
    ));
  $kfakultecek=$kfakultesor->fetch(PDO::FETCH_ASSOC);

    echo ' <td>'.$kfakultecek['name']    .'</td>';

     $kbolumsor=$db->prepare("select * from universite_bolum where bolum_id=:bolum_id");
  $kbolumsor->execute(array(
    'bolum_id' => $y_ders_cek['k_bolum']
    ));
  $kbolumcek=$kbolumsor->fetch(PDO::FETCH_ASSOC);

    echo ' <td>'.$kbolumcek['name']    .'</td>';
     echo ' <td>'.$y_ders_cek['k_ders_ad']    .'</td>';


      $bderssor=$db->prepare("select * from dersler where id=:id");
  $bderssor->execute(array(
    'id' => $y_ders_cek['b_ders_ad']
    ));
  $bderscek=$bderssor->fetch(PDO::FETCH_ASSOC);
  echo ' <td>'.$bderscek['ders_kodu']    .'</td>';



      $bbolumsor=$db->prepare("select * from bolumler where id=:id");
  $bbolumsor->execute(array(
    'id' => $y_ders_cek['b_bolum']
    ));
  $bbolumcek=$bbolumsor->fetch(PDO::FETCH_ASSOC);
  echo ' <td>'.$bbolumcek['bolum_ad']    .'</td>';

  echo ' <td>'.$bderscek['ders_ad']    .'</td>';


  echo  '</tr>';

    }

     ?>
  </table>
  <br>
  
 

   <table align="center"> 

   	<tr> <td><u> Tarih :  </u>  </td> <td> <?php 

   	echo date("j/n/Y"); 

   	 ?> </td> </tr>
   	 <tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td></tr>
   	<tr> <td><u> İmza : </u>  </td></tr>
   	<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td></tr>
   	<tr> <td><u> Ad Soyad : </u>  </td> <td> <?php echo $kadsoyad; ?>  </td></tr>

    </table>
<br><br><br><br><br>
    <table align="left">
    	<tr>
    		<td > Tarih: </td><td> </td>
    		<td> </td>
    		    
    	</tr>
    	<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td></tr>
    	<tr> <td><u> İmza </u> </td>   </tr>
    	<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td></tr>
    	<tr> <td><u>Danışmanın Unvanı, Adı ve Soyadı</u> </td>   </tr>
    	

    </table>

        <table align="right">
    	<tr>
    		<td > Tarih: </td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    		    
    	</tr>
    	<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td></tr>
    	<tr> <td><u> İmza </u> </td>   </tr>
    	<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td></tr>
    	<tr> <td><u> Bölüm Başkanının Unvanı, Adı ve Soyadı </u> </td>   </tr>
      <tr> <td>  <?php  echo $bolumcek['bolum_baskani'];  ?>   </td>   </tr>
    	
    	
    </table>

      

    </form>



    

</Div>   
<?php 
}
 ?>
</body>
</html>

<?php include "footer.php"; ?>