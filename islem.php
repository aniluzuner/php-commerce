<?php

session_start();

include 'baglan.php';

//KAYIT İŞLEMLERİ

if(isset($_POST['kayit'])){
  $ad = $_POST['ad'];
  $soyad = $_POST['soyad'];
  $email = $_POST['email'];
  $sifre = $_POST['sifre'];

  $sorgu = $db->prepare('INSERT INTO musteri SET
    ad = ?,
    soyad = ?,
    email = ?,
    sifre = ?
  ');

  $sorgu->execute([$ad, $soyad, $email, $sifre]);

  header('Location: giris.php');
}


//GİRİŞ KONTROL

if(isset($_POST['giris'])){
  $email = $_POST['email'];
  $sifre = $_POST['sifre'];

  $mustericek = $db->prepare('SELECT * FROM musteri WHERE email=:email and sifre=:sifre');

  $mustericek->execute([
    'email' => $email,
    'sifre' => $sifre
  ]);


  $say = $mustericek->rowCount();

  if($say){
    $musteriveri = $mustericek->fetch(PDO::FETCH_ASSOC);

    if ($musteriveri['ad'] == "admin") {
      $_SESSION['kullanici'] = "admin";
      header('Location: urunekle.php');
    }
    else {
      $_SESSION['kullanici'] = $musteriveri['ad']." ".$musteriveri['soyad'];
      header('Location: index.php');
    }
  }
  else {
    header('Location: giris.php?hata');
  }
}


//SEPETE ÜRÜN EKLE

if(isset($_GET['sepetekle'])){
  $urunid = $_GET['sepetekle'];

  if (isset($_COOKIE['sepet'])) {
      foreach ($_COOKIE['sepet'] as $index => $value) {
          $sayi = $index + 1;
      }
      setcookie("sepet[$sayi]",$urunid,time()+3600);
      header("Location: urun.php?id=$urunid");
  }
  else {
    setcookie("sepet[0]",$urunid,time()+3600);
    header("Location: urun.php?id=$urunid");
  }
}

//SEPETTEN ÜRÜN SİL

if(isset($_GET['sepetsil'])){
  $urunindex = $_GET['sepetsil'];
  setcookie("sepet[$urunindex]","",time()-1);
  header("Location: sepet.php");
}

//SEPETİ BOŞALT

if(isset($_GET['sepetbosalt'])){
  foreach ($_COOKIE['sepet'] as $index => $value) {
    setcookie("sepet[$index]","",time()-1);
  }
  header("Location: sepet.php");
}

//ÜRÜN EKLE

if (isset($_GET['urunekle'])) {
  $kategori = $_GET['kategori'];
  $marka = $_GET['marka'];
  $model = $_GET['model'];
  $baslik = $_GET['baslik'];
  $fiyat = $_GET['fiyat'];
  $stok = $_GET['stok'];
  $gorsel = "images/urunler/".$_GET['gorsel'];
  $ozellikler = $_GET['ozellikler'];

  $sorgu = $db->prepare("INSERT INTO `urunler` (`kategori`, `marka`, `model`, `baslik`, `fiyat`, `stok`, `gorsel`, `ozellikler`) VALUES (?,?,?,?,?,?,?,?); ");

  $sorgu->execute([$kategori, $marka, $model, $baslik, $fiyat, $stok, $gorsel, $ozellikler]);

  if ($sorgu) {
    header("Location: urunekle.php?basarili");
  }
}

//SATIN ALIM

if(isset($_GET['satinal'])) {
  $adet = $_GET['adet'];

  foreach ($_COOKIE['sepet'] as $index => $value) {
    $urun = $db->query("SELECT stok FROM urunler WHERE id='{$value}'")->fetch(PDO::FETCH_ASSOC);

    $yenistok = $urun['stok'] - $adet[$index];

    $stok_guncelle = $db->query("UPDATE urunler SET stok = {$yenistok} WHERE id='{$value}'");

    setcookie("sepet[$index]","",time()-1);
  }

  if ($stok_guncelle) {
    header("Location: index.php?basarili");
  }
  else {
    header("Location: index.php?basarisiz");
  }

}

if(isset($_GET['urunduzenle'])){
  
  $id = $_GET['id'];
  $kategori = $_GET['kategori'];
  $marka = $_GET['marka'];
  $model = $_GET['model'];
  $baslik = $_GET['baslik'];
  $fiyat = $_GET['fiyat'];
  $stok = $_GET['stok'];
  $gorsel = $_GET['gorsel'];
  $ozellikler = $_GET['ozellikler'];
  

  $sorgu = $db->prepare("UPDATE urunler SET kategori=?, marka=?, model=?, baslik=?, fiyat=?, stok=?, ozellikler=? WHERE id={$id};");

  $sorgu->execute([$kategori, $marka, $model, $baslik, $fiyat, $stok, $ozellikler]);

  if($gorsel != NULL){
    $gorsel = "images/urunler/".$gorsel;

    $db->query("UPDATE urunler SET gorsel='{$gorsel}' WHERE id='{$id}'");
  }

    
  if ($sorgu) {
    header("Location: urunduzenle.php?basarili&id=$id");
  }
  
}

if(isset($_GET['urunsil'])){
  $id = $_GET['id'];

  $db->query("DELETE FROM urunler WHERE id='{$id}'");

  header("Location: urunlerliste.php");
}


//ÇIKIŞ YAP

if(isset($_GET['cikis'])){
  session_destroy();

  header('Location: index.php');
}






















?>
