<?php
if (isset($_POST['bookid'])) {
    echo $_POST['bookid'];
    if ($_FILES['imgInp']["name"] == '') {
        // echo '<br>no image,data ke-' . ($key + 1);
    }
    if ($_FILES['imgInp']["name"] !== '') {
        $target_dir = "../../upload/invoice/";
        $target_file = $target_dir . basename($_FILES["imgInp"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["imgInp"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                ?>
<script>
alert("File is not an image.");
</script><?php
header("Location:order");
                $uploadOk = 0;
            }
        }
        if (file_exists($target_file) && $_FILES['imgInp']["name"] == '') {
            ?>
<script>
alert("Sorry, file name already exist.");
</script><?php
header("Location:order");
            $uploadOk = 0;
        }
        if ($_FILES["imgInp"]["size"] > 4194304 && $_FILES['imgInp']["name"] == '') {
            ?>
<script>
alert("Sorry, file is too large.");
</script><?php
header("Location:order");
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $_FILES['imgInp']["name"] == '') {
            ?>
<script>
alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
</script><?php
header("Location:order");
            $uploadOk = 0;
        }
        if ($uploadOk == 0 && $_FILES['imgInp']["name"] == '') {
            header("Location:order");
        } else {
            if (move_uploaded_file($_FILES["imgInp"]["tmp_name"], $target_dir . $_POST['bookid'] . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION)))) {
                $foto_identitas = "upload/invoice/" . $_POST['bookid'] . "." . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $array = jumlahBID($_POST['bookid']);
                echo updateInvoice($foto_identitas, $_POST['bookid']);
                echo updateTiket($array['jumlah'], $array['jenis'], $array['kategori']);
                
                header("Location:invoice?bid=" . $_POST['bookid']);
            } else {
                echo "Sorry, there was an error uploading your file.";
                window . location . replace('order');
            }
        }
    }
} else {
    header("Location:order");
}

function jumlahBID($bookid)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_book WHERE bid = ?");
        $dbQuery->bind_param("s", $bookid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            header("Location:order");
        }
        $dbGet = $result->fetch_assoc();
        $array['jumlah'] = $dbGet['jumlah'];
        $array['jenis'] = $dbGet['jenis'];
        $array['kategori'] = $dbGet['kategori'];
        return $array;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}

function updateInvoice($file_name, $bookid)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("UPDATE `tuhm_book` SET `foto_invoice` = ? WHERE `tuhm_book`.`bid` = ?;");
        $dbQuery->bind_param("ss", $file_name, $bookid);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
    } catch (Exception $e) {
        return 'error inserting data';
    }
}
function updateTiket($jumlah, $jenis, $kategori)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT kuota FROM tiket WHERE jenis = ? AND kategori = ?");
        $dbQuery->bind_param("ss", $jenis, $kategori);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            header("Location:order");
        }
        $dbQuery->close();
        $dbGet = $result->fetch_assoc();
        $array = $dbGet['kuota'];
        $jumlah = (int) $array - (int) $jumlah;

        $dbQuery2 = $dbConn->prepare("UPDATE `tiket` SET `kuota` = ? WHERE jenis = ? AND kategori = ?;");
        $dbQuery2->bind_param("sss", $jumlah, $jenis, $kategori);
        $dbQuery2->execute();
        $dbQuery2->close();
        return 'data inserted';
        // return $jumlah;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}