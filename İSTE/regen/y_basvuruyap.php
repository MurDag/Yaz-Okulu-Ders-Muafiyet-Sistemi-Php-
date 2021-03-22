<?php
error_reporting(0);
 session_start();
include "../nedmin/netting/baglan.php";

 $y_ayarsor=$db->prepare("SELECT * from y_ayar");
  $y_ayarsor->execute(array());
 $y_ayarcek=$y_ayarsor->fetch(PDO::FETCH_ASSOC);
$max_kredi=0;
$max_ders=0;
$max_uni=0;


 date_default_timezone_set('Etc/GMT-3');
				$yil=date("Y");
     $id=$_SESSION['kullanici_idno'];
   $y_izin=$db->prepare("SELECT distinct k_universite FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil and basvuru_sonuc=:basvuru_sonuc");
     $y_izin->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil,
      'basvuru_sonuc' => 1
      ));

     while ($y_izincek=$y_izin->fetch(PDO::FETCH_ASSOC)) {
     	$max_uni++;
     	
     }


     $y_izinsor=$db->prepare("SELECT distinct k_universite FROM yazokulu_basvuru  where basvuru_kul_id=:basvuru_kul_id and basvuru_yil=:basvuru_yil and basvuru_sonuc=:basvuru_sonuc");
     $y_izinsor->execute(array( 
      'basvuru_kul_id' => $kid,
      'basvuru_yil' => $yil,
      'basvuru_sonuc' => 1
      ));

     while ($y_izincek=$y_izinsor->fetch(PDO::FETCH_ASSOC)) {
     		
     $kredisor=$db->prepare("SELECT * FROM dersler  where id=:id ");
    $kredisor->execute(array( 'id' => $y_izincek['b_ders_ad'] )); 
    $kredicek=$kredisor->fetch(PDO::FETCH_ASSOC);	


     	$max_ders++;
     	$max_kredi=$max_kredi+$kredicek['ders_kredi'];

     	
     }

    


    if ($max_ders>=$y_ayarcek['max_ders'] && $max_unisayi>=$$y_ayarcek['max_universite'] && $max_kredi>=$$y_ayarcek['max_kredi']) {
    	header("Location:y_basvurular");
    }


include "header.php";
$_SESSION['a']=1;


     $id=$_SESSION['kullanici_idno'];
    $o_blmsor=$db->prepare("SELECT * FROM ogrenci  where id=:id ");
    $o_blmsor->execute(array( 
    	'id' => $id
     ));

     $o_blmcek=$o_blmsor->fetch(PDO::FETCH_ASSOC);


    $blm_derssor=$db->prepare("SELECT * FROM dersler  where ders_bolum=:ders_bolum ");
    $blm_derssor->execute(array( 
    	'ders_bolum' => $o_blmcek['kullanici_bolum_id']
     ));






 $unisor=$db->prepare("SELECT * from universite");
      $unisor->execute(array());

       $bfakultesor=$db->prepare("SELECT * from fakulteler");
      $bfakultesor->execute(array());


       $id=$_SESSION['kullanici_idno'];
    $bsor=$db->prepare("SELECT * FROM onerilen_dersler  where onerenkisi_id=:onerenkisi_id  and oneri_sonuc=:oneri_sonuc");
    $bsor->execute(array( 
    	'onerenkisi_id' => $id,
    	'oneri_sonuc' => 0,

     )); 
