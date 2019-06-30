<?php
session_start();
require 'script/db.php';
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
  $admin = $_SESSION['adminName'];
  $auth = 1;
} else {
  $auth = 0;
  $admin = "";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Sudo - Volunteer TUHM 2019</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/resume.min.css" rel="stylesheet">



</head>

<body id="page-top">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
    <a class="navbar-brand js-scroll-trigger" href="#page-top">
      <?php
      if ($auth === 1) {
        ?>
        <span class="d-block d-lg-none font-weight-bold">Admin : <?= $admin ?></span>
      <?php
      }
      ?>
      <span class="d-none d-lg-block">
        <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="img/statistics.png" alt="">
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <?php
        if ($auth === 0) {
          ?>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#about">Login</a>
          </li>
        <?php
        }
        if ($auth === 1) {
          ?>
          <li class="nav-item">
            <p class="text-white font-weight-bold">Admin : <?= $admin ?></p>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#experience">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#education">Accepted</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#skills">Rejected</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#interests">Logout</a>
          </li>
        <?php
        }
        ?>
        <li class="nav-item">
          <small class="text-white">&copy; 2019 Nuki Pratama</small>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid p-0">
    <?php
    if ($auth === 0) {
      ?>
      <section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="about">
        <div class="w-100">
          <h1 class="mb-0">Volunteer
            <span class="text-primary">TUHM 2019</span>
          </h1>
          <div class="subheading">Telkom University Half Marathon 2019 Volunteer System
          </div>

          <form class="mt-5 mb-5" action="script/auth.php" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control w-50" name="username" aria-describedby="emailHelp" placeholder="Your Username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control w-50" name="password" placeholder="Your Password" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary w-50 text-white">Login</button>
            </div>
          </form>
          <div class="social-icons">
            <a href="https://www.linkedin.com/in/nukipratama" target="_blank">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://www.github.com/nukipratama" target="_blank">
              <i class="fab fa-github"></i>
            </a>
            <a href="https://www.instagram.com/nukipratama" target="_blank">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>
      </section>
    <?php
    } else {
      ?>
      <hr class="m-0">

      <section class="resume-section p-3 p-lg-5 d-flex justify-content-center" id="experience">
        <div class="w-100">
          <h2 class="mb-5">Dashboard</h2>
          <div class="resume-item d-flex flex-column flex-md-row justify-content-between mb-5">
            <div class="resume-content">
              <h3 class="mb-0 text-primary">Registered Users</h3>
              <div class="subheading mb-3">Unconfirmed Users</div>
              <table id="dashboard" class="table table-striped table-bordered " role="" style="table-layout:auto">
                <thead role="">
                  <tr class="bg-primary text-white text-center" role="row">
                    <th role="">No</th>
                    <th role="">Nama</th>
                    <th role="">NIM</th>
                    <th role="">Jurusan</th>
                    <th role="">Email</th>
                    <th role="">Whatsapp</th>
                    <th role="">Motivasi</th>
                    <th role="">KTM</th>
                    <th role="">Accept</th>
                    <th role="">Reject</th>
                  </tr>
                </thead>
                <tbody role="">
                  <?php
                  $dbQuery = $dbConn->prepare("SELECT * FROM `form_volunteer` WHERE `status` = 0");
                  $dbQuery->execute();
                  $result = $dbQuery->get_result();
                  if ($result->num_rows === 0) {
                    return false;
                  }
                  $count = 0;
                  while ($dbGet = $result->fetch_assoc()) {
                    $count++;
                    ?>
                    <tr class="text-center" role="" style="">
                      <td role=""><?= $count; ?></td>
                      <td role=""><?= $dbGet['nama'] ?></td>
                      <td role=""><?= $dbGet['nim'] ?></td>
                      <td role=""><?= $dbGet['jurusan'] ?></td>
                      <td role=""><?= $dbGet['email'] ?></td>
                      <td role=""><?= $dbGet['nohp'] ?></td>

                      <td><a class="btn btn-dark text-white" data-toggle="modal" data-target="#motivasi<?= $dbGet['nim'] ?>">Motivasi
                      </td>
                      <td><a class="btn btn-dark text-white" data-toggle="modal" data-target="#ktm<?= $dbGet['nim'] ?>">KTM
                      </td>
                      <td role=""><a href="script/accept.php?nim=<?= $dbGet['nim'] ?>" class="btn btn-success">Accept</a></td>
                      <td role=""><a href="script/reject.php?nim=<?= $dbGet['nim'] ?>" class="btn btn-danger">Reject</a></td>
                    </tr>
                    <!-- motivasi modal start -->
                    <div class="modal fade" id="motivasi<?= $dbGet['nim'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Motivasi <?= $dbGet['nama'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="lead text-dark text-justify"><?= $dbGet['motivasi'] ?></p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- motivasi modal end -->
                    <!-- ktm modal start -->
                    <div class="modal fade" id="ktm<?= $dbGet['nim'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">KTM <?= $dbGet['nama'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body bg-primary">
                            <center>
                              <img src="https://localhost/tuhm2019/volunteer/<?= $dbGet['ktm'] ?>" alt="" class="w-100 img-fluid">
                            </center>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- ktm modal end -->

                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>



        </div>

      </section>

      <hr class="m-0">

      <section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="education">
        <div class="w-100">
          <h2 class="mb-5">Accepted</h2>

          <div class="resume-item d-flex flex-column flex-md-row justify-content-between mb-5">
            <div class="resume-content">
              <h3 class="mb-0 text-success">Accepted Volunteers</h3>
              <div class="subheading mb-3">List of Accepted Volunteers</div>
              <table id="accepted" class="table table-striped table-bordered " role="" style="table-layout:auto">
                <thead role="">
                  <tr class="bg-success text-white text-center" role="row">
                    <th role="">No</th>
                    <th role="">Nama</th>
                    <th role="">NIM</th>
                    <th role="">Jurusan</th>
                    <th role="">Email</th>
                    <th role="">Whatsapp</th>
                    <th role="">Motivasi</th>
                    <th role="">KTM</th>
                  </tr>
                </thead>
                <tbody role="">
                  <?php
                  $dbQuery1 = $dbConn->prepare("SELECT * FROM `form_volunteer` WHERE `status` = 1");
                  $dbQuery1->execute();
                  $result1 = $dbQuery1->get_result();
                  if ($result1->num_rows === 0) {
                    return false;
                  }
                  $count1 = 0;
                  while ($dbGet1 = $result1->fetch_assoc()) {
                    $count1++;
                    ?>
                    <tr class="text-center" role="" style="">
                      <td role=""><?= $count1; ?></td>
                      <td role=""><?= $dbGet1['nama'] ?></td>
                      <td role=""><?= $dbGet1['nim'] ?></td>
                      <td role=""><?= $dbGet1['jurusan'] ?></td>
                      <td role=""><?= $dbGet1['email'] ?></td>
                      <td role=""><?= $dbGet1['nohp'] ?></td>

                      <td><a class="btn btn-dark text-white" data-toggle="modal" data-target="#motivasi<?= $dbGet1['nim'] ?>">Motivasi
                      </td>
                      <td><a class="btn btn-dark text-white" data-toggle="modal" data-target="#ktm<?= $dbGet1['nim'] ?>">KTM
                      </td>
                    </tr>
                    <!-- motivasi modal start -->
                    <div class="modal fade" id="motivasi<?= $dbGet1['nim'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Motivasi <?= $dbGet1['nama'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="lead text-dark text-justify"><?= $dbGet1['motivasi'] ?></p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- motivasi modal end -->
                    <!-- ktm modal start -->
                    <div class="modal fade" id="ktm<?= $dbGet1['nim'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">KTM <?= $dbGet1['nama'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body bg-primary">
                            <center>
                              <img src="https://localhost/tuhm2019/volunteer/<?= $dbGet1['ktm'] ?>" alt="" class="w-100 img-fluid">
                            </center>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- ktm modal end -->

                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>



        </div>
      </section>

      <hr class="m-0">

      <section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="skills">
        <div class="w-100">
          <h2 class="mb-5">Rejected</h2>

          <div class="resume-item d-flex flex-column flex-md-row justify-content-between mb-5">
            <div class="resume-content">
              <h3 class="mb-0 text-danger">Rejected Volunteers</h3>
              <div class="subheading mb-3">List of Rejected Volunteers</div>
              <table id="rejected" class="table table-striped table-bordered " role="" style="table-layout:auto">
                <thead role="">
                  <tr class="bg-danger text-white text-center" role="row">
                    <th role="">No</th>
                    <th role="">Nama</th>
                    <th role="">NIM</th>
                    <th role="">Jurusan</th>
                    <th role="">Email</th>
                    <th role="">Whatsapp</th>
                    <th role="">Motivasi</th>
                    <th role="">KTM</th>
                  </tr>
                </thead>
                <tbody role="">
                  <?php
                  $dbQuery2 = $dbConn->prepare("SELECT * FROM `form_volunteer` WHERE `status` = 2");
                  $dbQuery2->execute();
                  $result2 = $dbQuery2->get_result();
                  if ($result2->num_rows === 0) {
                    return false;
                  }
                  $count2 = 0;
                  while ($dbGet2 = $result2->fetch_assoc()) {
                    $count2++;
                    ?>
                    <tr class="text-center" role="" style="">
                      <td role=""><?= $count2; ?></td>
                      <td role=""><?= $dbGet2['nama'] ?></td>
                      <td role=""><?= $dbGet2['nim'] ?></td>
                      <td role=""><?= $dbGet2['jurusan'] ?></td>
                      <td role=""><?= $dbGet2['email'] ?></td>
                      <td role=""><?= $dbGet2['nohp'] ?></td>

                      <td><a class="btn btn-dark text-white" data-toggle="modal" data-target="#motivasi<?= $dbGet2['nim'] ?>">Motivasi
                      </td>
                      <td><a class="btn btn-dark text-white" data-toggle="modal" data-target="#ktm<?= $dbGet2['nim'] ?>">KTM
                      </td>
                    </tr>
                    <!-- motivasi modal start -->
                    <div class="modal fade" id="motivasi<?= $dbGet2['nim'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Motivasi <?= $dbGet2['nama'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p class="lead text-dark"><?= $dbGet2['motivasi'] ?></p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- motivasi modal end -->
                    <!-- ktm modal start -->
                    <div class="modal fade" id="ktm<?= $dbGet2['nim'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">KTM <?= $dbGet2['nama'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body bg-primary">
                            <center>
                              <img src="https://localhost/tuhm2019/volunteer/<?= $dbGet2['ktm'] ?>" alt="" class="w-100 img-fluid">
                            </center>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- ktm modal end -->

                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>



        </div>
      </section>

      <hr class="m-0">

      <section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="interests">
        <div class="w-100">
          <h2 class="mb-5 ">Logout</h2>
          <h3 class="text-danger">End current session?</h3>
          <div class="row">
            <div class="col-sm-3">
              <a href="script/logout.php" class="btn btn-danger w-100 text-white">Yes</a>
            </div>
            <div class="col-sm-3">
              <a href="#experience" class="btn btn-secondary w-100 text-white">No</a>
            </div>
          </div>
        </div>
      </section>


    <?php
    }
    ?>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/resume.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#dashboard').DataTable();
      $('#accepted').DataTable();
      $('#rejected').DataTable();
    });
  </script>

</body>

</html>