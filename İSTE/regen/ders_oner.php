<?php
error_reporting(0);
include "header.php";
include "../nedmin/netting/baglan.php";
$_SESSION['a']=1;

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

			$('#universiteler').change(function(){
				
				$('#fakulteler').empty();
				var deger=$(this).val();
				$("#fakulteler").attr("disabled", false);
				$("#bolumler").attr("disabled", true);
				$('#bolumler').empty();
				 $('#bolumler').append( new Option("Bölüm Seçiniz",0) );

				$.post("post.php",{universite:deger},function(a){
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

				$.post("post.php",{fakulteler:deger},function(a){
					$('#bolumler').append(a);
				});

			});

		});

	</script>

			<script>
		
		$(document).ready(function(){

			$('#bf').change(function(){
				$('#blm').empty();
				var deger=$(this).val();
				$("#blm").attr("disabled", false);

				$("#drs").attr("disabled", true);
				$('#drs').empty();
				 $('#drs').append( new Option("Ders Seçiniz",0) );

				$.post("post.php",{bfakulteid:deger},function(a){
					$('#blm').append(a);
				});

			});

		});

	</script>

				<script>
		
		$(document).ready(function(){

			$('#blm').change(function(){
				$('#drs').empty();
				var deger=$(this).val();
				$("#drs").attr("disabled", false);
				$.post("post.php",{bolumid:deger},function(a){
					$('#drs').append(a);
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
			var deger1 = $('#universiteler').val();
			var deger2 = $('#fakulteler').val();
			var deger3 = $('#bolumler').val();
			var deger4 = $('#bf').val();
			var deger5 = $('#blm').val();
			var deger6 = $('#drs').val();

			
     
			if (deger1==0) 
			{
				alert("Lütfen Önerdiğiniz Dersin Üniversitesini Seçiniz !");
				event.preventDefault();

			}
			else if (deger2==0) 
			{
				alert("Lütfen Önerdiğiniz Dersin Fakültesini Seçiniz !");
				event.preventDefault();
			}
			else if (deger3==0) 
			{
				alert("Lütfen Önerdiğiniz Dersin Bölümünü Seçiniz !");
				event.preventDefault();
			}
			else if (deger4==0) 
			{
				alert("Lütfen eşleştirmek istediğiniz dersin üniversitemizdeki fakültesini seçiniz !");
				event.preventDefault();
			}
			else if (deger5==0) 
			{
				alert("Lütfen eşleştirmek istediğiniz dersin üniversitemizdeki bölümünü seçiniz !");
				event.preventDefault();
			}
			else if (deger6==0) 
			{
				alert("Lütfen eşleştirmek istediğiniz dersin üniversitemizdeki adını seçiniz !");
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

       Yanlış Ders Linki Girdiniz ! / Lütfen https ve edu.tr uzantılı bir adres giriniz.</strong></font>
              </div>';

              

}


if ($_GET['oneri_durum']=="yanlisformat") {
  
   echo '      <div id="dv1" class="alert alert-success" role="alert"><font color="black"><strong>
       Lütfen .pdf formatında bir dosya yükleyiniz !</strong></font>
       
      </div>';
      echo '<br>';
}





?>

<form id="form1" name="form1" action="../nedmin/netting/islem.php" method="POST" enctype="multipart/form-data">

<div class="container" align="center">
    <div class="row">
        <div class="col-md-12"><h1> <font color="black">Ders Önermek İçin Lütfen Bu Formu Doldurunuz</font></h1><hr></div>

        <div class="col-md-4">
            <label for="bolge">Üniversite</label>
            

            <select name="universiteler" id="universiteler" class="form-control">
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


			<div class="col-md-3">
								<font color="black" >   Lütfen ders adını giriniz.    </font><br>
				<div class="input-group" align="center"> 

              <input style="text-align: center;" align="middle" name="o_dersadi" type="text" class="form-control pl-0 border-center-0 form-pill" placeholder="Ders Adı" required="true">
            </div></div>
            <br>
 <div class="col-md-4">
            <table>
            <thead>
              <tr>
                <th>
                  Ders Kodu
                </th>
                <th >
                  Kredi
                </th>
                <th >
                  TUL
                </th>
                <th >
                  AKTS
                </th>
              </tr>
              </thead> 
            	<tr>
            		<td data-title='Ders Kodu'>
            				<div class="input-group" align="center"> 

              <input style="text-align: center;" align="middle" name="o_derskodu" type="text" class="form-control pl-0 border-center-0 form-pill" placeholder="Ders Kodu" required="true">
            </div>
         
            		</td>

            		<td data-title='Kredi'>
            				<div class="input-group" align="center"> 

              <input style="text-align: center;" align="middle" name="o_derskredi" type="number" class="form-control pl-0 border-center-0 form-pill" placeholder="Kredi" required="true">
            </div>
         
            		</td>
            		<td data-title='TUL'>
            			   <div class="input-group" align="center"> 

              <input style="text-align: center;" align="middle" name="o_derstul" type="text" class="form-control pl-0 border-center-0 form-pill" placeholder="TUL" required="true">
            </div>
            
            		</td>
            		<td data-title='AKTS'>
            			<div class="input-group" align="center"> 

              <input style="text-align: center;" align="middle" name="o_dersakts" type="number" class="form-control pl-0 border-center-0 form-pill" placeholder="AKTS" required="true">
            </div>
            		</td>
            	</tr>
            </table>
        </div>
           <div class="col-md-3">
            	
            
				
				
		<br>
				<font color="black" >   Lütfen https ve edu.tr uzantılı resmi ders linkini giriniz.
				     </font> <br> (Örnek: https://iste.edu.tr)<br>
            <div class="input-group"> 

              <input style="text-align: center;" type="text" id="o_derslink" name="o_derslink" class="form-control pl-0 border-center-0 form-pill" placeholder="Resmi Ders Linki" required="true">
            </div>

<br>
<table>
					<tr>
						<td>
							<font color="black" >   Lütfen ders içeriğini .pdf formatında yükleyiniz.    </font>
						</td>
					</tr>
					<tr>
						<td bgcolor="	#E53935">
							<div style="color: black;"> 

  						<input color="red" type="FILE" name="dosya" required="true"> </div>
						</td>

					</tr>	


				</table>
		
   	        </div>
   	        <br>



   	        <div class="container" align="center">
    <div class="row">
        <div class="col-md-12" ><h3> <font color="black">Bölümünüzdeki Eşleştirmek İstediğiniz Dersi Seçiniz</font> </h3><hr></div>
        <div class="col-md-4">

        </div>


        <div class="col-md-4">
            <label for="bolum">Dersler</label>
            <select name="drs" id="drs" class="form-control">
            	<option value="0">Ders Seçiniz.</option>
            	        <?php 

          $kid=$_SESSION['kullanici_idno'];
    $kbilgisor=$db->prepare("SELECT * FROM ogrenci WHERE id=:id  ");
  $kbilgisor->execute(array(
    'id' => $kid
    ));


  $kbilgicek=$kbilgisor->fetch(PDO::FETCH_ASSOC);

 $drssor=$db->prepare("SELECT * FROM dersler WHERE ders_bolum=:ders_bolum  ");
  $drssor->execute(array(
    'ders_bolum' => $kbilgicek['kullanici_bolum_id']
    ));

  while ($drscek=$drssor->fetch(PDO::FETCH_ASSOC)) { ?>
  	<option value="<?php echo $drscek['id']; ?>"><?php echo $drscek['ders_ad']; ?></option>
  <?php } ?>
               
            </select>
        </div>


        <div class="col-md-4">

        </div>

    </div>
</div>
    <br>
 <input type="submit" id="d_oner" onclick="kontrol_click();" name="ders_oner" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" value="Gönder"/>
</form>







</center>



<?php

include "footer.php";


 ?>
</body>
</html>