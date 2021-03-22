<?php 

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi
$fakultesor=$db->prepare("SELECT * FROM fakulteler");
$fakultesor->execute();


?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Fakülteler <small>,
              <?php

              if ($_GET['durum']=="ok") {
                echo "Güncelleme Başarılı";
              }
              if ($_GET['durum']=="no") {
                echo "Güncelleme Başarısız";
              }
              if ($_GET['durum']=="s-ok") {
                echo "Silme İşlemi Başarılı";
              }
              if ($_GET['durum']=="s-no") {
                echo "Silme İşlemi Başarısız";
              }
               if ($_GET['durum']=="e-ok") {
                echo "Ekleme İşlemi Başarılı";
              }
               if ($_GET['durum']=="e-no") {
                echo "Ekleme İşlemi Başarısız";
              }


              ?>

            


            </small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix">
              


            </div>
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Fakülte Adı</th>
                  <th>Dekan</th>
                </tr>
              </thead>

              <tbody>

                <?php 

                while($fakultecek=$fakultesor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                  <td><?php echo $fakultecek['fakulte_ad'] ?></td>
                  <td><?php echo $fakultecek['fakulte_dekan'] ?></td>
                  <td><center><a href="fakulte-duzenle?fakulte_id=<?php echo $fakultecek['id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                  <td><center><a href="../netting/islem.php?fakulte_id=<?php echo $fakultecek['id']; ?>&fakultesil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
                </tr>



                <?php  
                }
                ?>
              </tbody>
            </table>

            <br> <br>
            <form action="../netting/islem.php" method="POST"">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fakülte Adı :<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="fakulte_ad" placeholder="Eklenecek Fakülte Adını Giriniz" required="required" class="form-control col-md-7 col-xs-12"> </div> </div>

                  <br>

                   <div class="form-group">
                    <br>
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fakülte Dekanının Adı :<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="fakulte_dekan" placeholder="Eklenecek Fakülte Dekanının Adını Giriniz" required="required" class="form-control col-md-7 col-xs-12"> </div> </div>
              

                     



                  <br><br><br>
                  <center>

                  <button type="submit" name="fakulteekle" class="btn btn-success">Ekle</button>
                  </center>
                  </form>
                </div>
              </div>
               
                
              
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
