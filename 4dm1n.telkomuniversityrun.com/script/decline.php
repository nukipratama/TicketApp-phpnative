<?php
if (isset($_GET['bid'])) {
    $bookid = $_GET['bid'];
    decline($bookid);
    $jumlah = (int) checkJumlah($bookid)['jumlah'];
    $jenis = checkJumlah($bookid)['jenis'];
    $kategori = checkJumlah($bookid)['kategori'];
    updateKuota($jumlah, $jenis, $kategori);
}
header("Location:confirmation");

function decline($bookid)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("UPDATE `tuhm_book` SET `paid_status` = 2 WHERE `tuhm_book`.`bid` = ?;");
        $dbQuery->bind_param("s", $bookid);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
        header("Location:confirmation");
    } catch (Exception $e) {
        return 'error decline';
    }
}
function checkJumlah($bookid)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_book WHERE bid = ?;");
        $dbQuery->bind_param("s", $bookid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
        $key = 0;
        $dbGet = $result->fetch_assoc();
        return $dbGet;
    } catch (Exception $e) {
        return 'error decline';
    }
}
function updateKuota($jumlah, $jenis, $kategori)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT `kuota` FROM `tiket`  WHERE `jenis` = ? AND `kategori` = ? ;");
        $dbQuery->bind_param("ss", $jenis, $kategori);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
        $key = 0;
        $dbGet = $result->fetch_assoc();
        $jumlah = $jumlah + $dbGet['kuota'];
        $dbQuery->close();
        $dbQuery = $dbConn->prepare("UPDATE `tiket` SET `kuota` = ? WHERE `jenis` = ? AND kategori = ? ;");
        $dbQuery->bind_param("sss", $jumlah, $jenis, $kategori);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
    } catch (Exception $e) {
        return 'error decline';
    }
}