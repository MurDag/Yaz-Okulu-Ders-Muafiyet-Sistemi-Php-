<?php 
error_reporting(0);

include 'header.php'; 
include "../netting/baglan.php";
//Belirli veriyi seçme işlemi
$basvuru_yil=$_POST['byil'];
$basvuru_donem=$_POST['donem'];

 $yilsor=$db->prepare("SELECT distinct basvuru_yil FROM basvuru where basvuru_sonuc=1");
$yilsor->execute();

?>

<!DOCTYPE html>
<html>
<head>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" charset='UTF-8'>
<script type="text/javascript">

function exportExcel() {
     var tableExport = document.getElementById('tableExport');
     var html = tableExport.outerHTML;

     while (html.indexOf('ç') != -1) html = html.replace('ç', '&ccedil;');
     while (html.indexOf('ğ') != -1) html = html.replace('ğ', '&#287;');
     while (html.indexOf('ı') != -1) html = html.replace('ı', '&#305;');
     while (html.indexOf('ö') != -1) html = html.replace('ö', '&ouml;');
     while (html.indexOf('ş') != -1) html = html.replace('ş', '&#351;');
     while (html.indexOf('ü') != -1) html = html.replace('ü', '&uuml;');

     while (html.indexOf('Ç') != -1) html = html.replace('Ç', '&Ccedil;');
     while (html.indexOf('Ğ') != -1) html = html.replace('Ğ', '&#286;');
     while (html.indexOf('İ') != -1) html = html.replace('İ', '&#304;');
     while (html.indexOf('Ö') != -1) html = html.replace('Ö', '&Ouml;');
     while (html.indexOf('Ş') != -1) html = html.replace('Ş', '&#350;');
     while (html.indexOf('Ü') != -1) html = html.replace('Ü', '&Uuml;');

     window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
}

</script>

  <title></title>
</head>
<body>
  <?php

      $basvurusor=$db->prepare("SELECT * from basvuru where basvuru_sonuc=:basvuru_sonuc");
  $basvurusor->execute(array(
    'basvuru_sonuc' => 1
    ));


  if (isset($_POST['byil']) && isset($_POST['donem']))
  { 

    $basvurusor=$db->prepare("SELECT * from basvuru where basvuru_sonuc=:basvuru_sonuc and basvuru_yil=:basvuru_yil and basvuru_donem=:basvuru_donem");
  $basvurusor->execute(array(
    'basvuru_sonuc' => 1,
    'basvuru_yil' => $basvuru_yil,
    'basvuru_donem' => $basvuru_donem
    ));
  }


  ?>



<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <table>
              <tr>
                <td colspan="2">

                   <h2>Ders Muafiyet/Eşleştirme Başvuruları<small>

            </small></h2>
                </td>
              </tr>
            </table>
          
           
            <div class="clear
            fix"></div>
          </div>
          <form action="#" method="POST">
            
          
          <div class="form-group">

           <div class="col-md-2 col-sm-2 col-xss-12">
            <table>
              <tr>
            <td>
              
               <select name="byil" class="form-control">

                            <?php while($yilcek=$yilsor->fetch(PDO::FETCH_ASSOC)) 
                            {     ?>

                            <option><?php echo $yilcek['basvuru_yil']; ?></option>


                          <?php } ?>

                          </select>

            </td>
            <td>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
            <td>
              
              <select name="donem" class="form-control">
                             <option value="1"> Normal Örgün</option>
                             <option value="2"> Yaz Okulu</option>
                          </select>

            </td>
          </tr>

        </table>

                        </div>


          </div>
          <input type="submit" name="getir">
          </form>

          <br>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->
            <center><button id="btnExport" onclick="exportExcel();">Excel'e Aktar</button></center>
            <table border="1" id="tableExport" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="32%">
              <thead>
                <?php if ($basvuru_donem==1) {
                  echo '<tr><td colspan="5"> <center>'.$basvuru_yil.' Yılı Örgün Ders Muafiyet Başvuruları </center></td></tr>';
                }

                if ($basvuru_donem==2) {
                  echo '<tr><td colspan="5"> <center>'.$basvuru_yil.' Yılı Yaz Okulu Ders Eşleştirme Başvuruları </center></td></tr>';
                }


                 ?>

                
                <tr>
                  <th>Öğrenci No</th>
                  <th>Ad</th>
                  <th>Soyad</th>
                  <th>Bölüm</th>
                  <th>Muaf Edilen Dersler</th>
                </tr>
              </thead>

              <tbody>

                <?php 


                while($basvurucek=$basvurusor->fetch(PDO::FETCH_ASSOC)) {?>


                <tr>
                  <?php 
                   $id=$basvurucek['basvuru_yid'];
                   $nosor=$db->prepare("SELECT kullanici_no FROM ogrenci where id='$id'");
                   $nosor->execute();
                   $nocek=$nosor->fetch(PDO::FETCH_ASSOC);

                   ?>

                  <td valign="middle"><?php echo $nocek['kullanici_no'] ?></td>
                  <td valign="middle"><?php echo $basvurucek['basvuru_ad'] ?></td>
                  <td valign="middle"><?php echo $basvurucek['basvuru_soyad'] ?></td>

                  <td valign="middle">
                    <?php  
                    $bolumsor=$db->prepare("SELECT * FROM bolumler  where id=:id ");
                    $bolumsor->execute(array( 'id' => $basvurucek['basvuru_bolum_id'] )); 
                    $bolumcek=$bolumsor->fetch(PDO::FETCH_ASSOC);
                    echo $bolumcek['bolum_ad']; 
                    ?>
                      
                    </td>
                  <td>
                    <?php  
                    $muafsor=$db->prepare("SELECT muaf_ders FROM kdersler  where basvuru_yid=:basvuru_yid ");
                    $muafsor->execute(array( 'basvuru_yid' => $basvurucek['basvuru_yid'] )); 
                    while ($muafcek=$muafsor->fetch(PDO::FETCH_ASSOC)) 
                    {
                    $derssor=$db->prepare("SELECT * FROM dersler  where id=:id ");
                    $derssor->execute(array( 'id' => $muafcek['muaf_ders'] )); 
                    $derscek=$derssor->fetch(PDO::FETCH_ASSOC);

                        echo $derscek['ders_ad'];
                        echo '<br>'; 
                    }           
                    ?>


                  </td>
                </tr>

                <?php  }

                ?>


              </tbody>
            </table>

            <!-- Div İçerik Bitişi -->


          </div>
        </div>
      </div>
    </div>




  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
