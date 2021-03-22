<?php
error_reporting(0);
include "header.php";
include "../nedmin/netting/baglan.php";
$girdi=0;


 $unisor=$db->prepare("SELECT * from universite");
      $unisor->execute(array());

       $bfakultesor=$db->prepare("SELECT * from fakulteler");
      $bfakultesor->execute(array());

date_default_timezone_set('Etc/GMT-3');
$yil=date("Y");

       $kid=$_SESSION['kullanici_idno'];
    $bsor=$db->prepare("SELECT * FROM onerilen_dersler  where onerenkisi_id=:onerenkisi_id and oneri_yil=:oneri_yil");
    $bsor->execute(array( 
      'onerenkisi_id' => $kid,
      'oneri_yil' => $yil

    )); 
$bsayi=$bsor->rowCount();


      

    $o_ilerlemesor=$db->prepare("SELECT * FROM oneri_ilerleme_kontrol WHERE oneri_yil=:oneri_yil and  oneri_kul_id=:oneri_kul_id ");
  $o_ilerlemesor->execute(array(
    'oneri_yil' => $yil,
    'oneri_kul_id' => $kid
    ));

$o_ilerlemecek=$o_ilerlemesor->fetch(PDO::FETCH_ASSOC);



 $y_ayarsor=$db->prepare("SELECT * from y_ayar");
  $y_ayarsor->execute(array());
 $y_ayarcek=$y_ayarsor->fetch(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html>
<head>
  <title>Ders Önerileri</title>

      <script type="text/javascript">
        function kapat() {
        //    setTimeout("document.getElementById('dv1').style.visibility = 'hidden'", 5000);

               
          

          setTimeout(function() { $("#dv1").slideUp("slow"); },8000); 
         
         
       }
      

        
    </script>

</head>
<body>
  <center>

    <br>
<br>

    <?php
if ($_GET['oneri_durum']=="successful") {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Ders öneri kaydınız başarılı bir şekilde alınmıştır ! / Sonuç incelendikten sonra anasayfanıza düşecektir.
        
      </div>';
   
}

if ($_GET['ognclm_durum']=="successful") {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Güncelleme İşlemi Başarılı !
        
      </div>';
   
}


if ($_GET['oneri_durum']=="imzalanmadi") {
  
  echo '      <div id="dv1" class="alert alert-info" role="alert">
       Ders öneri kaydınızın ilk adımı başarılı bir şekilde yapılmıştır. 
       <br>


        Lütfen öneri başvurularınızın tamamlanması için önereceğiniz bütün dersleri ekledikten sonra aşağıdaki butona tıklayıp dilekçenizi indirip sonra imzalayarak tekrar yükleyiniz.
        
      </div>';

      $girdi=1;
      

      
}




if ($_GET['oneri_durum']=="error") {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Ders öneri kaydınız yapılırken bir hata oluştu ! / Lütfen ilgili birime durumu bildiriniz.</strong></font>
              </div>';


              

}
?>

<?php 
$kontrol=1;

$o_id=$_SESSION['kullanici_idno'];
$imzasor=$db->prepare("SELECT * FROM onerilen_dersler  where onerenkisi_id=:onerenkisi_id ");
    $imzasor->execute(array( 'onerenkisi_id' => $o_id )); 
    while ($imzacek=$imzasor->fetch(PDO::FETCH_ASSOC)) {
      
    if ($imzacek['oneri_imza']==0) {
      $kontrol=0;
    }


    }
    
   


?>

  
    <div ><h3> <font color="black">Yapılan Ders Önerileriniz</font> </h3><hr></div>

    <?php 

    if ($o_ilerlemecek['oneri_ilerleme_durum']==1) {
 ?>
 <font color="black">Eklediğiniz ders önerileri sonuçlandığında anasayfanıza düşecektir.</font>
<?php }  ?>



    <?php if ($kontrol==0) { ?>
      <br><center>Lütfen imzalama işlemini önereceğiniz bütün dersleri ekledikten sonra yapınız.</center>
          <input type="button" class="btn px-5 m-1 width-2 btn-pill btn-outline-primary" onclick="location.href='dilekce_yukle';" value="Önerileri İmzala" />
        <?php } ?>

<?php

if ($bsayi>0) { ?>


<?php if ($kontrol==0 && $girdi==0) { ?>
<center><br> <font color="black" size="4">İmzalanmamış Öneri Mevcut !</font>   </center>
<?php } ?>

<?php if ($bsayi<$y_ayarcek['max_oneri'] && $o_ilerlemecek['oneri_ilerleme_durum']!=1) { ?>
<br>
<input type="button" class="btn px-4 m-1 btn-secondary" onclick="location.href='ders_oner';" value="Ders Ekle" />
<?php } ?>
<br>
  Önerilebilen Ders Sayısı :<?php echo " ".$bsayi.'/'.$y_ayarcek['max_oneri']; ?> 




<?php

if ($o_ilerlemecek['oneri_ilerleme_durum']==0 || $o_ilerlemecek['oneri_ilerleme_durum']==2) {
 ?>
<br>


<div class="konteynir" >
<table style="margin-top: 50px;">
    <thead>

    	<tr>
    		<td colspan="8"><center>
    			Önerilen Ders Bilgileri
    			</center>
    		</td>
    		<td colspan="3">
    			<center>
    			Eşleştirilmek İstenen Ders Bilgileri
    			</center>
    		</td>
    		<td colspan="2">
    			<center>
    			Düzenle/Sonuç
    			</center>
    		</td>
    	
    	</tr>

      <tr>

        <th>
          Üniversite 
        </th>
         <th>
          Fakülte
        </th>
         <th>
          Bölüm
        </th>
        <th> 
        	Ders Adı
        </th>
        <th> 
        	Ders Kodu
        </th>
        <th> 
        	Kredi
        </th>
        <th> 
        	TUL
        </th>
        <th> 
        	AKTS
        </th>


         <th>
          Fakülte
        </th>
         <th>
          Bölüm
        </th>
        <th> 
        	Ders
        </th>
        
          <th>Öneri Sonuç</th>
          <th>Red Sebebi</th>
      
        




      </tr>
    </thead>
   
    <tbody >
    <?php 

      while($bcek=$bsor->fetch(PDO::FETCH_ASSOC)) {
        
        ?>
      <tr>

        <td bgcolor="#DDDDDD" data-title='Önerilen Ders Bilgileri'>
        	<?php
$kunisor=$db->prepare("SELECT * FROM universite  where universite_id=:universite_id ");
    $kunisor->execute(array( 'universite_id' => $bcek['ders_kuniversite'] )); 
    $kunicek=$kunisor->fetch(PDO::FETCH_ASSOC);
    echo $kunicek['name'];

        	?>

          
        
        </td>
        <td bgcolor="#DDDDDD">
           <?php
$kfakultesor=$db->prepare("SELECT * FROM universite_fakulte  where fakulte_id=:fakulte_id ");
    $kfakultesor->execute(array( 'fakulte_id' => $bcek['ders_kfakulte'] )); 
    $kfakultecek=$kfakultesor->fetch(PDO::FETCH_ASSOC);
    echo $kfakultecek['name'];

        	?>
        </td>
        <td bgcolor="#DDDDDD">
                    <?php
$kbolumsor=$db->prepare("SELECT * FROM universite_bolum  where bolum_id=:bolum_id ");
    $kbolumsor->execute(array( 'bolum_id' => $bcek['ders_kbolum'] )); 
    $kbolumcek=$kbolumsor->fetch(PDO::FETCH_ASSOC);
    echo $kbolumcek['name'];

        	?>
        </td>
        <td bgcolor="#DDDDDD">
          <?php echo $bcek['ders_ad']; ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Ders Kodu'>
        	 <?php echo $bcek['ders_kkodu']; ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Kredi'>
        	 <?php echo $bcek['ders_kkredi']; ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='TUL'>
        	 <?php echo $bcek['ders_ktul']; ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='AKTS'>
        	 <?php echo $bcek['ders_kakts']; ?>
        </td>
          <td bgcolor="#CFCFCF" data-title='Eşleştirilen Ders Bilgileri'>
                    <?php
   
$bfakultesor=$db->prepare("SELECT * FROM fakulteler  where id=:id ");
    $bfakultesor->execute(array( 'id' => $bcek['ders_bfakulte'] )); 
    $bfakultecek=$bfakultesor->fetch(PDO::FETCH_ASSOC);
    echo $bfakultecek['fakulte_ad'];


        	?>
        </td>
         <td bgcolor="#CFCFCF">
                    <?php
$bbolumsor=$db->prepare("SELECT * FROM bolumler  where id=:id ");
    $bbolumsor->execute(array( 'id' => $bcek['ders_bbolum'] )); 
    $bbolumcek=$bbolumsor->fetch(PDO::FETCH_ASSOC);
    echo $bbolumcek['bolum_ad'];

        	?>
        </td>
         <td bgcolor="#CFCFCF">
                    <?php
$bderssor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $bderssor->execute(array( 'id' => $bcek['ders_bders'] )); 
    $bderscek=$bderssor->fetch(PDO::FETCH_ASSOC);
    echo $bderscek['ders_ad'];

        	?>
        </td>


        <?php   if ($bcek['oneri_sonuc']==0) { ?>

        <td bgcolor="#BFBFBF" ><center><a href="oneri_guncelle?oneriguncelle_id=<?php echo $bcek['id']; ?>">
          <button  <?php if($bcek['oneri_sonuc']>0 || $o_ilerlemecek['oneri_ilerleme_durum']==1) { ?> style="color: black; cursor: not-allowed;"   disabled=" disabled "  <?php } ?>
          class="btn px-4 m-1 btn-success">Güncelle</button></a></center></td>



         <td bgcolor="#BFBFBF" ><center><a href="../nedmin/netting/islem.php?onerisil_id=<?php echo $bcek['id']; ?>">
          <button <?php if($bcek['oneri_sonuc']>0 || $o_ilerlemecek['oneri_ilerleme_durum']==1) { ?> style="color: black; cursor: not-allowed;"  disabled=" disabled "  <?php } ?> class="btn px-4 m-1 btn-outline-dark">Sil</button></a></center></td>


        <?php } ?>




          <?php if ($o_ilerlemecek['oneri_ilerleme_durum']==2 && $bcek['oneri_sonuc']!=0) { ?>
        
            <td bgcolor="#BFBFBF">
              
            <?php   if ($bcek['oneri_sonuc']==0) { ?>
             <font color="black" size="2" style="font-weight: bold;">Sonuçlandırılmadı</font>
           <?php  }  ?>
            <?php   if ($bcek['oneri_sonuc']==1) { ?>
             <font color="#0055FF" size="3" style="font-weight: bold;">Onaylandı </font>
           <?php  }  ?>
            <?php   if ($bcek['oneri_sonuc']==2) { ?>
            <font color="red" size="3" style="font-weight: bold;" >Red Edildi</font>
           <?php  }  ?>





            </td>

             

            <td bgcolor="#BFBFBF">
             <?php   if ($bcek['oneri_sonuc']==2) { echo $bcek['oneri_red_sebep']; } ?>
            <?php   if ($bcek['oneri_sonuc']==1 || $bcek['oneri_sonuc']==0) {  ?>  
              <center>
                 <font>---</font>
                 </center>
           <?php } ?>

            </td>
         

        <?php } ?>
      </tr>
      <?php } ?>



    </tbody>
  </table>




</div>

<?php }
  
  if ($o_ilerlemecek['oneri_ilerleme_durum']==1) 
  {
    ?>
    <br>
    <font color="darkblue"> Öneriniz Henüz Kurul Tarafından <u>Kesinleştirilmedi </u>   </font>

<div class="konteynir" >
<table style="margin-top: 50px;">
    <thead>

      <tr>
        <td colspan="8"><center>
          Önerilen Ders Bilgileri
          </center>
        </td>
        <td colspan="3">
          <center>
          Eşleştirilmek İstenen Ders Bilgileri
          </center>
        </td>
        <td colspan="2">
          <center>
          Öneri Sonucu
          </center>
        </td>
      
      </tr>

      <tr>

        <th>
          Üniversite 
        </th>
         <th>
          Fakülte
        </th>
         <th>
          Bölüm
        </th>
        <th> 
          Ders Adı
        </th>
        <th> 
          Ders Kodu
        </th>
        <th> 
          Kredi
        </th>
        <th> 
          TUL
        </th>
        <th> 
          AKTS
        </th>


         <th>
          Fakülte
        </th>
         <th>
          Bölüm
        </th>
        <th> 
          Ders
        </th>
        <th>Sonuç</th>
        <th>Red Sebebi</th>
       
        




      </tr>
    </thead>
   
    <tbody >
    <?php 

      while($bcek=$bsor->fetch(PDO::FETCH_ASSOC)) {?>
      <tr>

        <td bgcolor="#DDDDDD" data-title='Önerilen Üniversite'>
          <?php
$kunisor=$db->prepare("SELECT * FROM universite  where universite_id=:universite_id ");
    $kunisor->execute(array( 'universite_id' => $bcek['ders_kuniversite'] )); 
    $kunicek=$kunisor->fetch(PDO::FETCH_ASSOC);
    echo $kunicek['name'];

          ?>

          
        
        </td>
        <td bgcolor="#DDDDDD" data-title='Önerilen Fakülte'>
           <?php
$kfakultesor=$db->prepare("SELECT * FROM universite_fakulte  where fakulte_id=:fakulte_id ");
    $kfakultesor->execute(array( 'fakulte_id' => $bcek['ders_kfakulte'] )); 
    $kfakultecek=$kfakultesor->fetch(PDO::FETCH_ASSOC);
    echo $kfakultecek['name'];

          ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Önerilen Bölüm'>
                    <?php
$kbolumsor=$db->prepare("SELECT * FROM universite_bolum  where bolum_id=:bolum_id ");
    $kbolumsor->execute(array( 'bolum_id' => $bcek['ders_kbolum'] )); 
    $kbolumcek=$kbolumsor->fetch(PDO::FETCH_ASSOC);
    echo $kbolumcek['name'];

          ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Önerilen Ders Adı'>
          <?php echo $bcek['ders_ad']; ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Önerilen Ders Kodu'>
           <?php echo $bcek['ders_kkodu']; ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Önerilen Ders Kredi'>
           <?php echo $bcek['ders_kkredi']; ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Önerilen Ders TUL'>
           <?php echo $bcek['ders_ktul']; ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Önerilen Ders AKTS'>
           <?php echo $bcek['ders_kakts']; ?>
        </td>
          <td bgcolor="#DDDDDD" data-title='Eşleştirilen Fakülte'>
                    <?php
   
$bfakultesor=$db->prepare("SELECT * FROM fakulteler  where id=:id ");
    $bfakultesor->execute(array( 'id' => $bcek['ders_bfakulte'] )); 
    $bfakultecek=$bfakultesor->fetch(PDO::FETCH_ASSOC);
    echo $bfakultecek['fakulte_ad'];


          ?>
        </td>
         <td bgcolor="#DDDDDD" data-title='Eşleştirilen Bölüm'>
                    <?php
$bbolumsor=$db->prepare("SELECT * FROM bolumler  where id=:id ");
    $bbolumsor->execute(array( 'id' => $bcek['ders_bbolum'] )); 
    $bbolumcek=$bbolumsor->fetch(PDO::FETCH_ASSOC);
    echo $bbolumcek['bolum_ad'];

          ?>
        </td>
         <td bgcolor="#DDDDDD" data-title='Eşleştirilen Ders'>
                    <?php
$bderssor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $bderssor->execute(array( 'id' => $bcek['ders_bders'] )); 
    $bderscek=$bderssor->fetch(PDO::FETCH_ASSOC);
    echo $bderscek['ders_ad'];

          ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Sonuç' >
          <?php
             if ($bcek['oneri_sonuc']==0) {
             ?>
           <font color="black">Sonuçlandırılmadı</font> 
           <?php
          }

          if ($bcek['oneri_sonuc']==1) {
             ?>
           <font color="#052FAF" style="font-weight: bold;">Onaylandı</font> 
           <?php
          }

          if ($bcek['oneri_sonuc']==2) {
            ?>
           <font color="red" style="font-weight: bold;">Red Edildi</font> 
           <?php
          }
          ?>

        </td>



         <td bgcolor="#DDDDDD" data-title='Red Sebebi'>
          <center>
            <?php
             if ($bcek['oneri_sonuc']==0) {
              ?>
           <font color="black">Sonuçlandırılmadı</font> 
           <?php
          }

           if ($bcek['oneri_sonuc']==1 ) {

            ?>
           <font color="black">---</font> 
           <?php

          } 
             if ($bcek['oneri_sonuc']==2 ) {
             ?>
           <font color="black"><?php echo $bcek['oneri_red_sebep']; ?></font> 
           <?php
          } 


          ?>
         </center>
        </td>
        


        
      </tr>

      <?php } ?>



    </tbody>
  </table>

<br>  
        

<br>




</div>

    <?php
  }

 ?>



<?php
}


else
{
?>
<div class="col-md-12" ><h5> <font color="red">Yapılmış Ders Öneriniz Bulunmamaktadır.</font> </h5><hr></div>
<br> <font color="black">Ders önermek istiyorsanız </font> 
<a href="ders_oner.php"> <font size="3" color="red"><u>buraya</u> </font> </a> <font color="black"> tıklayınız. </font>
</center>



<?php
}
include "footer.php";


 ?>
</body>
</html>