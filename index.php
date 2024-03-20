<?php include 'header.php'; ?>

  <!-- Anasayfa -->

  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active"> <img src="images/banners/banner.jpg" class="d-block w-100" alt="..."> </div>
      <div class="carousel-item"> <img src="images/banners/banner1.jpg" class="d-block w-100" alt="..."> </div>
      <div class="carousel-item"> <img src="images/banners/banner.jpg" class="d-block w-100" alt="..."> </div>
      <div class="carousel-item"> <img src="images/banners/banner1.jpg" class="d-block w-100" alt="..."> </div>
      <div class="carousel-item"> <img src="images/banners/banner.jpg" class="d-block w-100" alt="..."> </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <div class="container pb-4">
    <div class="row mt-2">
      <div class="row mt-5 pb-5">
        <h2 class="h2 mt-4 mb-4 text-center fw-bold">HAFTANIN FIRSAT ÜRÜNLERİ</h2>
        <?php
          for ($i=1; $i<=4; $i++) {
            $rastgelesayi = rand(1,$tumurunsay);
            $urun = $db->query("SELECT * FROM urunler WHERE id={$rastgelesayi}")->fetch(PDO::FETCH_ASSOC);
            $fiyat = number_format($urun['fiyat'], 0, ',', '.');

            echo '
            <div class="col-6 col-lg-3 d-flex justify-content-center">
              <div class="card index-card" style="width: 90%;">
                <img src="'.$urun['gorsel'].'" class="card-img-top m-auto mt-4 mb-2 w-75">
                <div class="card-body pb-0">
                  <h5 class="card-title fs-6">'.$urun['baslik'].'</h5>
                  <p class="card-text fs-2 fw-bold mt-3 mb-1">'.$fiyat.' TL</p>
                  <a href="urun.php?id='.$urun['id'].'" class="stretched-link"></a>
                </div>
              </div>
            </div>
            ';
          }
        ?>
      </div>
    </div>

    <div class="row mt-5 pb-5">
      <h2 class="h2 mt-4 mb-4 text-center fw-bold">HAFTANIN FIRSAT ÜRÜNLERİ</h2>
      <?php
        for ($i=1; $i<=4; $i++) {
          $rastgelesayi = rand(1,$tumurunsay);
          $urun = $db->query("SELECT * FROM urunler WHERE id={$rastgelesayi}")->fetch(PDO::FETCH_ASSOC);
          $fiyat = number_format($urun['fiyat'], 0, ',', '.');

          echo '
          <div class="col-6 col-lg-3 d-flex justify-content-center">
            <div class="card index-card" style="width: 90%;">
              <img src="'.$urun['gorsel'].'" class="card-img-top m-auto mt-4 mb-2 w-75">
              <div class="card-body pb-0">
                <h5 class="card-title fs-6">'.$urun['baslik'].'</h5>
                <p class="card-text fs-2 fw-bold mt-3 mb-1">'.$fiyat.' TL</p>
                <a href="urun.php?id='.$urun['id'].'" class="stretched-link"></a>
              </div>
            </div>
          </div>
          ';
        }
      ?>
    </div>
  </div>

<?php
include 'footer.html';

if(isset($_GET['basarili']))
  echo ' <script> alert("Satın alım başarılı. Siparişiniz hazırlanıyor."); </script>';
elseif(isset($_GET['basarisiz']))
  echo ' <script> alert("Siparişiniz alınırken bir sorun oluştu."); </script>';

?>
