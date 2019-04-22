<?php
session_start();
function check($email, $pass)
{
    require 'db.php';
    try {
        $dbQuery = $dbConn->prepare("SELECT name FROM admin WHERE email = ? AND pass = ?");
        $dbQuery->bind_param("ss", $email, $pass);
        $dbQuery->execute();
        $result = $dbQuery->get_result();
        if ($result->num_rows === 0) {
            return false;
        }
        $dbGet = $result->fetch_assoc();
        $_SESSION['auth_name'] = $dbGet['name'];
        return true;
    } catch (Exception $e) {
        return 'error fetching data';
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if (check($email, $pass)) {
        $_SESSION['auth'] = $pass;
        header("Location:../dashboard");
    } else {
        ?>
<script>
alert('Wrong Email / Password');
</script>
<?php
header("Location:../login");
    }
}