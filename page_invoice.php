<?php
ini_set('file_uploads', 'On');
function checkBID($bookid)
{
    try {
        require 'script/db/db.php';
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_book WHERE bid = ?");
        $dbQuery->bind_param("s", $bookid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            // header("Location:home");
        }
        $dbGet = $result->fetch_assoc();
        $dbQuery->close();
        return $dbGet;
    } catch (Exception $e) {
        return false;
    }
}
if (isset($_GET['bid'])) {
    $bookid = $_GET['bid'];
    $returnBID = checkBID($bookid);
    if (!$returnBID === false) {
        $book_time = date('d-m-Y H:i:s', strtotime($returnBID['tanggal'] . '+ 1 days'));
        $current_time = date('d-m-Y H:i:s');
        $book_time = strtotime($book_time);
        $current_time = strtotime($current_time);

        if ($returnBID['foto_invoice'] == null) {
            if ($book_time > $current_time) {
                if ($returnBID['foto_invoice'] == null) {
                    $status = 'belum';
                } elseif (!$returnBID['foto_invoice'] == null) {
                    $status = 'menunggu';
                    if ($returnBID['paid_status'] == 1) {
                        $status = 'sudah';
                    }
                }
                include 'script/timer/page_exist.php';
            } else {
                include 'script/timer/page_expired.php';
            }
        } else {
            if ($returnBID['paid_status'] == 0) {
                $status = 'menunggu';
                include 'script/timer/page_exist.php';
            } elseif ($returnBID['paid_status'] == 1) {
                $status = 'sudah';
                include 'script/timer/page_exist.php';
            } elseif ($returnBID['paid_status'] == 2) {
                include 'script/timer/page_expired.php';
            }

        }
    } else {
        header("Location:home");
    }
} else {
    header("Location:home");
}