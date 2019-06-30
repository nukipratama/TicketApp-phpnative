<?php
include 'script/db/db.php';
$stmt = $dbConn->prepare("SELECT * FROM `tiket`");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    exit('No rows');
}

include 'page_header.php';
?>
<style>
.stamp {
    transform: rotate(12deg);
    color: #555;
    font-size: 3rem;
    font-weight: 700;
    border: 0.25rem solid #555;
    display: inline-block;
    padding: 0.25rem 1rem;
    text-transform: uppercase;
    border-radius: 1rem;
    font-family: 'Courier';
    -webkit-mask-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/8399/grunge.png');
    -webkit-mask-size: 944px 604px;
    mix-blend-mode: multiply;
}

.is-nope {
    color: #D23;
    border: 0.5rem double #D23;
    transform: rotate(3deg);
    -webkit-mask-position: 2rem 3rem;
    font-size: 2rem;
}
</style>

<div class="container mt-5 text-center">

    <div class="row justify-content-md-center">

        <div class="col-lg-10 mt-3">
            <br>
            <h2 class="h2">Pendaftaran TUHM 2019</h2>
            <hr>
 <p class="lead ">Silahkan lakukan pendaftaran dengan memilih salah satu kategori lari dibawah. Pendaftaran akan tertutup otomatis jika slot sudah habis.</p>
            <?php
while ($dbGet = $result->fetch_assoc()) {
    if ($dbGet['kuota'] < 1) {
    } else {?>
            <div class="row justify-content-center">
                <div class="col-lg-12 align-middle ">
                    <div class="card mt-3" style="background-color:#b82211;border-radius:10px">
                        <div class="row justify-content-center p-2">
                            <div class="col-lg-7">
                                <img src="asset/<?=$dbGet['poster']?>" class="h-100 w-100" style="vertical-align:middle">
                            </div>
                            <div class="col-lg-5 mt-3" style="vertical-align:middle">
                                <h4 class="card-title text-white font-weight-bold"><?=$dbGet['jenis']?><br>
                                    <?=$dbGet['kategori']?> Run</h4>
                                    <hr style="background-color: #fff; height: 2px; border: 0;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-white" style="background-color:#b82211;border:0;">Harga Tiket :
                                        <br><b><?='Rp ' . number_format($dbGet['harga'], 3, '.', '') . ';'?></b></li>
                                </ul>
                                <p class="text-center text-white" style="">Tiket sudah termasuk : <br><b>Racepack, Refreshment,<br>dan Medali untuk Finisher</b></p>
                                <p class="text-center text-white" style="display:none">Sisa Kuota : <b><?=$dbGet['kuota'] . ' Tiket'?></b></p>
                                 <hr style="background-color: #fff; height: 2px; border: 0;">
                                <button
                                    class="mb-1 btn tingle-btn--danger btn-primary js-tingle-modal-<?=$dbGet['idnya']?>">Pesan
                                    Sekarang!
                                </button>
                            </div>
                            <!--<div class="col-lg-3 mt-2">-->
                           
                            <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
            <!--tingle content-->
            <div class="tingle-demo tingle-demo-force-close-<?=$dbGet['idnya']?>" style="display:none;">

                <!-- Material input -->
                <div class="md-form">
                    <h4 class="card-title text-primary text-center font-weight-bold"><?=$dbGet['jenis']?> TUHM
                        <?=$dbGet['kategori']?> Run</h4>
                    <hr>
                    <h5 class=" text-center">Jumlah Peserta</h5>

                    <input type="number" id="qty<?=$dbGet['idnya']?>" class="form-control">

                </div>

            </div>
            <!--end tingle-->

            <script>
            var modalButtonOnly<?=$dbGet['idnya']?> = new tingle.modal({
                closeMethods: [],
                footer: true,
                stickyFooter: true
            });

            var btn<?=$dbGet['idnya']?> = document.querySelector('.js-tingle-modal-<?=$dbGet['idnya']?>');
            btn<?=$dbGet['idnya']?>.addEventListener('click', function() {
                modalButtonOnly<?=$dbGet['idnya']?>.open();
            });

            modalButtonOnly<?=$dbGet['idnya']?>.setContent(document.querySelector(
                '.tingle-demo-force-close-<?=$dbGet['idnya']?>').innerHTML);

            modalButtonOnly<?=$dbGet['idnya']?>.addFooterBtn('Submit',
                'tingle-btn tingle-btn--danger tingle-btn--pull-right',
                function() {
                    var qty = document.getElementById('qty<?=$dbGet['idnya']?>').value;
                    if ('<?=$dbGet['kuota']?>' < parseInt(qty)) {
                        alert(
                            'Maaf, Kuota yang tersedia tidak mencukupi jumlah Tiket anda.\nSilahkan mengurangi jumlah Tiket anda.'
                        );
                        window.location.replace('order');
                    } else {
                        window.location.replace('registration?true=<?=$dbGet['idnya']?>&qty=' + qty + '');
                    }
                });
            modalButtonOnly<?=$dbGet['idnya']?>.addFooterBtn('Cancel',
                'tingle-btn tingle-btn--default tingle-btn--pull-right',
                function() {
                    modalButtonOnly<?=$dbGet['idnya']?>.close();
                });
            </script>

            <?php

    }}
$stmt->close();
?>


        </div>

    </div>
</div>
<script>
// function on() {
//     document.getElementById("overlay").style.display = "block";
// }

// function off() {
//     document.getElementById("overlay").style.display = "none";
// }
</script>
<?php
include 'page_footer.php';
?>