<?php
date_default_timezone_set('Asia/Jakarta');
function timestampdiff($bookid)
{
    $book_time = date('d-m-Y H:i:s', strtotime(checkTIME($bookid)['tanggal'] . '+ 1 days'));
    $current_time = date('d-m-Y H:i:s');
    $book_time = strtotime($book_time);
    $current_time = strtotime($current_time);
    $datetime1 = new DateTime("@$book_time");
    $datetime2 = new DateTime("@$current_time");
    $interval = $datetime1->diff($datetime2);
    // $interval->format('%Hh %Im %Ss');
    $array['hour'] = $interval->format('%H');
    $array['minute'] = $interval->format('%i');
    $array['second'] = $interval->format('%S');
    return $array;
}
function checkTIME($bookid)
{
    try {
        require '../db/db.php';
        $dbQuery = $dbConn->prepare("SELECT * FROM tuhm_book WHERE bid = ?");
        $dbQuery->bind_param("s", $bookid);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            header("Location:home");
        }
        $dbGet = $result->fetch_assoc();
        $dbQuery->close();
        return $dbGet;
    } catch (Exception $e) {
        return 'not found';
    }
}
if (isset($_POST['bid']) && isset($_POST['type'])) {
    $bookid = $_POST['bid'];
    echo json_encode(timestampdiff($bookid));

}