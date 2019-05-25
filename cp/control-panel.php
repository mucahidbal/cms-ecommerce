<?php
require_once "../includes/defines.php";
require_once "../includes/php_configuration.php";
require_once "../includes/utils.php";
require_once "../includes/api_utils.php";

include_once "cp-sidebar.php";

function create_table() : void {
    $items_array = getItems();
    $header_row = "<tr>
                    <td>id</td>
                    <td>İlan Adı</td>
                    <td>Kategori</td>
                    <td>Fiyat</td>
                    <td>Eklenme Tarihi</td>
                   </tr>";
    $table = "<table border=\"1\"><tbody>";
    $table .= $header_row;

    foreach ($items_array as $item) {
        unset($item["images_path"]);
        unset($item["description"]);
        $table .= "<tr>";
        foreach ($item as $column) {
            $table .= "<td>" . $column . "</td>";
        }
        $table .= "<td>" . "<input type=\"button\" value=\"Sil\" onclick=\"deleteItem(" . $item["id"] . ")\">" . "</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody></table>";
    echo $table;
}
?>

<div id="cp_main" style="float:left">
    <div id="db_table">
        <?php
        create_table();
        ?>
    </div>
</div>

<script src="../scripts/scripts.js"></script>
