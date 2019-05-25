<?php
declare(strict_types=1);

require_once "defines.php";
require_once "api_utils.php";

define("LOGFILENAME", "php_log.log");
define("TABLENAME", "items");

function writeToLog(string $message) : void {
    date_default_timezone_set('Europe/Istanbul');
    $date = date("d/m/y H:i:s");
    error_log($date . ": " . $message . PHP_EOL, 3, LOGFILENAME);
}

function checkLogin() : bool {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];

    if ($username && $password) {
        $query = "SELECT * 
                  FROM admins 
                  WHERE username=\"$username\" AND password=\"$password\"";

        $result = queryDB($query);
        $obj = $result->fetch_object();
        if ($obj !== NULL) {
            writeToLog($obj->username);
            writeToLog($obj->password);
            return true;
        } else {
            writeToLog("WRONG USERNAME OR PASSWORD!");
            return false;
        }
    } else {
        writeToLog("USERNAME AND PASSWORD EMPTY!");
        return false;
    }
}

function findDirPath() : void {
    $dir = dirname(__FILE__);
    echo "<p>Full path to this dir: " . $dir . "</p>";
}

function isFloat($num) : bool {
    if (filter_var($num, FILTER_VALIDATE_FLOAT) === 0.0 || !filter_var($num, FILTER_VALIDATE_FLOAT) === false) {
        return true;
    } else {
        return false;
    }
}

function isInt($num) : bool {
    if (filter_var($num, FILTER_VALIDATE_INT) === 0 || !filter_var($num, FILTER_VALIDATE_INT) === false) {
        return true;
    } else {
        return false;
    }
}

function deleteDir($path) : bool {
    try {
        $directory = new RecursiveDirectoryIterator($path);
    } catch (UnexpectedValueException $e) {
        writeToLog($e->getMessage());
        return false;
    }
    $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($iterator as $info) {
        $pathname = $info->getPathname();
        if (basename($pathname) !== "." && basename($pathname) !== "..") {
            is_dir($pathname) ? rmdir($pathname) : unlink($pathname);
        }
    }
    return rmdir($path);
}

function startsWith(string $haystack, string $needle) : bool {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function getFilesInDir($path) : array {
    $filenames = array();
    $dir = new DirectoryIterator($path);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            $filenames[] = str_replace("\\", "/", $fileinfo->getRealPath());
        }
    }
    return $filenames;
}
