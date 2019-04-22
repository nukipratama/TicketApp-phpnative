<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if (isset($_POST['name'])) {
    $jenis = '';
    $kategori = '';
    $harga = '';
    $book_email = $_POST['book_email'];
    $bookid = $_POST['bookid'];
    $uid = $_POST['uid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $medical = $_POST['medical'];
    $emergency = $_POST['emergency'];
    $community = $_POST['community'];
    $identity = $_POST['identity'];
    $baju = $_POST['baju'];

    for ($key = 0; $key < count($_POST['name']); $key++) {
        if ($_FILES['imgInp']["name"][$key] == '') {
            echo '<br>no image,data ke-' . ($key + 1);
        }
        if ($_FILES['imgInp']["name"][$key] !== '') {
            $target_dir[$key] = "../../upload/";
            $target_file[$key] = $target_dir[$key] . basename($_FILES["imgInp"]["name"][$key]);
            $uploadOk[$key] = 1;
            $imageFileType[$key] = strtolower(pathinfo($target_file[$key], PATHINFO_EXTENSION));
            if (isset($_POST["submit"])) {
                $check[$key] = getimagesize($_FILES["imgInp"]["tmp_name"][$key]);
                if ($check[$key] !== false) {
                    echo "File is an image - " . $check["mime"][$key] . ".";
                    $uploadOk[$key] = 1;
                } else {
                    ?>
<script>
alert("File is not an image.");
</script><?php
header('Location:order');
                    $uploadOk[$key] = 0;
                }
            }
            if (file_exists($target_file[$key]) && $_FILES['imgInp']["name"][$key] == '') {
                ?>
<script>
alert("Sorry, file name already exist.");
</script><?php
header('Location:order');
                $uploadOk[$key] = 0;
            }
            if ($_FILES["imgInp"]["size"][$key] > 4194304 && $_FILES['imgInp']["name"][$key] == '') {
                ?>
<script>
alert("Sorry, file is too large.");
</script><?php
header('Location:order');
                $uploadOk[$key] = 0;
            }
            if ($imageFileType[$key] != "jpg" && $imageFileType[$key] != "png" && $imageFileType[$key] != "jpeg"
                && $imageFileType[$key] != "gif" && $_FILES['imgInp']["name"][$key] == '') {
                ?>
<script>
alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
</script><?php
header('Location:order');
                $uploadOk[$key] = 0;
            }
            if ($uploadOk[$key] == 0 && $_FILES['imgInp']["name"][$key] == '') {
                header('Location:order');
            } else {
                if (move_uploaded_file($_FILES["imgInp"]["tmp_name"][$key], $target_dir[$key] . $_POST['uid'][$key] . '.' . strtolower(pathinfo($target_file[$key], PATHINFO_EXTENSION)))) {
                    $foto_identitas[$key] = "upload/" . $uid[$key] . "." . strtolower(pathinfo($target_file[$key], PATHINFO_EXTENSION));
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    window . location . replace('order');
                }
            }
        }
        echo user_insert($uid[$key], $name[$key], $email[$key], $address[$key], $phone[$key], $gender[$key], $age[$key], $medical[$key], $foto_identitas[$key], $bookid, $emergency[$key], $community[$key], $identity[$key], $baju[$key]);
    }
    $jenis = check($_SESSION['secret'])['jenis'];
    $kategori = check($_SESSION['secret'])['kategori'];
    $harga = check($_SESSION['secret'])['harga'];
    $jumlah = count($uid);
    echo book_insert($jenis, $kategori, $harga, $jumlah, $book_email, $bookid, $uid);
    echo mailer($name[0], $jenis, $kategori, $harga, $jumlah, $book_email, $bookid);
} else {
    header('Location:order');
}

function check($id)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tiket WHERE idnya = ?");
        $dbQuery->bind_param("s", $id);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            header('Location:order');
        }
        $dbGet = $result->fetch_assoc();
        $array['jenis'] = $dbGet['jenis'];
        $array['kategori'] = $dbGet['kategori'];
        $array['harga'] = $dbGet['harga'];
        return $array;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}
function book_insert($jenis, $kategori, $harga, $jumlah, $book_email, $bookid)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("INSERT INTO `tuhm_book` (`bid`, `jenis`, `kategori`, `harga_pcs`, `jumlah`, `book_email`) VALUES (?, ?, ?, ?, ?, ?);");
        $dbQuery->bind_param("ssssss", $bookid, $jenis, $kategori, $harga, $jumlah, $book_email);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
    } catch (Exception $e) {
        return 'error inserting data';
    }
}
function user_insert($uid, $name, $email, $address, $phone, $gender, $age, $medical, $foto_identitas, $bookid, $emergency, $community, $identity, $baju)
{
    require 'db.php';
    if (!$medical == '') {
    } else {
        $medical = 'Tidak Ada(Generated)';
    }
    try {
        $dbQuery = $dbConn->prepare("INSERT INTO `tuhm_users` ( `uid`, `nama`, `email`, `alamat`, `nohp`, `gender`, `umur`, `medical`, `foto_identitas`, `bid`,`emergency`,`community`,`identity`,`baju`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?);");
        $dbQuery->bind_param("ssssssssssssss", $uid, $name, $email, $address, $phone, $gender, $age, $medical, $foto_identitas, $bookid, $emergency, $community, $identity, $baju);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
    } catch (Exception $e) {
        return 'error inserting data';
    }
}
function mailer($nama, $jenis, $kategori, $harga, $jumlah, $book_email, $bookid)
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
    $_SESSION['bookid'] = $bookid;
    $_SESSION['nama'] = $nama;
    include 'book_mail.php';
    $mail->Body = ob_get_clean();
    // $mail->Body = '<b>MASUK DEH</b>';
    // $mail->send();
    if (!$mail->send()) {
        echo 'Pesan tidak dapat dikirim.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        session_destroy();
        header('Location:order');
    } else {
        $_SESSION['book_mail'] = $book_email;
        header("location:success");
        echo 'sent';
    }
    echo 'worked';
}