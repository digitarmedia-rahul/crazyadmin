<?php

error_reporting(0);
//mysqli connect method
$mysqli = new mysqli("localhost", "crazyuser", "Crazy#432", "crazy_db");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
// set charset to UTF-8
$mysqli->set_charset("utf8");