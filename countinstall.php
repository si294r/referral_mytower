<?php

defined('IS_DEVELOPMENT') OR exit('No direct script access allowed');

$swrve_user_id = isset($params[1]) ? $params[1] : "";
$count_install = isset($params[2]) ? $params[2] : "";

if (trim($swrve_user_id) == "") {
    return array(
        "status" => FALSE,
        "message" => "Error: swrve_user_id is empty"
    );
}

if (is_numeric($count_install)) {
    return array(
        'swrve_user_id' => $swrve_user_id,
        'count_install' => (int)$count_install,
        'error' => 0,
        'message' => 'Success'
    );
}

include("/var/www/mysql-config2.php");
$connection = new PDO(
    "mysql:dbname=mytower;host=$myhost;port=$myport",
    $myuser, $mypass
);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// get count install
$sql2 = "SELECT count(*) as count_install FROM referral WHERE referrer = :user_id";
$statement2 = $connection->prepare($sql2);
$statement2->execute(array(':user_id' => $swrve_user_id));
$row = $statement2->fetch(PDO::FETCH_ASSOC);

return array(
    'swrve_user_id' => $swrve_user_id,
    'count_install' => $row['count_install'],
    'error' => 0,
    'message' => 'Success'
);
