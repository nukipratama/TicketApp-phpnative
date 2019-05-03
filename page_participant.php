<?php
include 'page_header.php';
require 'script/db/db.php';
$dbQuery = $dbConn->prepare("SELECT * FROM tuhm_users INNER JOIN tuhm_book ON tuhm_users.bid=tuhm_book.bid WHERE tuhm_book.paid_status = 1");
$dbQuery->execute();
$result = $dbQuery->get_result();
if ($result->num_rows === 0) {
    return false;
}?>
<link href="asset/css/datatables/dataTables.bootstrap4.css" rel="stylesheet">
<div class="container mt-5">
    <div class="row justify-content-center text-justify text-center">
        <div class="col-md-12 mt-5">
            <h2 class="text-center">
                Daftar Peserta TUHM 2019</h2>
            <hr>
        </div>
    </div>
    <div class="row justify-content-center text-justify text-center">
        <div class="col-md-12 ">
            <h6 class="text-muted">Peserta yang ada pada tabel dibawah adalah peserta yang Resmi
                mengikuti Telkom University Half Marathon 2019</h6>
            <div class="card-body bg-light rounded">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle " id="dataTable" width="100%" cellspacing="0"
                        valign="middle">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>No BIB</th>
                                <th>Nama Peserta</th>
                                <th>Kategori Lomba</th>
                                <th>Ukuran Baju</th>
                                <th>Jenis Kelamin</th>
                                <th>Komunitas Lari</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
while ($dbGet = $result->fetch_assoc()) {
    ?> <tr>
                                <td><?=$dbGet['no']?></td>
                                <td><?=$dbGet['nama']?></td>
                                <td><?=getCategory($dbGet['bid'])?></td>
                                <td><?=$dbGet['baju']?></td>
                                <?php
switch ($dbGet['gender']) {
        case 'male':
            echo '<td>Laki-Laki</td>';
            break;
        case 'female':
            echo '<td>Perempuan</td>';
            break;
    } ?>

                                <td><?=$dbGet['community']?></td>
                            </tr>

                            <?php
}
$dbQuery->close();
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'page_footer.php';
function getCategory($bookid)
{
    require 'script/db/db.php';
    $stmt = $dbConn->prepare("SELECT * FROM `tuhm_book` WHERE bid= ?");
    $stmt->bind_param("s", $bookid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        exit('No rows');
    }
    $dbGet = $result->fetch_assoc();
    $stmt->close();
    return $dbGet['kategori'];
}
?>
<script src="asset/css/datatables/jquery.dataTables.js"></script>
<script src="asset/css/datatables/dataTables.bootstrap4.js"></script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>