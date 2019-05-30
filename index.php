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

            if (isset($_GET["pageno"])) {
                $pageno = $_GET["pageno"] > 0 ? $_GET["pageno"] : 1;
            } else {
                $pageno = 1;
            }

            $total_pages = getTotalPages();
            ?>
			<div id="main_block">
				<div id="items">
                    <?php
                    if (isset($_GET["category"])) {
                        create_items_list($pageno, $_GET["category"]);
                    } else {
                        create_items_list($pageno);
                    }
                    ?>
				</div>
                <div id="page_buttons">
                    <ul>
                        <li class="pagination"><a href="?pageno=1">İlk</a></li>
                        <li class="<?php if($pageno <= 1){ echo 'disabled'; } else { echo "pagination"; } ?>">
                            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Önceki</a>
                        </li>
                        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } else { echo "pagination"; } ?>">
                            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Sonraki</a>
                        </li>
                        <li class="pagination"><a href="?pageno=<?php echo $total_pages; ?>">Son</a></li>
                    </ul>
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
