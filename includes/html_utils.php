<?php
require_once "defines.php";
require_once "utils.php";
require_once "api_utils.php";

function create_items_list(int $pageno, int $category_id = NULL) {
    foreach (getItems($category_id, $pageno) as $item) {
        $pid = strval($item["id"]);
        $cover_image_path = getCoverImagePath($pid);
        $title = getItemName($pid);
        $price = getPrice($pid);

        echo "<a href=\"details.php?pid=$pid\">";
        echo "<div class=\"item\">";
        echo "<img src=\"$cover_image_path\" alt=\"\"/><br />";
        echo "<span class=\"title\">$title</span>";
        echo "<span class=\"price\">$price TL</span>";
        echo "</div>";
        echo "</a>";
    }
}
