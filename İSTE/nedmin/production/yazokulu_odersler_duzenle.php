 <?php 
include 'header.php'; 


$onayli_derssor=$db->prepare("SELECT * FROM yazokulu_onayli_dersler where id=:id");
$onayli_derssor->execute(array(
  'id' => $_GET['yo_ders_düzenle']
  ));
$onayli_derscek=$onayli_derssor->fetch(PDO::FETCH_ASSOC);







?>

<!-- page content -->
<!DOCTYPE html>
<html>
<head>

<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>

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

			$('#bfakulteler').change(function(){
				
				$('#bbolumler').empty();
				var deger=$(this).val();
				$("#bbolumler").attr("disabled", false);
				$("#bdersler").attr("disabled", true);
				$('#bdersler').empty();
				 $('#bdersler').append( new Option("Bir Bölüm Seçiniz",0) );
				 $('#bbolumler').empty();
				$.post("post.php",{bfakulteler:deger},function(a){
					$('#bbolumler').append(a);
				});

			});

		});

	</script>

	<script>
		
		$(document).ready(function(){

			$('#bbolumler').change(function(){
				
				
				var deger=$(this).val();
				$("#bdersler").attr("disabled", false);
			
				

				 $('#bdersler').append( new Option("Bir Ders Seçiniz",0));
				 $('#bdersler').empty();
				$.post("post.php",{bbolumler:deger},function(a){
					$('#bdersler').append(a);
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
			var deger4 = $('#bfakulteler').val();
			var deger5 = $('#bolumler').val();
			var deger6 = $('#bdersler').val();

			
     
			if (deger1==0) 
			{
				alert("Lütfen Dersin Üniversitesini Seçiniz !");
				event.preventDefault();

			}
			else if (deger2==0) 
			{
				alert("Lütfen Dersin Fakültesini Seçiniz !");
				event.preventDefault();
			}
			else if (deger3==0) 
			{
				alert("Lütfen Dersin Bölümünü Seçiniz !");
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



</head>
<body>
	<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Kullanıcı Düzenleme <small>,

              <?php 

              if ($_GET['durum']=="ok") {?>

              <b style="color:green;">İşlem Başarılı...</b>

              <?php } elseif ($_GET['durum']=="no") {?>

              <b style="color:red;">İşlem Başarısız...</b>

              <?php }

              ?>


            </small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <?php 

            $zaman=explode(" ",$onayli_derscek['kayit_tarih']);

             ?>

            <form enctype="multipart/form-data" action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

            	 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Üniversite</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select name="universiteler" id="universiteler" class="form-control">
                            <option value="0">Bir Üniversite Seçiniz</option>
                            <?php 

							$unisor=$db->prepare("SELECT * FROM universite");
							$unisor->execute(array());
							

							while ($unicek=$unisor->fetch(PDO::FETCH_ASSOC)) { ?>

								<option 
								<?php if ($onayli_derscek['k_universite']==$unicek['universite_id']) {?> selected <?php }?> 
								 value="<?php echo $unicek['universite_id']; ?>" ><?php echo $unicek['name']; ?></option>

							<?php } ?>
                          </select>
                        </div>
                      </div>

            	 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fakülte</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select id="fakulteler" name="fakulteler" class="form-control">
                            <option value="0">Bir Fakülte Seçiniz</option>
                             <?php 

							$fakultesor=$db->prepare("SELECT * FROM universite_fakulte where universite_id=:universite_id");
							$fakultesor->execute(array(
								'universite_id'=>$onayli_derscek['k_universite']
							));
							

							while ($fakultecek=$fakultesor->fetch(PDO::FETCH_ASSOC)) { ?>

								<option
								<?php if ($onayli_derscek['k_fakulte']==$fakultecek['fakulte_id']) {?> selected <?php }?> 
								 value="<?php echo $fakultecek['fakulte_id']; ?>" ><?php echo $fakultecek['name']; ?></option>

							<?php } ?>

                          </select>
                        </div>
                      </div>

            	 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bölüm</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select name="bolumler" id="bolumler" class="form-control">
                            <option value="0">Bir Bölüm Seçiniz</option>
                              <?php 

							$bolumsor=$db->prepare("SELECT * FROM universite_bolum where fakulte_id=:fakulte_id");
							$bolumsor->execute(array(
								'fakulte_id'=>$onayli_derscek['k_fakulte']
							));
							

							while ($bolumcek=$bolumsor->fetch(PDO::FETCH_ASSOC)) { ?>

								<option
								<?php if ($onayli_derscek['k_bolum']==$bolumcek['bolum_id']) {?> selected <?php }?> 
								 value="<?php echo $bolumcek['bolum_id']; ?>" ><?php echo $bolumcek['name']; ?></option>

							<?php } ?>

                          </select>
                        </div>
                      </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kayıt Tarihi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="" id="first-name" name="kullanici_tc" disabled="" value="<?php echo $zaman[0]; ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kayıt Saati <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="time" id="first-name" name="kullanici_tc" disabled="" value="<?php echo $zaman[1]; ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

             

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders Ad <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="ders_ad" value="<?php echo $onayli_derscek['k_ders_ad'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders Kodu <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="ders_kodu" value="<?php echo $onayli_derscek['k_ders_kodu'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kredi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="ders_kredi"  value="<?php echo $onayli_derscek['k_ders_kredi'] ?>"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">TUL <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="ders_tul"value="<?php echo $onayli_derscek['k_ders_tul'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">AKTS <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="ders_akts"  value="<?php echo $onayli_derscek['k_ders_akts'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders İçerik <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" id="first-name" name="dosya"  value="<?php echo $onayli_derscek['k_ders_akts'] ?>" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders link <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="ders_link"  value="<?php echo $onayli_derscek['k_ders_link'] ?>" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <center>
              	<font size="3">Eşleştirilen Ders Bilgileri</font>
              </center>
                          	 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fakülteler</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select name="bfakulteler" id="bfakulteler" class="form-control">
                            <option value="0">Bir Fakülte Seçiniz</option>
                            <?php 

							$bfsor=$db->prepare("SELECT * FROM fakulteler");
							$bfsor->execute(array());
							

							while ($bfcek=$bfsor->fetch(PDO::FETCH_ASSOC)) { ?>

								<option 
								<?php if ($onayli_derscek['b_fakulte']==$bfcek['id']) {?> selected <?php }?> 
								 value="<?php echo $bfcek['id']; ?>" ><?php echo $bfcek['fakulte_ad']; ?></option>

							<?php } ?>
                          </select>
                        </div>
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bölümler</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select name="bbolumler" id="bbolumler" class="form-control">
                            <option value="0">Bir Bölüm Seçiniz</option>
                            <?php 

							$bbolumsor=$db->prepare("SELECT * FROM bolumler where fakulte_yid=:fakulte_yid");
							$bbolumsor->execute(array(
								'fakulte_yid'=>$onayli_derscek['b_fakulte']
							));
							

							while ($bbolumcek=$bbolumsor->fetch(PDO::FETCH_ASSOC)) { ?>

								<option 
								<?php if ($onayli_derscek['b_bolum']==$bbolumcek['id']) {?> selected <?php }?> 
								 value="<?php echo $bbolumcek['id']; ?>" ><?php echo $bbolumcek['bolum_ad']; ?></option>

							<?php } ?>
                          </select>
                        </div>
                      </div>


                                  	 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dersler</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select name="bdersler" id="bdersler" class="form-control">
                            <option value="0">Bir Ders Seçiniz</option>
                            <?php 

							$bderssor=$db->prepare("SELECT * FROM dersler where ders_bolum=:ders_bolum");
							$bderssor->execute(array(
								'ders_bolum'=>$onayli_derscek['b_bolum']
							));
							

							while ($bderscek=$bderssor->fetch(PDO::FETCH_ASSOC)) { ?>

								<option 
								<?php if ($onayli_derscek['b_ders_ad']==$bderscek['id']) {?> selected <?php }?> 
								 value="<?php echo $bderscek['id']; ?>" ><?php echo $bderscek['ders_ad']; ?></option>

							<?php } ?>
                          </select>
                        </div>
                      </div>




              




             <input type="hidden" name="y_ders_duzenle_id" value="<?php echo $_GET['yo_ders_düzenle'] ?>"> 


             <div class="ln_solid"></div>
             <div class="form-group">
              <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="onayli_yazokuluders_duzenle" class="btn btn-success">Güncelle</button>
              </div>
            </div>

          </form>



        </div>
      </div>
    </div>
  </div>



  <hr>
  <hr>
  <hr>



</div>
</div>

</body>
</html>
<!-- /page content -->

<?php include 'footer.php'; ?>
