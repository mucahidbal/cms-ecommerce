<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<?php
require_once "./includes/defines.php";
require_once "./includes/php_configuration.php";
include_once "head.php";
require_once "./includes/html_utils.php";
?>
<body>
	<?php
    include_once "banner.php";
    ?>
	<div id="wrapper">																																																																																													
		<div id="content_inside">
            <?php
            include_once "sidebar.php";
            ?>
			<div id="main_block">
				<div id="items">
                    <?php
                    if (isset($_GET["category"])) {
                        create_items_list($_GET["category"]);
                    } else {
                        create_items_list();
                    }
                    ?>
				</div>
			</div>
		</div>
	</div>
	<?php
    include_once "footer.php";
    include_once "banner_map.php";
    ?>
</body>
</html>
