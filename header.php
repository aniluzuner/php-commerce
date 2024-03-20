<?php
@session_start();
include 'baglan.php';

$urunsay = $db->query("SELECT id FROM urunler");
$tumurunsay = $urunsay->rowcount();

?>

<!DOCTYPE html>
<html lang="tr">
  <head>
    <title>Php E-Commerce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/bff2903f21.js" crossorigin="anonymous"></script>
  </head>
  <body>

    <nav class="navbar navbar-expand-xl bg-white">
      <div class="container ps-0 py-4">
        <a class="navbar-brand ps-3 ps-lg-0" href="index.php"> <h2 class="display-6 fw-bold lh-sm p-0 m-0"> BRAND LOGO</h2></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <form class="d-inline m-auto search w-50" role="search" action="urunler.php" method="get">
            <div class="d-flex w-100 rounded-4 my-2 my-lg-0">
              <input class="form-control form-control-lg search rounded-0 rounded-start" type="search" placeholder="Ürün, kategori veya marka ara" aria-label="Search" name="ara"></input>
              <button class="btn btn-primary rounded-0 rounded-end px-3" type="submit"><i class="fa-solid fa-magnifying-glass fa-lg"></i></button>
            </div>
          </form>
          <div class="d-flex">
            <?php if (isset($_SESSION['kullanici'])) {
              echo '
                <div class="dropdown me-3 w-50">
                  <button class="btn btn-primary btn-lg dropdown-toggle fw-bold text-capitalize w-100 pe-md-5" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user me-2"></i> '.$_SESSION['kullanici'].' </button>
                  <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">';
              if ($_SESSION['kullanici'] == "admin") {
                echo '<li><a href="urunlerliste.php" class="dropdown-item">Ürünler</a></li>';
                echo '<li><a href="urunekle.php" class="dropdown-item">Ürün Ekle</a></li>';
              }
              echo '
                    <li><a href="islem.php?cikis" class="dropdown-item">Çıkış Yap</a></li>
                  </ul>
                </div>';
            }
            else {
              echo '<a href="giris.php" class="btn btn-primary btn-lg fw-bold d-flex align-items-center me-3 w-50 text-nowrap"><i class="fa-solid fa-user me-2"></i> Giriş Yap</a>';
            }
            ?>
          <a href="sepet.php" class="btn btn-primary btn-lg fw-bold w-50"><i class="fa-solid fa-shopping-cart me-2"></i>Sepetim</a>
          </div>
        </div>
      </div>
    </nav>

    <nav class="navbar navbar-expand-xl renk">
      <div class="container-xxl">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item mx-0 mx-lg-2 mx-xxl-4"> <a class="nav-link d-flex p-1" href="urunler.php?kategori=işlemci"> <img class="my-auto" src="images/icons/cpu.png"> <span class="fs-5 text-white fw-bold ms-2 my-auto"> İşlemci </span> </a> </li>
            <li class="nav-item mx-0 mx-lg-2 mx-xxl-4"> <a class="nav-link d-flex p-1" href="urunler.php?kategori=anakart"> <img class="my-auto" src="images/icons/mb.png"> <span class="fs-5 text-white fw-bold ms-2 my-auto"> Anakart </span> </a> </li>
            <li class="nav-item mx-0 mx-lg-2 mx-xxl-4"> <a class="nav-link d-flex p-1" href="urunler.php?kategori=bellek"> <img class="my-auto" src="images/icons/ram.png"> <span class="fs-5 text-white fw-bold ms-2 my-auto"> Bellek </span> </a> </li>
            <li class="nav-item mx-0 mx-lg-2 mx-xxl-4"> <a class="nav-link d-flex p-1" href="urunler.php?kategori=ekran kartı"> <img class="my-auto" src="images/icons/gpu.png"> <span class="fs-5 text-white fw-bold ms-2 my-auto"> Ekran Kartı </span> </a> </li>
            <li class="nav-item mx-0 mx-lg-2 mx-xxl-4"> <a class="nav-link d-flex p-1" href="urunler.php?kategori=depolama"> <img class="my-auto" src="images/icons/hdd.png"> <span class="fs-5 text-white fw-bold ms-2 my-auto"> Depolama </span> </a> </li>
            <li class="nav-item mx-0 mx-lg-2 mx-xxl-4"> <a class="nav-link d-flex p-1" href="urunler.php?kategori=kasa"> <img class="my-auto" src="images/icons/kasa.png"> <span class="fs-5 text-white fw-bold ms-2 my-auto"> Kasa </span> </a> </li>
            <li class="nav-item mx-0 mx-lg-2 mx-xxl-4"> <a class="nav-link d-flex p-1" href="urunler.php?kategori=güç kaynağı"> <img class="my-auto" src="images/icons/psu.png"> <span class="fs-5 text-white fw-bold ms-2 my-auto"> Güç Kaynağı </span> </a> </li>
          </ul>
        </div>
      </div>
    </nav>
