<?php 
     include "header.php";
    include "../nedmin/netting/baglan.php";
    error_reporting(0);
    $kullanicitc=$_SESSION['kullanici_tc'];

      $b_ilerleme=$db->prepare("UPDATE ogrenci SET
    b_ilerleme=:b_ilerleme

    WHERE kullanici_tc=$kullanicitc");

  $update=$b_ilerleme->execute(array(
    'b_ilerleme' => 1
  ));


    


 ?>
 <center>
<?php 
      if ($_SESSION['dosyadurum']=="ok" || $_SESSION['ddrm']=="ok")
{ 

$_SESSION['ddrm']="no";

echo '
<form action="#" method="POST">
<font size="3" color="red">Lütfen muaf etmek istediğiniz ders sayısını giriniz.</font>
<input type="number" name="derssayi">
<input type="submit" name="getir" value="Git">
</form>';
$_SESSION['dosyadurum']="no";
}


 if ($_POST['getir'])
{   

      echo '<center>
<form action="#" method="POST">
<font size="3" color="red">Satır Ekle/Çıkar </font>
<input type="number" name="satirekle">
<input type="submit" name="ekle" value="Git">
</form>';


  $k=$_POST['derssayi'];
  echo '<center> ';
  echo '<br> ';
  echo '<form action="post-et.php" method="POST"> ';
  echo '<table> <tr>  <td>  </td>  <td align="center"> Ders Adı  </td>  <td align="center"> Kredi  </td> <td align="center">  TUL </td> <td align="center"> AKTS </td>    </tr> ';

    
  for($i=1;$i<=$k;$i++)
  {
    echo '<tr><td> '.$i.'. Dersi Giriniz :   </td> <td> <input type="text" name="ders'.$i.'" placeholder="Ders Adı"  title="Bu alan boş geçilemez" required=""> </td> <td>  <input type="number" name="derskredi'.$i.'" placeholder="Kredi "pattern="\d{2}"  title="Bu alana en fazla 2 karakterli sayısal değer girilebilir." required="">    </td> <td>  <input type="text" name="derstul'.$i.'" placeholder="TUL"  title="Bu alan boş geçilemez" required=""  >    </td> <td>  <input type="number" name="dersakts'.$i.'" placeholder="AKTS "pattern="\d{2}"  title="Bu alana en fazla 2 karakterli sayısal değer girilebilir." required="">    </td> </tr>';

  }  
  echo '</table>
<br> <br>
<input type="submit" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" value="Eşleştirmek için Hazırla" name="ehazirla">

    </form>';
  $_SESSION['s']=$k;
  $_SESSION['dsayi']=$k;
}
       


        if ($_POST['ekle'])
  { 
          echo '<br>
<form action="#" method="POST">
<font size="3" color="red">Satır Ekle/Çıkar </font>
<input type="number" name="satirekle">
<input type="submit" name="ekle" value="Git">
</form>';

      echo '<center> ';
 
  echo '<br> <br> <br> <form action="post-et.php" method="POST"> ';
  echo '<table> <tr>  <td>  </td>  <td align="center"> Ders Adı  </td>  <td align="center"> Kredi  </td> <td align="center">  TUL </td> <td align="center"> AKTS </td>    </tr> ';
   
    $l=$_POST['satirekle']+$_SESSION['s'];

    if ($l<0) {

      $l=0;
    }

      for($j=1;$j<=$l;$j++)
  {
    echo '<tr><td> '.$j.'. Dersi Giriniz :   </td> <td> <input type="text" name="ders'.$j.'"> </td> <td>  <input type="number" name="derskredi'.$j.'">    </td> <td>  <input type="text" name="derstul'.$j.'">    </td> <td>  <input type="number" name="dersakts'.$j.'"> </tr>';


  }
  echo '</table> 
  <br> <br>
<input type="submit" class="btn px-4 m-1 width-2 btn-pill btn-outline-primary" value="Eşleştirmek için Hazırla" name="ehazirla">
   </form>';
  $_SESSION['s']=$l;
  $_SESSION['dsayi']=$l;

 
  } 
 ?>



<center>

<br><br>
<center>
   


</center>



<?php include "footer.php"; ?>