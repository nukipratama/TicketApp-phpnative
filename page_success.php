<?php
session_start();
include 'page_header.php';
?>
<div id="overlay"></div>
<header class="h-100 masthead justify-content-center text-left text-white d-flex" id="success">
    <div class="container">
        <div class="row" style="margin-top:30%">
            <div class="col-lg-12">
                <h3>Pemesanan Tiket Berhasil</h3>
                <h4 class="h4 ">Tagihan telah dikirimkan ke <?=$_SESSION['book_mail']?></h4>
                <h6>Silahkan melakukan pembayaran dalam waktu 24 Jam, apabila melewati batas waktu maka booking
                    dinyatakan
                    hangus.</h6>
            </div>
        </div>
    </div>
</header>


<?php
session_destroy();
include 'page_footer.php';
?>

<script>
(function(window, location) {
    history.replaceState(null, document.title, location.pathname + "#!/nottodaykid");
    history.pushState(null, document.title, location.pathname);

    window.addEventListener("popstate", function() {
        if (location.hash === "#!/nottodaykid") {
            history.replaceState(null, document.title, location.pathname);
            setTimeout(function() {
                location.replace("order");
            }, 0);
        }
    }, false);
}(window, location));
</script>