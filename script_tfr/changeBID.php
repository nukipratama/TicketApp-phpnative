<?php
// echo getUID()[15];
foreach (getUID() as $key) {

    echo changeBID($key);
}
function getUID()
{
    try {
        require '../script/db/db.php';
        $dbQuery = $dbConn->prepare("SELECT * FROM `peserta_7k`");
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        $key = 0;
        while ($array = $result->fetch_assoc()) {
            $get[$key] = $array['uid'];
            $key++;
        }

        return $get;
    } catch (Exception $e) {

    }
}
function changeBID($userid)
{

    try {
        require '../script/db/db.php';
        $dbQuery = $dbConn->prepare("UPDATE `peserta_7k` SET `book_id` = ? WHERE `peserta_7k`.`userid` = ?;");
        $dbQuery->bind_param("ss", $userid, $userid);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
    } catch (Exception $e) {
        return 'error inserting data';
    }
}