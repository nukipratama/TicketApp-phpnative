<?php

require 'script/db/db.php';

include 'page_header.php';
?>
<div class="container mt-5">
    <?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $dbConn->prepare("SELECT * FROM `news` WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        exit('No rows');
    }

    // allNews($id);
    while ($dbGet = $result->fetch_assoc()) {
        ?>
    <div class="row justify-content-center text-justify text-center">
        <div class="col-md-12 mt-5">
            <h2 class="text-center text-primary font-weight-bold">
                <?=$dbGet['title']?></h2>
            <h6 class="mb-1 text-muted small ann"><?=$dbGet['date']?></h6>
        </div>
    </div>
    <div class="row justify-content-center text-center">
        <div class="col-md-8 mt-3">
            <img class="w-50 img-thumbnail " src="<?=$dbGet['image']?>" style="">

        </div>
    </div>
    <div class="row justify-content-center text-justify">
        <div class="col-md-8 mt-3">
            <p class=""><?=$dbGet['long_desc']?></p>
        </div>
    </div>




    <?php
}
    $stmt->close();
} else {
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
            <h4><a href="?id=<?=$dbGet2['id']?>" class=" text-center text-primary ">
                    <?=$dbGet2['title']?></a></h4>
            <h6 class="text-muted"><?=$dbGet2['short_desc']?></h6>
        </div>
    </div>
    <hr>
    <?php
}
    $stmt->close();
}
?>
</div>











<?php
include 'page_footer.php';