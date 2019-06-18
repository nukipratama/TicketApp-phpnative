<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if (isset($_GET['bid'])) {
    $bookid = $_GET['bid'];
    accept($bookid);
    mailer($bookid);
}
header("Location:confirmation");

function accept($bookid)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("UPDATE `tuhm_book` SET `paid_status` = 1 WHERE `tuhm_book`.`bid` = ?;");
        $dbQuery->bind_param("s", $bookid);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
        header("Location:confirmation");
    } catch (Exception $e) {
        return 'error decline';
    }
}
function getName($bookid)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_users WHERE bid = ? LIMIT 1;");
        $dbQuery->bind_param("s", $bookid);
        $dbQuery->execute();

        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            return false;
        }

        $dbGet = $result->fetch_assoc();
        $dbQuery->close();
        return $dbGet['nama'];
    } catch (Exception $e) {
        header('Location:confirmation');
    }
}
function mailer($bookid)
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
        $dbQuery->close();

        $mail_recipient = $dbGet['book_email'];

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'mail.telkomuniversityrun.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'payment@telkomuniversityrun.com';
        $mail->Password = 'tuhmrunwithspirit';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('payment@telkomuniversityrun.com', 'Telkom University Half Marathon 2019');
        $mail->addAddress($mail_recipient);

        $mail->Subject = "[telkomuniversityrun.com] Pembelian Tiket Half Marathon 2019 Berhasil";

        $mail->isHTML(true);

        ob_start();
        $_SESSION['nama'] = getName($bookid);
        $_SESSION['bookid'] = $bookid;
        $_SESSION['jenis'] = $dbGet['jenis'];
        $_SESSION['jumlah'] = $dbGet['jumlah'];
        $_SESSION['kategori'] = $dbGet['kategori'];
        $_SESSION['total_harga'] = $total_harga = (int) $dbGet['jumlah'] * (int) $dbGet['harga_pcs'];
        include 'accept_mail.php';
        $mail->Body = ob_get_clean();
        // $mail->Body = '<b>MASUK DEH</b>';
        // $mail->send();
        if (!$mail->send()) {
            echo 'Pesan tidak dapat dikirim.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            session_destroy();
            header("Location:confirmation");
        } else {
            $_SESSION['book_mail'] = $book_email;
            header('Location:confirmation');
        }
        echo 'worked';
    } catch (Exception $e) {
        header('Location:confirmation');
        // return 'error inserting data';
    }
}