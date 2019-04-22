<?php
$total_harga = $_SESSION['total_harga'];
$bookid = $_SESSION['bookid'];
$jumlah = $_SESSION['jumlah'];
$kategori = $_SESSION['kategori'];
$jenis = $_SESSION['jenis'];
$nama = $_SESSION['nama'];
?>

<html>

<body>

    <h1><b>Hai, <?=$nama?></b></h1>
    <h3 style="color:gray">Book ID : <b><?=$bookid;?></b></h3>
    <br>
    <h4>Terima Kasih telah melakukan pembayaran E-Ticket Telkom University Half Marathon 2019!</h4>
    <h4>Pembayaran telah diproses dan siap untuk diunduh pada link yang terlampir dibawah.</h4>
    <h4>Dengan dikirimkannya email ini artinya anda telah resmi menjadi peserta Telkom University Half Marathon 2019.
    </h4>
    <h4>Setiap peserta memiliki 1 tiket yang harus dibawa masing masing ketika pengambilan RacePack.</h4>
    <hr style="background-color:gray;">
    <h4>Berikut rincian Tagihan yang telah diterima</h4>
    <h4>Book ID Pemesanan : <b><?=$bookid?></b></h4>
    <h4>Jenis Tiket : <b><?=$jenis?></b></h4>
    <h4>Kategori Tiket : <b><?=$kategori?></b></h4>
    <h4>Jumlah Tiket : <b><?=$jumlah?> Tiket</b></h4>
    <h4>Total Pembayaran : <b><?='Rp ' . number_format($total_harga * 1000, 2, ',', '.') . ';'?></b></h4>
    <hr style="background-color:gray;">
    <h4>Berikut adalah link untuk mengunduh Tiket anda</h4>
    <h4><a href='https://telkomuniversityrun.com/invoice?bid=<?=$bookid?>'>Unduh Tiket disini</a></h4>
    <hr style="background-color:gray;">
    <h4>Untuk melihat Peraturan Acara <a href="https://telkomuniversityrun.com/rules">Klik disini</a></h4>
    <h4>Untuk melihat Rundown Acara <a href="https://telkomuniversityrun.com/information#rundown">Klik disini</a></h4>
    <hr style="background-color:gray;">
    <h4>Sampai berjumpa di Telkom University Half Marathon 2019!</h4>
    <h4>Jika ada pertanyaan, silahkan hubungi kami di cs@telkomuniversityrun.com</h4>
    <br>
    <h4>Salam Olahraga,</h4>
    <br>
    <h4>Telkom University Run 2019 Team</h4>
</body>

</html>