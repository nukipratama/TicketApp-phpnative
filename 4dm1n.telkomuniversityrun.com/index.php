<?php
session_start();
if (isset($_SESSION['auth'])) {
    $dash_status = 'active';
} else {
    header("Location:login");
}
include 'page_header.php';
// $uploadBook = count(book()['upload']) - count(book()['paid']);
if (isset(book()['paid'])) {
    $paid_book = count(book()['paid']);
} else {
    $paid_book = 0;
    // unconfirmed()['bid'][0] = 0;
}
$expiredBook = 0;
$totalIncome = 0;
for ($key = 0; $key < count(book()['tanggal']); $key++) {
    $book_time = date('d-m-Y H:i:s', strtotime(book()['tanggal'][$key] . '+ 1 days'));
    $current_time = date('d-m-Y H:i:s');
    $book_time = strtotime($book_time);
    $current_time = strtotime($current_time);
    
    if (book()['paid_status'][$key] == 1) {
        $totalIncome += book()['harga_book'][$key];
    }else{
        if ($book_time < $current_time) {
        $expiredBook++;
    }
    }
}
function user()
{
    require 'script/db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_users INNER JOIN tuhm_book ON tuhm_users.bid=tuhm_book.bid WHERE tuhm_book.paid_status = 1");
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

        return $array;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}
function book()
{
    require 'script/db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_book");
        // $dbQuery->bind_param($foto_invoice);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
        $key = 0;

        while ($dbGet = $result->fetch_assoc()) {
            $array['foto_invoice'][$key] = $dbGet['foto_invoice'];
            $array['paid_status'][$key] = $dbGet['paid_status'];
            $array['tanggal'][$key] = $dbGet['tanggal'];
            $array['harga_book'][$key] = (int) $dbGet['harga_pcs'] * (int) $dbGet['jumlah'];
            if (null !== $dbGet['foto_invoice']) {
                $array['upload'][$key] = $dbGet['foto_invoice'];
                if (0 === $dbGet['paid_status']) {
                    $array['paid'][$key] = $dbGet['paid_status'];
                }
            }

            $key++;
        }

        return $array;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}

?>
<div id="content-wrapper">

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="dashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-list"></i>
                        </div>
                        <div class="mr-5"><?=$paid_book?> Unconfirmed Book!</div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-shopping-cart"></i>
                        </div>
                        <div class="mr-5"><?='Total
                                    Income Rp ' . number_format($totalIncome * 1000, 2, ',', '.') . ';'?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-trash-alt"></i>
                        </div>
                        <div class="mr-5"><?=$expiredBook?> Expired / Declined Book!</div>

                    </div>

                </div>
            </div>

        </div>



        <!-- DataTables Example -->
        <div class="card mb-3 text-center">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Paid User List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No BIB</th>
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
                                <th>No BIB</th>
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

                            <?php for ($key = 0; $key < count(user()['uid']); $key++) {
    ?>
                            <tr>
                                 <td><?=($key + 1)?></td>
                                <td><?=user()['uid'][$key]?></td>
                                <td><?=user()['nama'][$key]?></td>
                                <td><?=user()['umur'][$key]?></td>
                                <td><?=user()['email'][$key]?></td>
                                <td><?=user()['alamat'][$key]?></td>
                                <td><?=user()['nohp'][$key]?></td>
                                <td><?=user()['gender'][$key]?></td>
                                <td><?=user()['medical'][$key]?></td>
                                <td><?=user()['identity'][$key]?></td>
                                <td><a class="btn btn-primary" target="_blank"
                                        href="https://telkomuniversityrun.com/<?=user()['foto_identitas'][$key]?>">Click
                                </td>
                                <td><?=user()['community'][$key]?></td>
                                <td><?=user()['bid'][$key]?></td>
                            </tr>
                            <?php
}?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <?php
include 'page_footer.php';
?>