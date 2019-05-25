<div id="sidebar">
    <img src="images/title1.gif" alt="" width="174" height="30" /><br />
    <ul id="list">
        <?php
            $color = false;
            foreach (getCategories() as $category) {
                $id = $category["id"];
                $name = $category["name"];
                $url = "index.php?category=$id";
                if ($color) {
                    $class = "color";
                } else {
                    $class = "";
                }
                echo "<li class=\"$class\"><a href=\"$url\">$name</a></li>";
                $color = !$color;
            }
        ?>
    </ul>
</div>
