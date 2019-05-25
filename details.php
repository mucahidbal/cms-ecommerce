<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<?php
require_once "./includes/defines.php";
require_once "./includes/php_configuration.php";
include_once "head.php";
require_once "./includes/utils.php";

//TODO: if ($_GET["pid"]) ekle
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
				<div id="item">
                    <div id="product_name" style="width: 478px">
                        <h4><?php echo getItemName($_GET["pid"]) ?></h4><br />
                    </div>
					<div class="big_view">
						<img id="cover" src="<?php echo getCoverImagePath($_GET["pid"])?>" alt="" width="311" height="319" /><br />
					</div>
					<div class="scroll">
                        <?php
                        foreach (getDetailImagesPaths($_GET["pid"]) as $detailImagePath) {
                            echo "<img src=\"$detailImagePath\" alt=\"\" width=\"62\" height=\"62\" onclick='document.getElementById(\"cover\").src = this.src'/>";
                        }
                        ?>
					</div>
                    <div id="price-detail-container">
                        <div id="price"><?php echo getPrice($_GET["pid"])?> TL</div>
                        <a href="#">Hemen Satın Al</a>
                    </div>
				</div>
				<div class="description">
					<p id="description-text">
                        <?php
                            echo getItemDescription($_GET["pid"]);
                        ?>
					</p>
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
