<?php
date_default_timezone_set("Asia/Bangkok");
// $dbConn = new mysqli("localhost", "telkomu1_db", "(alfamart12)", "telkomu1_tuhm");
$dbConn = new mysqli("localhost", "root", "", "db_tuhm");
if ($dbConn->connect_error) {
    exit('Error connecting to database');
    header('Location:order');
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$dbConn->set_charset("utf8mb4");