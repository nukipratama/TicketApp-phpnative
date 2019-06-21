<?php
function user_insert($nama, $email, $jurusan, $nohp, $nim, $motivasi, $ktm_path)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("INSERT INTO `form_volunteer` (`nama`, `email`, `jurusan`, `nohp`, `nim`, `motivasi`, `ktm`) VALUES (?, ?, ?, ?, ?, ?, ?);");
        $dbQuery->bind_param("sssssss", $nama, $email, $jurusan, $nohp, $nim, $motivasi, $ktm_path);
        $dbQuery->execute();
        $dbQuery->close();
        header("Location:VolunteerRegistrationSuccess");
    } catch (Exception $e) {
        ?>
        <meta http-equiv="refresh" content="5;url=https://volunteer.telkomuniversityrun.com">
        <?php
        echo "NIM already registered.<br>Redirecting to Home..";
    }
}

$nama = $_POST['nama'];
$email = $_POST['email'];
$jurusan = $_POST['email'];
$nohp = $_POST['nohp'];
$nim = $_POST['nim'];
$motivasi = $_POST['motivasi'];
$ktm = $_FILES['ktm'];

if (isset($nama) && isset($email) && isset($jurusan) && isset($nohp) && isset($nim) && isset($motivasi) && isset($ktm)) {
    user_insert($nama, $email, $jurusan, $nohp, $nim, $motivasi, processData($nim, $ktm));
}

function processData($nim, $ktm)
{
    $_FILES['imgInp'] = $ktm;
    if ($_FILES['imgInp']["name"] !== '') {
        $target_dir = "../upload/ktm/";
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
                            header('Location:register');
                            $uploadOk = 0;
                        }
                    }
                    if (file_exists($target_file) && $_FILES['imgInp']["name"] == '') {
                        ?>
            <script>
                alert("Sorry, file name already exist.");
            </script><?php
                        header('Location:order');
                        $uploadOk = 0;
                    }
                    if ($_FILES["imgInp"]["size"] > 4194304 && $_FILES['imgInp']["name"] == '') {
                        ?>
            <script>
                alert("Sorry, file is too large.");
            </script><?php
                        header('Location:order');
                        $uploadOk = 0;
                    }
                    if (
                        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" && $_FILES['imgInp']["name"] == ''
                    ) {
                        ?>
            <script>
                alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            </script><?php
                        header('Location:order');
                        $uploadOk = 0;
                    }
                    if ($uploadOk == 0 && $_FILES['imgInp']["name"] == '') {
                        header('Location:order');
                    } else {
                        if (move_uploaded_file($_FILES["imgInp"]["tmp_name"], $target_dir . $nim . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION)))) {
                            $path = "upload/ktm/" . $nim . "." . $imageFileType;
                            return $path;
                        } else {
                            // echo "Sorry, there was an error uploading your file.";
                            echo 'error uploading data';
                        }
                    }
                }
            }
