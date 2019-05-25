<?php
declare(strict_types=1);
require_once "defines.php";
require_once "utils.php";

define("ITEMS_TABLE", "items");
define("ID_COLUMN", "id");
define("NAME_COLUMN", "name");
define("CATEGORY_COLUMN", "category");
define("PRICE_COLUMN", "price");
define("DESCRIPTION_COLUMN", "description");
define("CREATIONDATE_COLUMN", "creation_date");

define("CATEGORIES_TABLE", "categories");
define("CATEGORIES_NAME_COLUMN", "name");

function connectoToDB() {
//    $servername = "sql210.epizy.com";
//    $username = "epiz_23808780";
//    $password = "pmTLOCJlzG";
//    $dbname = "epiz_23808780_furniture_shop";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "furniture_shop";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        writeToLog("Connection failed: " . $conn->connect_error);
        return NULL;
    }
    writeToLog("Connected to DB successfully");
    return $conn;
}

function queryDB(string $sql_query) {
    $conn = connectoToDB();
    if ($conn !== NULL) {
        $result = $conn->query($sql_query);
        if ($result) {
            if (startsWith($sql_query, "INSERT")) {
                return array($result, $conn->insert_id);
            }
            writeToLog("Query successfull: " . $sql_query);
        } else {
            writeToLog("Error: " . $sql_query . PHP_EOL . $conn->error);
        }
        return $result;
    } else {
        return false;
    }
}

function getItemsPath() : string {
    return "items/";
}

function getItemPath(int $pid) : string {
    if ($pid !== NULL) {
        return getItemsPath() . strval($pid) . "/";
    } else {
        return getItemsPath() . $_GET['pid'] . "/";
    }
}

function getObjFromDB(int $id, string $table_name) {
    $sql_query = "SELECT * FROM " . $table_name . " WHERE " . "id = " . $id;
    return queryDB($sql_query)->fetch_object();
}

function getItemObjFromDB(int $pid) {
    return getObjFromDB($pid, ITEMS_TABLE);
}

function getCategoryObjFromDB($id) {
    return getObjFromDB($id, CATEGORIES_TABLE);
}

function getItems(int $category_id = NULL) {
    if ($category_id) {
        $sql_query = "SELECT * FROM " . ITEMS_TABLE . " WHERE " . "category = " . $category_id;
    } else {
        $sql_query = "SELECT * FROM " . ITEMS_TABLE;
    }
    $result = queryDB($sql_query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getCategories() {
    $sql_query = "SELECT * FROM " . CATEGORIES_TABLE;
    $result = queryDB($sql_query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getImagesPath(int $pid) {
    return getItemPath($pid) . "images/";
}

function getImagesPathFromDB(int $pid, bool $relative) : string {
    $item_obj = getItemObjFromDB($pid);
    if ($relative) {
        return $item_obj->images_path;
    } else {
        return WEBSITE_ROOT . $item_obj->images_path;
    }
}

function getCoverImagePath(int $pid) : string {
    return getImagesPathFromDB($pid, true) . "cover.jpg";
}

function getPrice(int $pid) : string {
    $item_obj = getItemObjFromDB($pid);
    return $item_obj->price;
}

function getItemName(int $pid) : string {
    $item_obj = getItemObjFromDB($pid);
    return $item_obj->name;
}

function getItemDescription(int $pid) : string {
    $item_obj = getItemObjFromDB($pid);
    return $item_obj->description;
}

function convertToRelative(string $path) {
    return str_replace(WEBSITE_ROOT, "", $path);
}

function getDetailImagesPaths(int $pid) : array {
    $paths_array = getFilesInDir(getImagesPathFromDB($pid, false));
    return array_map('convertToRelative', $paths_array);
}

function getCategoryName($id) {
    $category_obj = getCategoryObjFromDB($id);
    return $category_obj->name;
}

function addItem(string $name, string $category, float $price, string $description) : string {
    $insert_query = "INSERT INTO " . ITEMS_TABLE . "(" . NAME_COLUMN . "," . CATEGORY_COLUMN . "," . PRICE_COLUMN . "," . DESCRIPTION_COLUMN .") ";
    $values_query = "VALUES" . "(" . "\"$name\"" . "," . "\"$category\"" . "," . "\"$price\"" . "," ."\"$description\"" . ")";

    $sql_query = $insert_query . $values_query;

    $result = queryDB($sql_query);
    $pid = $result[1];

    if ($result[0]) {
        writeToLog("Item added successfully.");
        $json_response = json_encode(array("status" => true, "pid" => $result[1]));

        $update_query = "UPDATE " . ITEMS_TABLE . " SET images_path = \"" . getImagesPath($pid) . "\" WHERE " . ITEMS_TABLE . ".id = $pid";
        queryDB($update_query);
    } else {
        writeToLog("ADD ITEM ERROR!");
        $json_response = json_encode(array("status" => false));
    }

    return $json_response;
}

function deleteItem($id) : bool {
    $sql_query = "DELETE FROM " . ITEMS_TABLE . " WHERE " . ITEMS_TABLE . ".id = $id";

    $result = queryDB($sql_query);

    if (!$result) {
        echo "DELETE ITEM ERROR!";
        writeToLog("DELETE ITEM ERROR!");
        return false;
    }

    if (deleteDir(WEBSITE_ROOT . getItemPath(intval($id)))) {
        writeToLog("Item deleted successfully.");
        echo "Item deleted successfully.";
    } else {
        echo "Item directory cannot deleted!";
    }

    return true;
}

function addCategory(string $name) {
    $sql_query = "INSERT INTO " . CATEGORIES_TABLE . "(" . CATEGORIES_NAME_COLUMN .") VALUES(\"$name\")";

    $result = queryDB($sql_query);

    if ($result[0]) {
        writeToLog("Category added successfully.");
        $json_response = json_encode(array("status" => true));
    } else {
        writeToLog("ADD CATEGORY ERROR!");
        $json_response = json_encode(array("status" => false));
    }

    return $json_response;
}

function deleteCategory($id) : bool {
    $sql_query = "DELETE FROM " . CATEGORIES_TABLE . " WHERE " . CATEGORIES_TABLE . ".id = $id";

    $result = queryDB($sql_query);

    if (!$result) {
        echo "DELETE CATEGORY ERROR!";
        writeToLog("DELETE CATEGORY ERROR!");
        return false;
    }

    return true;
}