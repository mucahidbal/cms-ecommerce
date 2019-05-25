<?php
require_once "../includes/defines.php";
require_once "../includes/php_configuration.php";
require_once "../includes/utils.php";
require_once "../includes/api_utils.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode($_POST["json_data"], true);
    if ($data["name"] && $data["category"] && (isFloat($data["price"]) && floatval($data["price"] >= 0))) {
        echo addItem($data["name"], $data["category"], $data["price"], $data["description"]);
    } else {
        echo "Incomplete information sent!";
    }
}
