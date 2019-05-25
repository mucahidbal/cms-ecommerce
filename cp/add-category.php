<?php
require_once "../includes/defines.php";
require_once "../includes/php_configuration.php";
require_once "../includes/utils.php";
require_once "../includes/api_utils.php";

include_once "cp-sidebar.php";

function create_table() : void {
    $header_row = "<tr>
                    <td>id</td>
                    <td>Kategori Adı</td>
                   </tr>";
    $table = "<table border=\"1\"><tbody>";
    $table .= $header_row;

    foreach (getCategories() as $category) {
        $table .= "<tr>";
        foreach ($category as $column) {
            $table .= "<td>" . $column . "</td>";
        }
        $table .= "<td>" . "<input type=\"button\" value=\"Sil\" onclick=\"deleteCategory(" . $category["id"] . ")\">" . "</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody></table>";
    echo $table;
}
?>

<div id="add-category-main" style="float:left">
    <div id="add-category">
        <p>Kategori Adı:</p> <input type="text" id="category-name" value="">

        <input type="button" value="Ekle" onclick="addCategory()"><br><br>
        <?php
            create_table();
        ?>
    </div>
</div>

<script src="../scripts/scripts.js"></script>
