<?php
session_start();
if (!($_SESSION['kullanici'] == "admin")) {
  header('Location: giris.php');
}


include 'header.php';
?>



<div class="container my-5 pt-3 pb-5">
  <?php
    if (isset($_GET['basarili'])) {
      echo '
        <div class="row justify-content-center">
          <div class="col-5 p-0">
            <div class="alert alert-success fw-bold fs-4" role="alert">
              <i class="fa-solid fa-circle-check me-2"></i> Ürün ekleme başarılı.
            </div>
          </div>
        </div>
      ';
    }
  ?>
  <div class="row pb-5 justify-content-center">
    <div class="col-5 border rounded-4 p-5">
      <h1 class="h1 fw-bold">Ürün Ekle</h1>
      <form action="islem.php" method="get" autocomplete="off">
        <div class="row mt-4">
          <div class="col-4">
            <label class="form-label ms-1">Kategori</label>
            <select class="form-select" name="kategori" required>
              <option selected></option>
              <option value="İşlemci">İşlemci</option>
              <option value="Anakart">Anakart</option>
              <option value="Bellek">Bellek</option>
              <option value="Ekran Kartı">Ekran Kartı</option>
              <option value="Depolama">Depolama</option>
              <option value="Kasa">Kasa</option>
              <option value="Güç Kaynağı">Güç Kaynağı</option>
            </select>
          </div>
          <div class="col-4">
            <label class="form-label ms-1">Marka</label>
            <select class="form-select" name="marka" required>
              <option selected></option>
              <option value="Amd">Amd</option>
              <option value="Intel">Intel</option>
              <option value="Msi">Msi</option>
              <option value="Asus">Asus</option>
              <option value="Gigabyte">Gigabyte</option>
              <option value="Corsair">Corsair</option>
              <option value="Wd">Wd</option>
            </select>
          </div>
          <div class="col-4">
            <label class="form-label ms-1">Model</label>
            <input class="form-control" type="text" name="model" required>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col">
            <label class="form-label ms-1">Ürün Başlığı</label>
            <input class="form-control" type="text" name="baslik" required>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-6">
            <label class="form-label ms-1">Fiyat</label>
            <input class="form-control" type="text" name="fiyat" pattern="[0-9]+" required>
          </div>
          <div class="col-6">
            <label class="form-label ms-1">Stok</label>
            <input class="form-control" type="text" name="stok" pattern="[0-9]+" required>
          </div>
          <div class="col-12">
            <label class="form-label ms-1">Görsel</label>
            <p>Ürün görselini "images/urunler" klasörüne atıp aşağıdan seçin: </p>
            <input class="form-control" type="file" accept="image/png, image/jpg, image/jpeg" name="gorsel" required>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col">
            <label class="form-label ms-1">Özellikler</label>
            <textarea class="form-control" rows="19" name="ozellikler">

  <table class="urun-table">
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
  </table>

  </div><div class="col-6 pe-4">

  <table class="urun-table">
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
    <tr> <td>İşlemci Serisi:</td> <td>Msi Anakart</td> </tr>
  </table>
            </textarea>
          </div>
        </div>

        <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 fw-bold fs-4" name="urunekle"> Ürün Ekle </button>
      </form>
    </div>
  </div>
</div>

















<?php
include 'footer.html';
?>
