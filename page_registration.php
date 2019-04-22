<?php
session_start();
ini_set('file_uploads', 'On');
include 'script/db/db.php';

if ($_GET['qty'] > 0) {
    if ($_GET['qty'] > 10) {
        ?>
<script>
window.alert("max 10 tickets");
window.location.replace("order");
</script><?php
    } elseif ($_GET['qty'] == '0') {
        ?>
<script>
window.alert("Tickets cant 0");
window.location.replace("order");
</script><?php
    } else {
        if (isset($_GET['true'])) {
            $dbQuery = $dbConn->prepare("SELECT * FROM tiket WHERE idnya = ? AND kuota != 0");
            $dbQuery->bind_param("s", $_GET['true']);
            $dbQuery->execute();
            $result = $dbQuery->get_result();
            $dbGet = $result->fetch_assoc();
            if ($result->num_rows === 0) {
                header("Location:order");
            }
            if ($_GET['qty'] > $dbGet['kuota']) {
                header("Location:order");
            }
        }
    }
} else {
    header("Location:order");
}

// $dbQuery1 = mysqli_query($dbConn, 'SELECT * FROM tiket WHERE idnya=' . $_GET['true']);

$_SESSION['secret'] = $_GET['true'];
include 'page_header.php';
?>
<div class="container mt-5">

    <div class="row justify-content-md-center">
        <div class="col-lg-5 mt-3">
            <br>
            <h4 class="card-title text-center text-uppercase">Informasi Pemesanan</h4>
            <hr>
            <div class="row justify-content-md-center">
                <div class="col-md-12 text-center">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">Jenis</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Harga Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$dbGet['jenis']?></td>
                                <td><?=$dbGet['kategori']?></td>
                                <td><?='Rp' . number_format($dbGet['harga'], 3, '.', '') . ';'?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form class="needs-validation" action="book" method="POST" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="bookid" value="<?=uniqid("TUHM_" . date("dmY_"))?>">
        <div class="row justify-content-center">
            <div class="col-md-6 mb-3">
                <h4 class="card-title text-center text-uppercase">Alamat Email Pemesan</h4>
                <hr>
                <input type="email" class="form-control" name="book_email" placeholder="contoh : pendaftar@email.com"
                    value="" required>
                <div class="invalid-feedback">
                    Harap isi Email Pemesan.
                </div>
                <small class="form-text text-muted">Email yang akan dikirimkan tagihan dan tiket.</small>
            </div>
        </div>
        <?php
