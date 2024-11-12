<?php 
    session_start();
    session_unset();
    session_destroy();
    header("Location: http://midterm-exam-3a.test/root/");
    exit();
?>