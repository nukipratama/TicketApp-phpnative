<?php
foreach (getUID() as $key) {
    echo insertBID($key['bid'], $key['email']);
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
            $get[$key] = $array;
            $key++;
        }

        return $get;
    } catch (Exception $e) {

    }
}

function insertBID($bid, $email)
{

    try {
        require '../script/db/db.php';
        $dbQuery = $dbConn->prepare("INSERT INTO `book` (`bid`, `jenis`, `kategori`, `harga_pcs`, `jumlah`, `book_email`,`paid_status`) VALUES (?, 'TFR Participant', '7K', '100', '1', ?,0);");
        $dbQuery->bind_param("ss", $bid, $email);
        $dbQuery->execute();
        $dbQuery->close();
        return 'data inserted';
    } catch (Exception $e) {
        return '<br>error inserting data' . $e;
    }
}