$count = $_GET['qty'];
for ($c = 0;
    $c < $count;
    $c++) {
    $urutan = $c + 1; ?>
        <input type="hidden" name="uid[]" value="<?=uniqid("RUN_" . date("dmY_"))?>">


        <?php if ($urutan == 1) {
        ?>
        <div class="row justify-content-center">
            <?php
    } else {
        ?>
            <div class="row justify-content-center mt-5 ">
                <?php
    } ?>
                <div class="col-md-8 order-md-1">
                    <hr>
                    <h4 class="card-title text-center text-uppercase">Data Peserta ke-<?=$urutan?></h4>
                    <?php if ($urutan == 1) {
        ?>
                    <p class="card-text text-muted">Harap isi semua kolom dengan benar, Data yang dimasukkan hanya
                        akan digunakan untuk keperluan Telkom University Half Marathon 2019.
                        <br>*) Wajib diisi</p>
                    <?php
    } ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">Nama Peserta*</label>
                            <input type="text" class="form-control" name="name[]" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Harap isi Nama Peserta.
                            </div>
                            <small class="form-text text-muted">Nama Peserta yang akan berpartisipasi.<br>Harap isi sesuai Kartu Identitas.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Email Peserta*</label>
                            <input type="email" class="form-control" name="email[]"
                                placeholder="contoh : peserta@email.com" value="" required>
                            <div class="invalid-feedback">
                                Harap isi Email Peserta.
                            </div>
                            <small class="form-text text-muted">Email Peserta yang akan berpartisipasi.<br>Harap isi Alamat Email Aktif.</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address">Alamat Peserta*</label>
                        <input type="text" class="form-control" name="address[]"
                            placeholder="contoh : Jalan Lembong No.11-15" required>
                        <div class="invalid-feedback">
                            Harap isi Alamat Peserta.
                        </div>
                        <small class="form-text text-muted">Alamat Peserta yang akan berpartisipasi.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="phone">No Telp*</label>
                            <input type="number" class="form-control" name="phone[]" placeholder="contoh : 081234567890"
                                required>
                            <div class="invalid-feedback">
                                Harap isi No Telp Peserta.
                            </div>
                            <small class="form-text text-muted">No Telp Aktif Peserta.</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="gender">Jenis Kelamin*</label>
                            <select class="custom-select d-block w-100" name="gender[]" required>
                                <option value="">Pilih...</option>
                                <option value="male">Laki-Laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                            <div class="invalid-feedback">
                                Harap pilih Jenis Kelamin Peserta.
                            </div>
                            <small class="form-text text-muted">Jenis Pekerjaan Peserta.</small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="age">Umur Peserta*</label>
                            <input type="number" class="form-control" name="age[]" placeholder="" required>
                            <div class="invalid-feedback">
                                Harap isi Umur Peserta
                            </div>
                            <small class="form-text text-muted">Umur Peserta.</small>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label for="address">No Telp Darurat*</label>
                        <input type="text" class="form-control" name="emergency[]" placeholder="contoh : 081234567890"
                            required>
                        <div class="invalid-feedback">
                            Harap isi No Telp Darurat.
                        </div>
                        <small class="form-text text-muted">No Telp Darurat yang akan dihubungi jika terjadi keadaan
                            darurat.<br>Disarankan No Telp Keluarga atau Kerabat Peserta.</small>
                    </div>
                    <div class="mb-3">
                        <label for="address">No Kartu Identitas*</label>
                        <input type="text" class="form-control" name="identity[]" placeholder="contoh : 081234567890"
                            required>
                        <div class="invalid-feedback">
                            Harap isi No Kartu Identitas.
                        </div>
                        <small class="form-text text-muted">Nomor Kartu Identitas yg digunakan.</small>
                    </div>
                    <!--                    <section id="pelajar">-->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label>Upload Foto Kartu Identitas*</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        Browse… <input class="form-control" onchange="ValidateSize(this)" type="file"
                                            name="imgInp[]" id="imgInp" accept="image/*" required>
                                        <div class="invalid-feedback">
                                            Harap upload Kartu Identitas Peserta.
                                        </div>
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly placeholder="Ukuran File Maksimal 4 MB"
                                    value="Ukuran File Maksimal 4 MB">

                            </div>
                            <small class="form-text text-muted">Upload Foto Kartu Identias Peserta (KTP / SIM /
                                Passport / KITAS / KK)
                        </div>

                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="address">Riwayat Penyakit</label>
                        <input type="text" class="form-control" name="medical[]"
                            placeholder="contoh : Tifus, Hepatitis, DBD">
                        <small class="form-text text-muted">Riwayat Penyakit Peserta.<br>Kosongkan jika tidak
                            ada.</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="address">Komunitas Lari</label>
                            <input type="text" class="form-control" name="community[]"
                                placeholder="contoh : Telkom Runners">
                            <small class="form-text text-muted">Komunitas Lari Peserta.<br>Kosongkan jika tidak
                                ada.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender">Ukuran Baju*</label>
                            <select class="custom-select d-block w-100" name="baju[]" required>
                                <option value="">Pilih...</option>
                                <option value="S">S-Small</option>
                                <option value="M">M-Medium</option>
                                <option value="L">L-Large</option>
                                <option value="XL">XL-Extra Large</option>
                            </select>
                            <div class="invalid-feedback">
                                Harap pilih Ukuran Baju Peserta.
                            </div>
                            <small class="form-text text-muted">Ukuran Baju Peserta.</small>
                        </div>
                    </div>




                    <!--                    </section>-->

                </div>
            </div>


            <?php
}
?>

            <div class="row justify-content-center">
                <div class="col-md-8 order-md-1">
                    <hr>
                    <!-- <button class="btn btn-primary btn-lg btn-block" data-target="#terms" data-toogle="modal">Continue to checkout</button> -->
                    <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal"
                        data-target="#exampleModalCenter">
                        <i class="fas fa-shopping-cart"></i> Lanjutkan ke Pembayaran
                    </button>
                </div>
            </div>




            <!-- Button trigger modal -->


            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-fixed-footer" role="document">
                    <div class="modal-content">
                        <nav class="mt-3">
                            <!-- <div class="modal-header"> -->
                            <div class="nav nav-tabs" role="tablist">
                                <a class="nav-item nav-link active text-dark" id="nav-home-tab" data-toggle="tab"
                                    href="#nav-pendaftaran" role="tab" aria-controls="nav-home"
                                    aria-selected="true">Peraturan Pendaftaran</a>
                                <a class="nav-item nav-link text-dark" id="nav-home-tab" data-toggle="tab"
                                    href="#nav-acara" role="tab" aria-controls="nav-home"
                                    aria-selected="false">Peraturan Acara</a>
                            </div>
                            <!-- </div> -->
                        </nav>
                        <div class="modal-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="nav-pendaftaran" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <ol>
                                        <li>Peserta memiliki identitas / tanda pengenal seperti (KTP/SIM/PASSPORT)</li>
                                        <li>Peserta adalah warga Negara Indonesia dan warga Negara asing.
                                        </li>
                                        <li>Pendaftaran Peserta tidak dapat dialihnamakan dan bersifat final serta
                                            menerima sepenuhnya atas seluruh peraturan dan ketentuan yang berlaku.
                                            Barangsiapa memberikan nomor lomba (BIB) nya kepada pihak/peserta lain akan
                                            didiskualifikasi dari perlombaan.</li>
                                        <li> Perlu diingat bahwa inspeksi akan dilaksanakan selama perlombaan untuk
                                            memastikan bahwa seluruh peraturan perlombaan dipatuhi.</li>
                                        <li>Penyelesaian formulir pendaftaran online menegaskan persetujuan peserta
                                            untuk mematuhi seluruh aturan dan regulasi.</li>
                                        <li>Konfirmasi pendaftaran lomba akan diberikan setelah melengkapi pendaftaran
                                            dan pembayaran.</li>
                                        <li>Pihak penyelenggara memiliki hak untuk menutup pendaftaran sebelum tenggang
                                            waktu tanpa pemberitahuan terlebih dahulu ketika kuota lomba sudah penuh.
                                        </li>
                                        <li>Peserta menyetujui untuk memberikan informasi tentang kepesertaan yang
                                            benar, akurat, terkini dan menyeluruh, yang terdapat dalam formulir
                                            pendaftaran.</li>
                                    </ol>
                                </div>
                                <div class="tab-pane fade show " id="nav-acara" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <ol>
                                        <li>Peserta adalah warga Negara Indonesia dan warga Negara asing.
                                        </li>
                                        <li>Peserta yang tidak memiliki (BIB) dilarang masuk kedalam venue.</li>
                                        <li>Batas waktu keterlambatan bagi peserta lomba hanya (½ jam) pada jam yang
                                            telah ditentukan pada perhitungan awal.</li>
                                        <li>Apabila hingga batas keterlambatan tersebut peserta belum hadir di tempat
                                            pelaksanaan atau melebihi jam toleransi maka, peserta tidak diperbolehkan
                                            mengikuti perlombaan.</li>
                                        <li>Jika peserta tetap memaksa untuk mengikuti lomba dengan melebihi batas waktu
                                            toleransi maka segala resiko di luar tanggungjawab panitia Telkom University
                                            Half Marathon.</li>
                                        <li>BIB peserta diberikan atau dapat di ambil H-2 oleh peserta sebelum acara
                                            Telkom University Half Marathon berlangsung.</li>
                                        <li>Berikut tertera waktu untuk pengambilan BIB peserta : </li>
                                        <div class="ml-3">
                                            <table class="table-responsive">
                                                <tr>
                                                    <th>Hari Pertama</th>
                                                </tr>
                                                <tr>
                                                    <td>Hari/Tanggal</td>
                                                    <td>:</td>
                                                    <td>Jumat/13 September 2019</td>
                                                </tr>
                                                <tr>
                                                    <td>Pukul</td>
                                                    <td>:</td>
                                                    <td>16.00 hingga 21.00 WIB</td>
                                                </tr>
                                                <tr>
                                                    <td>Tempat</td>
                                                    <td>:</td>
                                                    <td>Telkom Lembong Bandung, Jawa Barat</td>
                                                </tr>
                                                <tr>
                                                    <th>Hari Kedua</th>
                                                </tr>
                                                <tr>
                                                    <td>Hari/Tanggal</td>
                                                    <td>:</td>
                                                    <td>Sabtu/14 September 2019</td>
                                                </tr>
                                                <tr>
                                                    <td>Pukul</td>
                                                    <td>:</td>
                                                    <td>13.00 hingga 00.00 WIB</td>
                                                </tr>
                                                <tr>
                                                    <td>Tempat</td>
                                                    <td>:</td>
                                                    <td>Telkom Lembong Bandung, Jawa Barat</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <li>BIB tidak boleh hilang ataupun rusak.</li>
                                        <li>Panitia menyediakan penitipan barang peserta dengan ketentuan dikenakan
                                            biaya tambahan sebesar Rp. 50.000,-</li>
                                        <li>Segala kerusakan dan kehilangan pada barang bawaan peserta yang dititipkan
                                            kepada panitia adalah tanggungjawab panitia.</li>
                                        <li>Peserta dilarang keras membawa minum – minuman keras, senjata tajam yang
                                            dapat membahayakan peserta lain.</li>
                                        <li>Peserta dilarang keras membawa rokok saat acara berlangsung.</li>
                                        <li>Apabila saat body checking panitia menemukan barang – barang tersebut maka
                                            panitia berhak untuk mengambilnya.</li>
                                        <li>Biaya pendaftaran tidak dapat dikembalikan. Pihak penyelenggara memiliki hak
                                            untuk menolak pendaftaran setelah pendaftaran diterima apabila ada pendaftar
                                            yang memberikan informasi salah.</li>
                                        <li>Apabila kegiatan/acara terpaksa dibatalkan dikarenakan hal-hal diluar
                                            kontrol pihak penyelenggara (termasuk hujan deras, badai, atau musibah,
                                            demonstrasi), tidak ada pengembalian biaya pendaftaran yang telah dibayarkan
                                            dan pihak penyelenggara tidak bertanggung jawab atas kerugian atau
                                            ketidaknyamanan yang terjadi.</li>
                                        <li>Penyelesaian formulir pendaftaran online menegaskan persetujuan peserta
                                            untuk mematuhi seluruh aturan dan regulasi.</li>
                                        <li>Konfirmasi pendaftaran lomba akan diberikan setelah melengkapi pendaftaran
                                            dan pembayaran.</li>
                                        <li>Pihak penyelenggara memiliki hak untuk menutup pendaftaran sebelum tenggang
                                            waktu tanpa pemberitahuan terlebih dahulu ketika kuota lomba sudah penuh.
                                        </li>
                                        <li>Peserta menyetujui untuk memberikan informasi tentang kepesertaan yang
                                            benar, akurat, terkini dan menyeluruh, yang terdapat dalam formulir
                                            pendaftaran. Pihak penyelenggara dapat menghubungi peserta sewaktu-waktu
                                            melalui surat elektronik. Surat pemberitahuan dikirim ke alamat surat
                                            elektronik yang terdaftar pada pihak penyelenggara akan disamakan dengan
                                            yang diterima oleh peserta.</li>
                                    </ol>
                                </div>


                            </div>

                        </div>
                        <div class="modal-footer mb-2 mt-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Saya mengerti</button>
                        </div>
                    </div>
                </div>
            </div>

    </form>
</div>


<?php
$dbQuery->close();
include 'page_footer.php';
?>

<script>
function ValidateSize(file) {
    var FileSize = file.files[0].size / 1048576; // in MB
    if (FileSize > 4.0) {
        alert('Ukuran File Maksimal 4 MB');
        $(file).val(null);
        $(file).attr(" placeholder", "Ukuran File Maksimal 4 MB");
        $(file).attr("value", "Ukuran File Maksimal 4 MB");
    }
}
</script>
<style>
.modal-dialog,
.modal-content {
    height: 70%;
}

.modal-body {
    overflow-y: scroll;
}
</style>