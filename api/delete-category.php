<?php
require_once "../includes/defines.php";
require_once "../includes/php_configuration.php";
require_once "../includes/utils.php";
require_once "../includes/api_utils.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode($_POST["json_data"], true);
    var_dump($data);
    if ($data["pid"] && isInt($data["pid"])) {
        deleteCategory($data["pid"]);
    } else {
        echo "Incomplete information sent!";
    }
}
