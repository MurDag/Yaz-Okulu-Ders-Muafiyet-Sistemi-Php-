<?php 

include 'header.php'; 

$_SESSION['drs-duzenle']=$_GET['ders_id'];
$derssor=$db->prepare("SELECT * FROM dersler where id=:id");
$derssor->execute(array(
  'id' => $_GET['ders_id']
  ));

$derscek=$derssor->fetch(PDO::FETCH_ASSOC);

$bolumsor=$db->prepare("SELECT * FROM bolumler");
$bolumsor->execute();

?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Ders Düzenleme <small>,

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

            <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

          


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders Kodu <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="" id="first-name" name="ders_kodu"  value="<?php echo $derscek['ders_kodu'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders Ad <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="" id="first-name" name="ders_ad"  value="<?php echo $derscek['ders_ad'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

            

             

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">TUL <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="ders_tul" value="<?php echo $derscek['ders_tul'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">AKTS <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="ders_akts" value="<?php echo $derscek['ders_akts'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kredi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="ders_kredi"  value="<?php echo $derscek['ders_kredi'] ?>"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders Türü<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <select id="heard" class="form-control" name="ders_turu" required>

                  <option value="Zorunlu" <?php echo $derscek['ders_turu'] == 'Zorunlu' ? 'selected=""' : ''; ?>>Zorunlu</option>
                  <option value="Seçmeli" <?php if ($derscek['ders_turu']=='Seçmeli') { echo 'selected=""'; } ?>>Seçmeli</option>
                 </select>
               </div>
             </div>

             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders Yılı<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <select id="heard" class="form-control" name="ders_yil" required>

                  <option value="1" <?php if ($derscek['ders_yil']==1) { echo 'selected=""'; } ?>>1.Sınıf</option>
                  <option value="2" <?php if ($derscek['ders_yil']==2) { echo 'selected=""'; } ?>>2.Sınıf</option>
                  <option value="3" <?php if ($derscek['ders_yil']==3) { echo 'selected=""'; } ?>>3.Sınıf</option>
                  <option value="4" <?php if ($derscek['ders_yil']==4) { echo 'selected=""'; } ?>>4.Sınıf</option>
                 </select>
               </div>
             </div>

             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders Dönem<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <select id="heard" class="form-control" name="ders_donem" required>

                  <option value="1" <?php if ($derscek['ders_donem']==1) { echo 'selected=""'; } ?>>1.Dönem</option>
                  <option value="2" <?php if ($derscek['ders_donem']==2) { echo 'selected=""'; } ?>>2.Dönem</option>
                 </select>
               </div>
             </div>




             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ders Bölüm<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <select id="heard" class="form-control" name="ders_bolum" required>



                   <?php  while($bolumcek=$bolumsor->fetch(PDO::FETCH_ASSOC)) {?>

                 

                   <option value="<?php echo $derscek['ders_bolum']; ?>" <?php if ($derscek['ders_bolum']==$bolumcek['id']) { echo 'selected=""'; } ?>><?php echo $bolumcek['bolum_ad']; ?></option>
                    
                    <?php } ?>
                 </select>
               </div>
             </div>



             <input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id'] ?>"> 


             <div class="ln_solid"></div>
             <div class="form-group">
              <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="drs-duzenle" class="btn btn-success">Güncelle</button>
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
<!-- /page content -->

<?php include 'footer.php'; ?>
