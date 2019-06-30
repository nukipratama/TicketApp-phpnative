<?php
date_default_timezone_set("Asia/Bangkok");
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Language" content="id">
  <meta name="author" content="Nuki Pratama(Full Stack) : https://github.com/nukipratama">
  <meta name="author2" content="Dzul Wulan(UI) : https://github.com/dzulwulan">
  <meta name="description" content="Tel-U Half Marathon 2019 Registration System">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <link rel="shortcut icon" href="../asset/img/LOGO-new.png">
  <title>Volunteer Registration Form</title>

  <!-- Google Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

  <!-- Bootstrap CSS File -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- Libraries CSS Files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css">
  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">

</head>

<body>
  <div id="preloader"></div>
  <!--==========================
  Header Section
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <a class="text-white" href="https://telkomuniversityrun.com">
          <h5 class="font-weight-bold text-white"><img src="../asset/img/LOGO-new.png" alt="" title="" /> Volunteer TUHM 2019</h5>
        </a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu ">
          <li class="menu-active"><a class="font-weight-bold" href="./#hero">Home</a></li>
          <li><a class="font-weight-bold" href="./#a">Information</a></li>
          <li><a class="font-weight-bold" href="./#b">Terms & Condition</a></li>
          <li><a class="font-weight-bold" href="./#c">Benefits</a></li>
          <li><a class="font-weight-bold" href="./#contact">Contact</a></li>
          <li><a class="font-weight-bold btn btn-dark rounded-0" href="register">Registration</a></li>
          <li></li>
        </ul>
      </nav>
      <!-- #nav-menu-container -->
    </div>
  </header>
  <!-- #header -->


  <!--==========================
  Contact Section
  ============================-->
  <section id="contact" class="mb-2">
    <section id="subscribe">
      <div class="container wow fadeInUp">
        <div class="row">
          <div class="col-md-8">
            <h3 class="subscribe-title">Ikuti Kami!</h3>
            <p class="subscribe-text">Ikuti Instagram Telkom University Run sebagai bentuk dukungan terhadap kesuksesan Telkom University Half Marathon 2019.</p>
          </div>
          <div class="col-md-4 subscribe-btn-container">
            <a class="subscribe-btn" target="_blank" href="https://www.instagram.com/telkomuniversityrun/">Ikuti @telkomuniversityrun</a>
          </div>
        </div>
      </div>
    </section>

    <div class="mt-5 container wow fadeInUp">

      <div class="row justify-content-center">
        <div class="col-md-12">
          <h3 class="section-title">Formulir Pendaftaran</h3>
          <div class="section-title-divider"></div>
          <p class="section-description">Silahkan isi data sesuai data diri.<br>Data yang tidak relevan / tidak sesuai dengan persyaratan akan dibatalkan secara otomatis.</p>
        </div>
      </div>

      <div class="row  justify-content-center">
        <div class="col-md-5 col-md-push-2">
          <div class="info">
            <div>
              <i class="fa fa-map-marker"></i>
              <p>Telkom University<br>Jl. Telekomunikasi, No.1</p>
            </div>

            <div>
              <i class="fa fa-envelope"></i>
              <p>volunteer@telkomuniversityrun.com</p>
            </div>

            <div>
              <i class="fa fa-phone"></i>
              <p>+62 812 3456 789</p>
            </div>

          </div>
        </div>

        <div class="col-md-5 col-md-push-2">
          <div class="form">
            <div id="sendmessage">Pesan telah terkirim. Kami akan segera menghubungi anda, Terima Kasih!</div>
            <div id="errormessage">Test</div>
            <form action="script/script_getdata.php" method="post" role="form" class="contactForm" enctype="multipart/form-data">
              <div class="form-group">
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Please enter a valid email" required>
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <input type="text" name="jurusan" class="form-control" id="jurusan" placeholder="Jurusan" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required>
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <input type="number" class="form-control" name="nohp" id="nohp" placeholder="Nomor Handphone (Whatsapp)" data-rule="minlen:10" data-msg="Please enter at least 10 chars of Phone Number" required>
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <input type="number" class="form-control" name="nim" id="nim" placeholder="Nomor Induk Mahasiswa (NIM)" data-rule="minlen:10" data-msg="Please enter at least 10 chars of NIM" required>
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="motivasi" id="motivasi" rows="5" data-rule="required" data-msg="Motivasi" placeholder="Alasan mengikuti Volunteer Telkom University Half Marathon 2019" required></textarea>
                <div class="validation"></div>
              </div>

              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Upload KTM</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="ktm" name="ktm" required>
                    <label class="custom-file-label" for="ktm">Pilih File..</label>
                  </div>
                </div>
                <div class="validation"></div>
              </div>
              <p class="muted text-justify">Dengan menekan tombol Submit Form, anda telah menyetujui <a href="./#b">Syarat dan Ketentuan</a> sebagai Volunteer <b>Telkom University Half Marathon 2019</b>.</p>
              <div class="text-center"><button type="submit">Submit Form</button></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--==========================
  Footer
============================-->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="copyright">
            &copy; 2019 <strong>Telkom University Run</strong>. All Rights Reserved
          </div>
          <div class="credits">
            Designed by <a href="https://telkomuniversityrun.com/">telkomuniversityrun.com</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- Required JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/superfish/hoverIntent.js"></script>
  <script src="lib/superfish/superfish.min.js"></script>
  <script src="lib/morphext/morphext.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/stickyjs/sticky.js"></script>
  <script src="lib/easing/easing.js"></script>

  <!-- Template Specisifc Custom Javascript File -->
  <script src="js/custom.js"></script>

  <!-- <script src="contactform/contactform.js"></script> -->


</body>

</html>