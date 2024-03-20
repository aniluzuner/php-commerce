<?php include 'header.php' ?>

<div class="container my-5 py-5">
  <div class="row mb-5 justify-content-center">
    <div class="col-4">


      <div class="tab-content p-5 border border-3 rounded rounded-4" id="nav-tabContent">

        <nav>
          <div class="nav nav-tabs justify-content-center mb-4" id="nav-tab" role="tablist">
            <button class="nav-link w-50 text-black fs-5 py-3 fw-bold active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Giriş Yap</button>
            <button class="nav-link w-50 text-black fs-5 py-3 fw-bold" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Kayıt Ol</button>
          </div>
        </nav>

        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
          <form action="islem.php" method="post" autocomplete="off">

            <?php
              if(isset($_GET['hata'])){
                echo '
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                  <i class="fa-solid fa-triangle-exclamation fa-xl"></i>
                  <div class="ms-3">
                    E-posta veya şifre hatalı!
                  </div>
                </div>';
              }
            ?>

            <label class="form-label mt-2 ms-1">E-posta</label>
            <input class="form-control form-control-lg" type="email" name="email" maxlength="30" required>

            <label class="form-label mt-4 ms-1">Şifre</label>
            <input class="form-control form-control-lg" type="password" name="sifre" maxlength="20" required>
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary btn-lg mt-2 fs-5 rounded-4 fw-bold" name="giris">Giriş Yap</button>
            </div>
          </form>
        </div>

        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
          <form action="islem.php" method="post" autocomplete="off">
            <div class="row pt-3">
              <div class="col-6">
                <label class="form-label ms-1">Ad</label>
                <input class="form-control form-control-lg" type="text" name="ad" maxlength="20" required>
              </div>
              <div class="col-6">
                <label class="form-label ms-1">Soyad</label>
                <input class="form-control form-control-lg" type="text" name="soyad" maxlength="20" required>
              </div>
            </div>

            <label class="form-label mt-4 ms-1">E-posta </label>
            <input class="form-control form-control-lg" type="email" name="email" maxlength="30" required>

            <label class="form-label mt-4 ms-1">Şifre</label>
            <input class="form-control form-control-lg" type="password" name="sifre" maxlength="20" required>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary btn-lg mt-2 fs-5 rounded-4 fw-bold" name="kayit">Kayıt Ol</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>



<?php include 'footer.html' ?>
