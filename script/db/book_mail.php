<?php
$nama = $_SESSION['nama'];
$jenis = $_SESSION['jenis'];
$kategori = $_SESSION['kategori'];
$harga = $_SESSION['harga'];
$jumlah = $_SESSION['jumlah'];
$bookid = $_SESSION['bookid'];?>

<html>

<body>

    <h1><b>Hai, <?php echo $nama; ?></b></h1>
    <h3 style="color:gray">Book ID : <b><?=$bookid;?></b></h3>
    <br>
    <h4>Terima Kasih telah memesan E-Ticket Telkom University Half Marathon 2019!</h4>
    <h4>Berikut rincian pemesanan</h4>
    <h4>Book ID Pemesanan : <b><?=$bookid?></b></h4>
    <h4>Nama Pemesan : <b><?=$nama?></b></h4>
    <h4>Jenis / Kategori : <b><?=$jenis . ' / ' . $kategori?></b></h4>
    <h4>Jumlah Tiket : <b><?=$jumlah?> Tiket</b></h4>
    <hr style="background-color:gray;">
    <h4>Batas waktu pembayaran adalah 24 jam setelah menerima email ini, jika tidak melakukan pembayaran dan
        mengunggah bukti pembayaran pada batas waktu maka pemesanan akan dibatalkan secara otomatis.</h4>
    <h4>Silahkan melakukan pembayaran ke rekening pada link yang terlampir dibawah.</h4>
    <h4><a href='https://telkomuniversityrun.com/invoice?bid=<?=$bookid?>'>Klik untuk melihat Status Pembayaran</a></h4>
    <hr style="background-color:gray;">
    <h4>Jika ada pertanyaan, silahkan hubungi kami di cs@telkomuniversityrun.com</h4>
    <br>
    <h4>Salam Olahraga,</h4>
    <br>
    <h4>Telkom University Run 2019 Team</h4>
</body>

</html>