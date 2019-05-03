<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$bid = $_GET['bid'];
$book_email = getbid($bid)['email'];
$nama = getbid($bid)['nama'];
mailer($book_email, $nama, $bid);

function getbid($bid)
{
    try {
        require '../script/db/db.php';
        $dbQuery = $dbConn->prepare("SELECT * FROM `peserta_7k` WHERE `bid`=?");
        $dbQuery->bind_param("s", $bid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        $key = 0;
        $array = $result->fetch_assoc();
        // while ($array = $result->fetch_assoc()) {
        //     $get[$key] = $array;
        //     $key++;
        // }

        return $array;
    } catch (Exception $e) {

    }
}
function mailer($book_email, $nama, $bid)
{
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'mail.telkomuniversityrun.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ticketing@telkomuniversityrun.com';
    $mail->Password = 'tuhmrunwithspirit';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('ticketing@telkomuniversityrun.com', 'Telkom University Half Marathon');
    $mail->addAddress($book_email);
    $mail->Subject = "[telkomuniversityrun.com] Konfirmasi Kehadiran Telkom University Half Marathon 2019";
    $mail->isHTML(true);
    ob_start();
    $_SESSION['bid'] = $bid;
    $_SESSION['nama'] = $nama;
    include 'book_mail.php';
    $mail->Body = ob_get_clean();
    // $mail->Body = '<b>MASUK DEH</b>';
    // $mail->send();
    if (!$mail->send()) {
        // echo 'Pesan tidak dapat dikirim.';
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
        session_destroy();
        header('Location:../order');
    } else {
        echo getbid($bid)['no'] . '. Email sent to = ' . $_SESSION['book_mail'] = $book_email;
        session_destroy();
        // header("Location:../success");
        // echo 'sent';
    }
    // header("Location:../success");
    // echo 'worked';
}