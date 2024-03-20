<?php
session_start();
if (!isset($_SESSION['kullanici'])){
  header("Location: giris.php");
}

include 'header.php';




$adet = $_GET['adet'];
$toplamfiyat = $_GET['toplam'];
?>

<form action="islem.php" method="get">


<?php
  foreach ($_COOKIE['sepet'] as $index => $value) {
    echo "<input type='hidden' name='adet[]' value='$adet[$index]'>";
  }
?>
<div class="container my-4 py-4">
  <div class="row justify-content-center mb-5">

    <div class="col-6 border rounded-3 p-5 mt-4">
      <h1 class="h2 fw-bold lh-1 m-0 p-0"> Teslimat Bilgileri</h1>

        <div class="row">
          <div class="col-6 pe-4">
            <label class="form-label mt-3 ms-1">Ad Soyad</label>
            <input class="form-control form-control-lg" type="text" name="">
          </div>
          <div class="col-6 pe-4">
            <label class="form-label mt-3 ms-1">TC Kimlik No</label>
            <input class="form-control form-control-lg" type="text" name="">
          </div>
        </div>

        <div class="row">
          <div class="col-6 pe-4">
            <label class="form-label mt-3 ms-1">E-Mail</label>
            <input class="form-control form-control-lg" type="text" name="">
          </div>
          <div class="col-6 pe-4">
            <label class="form-label mt-3 ms-1">Telefon</label>
            <input class="form-control form-control-lg" type="text" name="">
          </div>
        </div>

        <div class="row">
          <div class="col-6 pe-4">
            <label class="form-label mt-3 ms-1">Şehir</label>
            <select class="form-select form-select-lg">
              <option selected>Şehir Seçiniz</option>
              <?php
                $iller = file_get_contents('iller.json');
                $iller = json_decode($iller, true);

                for ($i=1; $i<=81; $i++){
                  echo "<option value=$i>$iller[$i]</option>";
                }
              ?>
            </select>
          </div>
          <div class="col-6 pe-4">
            <label class="form-label mt-3 ms-1">İlçe</label>
            <select class="form-select form-select-lg" disabled>
              <option selected>İlçe Seçiniz</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-12 pe-4">
            <label class="form-label mt-3 ms-1">Adres</label>
            <textarea class="form-control form-select-lg" name="" rows="3"></textarea>
          </div>
        </div>

      <h1 class="h2 fw-bold mt-5"> Ödeme Bilgileri </h1>

      <div class="row">
        <div class="col-6 pe-4">
          <label class="form-label mt-3 ms-1">Kart Numarası</label>
          <input class="form-control form-control-lg" type="text" name="" disabled>
        </div>
        <div class="col-6 pe-4">
          <label class="form-label mt-3 ms-1">Kart Üzerindeki İsim</label>
          <input class="form-control form-control-lg" type="text" name="" disabled>
        </div>
      </div>

      <div class="row">
        <div class="col-6 pe-4">
          <label class="form-label mt-3 ms-1">Son Kullanma Tarihi</label>
          <input class="form-control form-control-lg" type="text" name="" disabled>
        </div>
        <div class="col-6 pe-4">
          <label class="form-label mt-3 ms-1">Güvenlik Kodu (CVC)</label>
          <input class="form-control form-control-lg" type="text" name="" disabled>
        </div>
      </div>

    </div>

    <div class="col-3">
      <div class="sticky-top pt-4">
      <div class="row justify-content-end">
        <div class="col-9 p-4 border rounded-3 sticky-top">
          <p class="fs-5 fw-bold lh-1 text-primary">ÖDENECEK TUTAR</p>
          <p class="fs-1 fw-bold"><?php echo number_format($toplamfiyat, 0, ',', '.'); ?> TL</p>
          <button class="btn btn-primary btn-lg w-100 rounded-3 fw-bold" type="submit" name="satinal"> Ödeme Yap </button>
        </div>
      </div>
      </div>
    </div>

  </div>
</div>

</form>






<?php include 'footer.html'; ?>
