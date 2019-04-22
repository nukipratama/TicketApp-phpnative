<?php
include 'script/timer/book_timer.php';
include 'page_header.php';

?>
<p id='bid' hidden><?=$bookid?></p>
<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="col-lg-12 mt-3">
            <br>
            <?php switch ($status) {
    case 'belum':
        ?>
            <div class="row justify-content-md-center mt-3">
                <div class="col-lg-8">
                    <div class="alert alert-warning text-center" role="alert">
                        <p class="fa fa-exclamation-triangle m-2"></p>
                        Anda belum mengunggah bukti Pembayaran.
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="alert alert-info text-center" role="alert">
                        Segera unggah bukti pembayaran sebelum waktu pembayaran habis.
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-center mt-3">
                <div class="col-lg-6 text-center">
                    <h4 class="card-title text-center text-uppercase">Sisa Waktu Pembayaran</h4>
                    <hr>
                    <div class="alert alert-secondary" role="alert">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <h1 class="text-black" time></h1>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-6 text-center">
                    <h4 class="card-title text-center text-uppercase">Unggah Bukti Pembayaran</h4>
                    <hr>
                    <div class="alert alert-secondary" role="alert">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <form class="needs-validation" action="uploadinvoice" method="POST"
                                    enctype="multipart/form-data" novalidate>
                                    <div class="input-group">
                                        <span class="input-group-btn">

                                            <input type="hidden" name="bookid" value="<?=$bookid?>" hidden>
                                            <span class="btn btn-default btn-file">
                                                Browse… <input class="form-control" onchange="ValidateSize(this)"
                                                    type="file" name="imgInp" id="imgInp" accept="image/*" required>
                                                <div class="invalid-feedback">
                                                    Harap upload Foto Bukti Pembayaran.
                                                </div>
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly
                                            placeholder="Ukuran File Maksimal 4 MB" value="Ukuran File Maksimal 4 MB">
                                    </div>
                                    <center>
                                        <button class="w-50 btn btn-primary btn-md btn-block mt-2"
                                            type="submit">Submit</button>
                                    </center>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-md-center mt-3">
                <div class="col-lg-6">
                    <h4 class="card-title text-center text-uppercase">Cara Pembayaran</h4>
                    <hr>
                    <h6 class="card-title text-center ">Silahkan melakukan transfer dengan nominal</h6>
                    <h5 class="card-title text-center "><b>Rp
                            <?=$returnBID['harga_pcs'] * $returnBID['jumlah']?>.000;</b></h5>
                    <h6 class="card-title text-center ">ke Rekening Tujuan berikut :</h6>
                    <table class="table table-secondary text-center">
                        <thead>
                            <tr>
                                <th scope="col">Nama Rekening</th>
                                <th scope="col">Bank Tujuan</th>
                                <th scope="col">Nomor Rekening</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dzul Wulan Ningtyas</td>
                                <td>Bank BNI</td>
                                <td>700419980</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col-lg-6 text-center">
                    <h4 class="card-title text-center text-uppercase">Informasi Pemesanan</h4>
                    <hr>
                    <p class="card-title text-center">Klik Nama Peserta untuk melihat detail</p>
                    <br>

                    <?php
// echo userBID($bookid);
        $returnUSER = userBID($bookid);
        for ($key = 0; $key < count($returnUSER['nama']); $key++) {
            ?>
                    <div class="row justify-content-center m-2">
                        <div class="col-lg-12 ">
                            <button type="button" class="w-75 btn btn-primary" data-toggle="modal"
                                data-target="#<?=$returnUSER['uid'][$key]?>">
                                <?=$returnUSER['nama'][$key]?>
                            </button>

                            <div class="modal fade" id="<?=$returnUSER['uid'][$key]?>" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                                <?=$returnUSER['nama'][$key]?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?=$returnUSER['foto_identitas'][$key]?>" alt=""
                                                class="w-100 img-fluid">
                                            <h6 class="text-left mt-2">UID : <b><?=$returnUSER['uid'][$key]?></b></h6>
                                            <h6 class="text-left">Email : <b><?=$returnUSER['email'][$key]?></b></h6>
                                            <h6 class="text-left">Alamat : <b><?=$returnUSER['alamat'][$key]?></b></h6>
                                            <h6 class="text-left">No. HP : <b><?=$returnUSER['nohp'][$key]?></b></h6>
                                            <h6 class="text-left">Jenis Kelamin :
                                                <b><?php
switch ($returnUSER['gender'][$key]) {
                case 'male':
                    echo 'Laki-laki';
                    break;
                case 'female':
                    echo 'Perempuan';
                    break;
            } ?></b></h6>
                                            <h6 class="text-left">Riwayat Penyakit :
                                                <b><?=$returnUSER['medical'][$key]?></b></h6>
                                            <h6 class="text-left">Komunitas :
                                                <b><?=$returnUSER['community'][$key]?></b></h6>
                                            <h6 class="text-left">Ukuran Baju :
                                                <b><?=$returnUSER['baju'][$key]?></b></h6>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
        }
        ?>

                </div>
            </div>
            <?php
break;
    case 'menunggu':
        ?>
            <div class="alert alert-primary text-center" role="alert">
                <p class="fa fa-users-cog m-2"></p>
                Bukti Pembayaran sedang di proses, silahkan menunggu.
            </div>
            <?php
require 'script/db/db.php';
        $stmt = $dbConn->prepare("SELECT * FROM `news`");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            exit('No rows');
        }?>
            <div class="row justify-content-center text-justify text-center">
                <div class="col-md-12 mt-5">
                    <h2 class="text-center">
                        Pengumuman</h2>
                    <hr>
                </div>
            </div>
            <?php
