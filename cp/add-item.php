<?php
require_once "../includes/defines.php";
require_once "../includes/php_configuration.php";
require_once "../includes/utils.php";
require_once "../includes/api_utils.php";

include_once "cp-sidebar.php";
?>

<div id="add-item-main" style="float:left">
    <div id="add-item">
        <p>İlan Adı:</p> <input type="text" id="name" value="">

        <p>&Uuml;r&uuml;n Kategorisi:</p>
        <select id="category">
            <?php
                foreach (getCategories() as $category) {
                    $id = $category["id"];
                    $name = $category["name"];
                    echo "<option value=\"$id\">$name</option>";
                }
            ?>
        </select>

        <p>&Uuml;r&uuml;n Fiyatı:</p> <input type="number" id="price" value="">
        <p>&Uuml;r&uuml;n Açıklaması:</p><textarea rows="5" cols="50" id="description"></textarea><br><br>

        <div id="upload">
            <form id="upload-form">
                Kapak resmini seçin:
                <input type="file" name="<?php echo COVERPHOTOINPUTNAME?>" id="coverPhotoInput" onchange="showThumbnails(this.files, 'cover-photo')"><br><br>
                <div id="cover-photo">
                </div>
                Eklemek için resim seçin:
                <input type="file" name="<?php echo FILEUPLOADINPUTNAME . "[]" ?>" id="fileUploadInput" multiple onchange="showThumbnails(this.files, 'selected-images')"><br><br>
                <div id="selected-images">
                </div>
            </form>
        </div>

        <input type="button" value="Ekle" onclick="addItem()"><br><br><br>
    </div>
</div>

<script src="../scripts/scripts.js"></script>
