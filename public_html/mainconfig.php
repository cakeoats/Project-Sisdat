<?php

date_default_timezone_set('Asia/Jakarta');

require("password_hash.php");

// web
$cfg_baseurl = "https://miamoe.my.id/"; // HTTPS(secure) atau HTTP(not-secure)
// database
$db_server = "localhost";
$db_user = "miamoemy_uang";
$db_password = "miamoemy_uang79";
$db_name = "miamoemy_uang";

// date & time
$date = date("Y-m-d");
$time = date("H:i:s");

// require
require("lib/database.php");