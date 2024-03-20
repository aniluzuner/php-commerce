<?php
include 'header.php';

$id = $_GET['id'];

$urungetir = $db->query("SELECT * FROM urunler WHERE id='{$id}'")->fetch(PDO::FETCH_ASSOC);

$fiyat = $urungetir['fiyat'];

if (isset($_COOKIE['sepet'])) {
  foreach ($_COOKIE['sepet'] as $index => $value) {
    if ($value == $id) {
      $sepette = 1;
    }
  }
}

?>

<div class="container my-5 py-4 px-5" style="height:650px;">
  <div class="row h-100 urun-div">
    <div class="col-6 d-flex justify-content-center align-items-center">
      <img class="w-75" src="<?php echo $urungetir['gorsel'] ?>" alt="">
    </div>
    <div class="col-6 rounded-end ps-4" style="background: #F0F0F3;">
      <h1 class="h3 mt-4"><?php echo $urungetir['baslik'] ?></h1>
      <a href="#"><img src="images/markalar/<?php echo $urungetir['marka'] ?>.svg" width="10%"></a>

      <p class="h1 fw-bold mt-5">
      <?php
      echo number_format($urungetir['fiyat'], 0, ',', '.');
      ?> TL</p>

      <div class="row">
        <div class="col">
          <?php
          if(isset($sepette)){
            echo '<a href="sepet.php" class="btn btn-primary p-2 my-4"> <i class="fa-solid fa-cart-shopping fa-2xl ms-1"></i> <span class="fs-3 fw-bold ms-3 me-1">Sepette</span></a>';
          }
          else {
            echo '<a href="islem.php?sepetekle='.$id.'" class="btn btn-primary p-2 my-4"> <i class="fa-solid fa-cart-shopping fa-2xl ms-1"></i> <span class="fs-3 fw-bold ms-3 me-1">Sepete Ekle</span></a>';
          }
          ?>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-6">
          <?php echo $urungetir['ozellikler'] ?>
        </div>
      </div>


    </div>
  </div>
</div>




<?php include 'footer.html' ?>
