<?php
include 'header.php';

if (!($_SESSION['kullanici'] == "admin")) {
  header('Location: giris.php');
}

$id = $_GET['id'];

$urungetir = $db->query("SELECT * FROM urunler WHERE id='{$id}'")->fetch(PDO::FETCH_ASSOC);

?>



<div class="container my-5 pt-3 pb-5">
  <?php
    if (isset($_GET['basarili'])) {
      echo '
        <div class="row justify-content-center">
          <div class="col-5 p-0">
            <div class="alert alert-success fw-bold fs-4" role="alert">
              <i class="fa-solid fa-circle-check me-2"></i> Ürün düzenlendi.
            </div>
          </div>
        </div>
      ';
    }
  ?>
  <div class="row pb-5 justify-content-center">
    <div class="col-5 border rounded-4 p-5">
      <h1 class="h1 fw-bold">Ürün Düzenle</h1>
      <form action="islem.php" method="get" autocomplete="off">
        <div class="row mt-4">
          <div class="col-4">
            <label class="form-label ms-1">Kategori</label>
            <select class="form-select" name="kategori" required>
              <option value="İşlemci" <?php echo $urungetir['kategori'] == "işlemci" ? "selected" : ""; ?>>İşlemci</option>
              <option value="Anakart" <?php echo $urungetir['kategori'] == "anakart" ? "selected" : ""; ?>>Anakart</option>
              <option value="Bellek" <?php echo $urungetir['kategori'] == "bellek" ? "selected" : ""; ?>>Bellek</option>
              <option value="Ekran Kartı" <?php echo $urungetir['kategori'] == "ekran kartı" ? "selected" : ""; ?>>Ekran Kartı</option>
              <option value="Depolama" <?php echo $urungetir['kategori'] == "depolama" ? "selected" : ""; ?>>Depolama</option>
              <option value="Kasa" <?php echo $urungetir['kategori'] == "kasa" ? "selected" : ""; ?>>Kasa</option>
              <option value="Güç Kaynağı" <?php echo $urungetir['kategori'] == "gün kaynağı" ? "selected" : ""; ?>>Güç Kaynağı</option>
            </select>
          </div>
          <div class="col-4">
            <label class="form-label ms-1">Marka</label>
            <select class="form-select" name="marka" required>
              <option selected></option>
              <option value="Amd" <?php echo $urungetir['marka'] == "Amd" ? "selected" : ""; ?>>Amd</option>
              <option value="Intel" <?php echo $urungetir['marka'] == "Intel" ? "selected" : ""; ?>>Intel</option>
              <option value="Msi" <?php echo $urungetir['marka'] == "Msi" ? "selected" : ""; ?>>Msi</option>
              <option value="Asus" <?php echo $urungetir['marka'] == "Asus" ? "selected" : ""; ?>>Asus</option>
              <option value="Gigabyte" <?php echo $urungetir['marka'] == "Gigabyte" ? "selected" : ""; ?>>Gigabyte</option>
              <option value="Corsair" <?php echo $urungetir['marka'] == "Corsair" ? "selected" : ""; ?>>Corsair</option>
              <option value="Wd" <?php echo $urungetir['marka'] == "Wd" ? "selected" : ""; ?>>Wd</option>
            </select>
          </div>
          <div class="col-4">
            <label class="form-label ms-1">Model</label>
            <input class="form-control" type="text" name="model" value="<?php echo $urungetir['model']?>">
          </div>
        </div>

        <div class="row mt-4">
          <div class="col">
            <label class="form-label ms-1">Ürün Başlığı</label>
            <input class="form-control" type="text" name="baslik" value="<?php echo $urungetir['baslik']?>">
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-6">
            <label class="form-label ms-1">Fiyat</label>
            <input class="form-control" type="text" name="fiyat" pattern="[0-9]+" value="<?php echo $urungetir['fiyat']?>">
          </div>
          <div class="col-6">
            <label class="form-label ms-1">Stok</label>
            <input class="form-control" type="text" name="stok" pattern="[0-9]+" value="<?php echo $urungetir['stok']?>">
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-12">
            <label class="d-block form-label ms-1">Görsel</label>
            <div class="d-flex justify-content-center">
              <img class="w-75 mx-auto" src="<?php echo $urungetir['gorsel'] ?>" alt="">
            </div>
            

            <p>Görseli değiştirmek istiyorsanız yeni görseli "images/urunler" klasörüne atıp aşağıdan seçin:</p>
            <input class="form-control" type="file" accept="image/png, image/jpg, image/jpeg" name="gorsel">
          </div>
            

        </div>

        <div class="row mt-4">
          <div class="col">
            <label class="form-label ms-1">Özellikler</label>
            <textarea class="form-control" rows="19" name="ozellikler">
  <?php echo $urungetir['ozellikler'] ?>
            </textarea>
          </div>
        </div>

        <input type="hidden" name="id" value="<?php echo $id ?>">
        <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 fw-bold fs-4" name="urunduzenle"> Kaydet </button>
      </form>
    </div>
  </div>
</div>

















<?php
include 'footer.html';
?>
