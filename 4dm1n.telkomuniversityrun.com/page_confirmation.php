<?php
session_start();
if (isset($_SESSION['auth'])) {
    $confirmation_status = 'active';
} else {
    header("Location:login");
}
function harga($harga_pcs, $jumlah, $no)
{
    $harga = ($harga_pcs * $jumlah * 1000) + $no;
    $harga = (int) $harga;
    $harga = 'Rp ' . number_format($harga, 0, ".", ".");
    // $harga = money_format('%.0n', $harga);
    return $harga;
}
include 'page_header.php';
// $uploadBook = count(book()['upload']) - count(book()['paid']);
if (isset(book()['paid']) && isset(unconfirmed()['bid'])) {
    $paid_book = count(book()['paid']);
    $count_bid = count(unconfirmed()['bid']);
} else {
    $paid_book = 0;
    $count_bid = 0;
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
    } else {
        if ($book_time < $current_time) {
            $expiredBook++;
        }
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
                Unconfirmed List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" valign="middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>BID</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th>Tagihan</th>
                                <th>Jumlah</th>
                                <th>Book Email</th>
                                <th>Invoice</th>
                                <th>Expired Date</th>
                                <th>Details</th>
                                <th>Accept</th>
                                <th>Decline</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>BID</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th>Tagihan</th>
                                <th>Jumlah</th>
                                <th>Book Email</th>
                                <th>Invoice</th>
                                <th>Expired Date</th>
                                <th>Details</th>
                                <th>Accept</th>
                                <th>Decline</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            <?php
for ($key = 0; $key < $count_bid; $key++) {
    ?>
                            <tr>
                                <td><?=($key + 1)?></td>
                                <td><?=unconfirmed()['bid'][$key]?></td>
                                <td><?=unconfirmed()['jenis'][$key]?></td>
                                <td><?=unconfirmed()['kategori'][$key]?></td>
                                <td><?=harga(unconfirmed()['harga_pcs'][$key], unconfirmed()['jumlah'][$key], unconfirmed()['no'][$key])?>
                                </td>
                                <td><?=unconfirmed()['jumlah'][$key]?></td>
                                <td><?=unconfirmed()['book_email'][$key]?></td>
                                <td><a class="btn btn-dark text-white" data-toggle="modal"
                                        data-target="#<?=unconfirmed()['bid'][$key]?>">Invoice
                                </td>


                                <div class="modal fade" id="<?=unconfirmed()['bid'][$key]?>" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Invoice Details</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="https://telkomuniversityrun.com/<?=unconfirmed()['foto_invoice'][$key]?>"
                                                    alt="" class="w-100 img-fluid">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <td><?=unconfirmed()['tanggal'][$key]?></td>

                                <td><a target="_blank" class="btn btn-secondary text-white"
                                        href="peserta?bid=<?=unconfirmed()['bid'][$key]?>">Details
                                </td>
                                <td><a class="btn btn-success text-white" data-toggle="modal"
                                        data-target="#accept<?=unconfirmed()['bid'][$key]?>"><i
                                            class="far fa-fw fa-check-circle"></i>Accept
                                </td>

                                <div class="modal fade" id="accept<?=unconfirmed()['bid'][$key]?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-white bg-success">
                                                <h5 class="modal-title " id="exampleModalLongTitle">Action
                                                    Confirmation -
                                                    ACCEPT</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h1><i class="fas fa-fw fa-exclamation-circle text-success"></i></h1>
                                                <h4 class="">DOING THIS ACTION WILL ACCEPT BOOK ID BELOW
                                                    <hr><b><?=unconfirmed()['bid'][$key]?></b>
                                                    <hr>
                                                </h4>
                                                <h5>Make sure you've done double check Book and Invoice Details</h5>
                                                <h5>Are you sure?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <b><a href="accept?bid=<?=unconfirmed()['bid'][$key]?>"
                                                        class="btn btn-success">ACCEPT</a>
                                                </b> </div>
                                        </div>
                                    </div>
                                </div>

                                <td><a class="btn btn-danger text-white" data-toggle="modal"
                                        data-target="#decline<?=unconfirmed()['bid'][$key]?>"><i
                                            class="far fa-fw fa-times-circle"></i>Decline
                                </td>

                                <div class="modal fade" id="decline<?=unconfirmed()['bid'][$key]?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-white bg-danger">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Action Confirmation -
                                                    DECLINE
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h1><i class="fas fa-fw fa-exclamation-circle text-danger"></i></h1>
                                                <h4 class="">DOING THIS ACTION WILL DECLINE BOOK ID BELOW
                                                    <hr><b class="text-danger"><?=unconfirmed()['bid'][$key]?></b>
                                                    <hr>
                                                </h4>
                                                <h5>Make sure you've done double check Book and Invoice Details</h5>
                                                <h5>Are you sure?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <b> <a href="decline?bid=<?=unconfirmed()['bid'][$key]?>"
                                                        class="btn btn-danger">DECLINE</a>

                                                </b> </div>
                                        </div>
                                    </div>
                                </div>

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
function unconfirmed()
{
    require 'script/db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_book WHERE paid_status = 0");
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        $array = array();
        if ($result->num_rows === 0) {
            return false;
        }
        $key = 0;
        while ($dbGet = $result->fetch_assoc()) {
            if (!$dbGet['foto_invoice'] == null) {
                $array['no'][$key] = $dbGet['no'];
                $array['bid'][$key] = $dbGet['bid'];
                $array['jenis'][$key] = $dbGet['jenis'];
                $array['kategori'][$key] = $dbGet['kategori'];
                $array['harga_pcs'][$key] = $dbGet['harga_pcs'];
                $array['jumlah'][$key] = $dbGet['jumlah'];
                $array['book_email'][$key] = $dbGet['book_email'];
                $array['foto_invoice'][$key] = $dbGet['foto_invoice'];
                $array['tanggal'][$key] = $dbGet['tanggal'];
                $key++;
            }
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
            $array['paid'] = 0;
        }
        $key = 0;

        // $array = array();
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

            // if ($dbGet['paid_status'] == 0) {
            //     $array['unconfirmed'][$key] = $dbGet['paid_status'];
            // }
            $key++;
        }
        return $array;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}

?>