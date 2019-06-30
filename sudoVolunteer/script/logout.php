<?php
session_start();
$_SESSION['authenticated'] = false;
session_destroy();
header("Location:https://localhost/tuhm2019/sudoVolunteer/");
// header("Location:https://volunteer.telkomuniversityrun.com/");
