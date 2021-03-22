<?php 

include 'header.php'; 
$k_redsebepsor=$db->prepare("SELECT * FROM klasik_red_sebepleri where id=:id");
  $k_redsebepsor->execute(array(
    'id' => $_GET['id']
    ));
$k_redsebepcek=$k_redsebepsor->fetch(PDO::FETCH_ASSOC);


?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Red Sebebi Ekle <small>


            </small></h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

            <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
            <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

          

            


             

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Red Sebebi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="textarea" id="first-name" name="red_sebep" value="<?php echo $k_redsebepcek['red_sebebi']; ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>


               </div>
             </div>


             <input type="hidden" name="k_red_id" value="<?php echo $_GET['id'] ?>"> 


             <div class="ln_solid"></div>
             <div class="form-group">
              <div align="center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="red_sebebi_guncelle" class="btn btn-success">Güncelle</button>
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
