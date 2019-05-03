<?php
$nama = $_SESSION['nama'];
$bid = $_SESSION['bid'];
?>

<html>

<body>

    <h1><b>Hai, <?php echo $nama; ?></b></h1>
    <h3 style="color:gray">Book ID : <b><?=$bid;?></b></h3>
    <br>
    <h4>Selamat Datang di Telkom University Half Marathon 2019!</h4>
    <h4>Sebelumnya, Kami mohon maaf karena mengundur acara Telkom Fun Run 2019.</h4>
    <h4>Sebagai permohonan maaf, kami sebagai Panitia Telkom Fun Run 2019 dan Telkom University Run memberikan slot gratis kepada semua peserta Telkom Fun Run 2019. Silahkan Konfirmasi kehadiran anda pada link yang terlampir dibawah. Harap segera melengkapi data peserta, karena link akan kami tutup pada waktu dekat.</h4>
    <h4>Terima Kasih atas kesabarannya menunggu Telkom University Half Marathon 2019.</h4>
    <hr style="background-color:gray;">
    <h4>Book ID Pemesanan : <b><?=$bid?></b></h4>
    <h4>Nama Pemesan : <b><?=$nama?></b></h4>
    <h4>Jumlah Tiket : <b>1 Tiket</b></h4>
    <hr style="background-color:gray;">
    <h4>Silahkan melakukan pelengkapan data peserta  pada link yang terlampir dibawah.</h4>
    <h4><a href='localhost/tuhm/tfr?bid=<?=$bid?>'>Klik untuk mengisi Data Peserta</a></h4>
    <hr style="background-color:gray;">
    <h4>Jika ada pertanyaan, silahkan hubungi kami di cs@telkomuniversityrun.com</h4>
    <br>
    <h4>Salam Olahraga,</h4>
    <br>
    <h4>Telkom University Run 2019 Team</h4>
</body>

</html>