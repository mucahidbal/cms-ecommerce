<?php
require_once "../includes/api_utils.php";
require_once "../includes/defines.php";

$pid = $_POST["pid"];
$target_dir = "../items/$pid/images/";
mkdir($target_dir, 0777, true);

// Upload cover photo
$file_tmp_path = $_FILES[COVERPHOTOINPUTNAME]["tmp_name"];
$file_name = "cover.jpg";
$destination_path = $target_dir . $file_name;
if (move_uploaded_file($file_tmp_path, $destination_path)) {
    echo "The file " . $destination_path . " has been uploaded.<br>";
} else {
    echo "Sorry, there was an error uploading your file: " . $destination_path . "<br>";
}

// Upload other images
if ($_FILES[FILEUPLOADINPUTNAME]["tmp_name"][0]) {
    for ($i = 0; $i < count($_FILES[FILEUPLOADINPUTNAME]["tmp_name"]); $i++) {
        $file_tmp_path = $_FILES[FILEUPLOADINPUTNAME]["tmp_name"][$i];
        $file_name = $_FILES[FILEUPLOADINPUTNAME]["name"][$i];
        $destination_path = $target_dir . $file_name;
        if (move_uploaded_file($file_tmp_path, $destination_path)) {
            echo "The file " . $destination_path . " has been uploaded.<br>";
        } else {
            echo "Sorry, there was an error uploading your file: " . $destination_path . "<br>";
        }
    }
}

//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$target_file = $target_dir . basename("cover.jpg");
//$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//var_dump($_FILES[FILEUPLOADINPUTNAME]);
//die();

//foreach ($_FILES[FILEUPLOADINPUTNAME]["tmp_name"] as $file_tmp_path) {
//    if (move_uploaded_file($file_tmp_path, $target_dir . basename($file_tmp_path))) {
//        echo "The file " . basename($file_tmp_path) . " has been uploaded.";
//    } else {
//        echo "Sorry, there was an error uploading your file.";
//    }
//}



//TODO: apply these checks below

//foreach ($_FILES[FILEUPLOADINPUTNAME]["name"] as $file_name) {
//    // Check if file already exists
//    if (file_exists($target_dir . $file_name)) {
//        echo "Sorry, file already exists.";
//        $uploadOk = 0;
//    }
//}

// Check if image file is an actual image or fake image
//if (isset($_POST["submit"])) {
//    $check = getimagesize($_FILES[FILEUPLOADINPUTNAME]["tmp_name"]);
//    if ($check !== false) {
//        echo "File is an image - " . $check["mime"] . ".";
//        $uploadOk = 1;
//    } else {
//        echo "File is not an image.";
//        $uploadOk = 0;
//    }
//}

//// Check file size
//if ($_FILES[FILEUPLOADINPUTNAME]["size"] > 5000000) {
//    echo "Sorry, your file is too large.";
//    $uploadOk = 0;
//}
//
//// Allow certain file formats
//if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//    && $imageFileType != "gif") {
//    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//    $uploadOk = 0;
//}
