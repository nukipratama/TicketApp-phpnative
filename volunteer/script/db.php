<?php
date_default_timezone_set("Asia/Bangkok");
$dbConn = new mysqli("localhost", "telkomu1_volunteer", "volunteertuhm", "telkomu1_volunteer");
// $dbConn = new mysqli("localhost", "root", "", "db_tuhm_volunteer");

if ($dbConn->connect_error) {
    echo ('Error connecting to database');
    header('Location:order');
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$dbConn->set_charset("utf8mb4");
