<?php
error_reporting(0);
include "header.php";
include "../nedmin/netting/baglan.php";

	   $kid=$_SESSION['kullanici_idno'];

	   	date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");

    $o_ilerlemesor=$db->prepare("SELECT * FROM oneri_ilerleme_kontrol WHERE oneri_yil=:oneri_yil and  oneri_kul_id=:oneri_kul_id ");
  $o_ilerlemesor->execute(array(
    'oneri_yil' => $yil,
    'oneri_kul_id' => $kid
    ));

$o_ilerlemecek=$o_ilerlemesor->fetch(PDO::FETCH_ASSOC);





 
    $kbilgisor=$db->prepare("SELECT * FROM ogrenci WHERE id=:id  ");
  $kbilgisor->execute(array(
    'id' => $kid
    ));


  $kbilgicek=$kbilgisor->fetch(PDO::FETCH_ASSOC);

  $kullanici_id=$kbilgicek['id'];

      $oderslersor=$db->prepare("SELECT * FROM onerilen_dersler WHERE onerenkisi_id=:onerenkisi_id   ");
  $oderslersor->execute(array(
    'onerenkisi_id' => $kid
    ));
  


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

      if ($_GET['oneri_durum']=="yanlisformat") {
  
  echo '      <div id="dv1" class="alert alert-success" role="alert"><font color="black"><strong>
       Lütfen .pdf formatında bir dosya yükleyiniz !</strong></font>
       
      </div>';
}

			if ($o_ilerlemecek['oneri_ilerleme_durum']==1) {

				  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Ders önerinizi zaten imzaladınız ! 
       Bu işlemi tekrar edemezsiniz. <br> Ders öneriniz sonuçlandığında anasayfanıza düşecektir.
        
      </div>';

   ?>
<input type="button" class="btn px-5 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='oneriler';" value="Geri Dön" />
   <?php

			}
			else {
				 echo '      <div id="dv1" class="alert alert-info" role="alert"> Onerilerinizi İmzalamak Üzeresiniz.<br>Bu adımdan sonra yeni öneri ekleyemez ve önerilerinizde değişiklik yapamazsınız !
        
      </div>';
 ?>

		 		




	<br><br>
       <input type="submit" onclick="PrintElem('#sd')" class="btn btn-danger btn-xs" value="Dilekçeyi İndir" />
       <center><br> <font color="black" size="4">İmzalanmamış Öneri Mevcut !</font> <br> Lütfen öneri başvurularınızın tamamlanması için önereceğiniz bütün dersleri ekledikten sonra yukarıdaki butona tıklayıp dilekçenizi indirip sonra imzalayarak tekrar yükleyiniz.    <br>          </center>
       <br><br>


      
        <div class="col-md-3">
<div class="konteynir">
	<form enctype="multipart/form-data" action="../nedmin/netting/islem.php" method="POST">
       <table>
				<tr>
						<td colspan="2">
              <center>
							<font color="black" >   Lütfen dilekçeyi .pdf formatında yükleyiniz.    </font>
              </center>
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
							type="submit" id="onerilen_dilekce_yukle" name="onerilen_dilekce_yukle" class="btn btn-danger btn-xs" value="Yükle"/>

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

      <img src="../images/dersoneri.png" alt="Başlık"/ width="900" height="200">
  
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



   echo $fakultecek['fakulte_ad'];  ?> Enstitü/ Fakültesi / <br> &nbsp;&nbsp;&nbsp;Yüksekokulu <?php echo $kbilgicek['kullanici_no']; ?> numaralı öğrencisiyim  <?php echo "$yill"." / ".($yil); ?> Öğretim Yılı yaz okulunda aşağıda belirtilen derslerin kabul edilmesi için önermek istiyorum.
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
  Yaz Okulu için Önerilen Dersin/Derslerin Bilgileri;

  <table border="1" cellpadding="0" cellspacing="0" style="width:100%">
  	<tr>
  			<td colspan="5">
  				<center>
  				Önerilen Ders Bilgileri
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

    while ($oderslercek=$oderslersor->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr> <td>'.$oderslercek['ders_kkodu']    .'</td>';

       $kunisor=$db->prepare("select * from universite where universite_id=:universite_id");
  $kunisor->execute(array(
    'universite_id' => $oderslercek['ders_kuniversite']
    ));
  $kunicek=$kunisor->fetch(PDO::FETCH_ASSOC);

  echo ' <td>'.$kunicek['name']    .'</td>';

    $kfakultesor=$db->prepare("select * from universite_fakulte where fakulte_id=:fakulte_id");
  $kfakultesor->execute(array(
    'fakulte_id' => $oderslercek['ders_kfakulte']
    ));
  $kfakultecek=$kfakultesor->fetch(PDO::FETCH_ASSOC);

    echo ' <td>'.$kfakultecek['name']    .'</td>';

     $kbolumsor=$db->prepare("select * from universite_bolum where bolum_id=:bolum_id");
  $kbolumsor->execute(array(
    'bolum_id' => $oderslercek['ders_kbolum']
    ));
  $kbolumcek=$kbolumsor->fetch(PDO::FETCH_ASSOC);

    echo ' <td>'.$kbolumcek['name']    .'</td>';
     echo ' <td>'.$oderslercek['ders_ad']    .'</td>';


      $bderssor=$db->prepare("select * from dersler where id=:id");
  $bderssor->execute(array(
    'id' => $oderslercek['ders_bders']
    ));
  $bderscek=$bderssor->fetch(PDO::FETCH_ASSOC);
  echo ' <td>'.$bderscek['ders_kodu']    .'</td>';



      $bbolumsor=$db->prepare("select * from bolumler where id=:id");
  $bbolumsor->execute(array(
    'id' => $oderslercek['ders_bbolum']
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