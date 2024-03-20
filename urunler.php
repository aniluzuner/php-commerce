<?php
include 'header.php';

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


if(isset($_GET['ara'])){

  $ara = $_GET['ara'];

  $urunler = $db->query("SELECT * FROM urunler WHERE baslik LIKE '%{$ara}%'");
}
else if($kategori){
  $urunler->execute([
    'kategori' => $kategori
  ]);
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

  $var_mi = 0;

  foreach ($markalar as $key => $marka) {
    if($marka == $markagetir[$indis]['marka']){
      $var_mi = 1;
    }
  }

  if(!$var_mi){
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

  $var_mi = 0;

  foreach ($modeller as $key => $model) {
    if($model == $modelgetir[$indis]['model']){
      $var_mi = 1;
    }
  }

  if(!$var_mi){
    $modeller[count($modeller)] = $modelgetir[$indis]['model'];
  }
}


?>

<div class="container py-2">
  <div class="row">
    <div class="col-12 col-lg-2 p-0 pe-3">
      <div class="sticky-top pt-4">
        <form action="urunler.php" method="get" class="rounded-3 py-3 px-3" style="background: #F0F0F3;">
          <input type="hidden" name="kategori" value="<?php echo $kategori; ?>">

          <?php
          if ($sirala) {
            if($sirala=="desc")
              $desc = "selected";
            elseif($sirala=="asc")
              $asc = "selected";
          }

          ?>
          <select class="form-select bg-white" name="sirala">
            <option selected disabled hidden>Sırala</option>
            <option value="asc" <?php echo @$asc ?>>Artan fiyat</option>
            <option value="desc" <?php echo @$desc ?>>Azalan fiyat</option>
          </select>

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
        </form>
      </div>
    </div>
    <div class="col-12 col-lg-10 mt-4">
      <div class="row mb-5">
        <?php
          foreach($urun as $indis => $value){

              $fiyat = number_format($urun[$indis]['fiyat'], 0, ',', '.');

              echo '
                  <div class="col-6 col-lg-3 d-flex justify-content-center mb-4 pb-3">
                    <div class="card urunler-card" style="width: 95%;">
                      <img src="'.$urun[$indis]['gorsel'].'" class="card-img-top m-auto mt-4 mb-2 w-75">
                      <div class="card-body pb-0">
                        <h5 class="card-title fs-6">'.$urun[$indis]['baslik'].'</h5>
                        <p class="card-text fs-2 fw-bold">'.$fiyat.' TL</p>
                        <a href="urun.php?id='.$urun[$indis]['id'].'" class="stretched-link"></a>
                      </div>
                    </div>
                  </div>
              ';
            }
        ?>
      </div>
    </div>
  </div>
</div>







<?php include 'footer.html' ?>
