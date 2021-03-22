<?php 

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi
$y_ayarsor=$db->prepare("SELECT * FROM y_ayar");
$y_ayarsor->execute();

$k_redsebepsor=$db->prepare("SELECT * FROM klasik_red_sebepleri");
$k_redsebepsor->execute();

?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Yaz Okulu Ayarları <small>,
              <?php

              if ($_GET['guncelle']=="ok") {
                echo "Güncelleme Başarılı";
              }
              if ($_GET['guncelle']=="no") {
                echo "Güncelleme Başarısız";
              }
              


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
            <div class="clearfix">
              


            </div>
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Maximum Ders Sayısı</th>
                  <th>Maximum Kredi Sayısı</th>
                  <th>Maximum Üniversite Sayısı</th>
                  <th>Maximum Öneri Sayısı</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>

                <?php 

                while($y_ayarcek=$y_ayarsor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                  <td><?php echo $y_ayarcek['max_ders']; ?></td>
                  <td> <?php echo $y_ayarcek['max_kredi']; ?> </td>
                  <td><?php echo $y_ayarcek['max_universite']; ?></td>
                  <td><?php echo $y_ayarcek['max_oneri']; ?></td>


                  <td><center><a href="y_ayar_duzenle?id=<?php echo $y_ayarcek['id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                </tr>



                <?php  
                }
                ?>
              </tbody>
            </table>
 <center>
<form action="../netting/islem.php" method="POST">
 <div class="form-group">
                
                <div class="col-md-12 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="k_red_sebep"  placeholder="Buradan Yeni Red Sebebi Ekleyebilirsiniz." required="required" class="form-control col-md-7 col-xs-12">
                   <button type="submit" name="k_redsebep_ekle" class="btn btn-success">Red Sebebi Ekle</button></center>
                </div>

  </div>
</form>

  
            <br>
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="50%">
              <thead>
                <tr>
                  <th colspan="3"><center> Red Sebepleri</center></th>

                </tr>
              </thead>

              <tbody>

                <?php 

                while($k_redsebepcek=$k_redsebepsor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                  
                  <td>
                 <?php echo $k_redsebepcek['red_sebebi']; ?>

                    </td>


                  <td><center><a href="k_redsebep_guncelle?id=<?php echo $k_redsebepcek['id']; ?>"><button class="btn btn-primary btn-xs">Güncelle</button></a></center></td>
                  <td><center>
                  <a href="../netting/islem.php?red_sebebi_sil=<?php echo $k_redsebepcek['id'];?>"><button class="btn btn-danger btn-xs">Sil</button></a>
                </center></td>
                </tr>

                


                <?php  
                }
                ?>
              </tbody>
            </table>  
                </div>
              </div>   
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
