<?php 

include 'header.php'; 




?>

<!DOCTYPE html>
<html>
<head>

  <title></title>
   <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script>
    
    $(document).ready(function(){

      $('#nedenler').change(function(){
        
        var deger=$(this).val();
       if (deger!=0) 
       {

        setTimeout(function() { $("#dv1").slideUp("fast"); }); 

       }
       if (deger==0) 
       {
         setTimeout(function() { $("#dv1").slideDown("fast"); }); 
       }

      });

    });

  </script>
</head>



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

          

            <input type="hidden" name="basvuru_red_id" value="<?php echo $_GET['basvuru_red_id']; ?>">



             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Klasik Red Sebepleri</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select name="nedenler" id="nedenler" class="form-control">
                            <option value="0">Bir Neden Seçiniz</option>
                            <?php 

              $kredsebepsor=$db->prepare("SELECT * FROM klasik_red_sebepleri");
              $kredsebepsor->execute(array());
              

              while ($kredsebepcek=$kredsebepsor->fetch(PDO::FETCH_ASSOC)) { ?>

                <option value="<?php echo $kredsebepcek['id']; ?>" ><?php echo $kredsebepcek['red_sebebi']; ?></option>

              <?php } ?>
                          </select>
                        </div>
                      </div>




             
              <div id="dv1">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Red Sebebi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="textarea" id="first-name" name="red_sebep" placeholder="Red etme nedenini giriniz." class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              </div>

               </div>
             </div>

            <input type="hidden" name="r_id" value="<?php echo $_GET['basvuru_red_id']; ?>" >
          
             


             <div class="ln_solid"></div>
             <div class="form-group">
              <div align="center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="basvuru_red_idm" class="btn btn-danger btn-xs">REDDET</button>
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
<body>

</body>
</html>

<?php include 'footer.php'; ?>
