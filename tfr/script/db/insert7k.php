<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if (isset($_POST['address'])) {

    echo $book_email = $_SESSION['book_email'];
    echo $bid = $_SESSION['bid'];
    echo $uid = $_SESSION['bid'];
    echo $name = $_SESSION['nama'];
    echo $address = $_POST['address'];
    echo $email = $_SESSION['email'];
    echo $phone = $_SESSION['nohp'];
    echo $gender = $_POST['gender'];
    echo $age = $_POST['age'];
    echo $medical = $_POST['medical'];
    echo $emergency = $_POST['emergency'];
    echo $community = $_POST['community'];
    echo $identity = $_POST['identity'];
    echo $baju = $_POST['baju'];

    if ($_FILES['imgInp']["name"] !== '') {
        $target_dir = "../../../upload/";
        $target_file = $target_dir . basename($_FILES["imgInp"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["imgInp"]["tmp_name"]);
            if ($check !== false) {
                // echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                ?>
<script>
alert("File is not an image.");
</script><?php
header('Location:../order');
                $uploadOk = 0;
            }
        }
        if (file_exists($target_file) && $_FILES['imgInp']["name"] == '') {
            ?>
<script>
alert("Sorry, file name already exist.");
</script><?php
header('Location:../order');
            $uploadOk = 0;
        }
        if ($_FILES["imgInp"]["size"] > 4194304 && $_FILES['imgInp']["name"] == '') {
            ?>
<script>
alert("Sorry, file is too large.");
</script><?php
header('Location:../order');
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $_FILES['imgInp']["name"] == '') {
            ?>
<script>
alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
</script><?php
header('Location:../order');
            $uploadOk = 0;
        }
        if ($uploadOk == 0 && $_FILES['imgInp']["name"] == '') {
            header('Location:../order');
        } else {
            if (move_uploaded_file($_FILES["imgInp"]["tmp_name"], $target_dir . $_SESSION['bid'] . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION)))) {
                $foto_identitas = "upload/" . $uid . "." . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            } else {
                // echo "Sorry, there was an error uploading your file.";
                window . location . replace('../order');
            }
        }

        user_insert($uid, $name, $email, $address, $phone, $gender, $age, $medical, $foto_identitas, $bid, $emergency, $community, $identity, $baju);
    }
    $jenis = 'TFR Participant';
    $kategori = '7K';
    $harga = '0';
    $jumlah = '1';
    $invoice = 'TFR Participant';
    book_insert($jenis, $kategori, $harga, $jumlah, $book_email, $bid, $invoice);
    mailer($name, $jenis, $kategori, $harga, $jumlah, $book_email, $bid);
} else {
    header('Location:../order');
}

function book_insert($jenis, $kategori, $harga, $jumlah, $book_email, $bid, $invoice)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("INSERT INTO `tuhm_book` (`bid`, `jenis`, `kategori`, `harga_pcs`, `jumlah`, `book_email`,`foto_invoice`) VALUES (?, ?, ?, ?, ?, ?,?);");
        $dbQuery->bind_param("sssssss", $bid, $jenis, $kategori, $harga, $jumlah, $book_email, $invoice);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
    } catch (Exception $e) {
        return 'error inserting data';
    }
}
function user_insert($uid, $name, $email, $address, $phone, $gender, $age, $medical, $foto_identitas, $bid, $emergency, $community, $identity, $baju)
{
    require 'db.php';
    if (!$medical == '') {
    } else {
        $medical = 'Tidak Ada(Generated)';
    }
    try {
        $dbQuery = $dbConn->prepare("INSERT INTO `tuhm_users` ( `uid`, `nama`, `email`, `alamat`, `nohp`, `gender`, `umur`, `medical`, `foto_identitas`, `bid`,`emergency`,`community`,`identity`,`baju`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?);");
        $dbQuery->bind_param("ssssssssssssss", $uid, $name, $email, $address, $phone, $gender, $age, $medical, $foto_identitas, $bid, $emergency, $community, $identity, $baju);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
    } catch (Exception $e) {
        return 'error inserting data';
    }
}
function mailer($nama, $jenis, $kategori, $harga, $jumlah, $book_email, $bid)
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
    $mail->Subject = "[telkomuniversityrun.com] Konfirmasi Pemesanan Tiket Half Marathon 2019";
    $mail->isHTML(true);
    ob_start();
    $_SESSION['jenis'] = $jenis;
    $_SESSION['kategori'] = $kategori;
    $_SESSION['harga'] = $harga;
    $_SESSION['jumlah'] = $jumlah;
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
        $_SESSION['book_mail'] = $book_email;
        header("Location:../success");
        // echo 'sent';
    }
    header("Location:../success");
    // echo 'worked';
}