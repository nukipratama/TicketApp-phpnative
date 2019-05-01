<?php

include 'script/db/db.php';
$stmt = $dbConn->prepare("SELECT * FROM `news`");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    exit('No rows');
}
include 'page_header.php'
?>
<header class="h-100 masthead justify-content-center text-center text-white d-flex">
    <div class="row justify-content-center">
        <div class="overlay"></div>
        <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="asset/video/tuhmteaser.mp4" type="video/mp4">
        </video>
        <div class="container h-100">
            <div class="d-flex h-100 text-center align-items-center">
                <div class="w-100 text-white">
                    <img class="w-25 img-fluid" src="asset/img//LOGO-new.png">
                    <h2 class=" font-weight-bold">Telkom University<br>Half Marathon</h2>
                    <p class="lead">Bandung, 15 September 2019</p>
                    <a href="#kategori" class="btn btn-dark"><i class="fas fa-fw fa-list-ul"></i>
                        Kategori</a>
                    <a href="order" class="btn btn-primary"><i class="fas fa-fw fa-cart-plus"></i>
                        Pendaftaran</a>

                </div>
            </div>
        </div>
    </div>
</header>

<section id="kategori">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Kategori Lari</h2>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">

                    <h3 class="mb-3"> <i class="fas fa-running"></i> 7K Run</h3>
                    <a class="portfolio-box img-fluid" href="asset/img/portfolio/fullsize/Maps 7.jpg">
                        <img class="img-fluid" src="asset/img/Maps 7.jpg" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Click here
                                </div>
                                <div class="project-name">
                                    Rute 7k
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">

                    <h3 class="mb-3"> <i class="fas fa-running"></i> 21K Run</h3>
                    <a class="portfolio-box img-fluid" href="asset/img/portfolio/fullsize/Maps 21.jpg">
                        <img class="img-fluid" src="asset/img/Maps 21.jpg" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Click here
                                </div>
                                <div class="project-name">
                                    Rute 21K / Half-marathon
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>


<section class="bg-primary" id="about">
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading" style="color:white; ">Pengumuman</h2>
                    <hr class="my-4" style="border-color:white;">
                </div>
            </div>
        </div>
        <?php
while ($dbGet = $result->fetch_assoc()) {
    ?>
        <div class="row ">
            <div class="col-md-6 ">
                <div class="card flex-md-row mb-4 shadow-sm h-md-250 sr-ann-1" style="">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h4 class="lead text-center text-primary font-weight-bold">
                            <?=$dbGet['title']?></h4>

                        <div class="mb-1 text-muted small ann"><?=$dbGet['date']?></div>
                        <p class="card-text mb-2 text-muted "><?=$dbGet['short_desc']?></p>
                        <a class="btn btn-secondary btn-sm" role="button" href="news?id=<?=$dbGet['id']?>">Informasi
                            lebih lanjut
                        </a>
                    </div>
                    <img class="img-fluid card-img-right flex-auto d-none d-lg-block" style="height:250px;width:180px;"
                        src="<?=$dbGet['image']?>" style="">
                </div>
            </div>
        </div>

        <?php
}?>
    </div>
</section>



<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Cara Pemesanan</h2>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fab fa-4x fa-wpforms text-primary mb-3 sr-icon-1"></i>
                    <h3 class="mb-3">Isi Formulir Peserta</h3>
                    <p class="text-muted mb-0">Formulir Pendaftaran sebagai data diri Peserta. </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="far fa-4x fa-money-bill-alt text-primary mb-3 sr-icon-2"></i>
                    <h3 class="mb-3">Transfer</h3>
                    <p class="text-muted mb-0">Setelah mengisi formulir, kami akan mengirimkan email berisi tagihan
                        pembayaran anda.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fas fa-4x fa-file-upload text-primary mb-3 sr-icon-3"></i>
                    <h3 class="mb-3">Upload</h3>
                    <p class="text-muted mb-0">Kami akan menyediakan link khusus untuk mengunggah bukti pembayaran anda.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fas fa-4x fa-heart text-primary mb-3 sr-icon-4"></i>
                    <h3 class="mb-3">Selesai</h3>
                    <p class="text-muted mb-0">Anda akan masuk kedalam daftar peserta dan tiket akan dikirim ke email
                        anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'page_footer.php'
?>