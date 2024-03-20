<?php
session_start();
if (!($_SESSION['kullanici'] == "admin")) {
  header('Location: giris.php');
}

include 'header.php';

//Filtreme işlemleri

@$kategori = $_GET['kategori'];

@$marka_filtre = $_GET['markalar'];

@$model_filtre = $_GET['modeller'];

@$sirala = $_GET['sirala'];


$sorgu = "SELECT * FROM urunler";

if ($kategori OR $marka_filtre OR $model_filtre) {
  $sorgu .= " WHERE";
}

if($marka_filtre){
  foreach ($marka_filtre as $key => $value) {
    if ($key==0) {
      if (count($marka_filtre) == 1) {
        $sorgu .= " ("."marka='$value')";
      }
      else {
        $sorgu .= " ("."marka='$value'";
      }
    }
    elseif ($key==(count($marka_filtre)-1)) {
      $sorgu .= " OR marka='$value')";
    }
    else {
     $sorgu .= " OR marka='$value'";
    }
  }
}

if ($marka_filtre AND $model_filtre) {
  $sorgu .= " AND";
}

if($model_filtre AND $kategori){
  foreach ($model_filtre as $key => $value) {
    if ($key==0) {
      if (count($model_filtre) == 1) {
        $sorgu .= " ("."model='$value')";
      }
      else {
        $sorgu .= " ("."model='$value'";
      }
    }
    elseif ($key==(count($model_filtre)-1)) {
      $sorgu .= " OR model='$value')";
    }
    else {
     $sorgu .= " OR model='$value'";
    }
  }
}


if ($kategori AND ($marka_filtre OR $model_filtre)) {
  $sorgu .=" AND kategori=:kategori";
}
elseif ($kategori) {
  $sorgu .=" kategori=:kategori";
}

if ($sirala) {
  $sorgu .= " ORDER BY fiyat $sirala";
}


$urunler = $db->prepare($sorgu);

if($kategori){
  $urunler->execute(array(
    'kategori' => $kategori)
  );
}
else{
  $urunler->execute();
}


$urun = array();

for ($i=0; $i < $urunler->rowCount(); $i++) {
  $urun[$i] = $urunler->fetch(PDO::FETCH_ASSOC);
}



if ($kategori) {
  $markagetir = $db->query("SELECT marka FROM urunler WHERE kategori='$kategori' ORDER BY marka ASC")->fetchAll(PDO::FETCH_ASSOC);
}
else {
  $markagetir = $db->query("SELECT marka FROM urunler ORDER BY marka ASC")->fetchAll(PDO::FETCH_ASSOC);
}


$markalar = array();

foreach($markagetir as $indis => $value){

  $var_mı = 0;

  foreach ($markalar as $key => $marka) {
    if($marka == $markagetir[$indis]['marka']){
      $var_mı = 1;
    }
  }

  if(!$var_mı){
    $markalar[count($markalar)] = $markagetir[$indis]['marka'];
  }
}

$sorgu = "SELECT model FROM urunler";

if($marka_filtre){
  foreach ($marka_filtre as $key => $value) {
    if ($key==0) {
      if (count($marka_filtre) == 1) {
        $sorgu .=  " WHERE ("."marka='$value')";
      }
      else {
        $sorgu .=  " WHERE ("."marka='$value'";
      }
    }
    elseif ($key==(count($marka_filtre)-1)) {
      $sorgu .= " OR marka='$value')";
    }
    else {
     $sorgu .= " OR marka='$value'";
    }
  }
}

if ($kategori AND $marka_filtre) {
  $sorgu .=" AND kategori='$kategori' ORDER BY model ASC";
}
elseif ($kategori) {
  $sorgu .=" WHERE kategori='$kategori' ORDER BY model ASC";
}


$modelgetir = $db->query($sorgu)->fetchAll(PDO::FETCH_ASSOC);

$modeller= array();

foreach($modelgetir as $indis => $value){

  $var_mı = 0;

  foreach ($modeller as $key => $model) {
    if($model == $modelgetir[$indis]['model']){
      $var_mı = 1;
    }
  }

  if(!$var_mı){
    $modeller[count($modeller)] = $modelgetir[$indis]['model'];
  }
}
?>

<script language="javascript">
  function confirmDelete() {
    var agree=confirm("Bu içeriği silmek istediğinizden emin misiniz?");
    if (agree) {
      return true; }
    else {
      return false; }
  }
</script>

