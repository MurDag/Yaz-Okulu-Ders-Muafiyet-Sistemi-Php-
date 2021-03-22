<head>
  <link rel="stylesheet" href="css/ozel.css">
</head>


<?php 

include "header.php";
include "../nedmin/netting/baglan.php";
error_reporting(0);

    $tc=$_SESSION['kullanici_tc'];
    $kbilgisor=$db->prepare("SELECT * FROM ogrenci WHERE kullanici_tc=:kullanici_tc  ");
  $kbilgisor->execute(array(
    'kullanici_tc' => $tc
    ));


  $kbilgicek=$kbilgisor->fetch(PDO::FETCH_ASSOC);

  $kullanici_id=$kbilgicek['id'];

      $kderslersor=$db->prepare("SELECT * FROM kdersler WHERE basvuru_yid=:basvuru_yid  ");
  $kderslersor->execute(array(
    'basvuru_yid' => $kullanici_id
    ));
  


      $bid=$kbilgicek['kullanici_bolum_id'];
    $fsor=$db->prepare("select fakulte_yid from bolumler where id=:id");
  $fsor->execute(array(
    'id' => $bid
    ));


  $fcek=$fsor->fetch(PDO::FETCH_ASSOC);





  

  $fid=$fcek['fakulte_yid'];
    $fadsor=$db->prepare("select fakulte_ad from fakulteler where id=:id");
  $fadsor->execute(array(
    'id' => $fid
    ));


  $fadcek=$fadsor->fetch(PDO::FETCH_ASSOC);

$kullanici_tc=$_SESSION['kullanici_tc'];


$idsor=$db->prepare("SELECT * FROM ogrenci  where kullanici_tc=:kullanici_tc ");
    $idsor->execute(array( 'kullanici_tc' => $kullanici_tc )); 
    $idcek=$idsor->fetch(PDO::FETCH_ASSOC);
    $id=$idcek['id'];



     $bsor=$db->prepare("SELECT * FROM kdersler  where basvuru_yid=:basvuru_yid ");
    $bsor->execute(array( 'basvuru_yid' => $id )); 
    



?>



  


<div class="konteynir" > 

  <h1 style="padding-bottom: 25px;">
 Muafiyet Başvuru Sonucu
</h1>
<p>
  Yapmış olduğunuz başvurunun sonucuna aşağıdaki tablodan ulaşabilirsiniz.
</p>
<br><br>
 <center>
   <button type="submit" name="dy" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" onclick="PrintElem('#sd')" >Başvuru Belgesini Yazdır!</button> 
 </center>
<table style="margin-top: 50px;">
    <thead>
      <tr>
        <th>
          Ders Adı
        </th>
         <th>
          Eşleştirilmek İstenen Ders
        </th>
         <th>
          Ders Sonuc
        </th>
        <th> Red Sebebi</th>
      </tr>
    </thead>
   
    <tbody >
    <?php   while($bcek=$bsor->fetch(PDO::FETCH_ASSOC)) {?>
      <tr>

        <td bgcolor="#DDDDDD" data-title='Ders Adı'>

          <?php echo $bcek['ders_ad'] ?>
        
        </td>
        <td bgcolor="#DDDDDD" data-title='Eşleştirmek İstenen Ders'>
            <?php  
                    $dsor=$db->prepare("SELECT * FROM dersler  where id=:id ");
                    $dsor->execute(array( 'id' => $bcek['muaf_ders'] )); 
                    $dcek=$dsor->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <?php echo $dcek['ders_ad'];  ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Ders Sonuç'>
          <?php 
                   if ($bcek['ders_onay']==2) 
                   {
                    ?>

<font face="arial" size="2" color=" #000"> Onaylandı </font>
                    <?php

                   } 
                   if ($bcek['ders_onay']==1) 
                   {

                     ?>

<font face="arial" size="2" color="000"> Reddedildi </font>
                    <?php
                   } 
                   
                   ?>
        </td>
        <td bgcolor="#DDDDDD" data-title='Red Sebebi'>
           <font face="arial" size="2" color="000"> <?php echo $bcek['red_sebep']; ?> </font>
        </td>


        
      </tr>
      <?php } ?> 
    </tbody>
  </table>




</div>





  <Div id="sd" style="display:none;" >
    <form >

      <img src="../images/asdf.png" alt="Başlık"/ width="900" height="200">
  
  <br> <br>
  <center>  
