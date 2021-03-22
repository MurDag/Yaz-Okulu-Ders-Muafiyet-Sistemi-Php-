<?php
error_reporting(0);
include "header.php";
include "../nedmin/netting/baglan.php";
$_SESSION['a']=1;


	     $yg_id=$_GET['basvuruguncelle_id'];
    $ygsor=$db->prepare("SELECT * FROM yazokulu_basvuru  where id=:id ");
    $ygsor->execute(array( 
    	'id' => $yg_id
     ));

     $ygcek=$ygsor->fetch(PDO::FETCH_ASSOC);




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


 $yobsor=$db->prepare("SELECT * FROM yazokulu_basvuru  where id=:id ");
    $yobsor->execute(array( 
    	'id' => $yg_id
     ));

 $yobcek=$yobsor->fetch(PDO::FETCH_ASSOC);
$ilkuni_id=$yobcek['k_universite'];
$ilkf_id=$yobcek['k_fakulte'];
$ilkb_id=$yobcek['k_bolum'];
$drs_id=$yobcek['b_ders_ad'];


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

if ($_GET['y_basvuru_durum']=="i_g") {
  
  echo '      <div id="dv1" class="alert alert-danger" role="alert"><font color="black"><strong>

       Bu kaydı daha önce sonuçlandığı için güncelleyemezsiniz !</strong></font>
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
<input type="hidden" name="y_okul_basvur_guncelle_id" value="<?php echo  $yg_id; ?>" >
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
                <option 
                <?php if ($ygcek['b_ders_ad']==$blm_derscek['id']) {?> selected <?php } ?>
                value="<?php echo $blm_derscek['id']; ?>"><?php echo $blm_derscek['ders_ad']; ?></option>
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
            

            <select name="universiteler" id="universiteler" class="form-control">
            	 <option value="0">Üniversite Seçiniz.</option>

            	                <?php if(isset($_GET['basvuruguncelle_id'])){

                $obsor=$db->prepare("SELECT * from yazokulu_onayli_dersler where b_ders_ad=:b_ders_ad");
     			 $obsor->execute(array( 'b_ders_ad'=>$drs_id ));
    			  while ($obcek=$obsor->fetch(PDO::FETCH_ASSOC)) {

    			  	 $yunisor=$db->prepare("SELECT * from universite where universite_id=:universite_id");
     			 $yunisor->execute(array( 'universite_id'=>$obcek['k_universite']));
     			 $yunicek=$yunisor->fetch(PDO::FETCH_ASSOC);

 				?>
				<option <?php if ($ilkuni_id==$yunicek['universite_id']) {?> selected <?php }?> value="<?php echo $yunicek['universite_id']; ?>">
					<?php echo $yunicek['name']; ?></option>
				<?php }} ?>


            </select>
        </div>

        <div class="col-md-4">
            <label for="fakulteler">Fakülte</label>
            <select name="fakulteler" id="fakulteler" class="form-control">
            	<option value="0">Fakülte Seçiniz.</option>
            	    <?php if(isset($_GET['basvuruguncelle_id'])){

                $obsor=$db->prepare("SELECT * from yazokulu_onayli_dersler where b_ders_ad=:b_ders_ad and k_universite=:k_universite");
     			 $obsor->execute(array( 
     			 	'b_ders_ad'=>$drs_id,
     			 	'k_universite'=>$ilkuni_id

     			  ));
    			  while ($obcek=$obsor->fetch(PDO::FETCH_ASSOC)) {

    			  	 $yunisor=$db->prepare("SELECT * from universite_fakulte where fakulte_id=:fakulte_id");
     			 $yunisor->execute(array( 
     			 	'fakulte_id'=>$obcek['k_fakulte']

     			));
     			 $yunicek=$yunisor->fetch(PDO::FETCH_ASSOC);

 				?>
				<option <?php if ($ilkf_id==$yunicek['fakulte_id']) {?> selected <?php }?> value="<?php echo $yunicek['fakulte_id']; ?>">
					<?php echo $yunicek['name']; ?></option>
				<?php }} ?>
            	 


            	
              
            </select>
        </div>

        <div class="col-md-4">
            <label for="bolum">Bölümler</label>
            <select name="bolumler" id="bolumler" class="form-control">
            	<option value="0">Bölüm Seçiniz.</option>

            	            	    <?php if(isset($_GET['basvuruguncelle_id'])){

                $obsor=$db->prepare("SELECT * from yazokulu_onayli_dersler where b_ders_ad=:b_ders_ad and k_universite=:k_universite and k_fakulte=:k_fakulte");
     			 $obsor->execute(array( 
     			 	'b_ders_ad'=>$drs_id,
     			 	'k_universite'=>$ilkuni_id,
     			 	'k_fakulte'=>$ilkf_id

     			  ));
    			  while ($obcek=$obsor->fetch(PDO::FETCH_ASSOC)) {

    			  	 $yunisor=$db->prepare("SELECT * from universite_bolum where bolum_id=:bolum_id");
     			 $yunisor->execute(array( 
     			 	'bolum_id'=>$obcek['k_bolum']

     			));
     			 $yunicek=$yunisor->fetch(PDO::FETCH_ASSOC);

 				?>
				<option <?php if ($ilkb_id==$yunicek['bolum_id']) {?> selected <?php }?> value="<?php echo $yunicek['bolum_id']; ?>">
					<?php echo $yunicek['name']; ?></option>
				<?php }} ?>

               
            </select>
        </div>

    </div>
</div>


   	        <br>

    <br>
 <input type="submit" id="y_okul_basvur_guncelle" onclick="kontrol_click();" name="y_okul_basvur_guncelle" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" value="Gönder"/>
</form>







</center>



<?php

include "footer.php";


 ?>
</body>
</html>