<div class="container-fluid px-5 mb-5 pt-2 pb-5">
  <div class="row">
    <div class="col-2 p-0 pe-3">
      <div class="sticky-top pt-4">
        <form action="urunlerliste.php" method="get" class="rounded-3 py-3 px-3" style="background: #F0F0F3;">

          <?php
          if ($sirala) {
            if($sirala=="desc")
              $desc = "selected";
            elseif($sirala=="asc")
              $asc = "selected";
          }

          ?>
          <p class="fs-5">Toplam <?php echo count($urun); ?> ürün</p>
          <select class="form-select bg-white" name="sirala">
            <option selected disabled hidden>Sırala</option>
            <option value="asc" <?php echo @$asc ?>>Artan fiyat</option>
            <option value="desc" <?php echo @$desc ?>>Azalan fiyat</option>
          </select>

          <p class="h4 fw-bold mt-3 mb-2">Kategoriler</p>

          <div class="form-check ms-1 fs-6 lh-sm">
            <input class="form-check-input" type="radio" name="kategori" value="işlemci" <?php echo $kategori == "işlemci" ? "checked" : ""; ?>>
            <span class="form-check-label fs-5">İşlemci</span>
          </div>

          <div class="form-check ms-1 fs-6 lh-sm">
            <input class="form-check-input" type="radio" name="kategori" value="anakart" <?php echo $kategori == "anakart" ? "checked" : ""; ?>>
            <span class="form-check-label fs-5">Anakart</span>
          </div>

          <div class="form-check ms-1 fs-6 lh-sm">
            <input class="form-check-input" type="radio" name="kategori" value="bellek" <?php echo $kategori == "bellek" ? "checked" : ""; ?>>
            <span class="form-check-label fs-5">Bellek</span>
          </div>

          <div class="form-check ms-1 fs-6 lh-sm">
            <input class="form-check-input" type="radio" name="kategori" value="ekran kartı" <?php echo $kategori == "ekran kartı" ? "checked" : ""; ?>>
            <span class="form-check-label fs-5">Ekran Kartı</span>
          </div>

          <div class="form-check ms-1 fs-6 lh-sm">
            <input class="form-check-input" type="radio" name="kategori" value="depolama" <?php echo $kategori == "depolama" ? "checked" : ""; ?>>
            <span class="form-check-label fs-5">Depolama</span>
          </div>

          <div class="form-check ms-1 fs-6 lh-sm">
            <input class="form-check-input" type="radio" name="kategori" value="kasa" <?php echo $kategori == "kasa" ? "checked" : ""; ?>>
            <span class="form-check-label fs-5">Kasa</span>
          </div>

          <div class="form-check ms-1 fs-6 lh-sm">
            <input class="form-check-input" type="radio" name="kategori" value="güç kaynağı" <?php echo $kategori == "güç kaynağı" ? "checked" : ""; ?>>
            <span class="form-check-label fs-5">Güç Kaynağı</span>
          </div>

          <p class="h4 fw-bold mt-3 mb-2">Markalar</p>
          <?php
            foreach ($markalar as $key => $marka) {

              $check = "";

              if ($marka_filtre) {
                foreach ($marka_filtre as $key => $value) {
                  if ($value==$marka) {
                    $check = "checked";
                  }
                }
              }

              echo '
                <div class="form-check ms-1 fs-6 lh-sm">
                  <input class="form-check-input" type="checkbox" name="markalar[]" value="'.$marka.'"'.@$check.'>
                  <span class="form-check-label fs-5">'.$marka.'</span>
                </div>
              ';
            }
          ?>


          <?php
            if (($kategori AND $marka_filtre) OR ($kategori AND !$marka_filtre)) {
              echo '<p class="h4 fw-bold mt-4 mb-2">Modeller</p>';

              foreach ($modeller as $key => $model) {

                $check = "";

                if ($model_filtre) {
                  foreach ($model_filtre as $key => $value) {
                    if ($value==$model) {
                      $check = "checked";
                    }
                  }
                }

                echo '
                  <div class="form-check ms-1 fs-6 lh-sm">
                    <input class="form-check-input" type="checkbox" name="modeller[]" value="'.$model.'"'.@$check.'>
                    <span class="form-check-label fs-5">'.$model.'</span>
                  </div>
                ';
              }
            }
          ?>

          <button class="btn btn-primary mt-4 w-100 fw-bold fs-5" type="submit" name="filtre">Filtrele</button>
          <a href="urunlerliste.php" class="btn btn-link text-black text-decoration-none m-0 mt-2 p-0 w-100 fw-bold fs-6">Filtreyi Sıfırla</a>
        </form>
      </div>
    </div>
    <div class="col-10 mt-4 urunler-liste">
      <?php
        echo "<table align='center'> <thead class='renk'> <tr> <th>Id</th> <th>Kategori</th> <th>Marka</th> <th>Model</th> <th>Başlık</th> <th style='padding-left:30px;'>Fiyat</th> <th>Stok</th> <th>İşlem</th> </tr> </thead>";

        foreach($urun as $indis => $value){
          echo "<tr>";
          echo "<td>".$urun[$indis]['id']."</td>";
          echo "<td>".$urun[$indis]['kategori']."</td>";
          echo "<td>".$urun[$indis]['marka']."</td>";
          echo "<td>".$urun[$indis]['model']."</td>";
          echo "<td style='max-width: 500px; overflow: hidden; white-space: nowrap;'>".$urun[$indis]['baslik']."</td>";
          echo "<td style='padding-left:30px;'>".number_format($urun[$indis]['fiyat'], 0, ',', '.')."</td>";
          echo "<td>".$urun[$indis]['stok']."</td>";
          echo "<td> 
                  <a class='px-1 text-decoration-none text-black' href=urunduzenle.php?id=".$urun[$indis]['id']."><i class='fa-solid fa-pen-to-square'></i></a>
                  <a class='px-1 text-decoration-none text-black' href=islem.php?urunsil&id=".$urun[$indis]['id']." onClick='return confirmDelete();'><i class='fa-solid fa-trash'></i></a> 
                </td>";
          echo "</tr>";
        }
        echo "</table>";
        
      ?>
    </div>
  </div>
</div> 