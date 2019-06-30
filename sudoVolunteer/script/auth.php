<?php


session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $uname = $_POST['username'];
    $pass = $_POST['password'];
    if (checkAuth($uname, $pass) !== false) {
        $_SESSION['authenticated'] = true;
        $_SESSION['adminName'] = checkAuth($uname, $pass);
        ?>
        <meta http-equiv="refresh" content="1;url=https://localhost/tuhm2019/sudoVolunteer/">
        <!-- <meta http-equiv="refresh" content="1;url=https://sudovolunteer.telkomuniversityrun.com/"> -->
        <?php
        echo "Login Success.<br>Redirecting to Home..";
    } else {
        ?>
        <meta http-equiv="refresh" content="1;url=https://localhost/tuhm2019/sudoVolunteer/">
        <!-- <meta http-equiv="refresh" content="1;url=https://sudovolunteer.telkomuniversityrun.com/"> -->
        <?php
        echo "Wrong Credentials.<br>Redirecting to Home..";
    }
} else {
    header("Location:https://localhost/tuhm2019/sudoVolunteer/");
    // header("Location:https://volunteer.telkomuniversityrun.com/");
}

function checkAuth($uname, $pass)
{
    try {
        require 'db.php';
        $dbQuery = $dbConn->prepare("SELECT * FROM `users`  WHERE `uname`=? AND `pass`=?");
        $dbQuery->bind_param("ss", $uname, $pass);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
        $dbGet = $result->fetch_assoc();
        $name = $dbGet['nama'];
        return $name;
    } catch (Exception $e) {
        echo 'Error' . $e;
    }
}
