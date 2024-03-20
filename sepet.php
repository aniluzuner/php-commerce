<?php
include 'header.php';

$urunsayisi = 0;
$toplamfiyat = 0;

if (isset($_COOKIE['sepet'])){
  foreach ($_COOKIE['sepet'] as $index => $value) {
    $urungetir[$index] = $db->query("SELECT * FROM urunler WHERE id='{$value}'")->fetch(PDO::FETCH_ASSOC);

    $urunsayisi++;

    $toplamfiyat += $urungetir[$index]['fiyat'];
  }
}
?>

<span id="urunsayisi" hidden><?php echo $urunsayisi ?></span>
<span id="ilkfiyat" hidden><?php echo $toplamfiyat ?></span>


<?php if (isset($_COOKIE['sepet'])){ ?>



<form action="odeme.php" method="get">

<div class="container my-3 py-5">
  <div class="row">
    <div class="col-12 col-lg-9 p-0">
      <h1 class="h1 display-5 m-auto fw-bold mb-5 d-flex lh-1" style="width: 80%;">Sepetim <a href="islem.php?sepetbosalt" class="text-decoration-none text-dark fs-5 fw-bold ms-auto me-1 my-auto lh-1" style=""> SEPETİ BOŞALT <i class="fa-solid fa-trash-can ms-1"></i></a> </h1>
    </div>

    <div class="col-12 col-lg-9 p-0">

      <?php
      foreach ($_COOKIE['sepet'] as $index => $value) {

        $fiyat = number_format($urungetir[$index]['fiyat'], 0, ',', '.');
        echo '
        <div class="card mb-4 mx-auto" style="width: 80%;">
          <div class="row g-0">
            <div class="col-md-3 d-flex">
              <img src="'.$urungetir[$index]['gorsel'].'" class="img-fluid rounded-start m-auto" style="width: 70%;">
            </div>
            <div class="col-md-7">
              <div class="card-body">
                <h5 class="card-title mt-3">'.$urungetir[$index]['baslik'].'</h5>
                <p class="fs-2 mt-4 fw-bold lh-1">'.$fiyat.' TL</p>
              </div>
            </div>
            <div class="col-md-2 pt-4" style="z-index: 2;">
              <input class="form-control mx-auto mt-2 fs-5" id="adet['.$index.']" onmouseup="fonk('.$index.','.$urungetir[$index]['fiyat'].')" type="number" name="adet['.$index.']" min="1" max="'.$urungetir[$index]['stok'].'" value="1" step="1" style="height: 40px; width: 70px;">
              <a href="islem.php?sepetsil='.$index.'" class="w-100 fs-2 mt-4 d-flex text-black"><i class="fa-solid fa-trash-can mt-1 mx-auto"></i></a>
            </div>
          </div>
          <a href="urun.php?id='.$urungetir[$index]['id'].'" class="stretched-link"></a>
        </div>
        ';
      }
      ?>
    </div>



    <div class="col-12 col-lg-3">
      <div class="row">
        <div class="col-12 col-lg-10 p-4 border rounded-3" style="border-color: rgb(0 0 0 / 18%) !important;">
          <p class="fs-5 fw-bold lh-1 text-primary">SEPET TOPLAM (<?php echo $urunsayisi; ?>)</p>
          <p class="fs-1 fw-bold" id="toplamfiyat"></p>

          <script>

            var toplamfiyat = parseInt(document.getElementById("ilkfiyat").innerHTML);

            if(toplamfiyat % 1000 == 0)
              fiyatyazdir = (toplamfiyat / 1000) + ".000";
            else if(toplamfiyat > 1000)
              fiyatyazdir = parseInt(toplamfiyat / 1000) + "." + (toplamfiyat % (parseInt(toplamfiyat / 1000) * 1000));

            document.getElementById("toplamfiyat").innerHTML = fiyatyazdir + " TL";

            var urunsayisi = parseInt(document.getElementById("urunsayisi").innerHTML);
            var sonadet = [];

            for (var i = 0; i < urunsayisi; i++) {
              sonadet[i] = 1;
            }

            var fiyatyazdir;

            function fonk(index,fiyat){
              var adet = document.getElementById(`adet[${index}]`).value;

              if (adet > sonadet[index]) {
                toplamfiyat += fiyat;
                sonadet[index]++;
              }
              else if (adet < sonadet[index]) {
                toplamfiyat -= fiyat;
                sonadet[index]--;
              }

              if(toplamfiyat % 1000 == 0)
                fiyatyazdir = (toplamfiyat / 1000) + ".000";
              else if(toplamfiyat > 1000)
                fiyatyazdir = parseInt(toplamfiyat / 1000) + "." + (toplamfiyat % (parseInt(toplamfiyat / 1000) * 1000));

              document.getElementById("toplamfiyat").innerHTML = fiyatyazdir + " TL";
            }

          </script>

          <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3" name="toplam" value="<?php echo $toplamfiyat; ?>">Alışverişi Tamamla</a>

        </div>
      </div>

    </div>
  </div>
</div>

</form>

<?php } else { ?>

<div class="container my-4 py-4">
  <div class="row my-4 py-5 justify-content-center">
    <div class="col-5">
      <div class="alert align-items-center p-5" role="alert" style="background-color: #F0F0F3; box-shadow: 0px 0px 3px 3px #e9ecef;">
        <div class="d-flex justify-content-center">
          <i class="fa-solid fa-cart-shopping fa-7x"></i>
        </div>
        <h2 class="fs-4 text-center mt-5 fw-bold"> SEPETİNİZDE ÜRÜN YOK </h2>
        <div class="d-flex justify-content-center mt-4">
          <a href="index.php" class="btn btn-outline-dark border border-dark border-3 py-2 px-4 fs-5 fw-bold">ALIŞVERİŞE DEVAM ET</a>
        </div>
      </div>
    </div>
  </div>
</div>


<?php } ?>



<?php include 'footer.html' ?>
