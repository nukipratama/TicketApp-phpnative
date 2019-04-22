<?php
session_start();
echo $_SESSION['secret'];
for ($a = 0; $a < count($_POST); $a++) {
    echo $_POST['phone'][$a];
}
