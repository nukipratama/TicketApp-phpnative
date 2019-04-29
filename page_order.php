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


<div class="container mt-5 text-center">

    <div class="row justify-content-md-center">

        <div class="col-lg-10 mt-3">
            <br>
            <h2 class="h2">Pendaftaran TUHM 2019</h2>
            <hr>
            <div class="row justify-content-center">
                <?php
while ($dbGet = $result->fetch_assoc()) {
    ?>

                <div class="col-md-5 align-middle ">
                    <div class="card mt-3">
                        <img src="asset/<?=$dbGet['poster']?>" class=" img-fluid">
                        <div class="card-block m-2">

                            <h4 class="card-title text-primary font-weight-bold"><?=$dbGet['jenis']?><br>TUHM
                                <?=$dbGet['kategori']?> Run</h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Sisa Kuota : <b>
                                        <?php
if ($dbGet['kuota'] < 1) {echo '0 / Tiket Habis';
    } else {
        echo $dbGet['kuota'] . ' Tiket';
    }

    ?></b></li>
                                <li class="list-group-item">Harga Tiket :
                                    <b><?='Rp ' . number_format($dbGet['harga'], 3, '.', '') . ';'?></b></li>
                                <?php

    if ($dbGet['kuota'] < 1) {
        ?>
                                <li class="list-group-item"><button
                                        class="btn tingle-btn--danger btn-primary js-tingle-modal-<?=$dbGet['idnya']?>"
                                        style="background-color:#b11d19" disabled>Sold Out!
                                    </button></li>
                                <?php
} else {
        ?>
                                <li class="list-group-item"><button
                                        class="btn tingle-btn--danger btn-primary js-tingle-modal-<?=$dbGet['idnya']?>">Pesan
                                        Sekarang!
                                    </button></li>
                                <?php
}
    ?>



                            </ul>
                        </div>

                    </div>
                    <!--<div class="col-md-7 ">-->

                    <!--</div>-->
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

}
$stmt->close();
?>
            </div>
        </div>

    </div>
</div>
<?php
include 'page_footer.php';
?>