while ($dbGet2 = $result->fetch_assoc()) {
            ?>
            <div class="row justify-content-center text-justify text-center">
                <div class="col-md-12">
                    <span class="text-center text-muted ">
                        <?=$dbGet2['date']?></span>
                    <h4><a href="news?id=<?=$dbGet2['id']?>" class=" text-center text-primary ">
                            <?=$dbGet2['title']?></a></h4>
                    <h6 class="text-muted"><?=$dbGet2['short_desc']?></h6>
                </div>
            </div>
            <?php
        }
        $stmt->close();

        break;
    case 'sudah':
        ?><div class="alert alert-success text-center" role="alert">
                <p class="fa fa-check-circle m-2"></p>
                Anda sudah menyelesaikan Pembayaran.
            </div>


            <div class="row justify-content-md-center mt-3">
                <div class="col-lg-6 text-center">
                    <h4 class="card-title text-center text-uppercase">Unduh Tiket</h4>
                    <hr>
                </div>
            </div>
            <?php
// echo userBID($bookid);
        $returnUSER = userBID($bookid);
        for ($key = 0; $key < count($returnUSER['nama']); $key++) {
            ?>

            <div class="card mt-3">
                <div class="row text-center justify-content-center">
                    <div class="col-md-5">
                        <img src="asset/img/pdf.jpg" class="w-50 img-fluid mt-3">
                    </div>
                    <div class="col-md-7 ">
                        <div class="card-block m-3">
                            <h4 class="card-title text-primary font-weight-bold"><?=$returnUSER['nama'][$key]?></h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><?=$returnUSER['email'][$key]?> -
                                    <?=$returnUSER['nohp'][$key]?></li>
                                <li class="list-group-item"> <?=$returnUSER['alamat'][$key]?></li>
                                <li class="list-group-item"><a href="ticket?uid=<?=$returnUSER['uid'][$key]?>"
                                        class="btn  btn-primary">Unduh
                                        Tiket
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>



            <?php
        }
        break;
}?>
        </div>
    </div>
</div>

<?php
include 'page_footer.php';
?>
<script>
$(function() {
    var timer_hour = $("[time]");
    var bid_val = $("#bid").html();
    setInterval(function() {
        // alert('hello');
        $.post("script/timer/book_timer.php", {
            type: "timerupdate",
            bid: bid_val
        }, function(data) {
            var json = JSON.parse(data);
            timer_hour.html(json.hour + " : " + json.minute + " : " + json.second);
            if ((parseInt(json.hour) <= 0) && (parseInt(json.minute) <= 0) && (parseInt(json
                    .second) <= 0)) {
                window.location.replace("invoice?bid=" + bid_val);
            }
        });
    }, 1000);
});
</script>
<?php
function userBID($bookid)
{
    require 'script/db/db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_users WHERE bid = ?");
        $dbQuery->bind_param("s", $bookid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            header("Location:order");
        }
        $key = 0;
        while ($dbGet = $result->fetch_array()) {
            $array['uid'][$key] = $dbGet['uid'];
            $array['nama'][$key] = $dbGet['nama'];
            $array['email'][$key] = $dbGet['email'];
            $array['alamat'][$key] = $dbGet['alamat'];
            $array['nohp'][$key] = $dbGet['nohp'];
            $array['gender'][$key] = $dbGet['gender'];
            $array['medical'][$key] = $dbGet['medical'];
            $array['foto_identitas'][$key] = $dbGet['foto_identitas'];
            $array['community'][$key] = $dbGet['community'];
            $array['baju'][$key] = $dbGet['baju'];
            $key++;
        }
        return $array;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}

?>
<script>
function ValidateSize(file) {
    var FileSize = file.files[0].size / 1048576; // in MB
    if (FileSize > 4.0) {
        alert('Ukuran File Maksimal 4 MB');
        $(file).val(null);
        $(file).attr("placeholder", "Ukuran File Maksimal 4 MB");
        $(file).attr("value", "Ukuran File Maksimal 4 MB");
    }
}
</script>