$bsayi=$bsor->rowCount();

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>




	<script>
		
		$(document).ready(function(){

			$('#dersler').change(function(){

				$('#universiteler').empty();
				var deger=$(this).val();
				$("#universiteler").attr("disabled", false);
				$("#fakulteler").attr("disabled", true);
				$("#bolumler").attr("disabled", true);
				$('#bolumler').empty();
				$('#fakulteler').empty();

				 $('#fakulteler').append( new Option("Fakülte Seçiniz",0) );
				 $('#bolumler').append( new Option("Bölüm Seçiniz",0) );

				$.post("post_yazokulu.php",{ders:deger},function(a){
					$('#universiteler').append(a);
				});

			});

		});

	</script>

		<script>
		
		$(document).ready(function(){

			$('#universiteler').change(function(){
				$('#fakulteler').empty();
				var deger=$(this).val();
				$("#fakulteler").attr("disabled", false);
				$("#bolumler").attr("disabled", true);
				$('#fakulteler').empty();
				$('#bolumler').append( new Option("Bölüm Seçiniz",0) );


				$.post("post_yazokulu.php",{universite:deger},function(a){
					$('#fakulteler').append(a);
				});

			});

		});

	</script>

			<script>
		
		$(document).ready(function(){

			$('#fakulteler').change(function(){
				$('#bolumler').empty();
				var deger=$(this).val();
				$("#bolumler").attr("disabled", false);

				$.post("post_yazokulu.php",{fakulteler:deger},function(a){
					$('#bolumler').append(a);
				});

			});

		});

	</script>






	<script>
		
		$(document).ready(function(){

			$('#drs').change(function(){
				
				var deger=$(this).val();
				
				$.post("post.php",{bdersid:deger},function(a){
					
				});

			});

		});

	</script>

		<script>
		
		$(document).ready(function(){

			$('#bolumler').change(function(){
				
				var deger=$(this).val();
				
				$.post("post.php",{kbolumid:deger},function(a){
					
				});

			});

		});

	</script>






	<script type="text/javascript">
		
		function kontrol_click()
		{			
			var deger1 = $('#dersler').val();	
			var deger2 = $('#universiteler').val();
			var deger3 = $('#fakulteler').val();
			var deger4 = $('#bolumler').val();
			

			
     
			if (deger1==0) 
			{
				alert("Lütfen Almak İstediğiniz Dersi Seçiniz !");
				event.preventDefault();

			}
			else if (deger2==0) 
			{
				alert("Lütfen Eşleştirmek İstediğiniz Üniversiteyi Seçiniz !");
				event.preventDefault();
			}
			else if (deger3==0) 
			{
				alert("Lütfen Eşleştirmek İstediğiniz Fakülteyi Seçiniz !");
				event.preventDefault();
			}
			else if (deger4==0) 
			{
				alert("Lütfen Eşleştirmek İstediğiniz Bölümü Seçiniz !");
				event.preventDefault();
			}
		
		
		}

	</script>


    <script type="text/javascript">
        function kapat() {
        //    setTimeout("document.getElementById('dv1').style.visibility = 'hidden'", 5000);

               
          

          setTimeout(function() { $("#dv1").slideUp("slow"); },2000); 
         
         
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

if ($_GET['oneri_durum']=="error") {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Ders öneri kaydınız yapılırken bir hata oluştu ! / Lütfen ilgili birime durumu bildiriniz.</strong></font>
              </div>';

              

}


if ($_GET['oneri_durum']=="yanlisderslinki") {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Yanlış Ders Linki Girdiniz ! / Lütfen edu.tr uzantılı bir adres giriniz.</strong></font>
              </div>';

              

}


if ($_GET['oneri_durum']=="yanlisformat") {
  
   echo '      <div id="dv1" class="alert alert-success" role="alert"><font color="black"><strong>
       Lütfen .pdf formatında bir dosya yükleyiniz !</strong></font>
       
      </div>';
      echo '<br>';
}

$kid=$_SESSION['kullanici_idno'];

				      date_default_timezone_set('Etc/GMT-3');
				$yil=date("Y");



?>

						
						




		<br>

<form id="form1" name="form1" action="../nedmin/netting/islem.php" method="POST" enctype="multipart/form-data">

<div class="container" align="center">
    <div class="row">
        <div class="col-md-12"><h1> <font color="black">Yaz Okulu Başvurusu Eklemek İçin Lütfen Bu Formu Doldurunuz</font></h1><hr></div>

 		

         		<div class="col-md-4">

        </div>




        <div class="col-md-4">
            <label for="bolge">Almak İstediğiniz Ders</label>
            

            <select name="dersler" id="dersler" class="form-control">
            	 <option value="0">Bir Ders Seçiniz</option>
            	<?php while ($blm_derscek=$blm_derssor->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $blm_derscek['id']; ?>"><?php echo $blm_derscek['ders_ad']; ?></option>
            <?php } ?>
            </select>
        </div>
 		<div class="col-md-4">

        </div>
        

       
    </div>
</div>

<br>		
<div class="container" align="center">
    <div class="row">
        <div class="col-md-12"><h1> <font color="black">Eşleştirmek İstediğiniz Ders Bilgileri</font></h1><hr></div>
			
			        <div class="col-md-4">
            <label for="bolge">Üniversite</label>
            

            <select name="universiteler" id="universiteler" class="form-control" disabled="disabled">
            	 <option value="0">Üniversite Seçiniz.</option>
            	<?php while ($unicek=$unisor->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $unicek['universite_id']; ?>"><?php echo $unicek['name']; ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="fakulteler">Fakülte</label>
            <select name="fakulteler" id="fakulteler" class="form-control" disabled="disabled">
            	<option value="0">Fakülte Seçiniz.</option>
            	
              
            </select>
        </div>

        <div class="col-md-4">
            <label for="bolum">Bölümler</label>
            <select name="bolumler" id="bolumler" class="form-control" disabled="disabled">
            	<option value="0">Bölüm Seçiniz.</option>

               
            </select>
        </div>

    </div>
</div>


   	        <br>

    <br>
 <input type="submit" id="y_okul_basvur" onclick="kontrol_click();" name="y_okul_basvur_ekle" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" value="Gönder"/>
</form>

 





</center>



<?php

include "footer.php";


 ?>
</body>
</html>