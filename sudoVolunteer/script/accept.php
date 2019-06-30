<?php
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];
    accept($nim); ?>
    <!-- <meta http-equiv="refresh" content="2;url=https://localhost/tuhm2019/sudoVolunteer/"> -->
    <meta http-equiv="refresh" content="2;url=https://sudovolunteer.telkomuniversityrun.com/">
    <?php
    echo $nim . " Accepted.<br>Redirecting to Home..";
} else {
    // header("Location:https://localhost/tuhm2019/sudoVolunteer/");
    header("Location:https://volunteer.telkomuniversityrun.com/");
}
function accept($nim)
{
    try {
        require 'db.php';
        $dbQuery = $dbConn->prepare("UPDATE `form_volunteer` SET `status` = '1' WHERE `form_volunteer`.`nim` = ?;");
        $dbQuery->bind_param("s", $nim);
        $dbQuery->execute();
        return true;
    } catch (Exception $e) {
        echo 'Error' . $e;
        return false;
    }
}
