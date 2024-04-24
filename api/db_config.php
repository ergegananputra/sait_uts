<?php
    $DB_SERVER = "localhost";
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "sait_db_uts";

    $mysqli = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    if(!$mysqli){
        die("Connection failed: " . mysqli_connect_error());
    }
?>