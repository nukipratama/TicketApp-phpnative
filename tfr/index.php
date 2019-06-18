<?php
function getUID($bid)
{
    try {
        require 'script/db/db.php';
        $dbQuery = $dbConn->prepare("SELECT * FROM `peserta_7k` WHERE `bid`=?");
        $dbQuery->bind_param("s", $bid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        $key = 0;
        if ($result->num_rows === 0) {
            header("Location:home");
        }
        $array = $result->fetch_assoc();
        return $array;
    } catch (Exception $e) {
    }
}

if (isset($_GET['bid'])) {
    session_start();
    $bid = $_GET['bid'];
    $_SESSION['bid'] = getUID($bid)['uid'];
    $_SESSION['nama'] = getUID($bid)['nama'];
    $_SESSION['email'] = getUID($bid)['email'];
    $_SESSION['nohp'] = getUID($bid)['nohp'];
    $_SESSION['book_email'] = getUID($bid)['email'];
    include 'header.php';

    ?>
<div class="container mt-5">
    <div class="row justify-content-center text-justify">
        <div class="col-md-12 mt-5">
            <h2 class="text-center">
                Selamat Datang di TUHM 2019,<br><?=$_SESSION['nama']?></h2>
            <hr>
            <p class="lead">Terima Kasih atas pendaftaran anda di Telkom Fun Run 2019. <br>Dikarenakan satu dan lain
                hal, Kami sebagai panitia Telkom University Run dan Telkom Fun Run 2019 dengan berat hati memberitahu
                jika acara telah diundur ke tanggal 15 September 2019 dan ditambahkan kategori Half Marathon.</p>
            <center><span>Untuk informasi lebih lanjut tentang acara silahkan klik <a class="text-primary"
                        href="https://telkomuniversityrun.com/">disini.</a></span></center>
            <br>
            <p class="lead">Sebagai permohonan maaf, Kami telah mengikut sertakan semua peserta yang telah terdaftar dan
                membayar di Telkom Fun Run 2019. Anda (<?=$_SESSION['nama']?>) telah terdaftar sebagai salah satu yang
                kami ikut sertakan di Telkom University Half Marathon 2019.<br>Dikarenakan migrasi dari Telkom Fun Run
                2019 ke Telkom University Half Marathon 2019 membutuhkan pelengkapan data, silahkan pilih kategori race
                yang ingin anda ikuti.</p>
            <center>
                <a href="7k" class="btn btn-primary btn-lg">7K (Free)</a>
                <br><br><a href="21k" class="btn btn-primary btn-lg">21K (Add IDR 150K)</a>
            </center>
            <br>
            <p class="lead">Untuk pendaftaran ke kategori 7K tidak dikenakan biaya, sedangkan jika pindah ke kategori
                21K dikenakan penambahan biaya sebesar Rp 150.000;</p>
        </div>
    </div>
</div>

<?php
include 'footer.php';
} else {
    header("Location:home");
}