<font face="tahoma" size="3" color="black"><?php  echo $fadcek['fakulte_ad'];  ?> DEKANLIĞINA/MÜDÜRLÜĞÜNE </font> 
  </center>
  
  <br>
  <br>
  <font face="tahoma" size="3" color="black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Okumuş olduğum İskenderun Teknik Üniversitesi (İSTE) <?php  echo $fadcek['fakulte_ad'];  ?> Enstitü/ Fakültesi / <br> &nbsp;&nbsp;&nbsp;Yüksekokulu’na ait transkriptimde başarılı olduğum ve aşağıda belirttiğim derslerden  muaf olmak istiyorum. <br>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Gereğini bilgilerinize arz ederim. </font> 
  <br><br>
  <table align="right"> <tr> <td><u> İmza </u>  </td></tr> </table>
  <br>
  <br><br>
  Öğrenci Bilgileri;
  <table border="1" cellpadding="0" cellspacing="0" style="width:100%" >

    <tr> <td> TC Kimlik NO    </td> <td> &nbsp;&nbsp;&nbsp; <?php echo  $kbilgicek['kullanici_tc']; ?>  </td>  </tr>
    <tr> <td> Okul NO    </td> <td> &nbsp;&nbsp;&nbsp; <?php echo  $kbilgicek['kullanici_no']; ?>   </td>  </tr>
    <tr> <td> Adı Soyadı    </td> <td> &nbsp;&nbsp;&nbsp; <?php echo  $kbilgicek['kullanici_ad'].' '.$kbilgicek['kullanici_soyad']; ?>  </td>  </tr>
    <tr> <td> Bölüm    </td> <td>  &nbsp;&nbsp;&nbsp; 
      <?php   

      $bolum_id=$kbilgicek['kullanici_bolum_id'];
    $kbolumsor=$db->prepare("SELECT * FROM bolumler WHERE id=:id  ");
  $kbolumsor->execute(array(
    'id' => $bolum_id ));

  $kbolumcek=$kbolumsor->fetch(PDO::FETCH_ASSOC);
  echo $kbolumcek['bolum_ad'];

      
       ?>  </td>  </tr>
    <tr> <td> İletişim Cep/TlfNo    </td> <td> &nbsp;&nbsp;&nbsp;  <?php echo  $kbilgicek['kullanici_tel']; ?>  </td>  </tr>

  </table>
  <br>
  Muafiyet İstenen Dersin/Derslerin;

  <table border="1" cellpadding="0" cellspacing="0" style="width:100%">
    <tr><td><u>Kodu</u></td><td><u>Adı</u></td><td><u>Kodu</u></td><td><u>Adı</u></td> </tr>
    <?php

    while ($kderslercek=$kderslersor->fetch(PDO::FETCH_ASSOC)) {
      echo '<tr> <td>'.$kderslercek['ders_kodu']    .'    </td>  <td> '. $kderslercek['ders_ad']  .'    </td> ';
            $bderslerid=$kderslercek['muaf_ders'];
    $bderslersor=$db->prepare("select * from dersler where id=:id");
  $bderslersor->execute(array(
    'id' => $bderslerid
    ));

  while ($bderslercek=$bderslersor->fetch(PDO::FETCH_ASSOC)) {

    echo '<td>'.$bderslercek['ders_kodu'].'</td>';
    echo '<td>'.$bderslercek['ders_ad'].'</td>';
  }


  echo  '</tr>';

    }

     ?>
  </table>
  <br>
  
  <font face="" size="4" color="black">İSTE Ön Lisans Ve Lisans Eğitim-Öğretim Ve Sınav Yönetmeliği    </font> 
  <table>
    
    <tr>
      <td> <font face="" size="2" color="black">MADDE 14 – (1) Üniversiteye yeni kayıt sırasında talepte bulunan öğrencilere, Rektörlükçe belirlenecek ders/derslerden muafiyet sınavı yapılır. Bu sınavda CC ve üzeri not alan öğrenciler, ilgili ders/derslerden başarılı sayılırlar ve sınavda almış oldukları not ders/derslere harf notu olarak verilir.     </font>        </td>
    </tr>
      <tr>
      
      <td> <font face="" size="2" color="black">(2) Üniversiteye bağlı birimlere kayıt yaptıran öğrenci; daha önce kayıtlı olduğu bir yükseköğretim kurumundan aldığı derslerin kayıt yaptırdığı birimin ders programlarında yer alan derslere içerik ve kredi/saat bakımından uygun olması halinde, bu derslerden muaf sayılabilir ve otomasyon sistemine, bu Yönetmelikte belirtilen notları işlenir. Ders muafiyetleri, ders muafiyet komisyonunun/bölümün önerisi ve ilgili birimin yönetim kurulunun kararıyla öğrencinin öğreniminin ilk yarıyılının başında sadece bir defaya mahsus olmak üzere yapılır.     </font>        </td>
    </tr>
      <tr>
      <td> <font face="" size="2" color="black"> (3) Öğrenciler muafiyet ve/veya intibak başvurularını, akademik takvimde belirlenen tarihler içerisinde kayıt yaptırdıkları birimlerine yapmak zorundadır. Bu tarihten sonra yapılacak başvurular dikkate alınmaz. Ortak zorunlu dersler dâhil, daha önce kayıtlı olduğu bir yükseköğretim kurumunda başarılı olduğu derslerden muafiyet isteği kabul edilen öğrencilerin muaf olduğu toplam kredi; birinci sınıfta okutulan derslerin toplam kredisinin yarısı veya yarısından fazla ise ikinci sınıfa intibakı yapılır. Üçüncü sınıfa intibak yapılabilmesi için ise öğrencinin birinci sınıfta okutulan toplam kredinin 2/3’ünden ve ikinci sınıfta okutulan toplam kredinin yarısı veya yarısından fazla kredilik dersten muaf olması gerekir.   </font>        </td>
    </tr>
    <tr>
      <td> <font face="" size="2" color="black"> (4) Öğrencinin hangi sınıfa intibakının yapılacağı, üçüncü fıkrada belirtilen esaslara göre ilgili birimin yönetim kurulunca kararlaştırılır. Bu işlemler sonucu kabul edilen eşdeğer süre, azami öğretim süresinden düşülür. İntibakı yapılan öğrenciler öncelikle varsa muaf olmadığı alt sınıf derslerini alır.     </font>        </td>

    </tr>

  </table>
      

    </form>



    

</Div>   

 <?php

include "footer.php";


 ?>