<?php
session_start();
if (isset($_SESSION['auth'])) {
    $peserta_status = 'active';
} else {
    header("Location:login");
}
include 'page_header.php';

if (isset($_GET['bid'])) {
    $bookid = $_GET['bid']; ?>
<div id="content-wrapper">
    <div class="container-fluid">

        <div class="card mb-3 text-center">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Book Details</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                               <th>No</th>
                                <th>UID</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Gender</th>
                                <th>Penyakit</th>
                                 <th>No ID</th>
                                <th>Foto ID</th>
                                <th>Komunitas</th>
                                <th>BID</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>UID</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Gender</th>
                                <th>Penyakit</th>
                                 <th>No ID</th>
                                <th>Foto ID</th>
                                <th>Komunitas</th>
                                <th>BID</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            <?php for ($key = 0; $key < count(checkUser($bookid)['uid']); $key++) {
        $check = checkUser($bookid); ?>
                            <tr>
                                <td><?=($key + 1)?></td>
                                <td><?=$check['uid'][$key]?></td>
                                <td><?=$check['nama'][$key]?></td>
                                <td><?=$check['umur'][$key]?></td>
                                <td><?=$check['email'][$key]?></td>
                                <td><?=$check['alamat'][$key]?></td>
                                <td><?=$check['nohp'][$key]?></td>
                                <td><?=$check['gender'][$key]?></td>
                                <td><?=$check['medical'][$key]?></td>
                                <td><?=$check['identity'][$key]?></td>
                                <td><a class="btn btn-primary" target="_blank"
                                        href="https://telkomuniversityrun.com/<?=$check['foto_identitas'][$key]?>">Click
                                </td>
                                <td><?=$check['community'][$key]?></td>
                                <td><?=$check['bid'][$key]?></td>
                            </tr>
                            <?php
    } ?>
                        </tbody>
                    </table>
                </div>
            </div>




        </div>
    </div>
    <?php
include 'page_footer.php';
} else {
    ?>
    <script>
    var check = prompt("Please enter BID number below");
    if (check != '') {
        window.location = "peserta?bid=" + check;
    } else {
        alert('Wrong BID!');
        window.location = "confirmation";
    }
    </script>
    <?php
}

function checkUser($bookid)
{
    require 'script/db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_users WHERE bid = ?");
        $dbQuery->bind_param("s", $bookid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
        $key = 0;
        while ($dbGet = $result->fetch_assoc()) {
            $array['uid'][$key] = $dbGet['uid'];
            $array['nama'][$key] = $dbGet['nama'];
            $array['umur'][$key] = $dbGet['umur'];
            $array['medical'][$key] = $dbGet['medical'];
            $array['identity'][$key] = $dbGet['identity'];
            $array['foto_identitas'][$key] = $dbGet['foto_identitas'];
            $array['bid'][$key] = $dbGet['bid'];
            $array['email'][$key] = $dbGet['email'];
            $array['alamat'][$key] = $dbGet['alamat'];
            $array['nohp'][$key] = $dbGet['nohp'];
            $array['gender'][$key] = $dbGet['gender'];
            $array['community'][$key] = $dbGet['community'];
            $key++;
        }
        $dbQuery->close();
        return $array;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}